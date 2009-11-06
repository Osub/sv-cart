<?php
/*****************************************************************************
 * SV-Cart 用户管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: votes_controller.php 3179 2009-07-22 05:09:18Z zhengli $
*****************************************************************************/
class WarnQuantityProductsController extends AppController {

	var $name = 'WarnQuantityProducts';
    var $components=array('Pagination','RequestHandler','Email');
    var $helpers=array('Pagination','Html','Form','Javascript','Tinymce');
    var $uses=array("Stock","ProviderProduct","MailSendQueue","MailTemplate","ProductLocalePrice","ProductShippingFee","Shipping","ProductGalleryI18n","ProductRank","TopicProduct","UserRank","Provider","BookingProduct","ProductType","ProductGallery","ProductRelation","ProductArticle","ProductTypeAttribute","ProductAttribute","ProductsCategory","Brand","BrandI18n","Category",'CategoryI18n',"Product","ProductI18n",'ProdcutVolume','SeoKeyword');
    function index($export=0,$orderby="number",$asc_desc="desc"){
    	/*判断权限*/
        $this->operator_privilege('warn_quantity_products_view');
        /*end*/
        $this->pageTitle="库存警告商品"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'进销存','url'=>'');
        $this->navigations[]=array('name' => '库存警告商品','url' => '/');
        $this->set('navigations',$this->navigations);
        $this->set('orderby',$orderby);

        $this->Product->hasMany = array();
		$this->Product->hasOne = array('ProductI18n'=>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 )
                 	   ); //
    	
        $this->Product->set_locale($this->locale);
		$condition = "";
		$condition["and"]["Product.status"] = "1";
		$condition["and"]["Product.status"] = "1";
		$condition["and"]["Product.extension_code"] = "";
		$condition["and"]["Product.extension_code"] = "";
        //高级库存 
        if(isset($this->configs['enable_advanced_stock_manage']) && $this->configs['enable_advanced_stock_manage']==1){}else{
        	$condition["and"]["Product.quantity <="] = "Product.warn_quantity";
        }
		//
        if(isset($this->params['url']['quantity']) && $this->params['url']['quantity']!=0){
        	$condition["and"]["Product.quantity <="] = $this->params['url']['quantity'] ;

        }
        if(isset($this->params['url']['forsale']) && $this->params['url']['forsale']!='99'){
        	$condition["and"]["Product.forsale ="] = $this->params['url']['forsale'];
        }
        if(isset($this->params['url']['promotion_status']) && $this->params['url']['promotion_status']!=0){
        	$condition["and"]["Product.promotion_status ="] =  $this->params['url']['promotion_status'] ;
            
        }
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
        if(isset($this->params['url']['min_price']) && $this->params['url']['min_price']!=''){

            $condition["and"]["Product.shop_price >="] = $this->params['url']['min_price'];
            $this->set('min_price',$this->params['url']['min_price']);
        }
        if(isset($this->params['url']['max_price']) && $this->params['url']['max_price']!=''){
        	$condition["and"]["Product.shop_price <="] = $this->params['url']['max_price'];
            $this->set('max_price',$this->params['url']['max_price']);
        }
        if(isset($this->params['url']['brand_id']) && $this->params['url']['brand_id']!=0){
        	$condition["and"]["Product.brand_id <="] = $this->params['url']['brand_id'];
        }
        if(isset($this->params['url']['type_id']) && $this->params['url']['type_id']!=''){
        	$condition["and"]["Product.product_type_id ="] = $this->params['url']['brand_id'];
        }
        if(isset($this->params['url']['date']) && $this->params['url']['date']!=''){
        	$condition["and"]["Product.created >="] = $this->params['url']['date']." 00:00:00";
            
            $this->set('date',$this->params['url']['date']);
        }
        if(isset($this->params['url']['date2']) && $this->params['url']['date2']!=''){
        	$condition["and"]["Product.created <="] = $this->params['url']['date2']." 23:59:59";
            
            $this->set('date2',$this->params['url']['date2']);
        }
        if(isset($this->params['url']['is_recommond']) && $this->params['url']['is_recommond']!=-1){
        	$condition["and"]["Product.recommand_flag ="] = $this->params['url']['is_recommond'];
            
        }
        if(isset($this->params['url']['provider_id']) && $this->params['url']['provider_id']!=-1){
        	$condition["and"]["Product.provider_id ="] = $this->params['url']['provider_id'];
            
        }

        //高级库存
        if(isset($this->configs['enable_advanced_stock_manage']) && $this->configs['enable_advanced_stock_manage']==1){
	      
        }else{
	        $total=$this->Product->findCount($condition,0);
	        $sortClass='Product';
	        $page=1;
	        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
	        $parameters=Array($rownum,$page);
	        $options=Array();
	        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
        }


        $fields[]="Product.id";
        $fields[]="Product.code";
        $fields[]="Product.shop_price";
        $fields[]="Product.quantity";
        $fields[]="Product.warn_quantity";
        $fields[]="Product.recommand_flag";
        $fields[]="Product.forsale";
        $fields[]="ProductI18n.name"; 
        //高级库存
        if(isset($this->configs['enable_advanced_stock_manage']) && $this->configs['enable_advanced_stock_manage']==1){
	        $fields[]="if( sum( Stock.quantity ) >0, sum( Stock.quantity ), -1) as stock_quantity"; 
        }else{
	        $this->Product->hasMany = array();
			$this->Product->hasOne = array('ProductI18n'=>array
													( 
													  'className'    => 'ProductI18n',   
						                              'order'        => '',   
						                              'dependent'    =>  true,   
						                              'foreignKey'   => 'product_id'
						                        	 )
	                 	   );
       		$this->Product->set_locale($this->locale);
			$products_list=$this->Product->find("all",array("conditions"=>$condition,"order"=>"Product.quantity ".$asc_desc,"fields"=>$fields,"limit"=>$rownum,"page"=>$page));
        }

        //高级库存
        if(isset($this->configs['enable_advanced_stock_manage']) && $this->configs['enable_advanced_stock_manage']==1){
	        $this->Product->hasMany = array();
			$this->Product->hasOne = array('ProductI18n'=>array
													( 
													  'className'    => 'ProductI18n',   
						                              'order'        => '',   
						                              'dependent'    =>  true,   
						                              'foreignKey'   => 'product_id'
						                        	 ),
											'Stock' =>   
					                        array('className'    => 'Stock',
					                        	  'conditions'    =>  '',   
					                              'order'        => '',   
					                              'dependent'    => true,   
					                              'foreignKey'   => 'product_id'  
					                        	)
	                 	   );
       		$this->Product->set_locale($this->locale);
       		
	        $total=count($this->Product->find("all",array("conditions"=>$condition,"group"=>array("Product.id HAVING Product.warn_quantity>=stock_quantity"),"fields"=>$fields)));
	        $sortClass='Product';
	        $page=1;
	        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
	        $parameters=Array($rownum,$page);
	        $options=Array();
	        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);

			$products_list=$this->Product->find("all",array("conditions"=>$condition,"order"=>"stock_quantity ".$asc_desc,"group"=>array("Product.id HAVING Product.warn_quantity>=stock_quantity"),"fields"=>$fields,"limit"=>$rownum,"page"=>$page,"HAVING"=>"Product.quantity=0"));
        }else{
        }
        //高级库存
        if(isset($this->configs['enable_advanced_stock_manage']) && $this->configs['enable_advanced_stock_manage']==1){
        	foreach( $products_list as $k=>$v ){
        		$stock_info = $this->Stock->find("all",array("conditions"=>array("product_id"=>$v["Product"]["id"]),"group"=>"product_id","fields"=>array("sum(quantity) as quantity")));
        		$products_list[$k]["Product"]["quantity"] = empty($stock_info[0][0]["quantity"])?0:$stock_info[0][0]["quantity"];
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
       
        $this->Brand->set_locale($this->locale);
        $brands_tree=$this->Brand->getbrandformat();
        $types_tree=$this->ProductType->gettypeformat();
        $provides_tree=$this->Provider->get_provider_list();
        $category_id=isset($this->params['url']['category_id']) ? $this->params['url']['category_id']: "0";
        $forsale=isset($this->params['url']['forsale']) ? $this->params['url']['forsale']: "99";
        $brand_id=isset($this->params['url']['brand_id']) ? $this->params['url']['brand_id']: "0";
        $type_id=isset($this->params['url']['type_id']) ? $this->params['url']['type_id']: "0";
        $keywords=isset($this->params['url']['keywords']) ? $this->params['url']['keywords']: '';
        $min_price=isset($this->params['url']['min_price']) ? $this->params['url']['min_price']: '';
        $max_price=isset($this->params['url']['max_price']) ? $this->params['url']['max_price']: '';
        $start_date=isset($this->params['url']['start_date']) ? $this->params['url']['start_date']: '';
        $end_date=isset($this->params['url']['end_date']) ? $this->params['url']['end_date']: '';
        $is_recommond=isset($this->params['url']['is_recommond']) ? $this->params['url']['is_recommond']: "-1";
        $provider_id=isset($this->params['url']['provider_id']) ? $this->params['url']['provider_id']: "-1";
        if($asc_desc == "asc"){
        	$asc_desc = "desc";
        }
        else{
        	$asc_desc = "asc";
        }
        
        $this->set('asc_desc',$asc_desc);
        $this->set('forsale',$forsale);
        $this->set('products_list',$products_list);
        $this->set('navigations',$this->navigations);
        $this->set('categories_tree',$categories_tree);
        $this->set('brands_tree',$brands_tree);
        $this->set('types_tree',$types_tree);
        $this->set('provides_tree',$provides_tree);
        $this->set('category_id',$category_id);
        $this->set('brand_id',$brand_id);
        $this->set('type_id',$type_id);
        $this->set('keywords',$keywords);
        $this->set('min_price',$min_price);
        $this->set('max_price',$max_price);
        $this->set('start_date',$start_date);
        $this->set('end_date',$end_date);
        $this->set('is_recommond',$is_recommond);
        $this->set('provider_id',$provider_id);
        $this->set('total',$total);
        /*CSV导出*/
     	if(isset($export) && $export==="export"){
            $filename='商品导出'.date('Ymd').'.csv';
            $ex_data="商品统计报表,";
            $ex_data.="日期,";
            $ex_data.=date('Y-m-d')."\n";
            $ex_data.="编号,";
            $ex_data.="商品名称,";
            $ex_data.="货号,";
            $ex_data.="库存,";
            $ex_data.="价格,";
            $ex_data.="上架,";
            $ex_data.="推荐\n";
            foreach($products_list as $k => $v){
                $ex_data.=$v['Product']['id'].",";
                $ex_data.=$v['ProductI18n']['name'].",";
                $ex_data.=$v['Product']['code'].",";
                $ex_data.=$v['Product']['quantity'].",";
                $ex_data.=$v['Product']['shop_price'].",";
                if($v['Product']['forsale']=="1"){
                    $ex_data.="是,";
                }
                else{
                    $ex_data.="否,";
                }
                if($v['Product']['recommand_flag']=="1"){
                    $ex_data.="是\n";
                }
                else{
                    $ex_data.="否\n";
                }
            }
            Configure::write('debug',0);
            header("Content-type: text/csv; charset=gb2312");
            header("Content-Disposition: attachment; filename=".iconv('utf-8','gb2312',$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8','gb2312',$ex_data."\n");
            exit;
        }
    }

}

?>