<?php
/*****************************************************************************
 * SV-Cart 商品管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: trash_controller.php 5493 2009-11-03 10:47:49Z huangbo $
 *****************************************************************************/
class TrashController extends AppController
{
    var $name='Trash';
    var $components=array('Pagination','RequestHandler');
    var $helpers=array('Pagination','Html','Form','Javascript');
    var $uses=array("Category","Product","ProductI18n","ProductGallery","OrderProduct","ProductsCategory","ProductAttribute",
                    "ProviderProduct","ProductRank","ProductShippingFee","ProductDownload","ProductService");
    
    function index(){
        $this->pageTitle="回收站"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'产品管理','url'=>'');
        $this->navigations[]=array('name' => '回收站','url' => '/trash/');
        $this->set('navigations',$this->navigations);
        $this->Product->hasMany = array();
		$this->Product->hasOne = array('ProductI18n'     =>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 ) ,
					   		
                 	   );
        $this->Product->set_locale($this->locale);
        $condition["Product.status"]='2';
        
        if(true){
        if(isset($this->params['url']['category_id']) && $this->params['url']['category_id']!=0){
        	$category_id = $this->params['url']['category_id'];
    	    $this->Category->hasOne=array();
		  	$this->Category->tree_p('P',$category_id,$this->locale);
    	  	$category_ids = isset($this->Category->allinfo['subids'][$category_id])?$this->Category->allinfo['subids'][$category_id]:$category_id;
			$condition["and"]["Product.category_id"] = $category_ids;
        }

        if(isset($this->params['url']['keywords']) && $this->params['url']['keywords']!=''){
            $keywords=$this->params['url']['keywords'];
            $condition["and"]["or"]["Product.code like"] = "%$keywords%";
            $condition["and"]["or"]["ProductI18n.name like"] = "%$keywords%";
            $condition["and"]["or"]["ProductI18n.description like"] = "%$keywords%";
            $condition["and"]["or"]["Product.id like"] = "%$keywords%";
            $this->set('keywords',$this->params['url']['keywords']);
        }

        if(isset($this->params['url']['date']) && $this->params['url']['date']!=''){
        	$condition["and"]["Product.modified >="] = $this->params['url']['date']." 00:00:00";
            
            $this->set('date',$this->params['url']['date']);
        }
        if(isset($this->params['url']['date2']) && $this->params['url']['date2']!=''){
        	$condition["and"]["Product.modified <="] = $this->params['url']['date2']." 23:59:59";
            
            $this->set('date2',$this->params['url']['date2']);
        }

        }
        
        $total=$this->Product->findCount($condition,0);
        $sortClass='Product';
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=Array($rownum,$page);
        $options=Array();
        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
        $fields[]="Product.id";
        $fields[]="Product.code";
        $fields[]="Product.shop_price";
        $fields[]="Product.quantity";
        $fields[]="Product.recommand_flag";
        $fields[]="Product.modified";
        $fields[]="Product.forsale";
        $fields[]="ProductI18n.name"; 
        $products_list=$this->Product->find("all",array("conditions"=>$condition,"fields"=>$fields,"order"=>"Product.created DESC","limit"=>$rownum,"page"=>$page));
        
        $keywords=isset($this->params['form']['keywords']) ? $this->params['form']['keywords']: '';
        if(!empty($products_list))
        {
        	foreach($products_list as $k=>$v)
        	{
        		$products_list[$k]['Product']['format_shop_price'] = '';
        		$products_list[$k]['Product']['format_shop_price'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$v['Product']['shop_price']));
        	}
        }
        $this->Category->hasOne = array('CategoryI18n' =>   
                        array('className'    => 'CategoryI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,
                              'foreignKey'   => 'category_id'  
                        )
                  );

        $categories_tree= $this->Category->tree('P',$this->locale);
        $category_id=isset($this->params['url']['category_id']) ? $this->params['url']['category_id']: "0";

        $this->set('category_id',$category_id);
        $this->set('categories_tree',$categories_tree);
        $this->set('products_list',$products_list);
        $this->set('keywords',$keywords);
    }
    
    //单独处理回收站商品---还原商品
    function revert($id)
    {
    	$this->Product->updateAll(array('Product.status' => '1'),array('Product.id' => $id));
    	$pn = $this->ProductI18n->find('list',array('fields' => array('ProductI18n.product_id','ProductI18n.name'),'conditions'=> 
                                        array('ProductI18n.product_id'=>$id,'ProductI18n.locale'=>$this->locale)));
    	//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'还原商品:'.$pn[$id] ,'operation');
    	}
        $this->flash("该商品已还原",'/trash/',10);
    }
    
    //单独处理回收站商品---彻底删除商品
    function com_delete($id){
    	$this->Product->hasOne=array();
    	$this->Product->hasMany=array();
    	$product_info = $this->Product->findById($id);
    	
    	if (empty($product_info)){
        	$this->flash("该商品不存在",'/trash/',10);
        }
        else{
        	if ($product_info['Product']['status']!= 2){
        		$this->flash("该商品尚未放入回收站，不能删除",'/trash/',10);
        	}
        	else{
        		
        		if ($product_info['Product']['extension_code']=="download_product"){
        		   $this->ProductDownload->deleteAll(array('ProductDownload.product_id'=>$id));
        		}
        		if ($product_info['Product']['extension_code']=="services_product"){
        		   $this->ProductService->deleteAll(array('ProductService.product_id'=>$id));
        		}        		
        		/* 删除商品 */
        		$this->Product->del($id);
        		/* 删除相关表记录 */
        		$this->ProductsCategory->deleteAll(array('ProductsCategory.product_id'=>$id));
        		$this->ProductAttribute->deleteAll(array('ProductAttribute.product_id'=>$id));
        		$this->ProviderProduct->deleteAll(array('ProviderProduct.product_id'=>$id));
        		$this->ProductRank->deleteAll(array('ProductRank.product_id'=>$id));
        		$this->ProductShippingFee->deleteAll(array('ProductShippingFee.product_id'=>$id));
        		$this->ProductGallery->deleteAll(array('ProductGallery.product_id'=>$id));
        		$this->delDirAndFile("../img/products/".$product_info['Product']['code']);
        		//操作员日志
        		if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
        	    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除商品:'.$product_info['Product']['code'],'operation');
        		}
        	}
        }
    }
    
    //批量处理回收站的商品
    function batch()
    {
        $pro_ids=!empty($this->params['form']['checkboxes']) ? $this->params['form']['checkboxes']: array();
        if($this->params['form']['act_type'] == 'rev')
        {
            $this->Product->updateAll(array('Product.status' => '1'),array('Product.id' => $pro_ids));
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'批量还原商品' ,'operation');
    		}
            $this->flash("商品已还原",'/trash/','');
        }
		
        if($this->params['form']['act_type'] == 'del'){ 
        	$this->Product->hasOne=array();		
        	$this->Product->hasMany=array();
        	   	/* 删除相关表记录 */
        		$this->ProductsCategory->deleteAll(array('ProductsCategory.product_id'=>$pro_ids));
        		$this->ProductAttribute->deleteAll(array('ProductAttribute.product_id'=>$pro_ids));
        		$this->ProviderProduct->deleteAll(array('ProviderProduct.product_id'=>$pro_ids));
        		$this->ProductRank->deleteAll(array('ProductRank.product_id'=>$pro_ids));
        		$this->ProductShippingFee->deleteAll(array('ProductShippingFee.product_id'=>$pro_ids));
        		$this->ProductGallery->deleteAll(array('ProductGallery.product_id'=>$pro_ids));
        		
        	$product_info = $this->Product->find("all",array("conditions"=>array("id"=>$pro_ids)));
        	foreach( $product_info as $k=>$v ){
        		if ($v['Product']['extension_code']=="download_product"){
        		   $this->ProductDownload->deleteAll(array('ProductDownload.product_id'=>$v['Product']['id']));
        		}
        		if ($v['Product']['extension_code']=="services_product"){
        		   $this->ProductService->deleteAll(array('ProductService.product_id'=>$v['Product']['id']));
        		}        		

        		/* 删除商品 */
        		$this->Product->del($v['Product']['id']);
        						
        		$this->delDirAndFile("../img/products/".$v['Product']['code']);
        		
        	}
		}
        	 //操作员日志
        	 if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	     $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'批量删除商品' ,'operation');
    	     }
        	 $this->flash("商品已删除",'/trash/','');
        
    }
    //删除文件和目录
	function delDirAndFile( $dirName ){
		if ( file_exists($dirName)&&$handle = opendir( "$dirName" ) ) {
			while ( false !== ( $item = readdir( $handle ) ) ) {
				if ( $item != "." && $item != ".." ) {
					if ( is_dir( "$dirName/$item" ) ) {
		         		$this->delDirAndFile( "$dirName/$item" );
		       		} 
		       		else {
		         		unlink( "$dirName/$item" );
		       		}
	     		}
	   		}
		   	closedir( $handle );
		   	rmdir( $dirName );
	  	}
	}

}
?>