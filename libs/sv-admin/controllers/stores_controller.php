<?php
/*****************************************************************************
 * SV-Cart 店铺管理管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: stores_controller.php 5339 2009-10-22 09:16:41Z huangbo $
*****************************************************************************/
class StoresController extends AppController {

	var $name = 'Stores';

	var $helpers = array('Html','Pagination','Tinymce','fck');
	var $components = array ('Pagination','RequestHandler','Email'); 
	var $uses = array("Store","StoreI18n","SystemResource",'SeoKeyword');
	

	function index(){
		/*判断权限*/
		$this->operator_privilege('entity_shop_view');
		/*end*/
		$this->pageTitle = "店铺管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'内部管理','url'=>'');
		$this->navigations[] = array('name'=>'店铺管理','url'=>'/stores/');
		$this->set('navigations',$this->navigations);
        
        $this->Store->set_locale($this->locale);
   	    $condition='';
   	    $total = count($this->Store->find("all",array("conditions"=>$condition,"fields"=>"DISTINCT Store.id")));
	    $sortClass='Store';
	    $page=1;
		$rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);

	    $parameters=Array($rownum,$page);
	    $options=Array();
     	$page  = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
		$store_list=$this->Store->findAll($condition,'',"Store.orderby",$rownum,$page);
		
   		$this->set('store_list',$store_list);
	}

	function remove($id){
		/*判断权限*/
		$this->operator_privilege('entity_shop_operation');
		/*end*/
		$pn = $this->StoreI18n->find('list',array('fields' => 
			array('StoreI18n.store_id','StoreI18n.name'),'conditions'=> 
                                        array('StoreI18n.store_id'=>$id,'StoreI18n.locale'=>$this->locale)));
		$this->Store->deleteAll("Store.id='$id'");
		//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除店铺:'.$pn[$id] ,'operation');
    	}
		$this->flash("删除成功",'/stores/',10);
    }
	function edit($id){
		/*判断权限*/
		$this->operator_privilege('entity_shop_operation');
		/*end*/
		$this->pageTitle = "店铺部门 - 店铺管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'内部管理','url'=>'');
		$this->navigations[] = array('name'=>'店铺管理','url'=>'/stores/');
		$this->navigations[] = array('name'=>'编辑店铺','url'=>'');
		
		if($this->RequestHandler->isPost()){
			$this->data['Store']['orderby'] = !empty($this->data['Store']['orderby'])?$this->data['Store']['orderby']:50;
			$this->Store->save($this->data); //保存
			foreach($this->data['StoreI18n'] as $v){
				$storeI18n_info=array(
		                           'id'					=>	isset($v['id'])?$v['id']:'',
		                           'locale'				=>	$v['locale'],
		                           'store_id'			=> 	isset($v['store_id'])?$v['store_id']:$id,
		                           'name'				=>	isset($v['name'])?$v['name']:'',
		                           'meta_keywords'		=> 	isset($v['meta_keywords'])?$v['meta_keywords']:'',
		                           'description'		=>	isset($v['description'])?$v['description']:'',
		                           'address'			=>	isset($v['address'])?$v['address']:'',
		                           'map'				=>	isset($v['map'])?$v['map']:'',
		                           'transport'			=>	isset($v['transport'])?$v['transport']:'',
		                           'url'				=>	isset($v['url'])?$v['url']:'',
		                           'telephone'			=>	isset($v['telephone'])?$v['telephone']:'',
		                           'zipcode'			=>	isset($v['zipcode'])?$v['zipcode']:'',
		                           'meta_keywords'		=>	isset($v['meta_keywords'])?$v['meta_keywords']:'',
		                           'meta_description'	=>	isset($v['meta_description'])?$v['meta_description']:''
		                        
		                     );
		                     $this->StoreI18n->saveall(array('StoreI18n'=>$storeI18n_info));//更新多语言
            }
			
			
			foreach( $this->data['StoreI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
			//操作员日志
        	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑店铺:'.$userinformation_name ,'operation');
    	    }
			$this->flash("店铺  ".$userinformation_name." 编辑成功。点击这里继续编辑该店铺。",'/stores/edit/'.$id,10);
			
		}
		$this->data=$this->Store->localeformat($id);
			//	pr($this->data);
		$this->set('stores_info',$this->data);
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$this->data["StoreI18n"][$this->locale]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated(false);//find("first",array("conditions"=>array("code"=>"order_status")));
       	//
       
		$this->set('systemresource_info',$systemresource_info);
			//关键字
			$seokeyword_data = $this->SeoKeyword->find("all",array("conditions"=>array("status"=>1)));
			$this->set("seokeyword_data",$seokeyword_data);

	}
	
	function add(){
		/*判断权限*/
		$this->operator_privilege('entity_shop_add');
		/*end*/

		$this->pageTitle = "店铺部门 - 店铺管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'内部管理','url'=>'');
		$this->navigations[] = array('name'=>'店铺管理','url'=>'/stores/');
		$this->navigations[] = array('name'=>'编辑店铺','url'=>'');
		$this->set('navigations',$this->navigations);
		
		if($this->RequestHandler->isPost()){
			$this->data['Store']['orderby'] = !empty($this->data['Store']['orderby'])?$this->data['Store']['orderby']:50;
			$this->Store->save($this->data); //保存
			$id=$this->Store->id;

			if(is_array($this->data['StoreI18n']))
				foreach($this->data['StoreI18n'] as $k => $v){
					$v['store_id']=$id;
					$this->StoreI18n->id='';
					$this->StoreI18n->save($v); 
			    }
			foreach( $this->data['StoreI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
			//操作员日志
        	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加店铺:'.$userinformation_name ,'operation');
    	    }
			$this->flash("店铺  ".$userinformation_name." 编辑成功。点击这里继续编辑该店铺。",'/stores/edit/'.$id,10);

		}
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated(false);//find("first",array("conditions"=>array("code"=>"order_status")));
       	//
       
		$this->set('systemresource_info',$systemresource_info);
		//关键字
		$seokeyword_data = $this->SeoKeyword->find("all",array("conditions"=>array("status"=>1)));
		$this->set("seokeyword_data",$seokeyword_data);

	}
}

?>