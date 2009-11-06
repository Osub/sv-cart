<?php
/*****************************************************************************
 * SV-Cart 供应商
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: providers_controller.php 4820 2009-10-09 12:22:53Z huangbo $
*****************************************************************************/
class ProvidersController extends AppController {
	var $name = 'Providers';

    var $components = array ('Pagination','RequestHandler','Email'); // Added 
    var $helpers = array('Pagination'); // Added 
	var $uses = array('Provider','Product','ProductI18n','ProductType','Category','ProviderProduct','SeoKeyword');

	function index(){
		/*判断权限*/
		$this->operator_privilege('supplier_view');
		/*end*/
		$this->pageTitle = "供应商"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'进销存','url'=>'');
		$this->navigations[] = array('name'=>'供应商','url'=>'/providers/');
		$this->set('navigations',$this->navigations);
		
		$name = $this->data['provider']['name']; 
		$status = $this->data['provider']['status']; 
		$wh["or"]['meta_keywords LIKE'] = "%".$name."%";
		$wh["or"]['name LIKE'] = "%".$name."%";
		$wh["or"]['contact_email LIKE'] = "%".$name."%";
		$wh["or"]['contact_name LIKE'] = "%".$name."%";
		if( $status != "all" && $status!=""){
			$wh["and"]['status'] = $status;
		}
		$this->set('keyword_name',$name);
		$this->set('status',$status);
		
		$provider_list=$this->Provider->findAll($wh,'','orderby');
		foreach( $provider_list as $k=>$v ){
			$Provider_id = $v['Provider']['id'];
			$condition['Product.provider_id'] = $Provider_id;
			$total = $this->Product->findCount($condition,0);
			$provider_list[$k]['Provider']['total'] = $total;
		}

		
		$this->set('provider_list',$provider_list);
	}
	
	function edit($id){
		/*判断权限*/
		$this->operator_privilege('supplier_operation');
		/*end*/
		$this->pageTitle = "编辑供应商 - 供应商"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'进销存','url'=>'');
		$this->navigations[] = array('name'=>'供应商','url'=>'/providers/');
		$this->navigations[] = array('name'=>'编辑供应商','url'=>'');
		
		
		if($this->RequestHandler->isPost()){
			if( !empty($this->data['Provider']['name']) ){
				$this->data['Provider']['orderby'] = !empty($this->data['Provider']['name'])?$this->data['Provider']['name']:50;
				$this->Provider->deleteall("id = ".$this->data['Provider']['id'],false); 
				$this->Provider->saveall($this->data); //保存
				//操作员日志
    	        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑供应商:'.$this->data['Provider']['name'] ,'operation');
            	}
				$this->flash("供应商 ".$this->data['Provider']['name']." 编辑成功。点击这里继续编辑该供应商。",'/providers/edit/'.$id,10);
			}
		}
		$provider_edit=$this->Provider->findbyid( $id );
		$this->set('provider_edit',$provider_edit);
		$condition['Product.provider_id'] = $id;
		$this->Product->set_locale($this->locale);
		$condition[' Product.status '] = 1;
		$product_list = $this->Product->findall( $condition );
		$this->set('providerid',$id);
		$this->set('product_list',$product_list);
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$provider_edit["Provider"]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);
			//关键字
			$seokeyword_data = $this->SeoKeyword->find("all",array("conditions"=>array("status"=>1)));
			$this->set("seokeyword_data",$seokeyword_data);

	}

	function trash($id,$pid){
		
	  	 $this->Product->updateAll(
			              array('Product.status' => 2),
			              array('Product.id' => $id)
			           );
		 $pn = $this->ProductI18n->find('list',array('fields' => array('ProductI18n.product_id','ProductI18n.name'),'conditions'=> 
                        array('ProductI18n.product_id'=>$id,'ProductI18n.locale'=>$this->locale)));
         $prn = $this->Provider->find('list',array('fields' => array('Provider.id','Provider.name'),'conditions'=> 
                        array('Provider.id'=>$pid)));
		 //操作员日志
    	 if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	 $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'回收供应商 '.$prn[$pid].' 商品:'.$pn[$id] ,'operation');
         }
         $this->flash("该商品已经进入回收站",'/providers/',10);
	}


	function remove($id){
		/*判断权限*/
		$this->operator_privilege('supplier_operation');
		/*end*/
		$pn = $this->Provider->find('list',array('fields' => array('Provider.id','Provider.name'),'conditions'=> 
                                        array('Provider.id'=>$id)));
		$this->Provider->deleteAll("Provider.id='$id'");
		//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除供应商:'.$pn[$id] ,'operation');
    	}
		$this->flash("删除成功",'/providers/',10);
    }
	function add(){
		/*判断权限*/
		$this->operator_privilege('supplier_add');
		/*end*/
		$this->pageTitle = "编辑供应商 - 供应商"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'进销存','url'=>'');
		$this->navigations[] = array('name'=>'供应商','url'=>'/providers/');
		$this->navigations[] = array('name'=>'新增供应商','url'=>'');
		$this->set('navigations',$this->navigations);

		if($this->RequestHandler->isPost()){
			if( !empty($this->data['Provider']['name']) ){
				$this->data['Provider']['orderby'] = !empty($this->data['Provider']['orderby'])?$this->data['Provider']['orderby']:50;
				$this->data['Provider']['description'] = !empty($this->data['Provider']['description'])?$this->data['Provider']['description']:"";
				$this->Provider->save($this->data['Provider']); //保存
				//操作员日志
    	        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加供应商:'.$this->data['Provider']['name'] ,'operation');
            	}
				$id=$this->Provider->id;
				$this->flash("供应商 ".$this->data['Provider']['name']." 编辑成功。点击这里继续编辑该供应商。",'/providers/edit/'.$id,10);

			}else{
				//$this->flash("请输入供应商名称",'/providers/','');
			}
		}
			//关键字
			$seokeyword_data = $this->SeoKeyword->find("all",array("conditions"=>array("status"=>1)));
			$this->set("seokeyword_data",$seokeyword_data);

   	}
	function product(){
		/*判断权限*/
		$this->operator_privilege('providers_product_view');
		/*end*/
		$this->pageTitle = "供应商商品 - 供应商商品"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'进销存','url'=>'');
		$this->navigations[] = array('name'=>'供应商商品','url'=>'/providers/product');

		$this->set('navigations',$this->navigations);
		$condition = "";
        if(isset($this->params['url']['providerkeywords']) && $this->params['url']['providerkeywords']!=''){
            $providerkeywords=$this->params['url']['providerkeywords'];
            $condition["and"]["or"]["Provider.name like"] = "%$providerkeywords%";
            $condition["and"]["or"]["Provider.description like"] = "%$providerkeywords%";
            $condition["and"]["or"]["Provider.meta_keywords like"] = "%$providerkeywords%";
            $condition["and"]["or"]["Provider.meta_description like"] = "%$providerkeywords%";
            $condition["and"]["or"]["Provider.contact_name like"] = "%$providerkeywords%";
            $condition["and"]["or"]["Provider.contact_email like"] = "%$providerkeywords%";
            $condition["and"]["or"]["Provider.contact_address like"] = "%$providerkeywords%";
            $this->set('providerkeywords',$this->params['url']['providerkeywords']);
        }
        if(isset($this->params['url']['productkeywords']) && $this->params['url']['productkeywords']!=''){
            $productkeywords=$this->params['url']['productkeywords'];
            $condition["and"]["or"]["Product.code like"] = "%$productkeywords%";
            $condition["and"]["or"]["ProductI18n.name like"] = "%$productkeywords%";
            $condition["and"]["or"]["ProductI18n.description like"] = "%$productkeywords%";
            $condition["and"]["or"]["Product.id like"] = "%$productkeywords%";
            $this->set('providerkeywords',$this->params['url']['providerkeywords']);
        }


		$ProviderProduct_list=$this->ProviderProduct->find("all",array("conditions"=>$condition,"order"=>"Provider.orderby"));

		$this->set("ProviderProduct_list",$ProviderProduct_list);
	}
	function product_add(){
		$this->pageTitle = "供应商商品 - 供应商商品"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'进销存','url'=>'');
		$this->navigations[] = array('name'=>'供应商商品','url'=>'/providers/product');
		$this->navigations[] = array('name'=>'新增供应商商品','url'=>'');
		$this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
		
			$this->ProviderProduct->hasOne=array();
			$this->ProviderProduct->saveAll($this->data["ProviderProduct"]); //保存
			$this->flash("供应商商品 添加成功。点击这里继续编辑该供应商商品。",'/providers/product_edit/'.$this->ProviderProduct->getLastInsertId(),10);
		}
		$this->Product->hasMany = array();
		$this->Product->hasOne = array('ProductI18n'=>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 )
                 	   );
		$fields[]="Product.id";
        $fields[]="ProductI18n.name"; 
		$products_list=$this->Product->find("all",array("fields"=>$fields));
		$this->set("products_list",$products_list);
		$this->Provider->hasMany = array();
		$Provider_list=$this->Provider->find("all");
		$this->set("Provider_list",$Provider_list);
	}
	function product_edit($id){
		$this->pageTitle = "供应商商品 - 供应商商品"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'进销存','url'=>'');
		$this->navigations[] = array('name'=>'供应商商品','url'=>'/providers/product');
		$this->navigations[] = array('name'=>'编辑供应商商品','url'=>'');
		$this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
			$this->data["ProviderProduct"]["id"] = $id;
			$this->ProviderProduct->hasOne=array();
			$this->ProviderProduct->saveAll($this->data["ProviderProduct"]); //保存
			$this->flash("供应商商品  编辑成功。点击这里继续编辑该供应商商品。",'/providers/product_edit/'.$id,10);
		}
		$this->Product->hasMany = array();
		$this->Product->hasOne = array('ProductI18n'=>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 )
                 	   );
		$fields[]="Product.id";
        $fields[]="ProductI18n.name"; 
		$products_list=$this->Product->find("all",array("fields"=>$fields));
		$this->set("products_list",$products_list);
		$this->Provider->hasMany = array();
		$Provider_list=$this->Provider->find("all");
		$this->set("Provider_list",$Provider_list);
		$ProviderProduct_info = $this->ProviderProduct->findById($id);
		$this->set("ProviderProduct_info",$ProviderProduct_info);
	
	}
	function product_remove($id){	
		$this->ProviderProduct->del($id);
		die();
	}

}

?>