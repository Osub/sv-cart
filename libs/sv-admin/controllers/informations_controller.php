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
class InformationsController extends AppController {

	var $name = 'Informations';
    var $components = array ('Pagination','RequestHandler');
    var $helpers = array('Pagination');
	var $uses = array("InformationResource","InformationResourceI18n");
	
 	function index($orderby = 'created', $ordertype = 'desc'){
		/*判断权限*/
		$this->operator_privilege('system_resource_view');
		/*end*/
		$this->pageTitle = "系统信息库管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'系统信息库管理','url'=>'/system_resources/');
		$this->set('navigations',$this->navigations);
		$condition = "'1'";
		$this->InformationResource->set_locale($this->locale);
		$src_id = '';
		if(isset($this->params['url']['src_id']) && $this->params['url']['src_id']!=0){
			$src_id = $this->params['url']['src_id'];
            $condition.=" and InformationResource.id = '".$this->params['url']['src_id']."'";
            $this->set('src_id',$this->params['url']['src_id']);
        }
              
		$total = $this->InformationResource->findCount($condition." and InformationResource.parent_id='0'",0);
	    $sortClass = 'InformationResource';
	    $page = 1;
	    $rownum = isset($this->configs['show_count']) ? $this->configs['show_count'] : ((!empty($rownum)) ? $rownum : 20);
	    $parameters = Array($rownum,$page);
	    $options = Array();
	    $page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
	    $resource = $this->InformationResource->tree($condition,"InformationResource.$orderby $ordertype",$rownum,$page);//取所有信息库
//	    pr($resource);exit;
		$top_src = $this->InformationResource->findAll(array('parent_id'=>'0'));
		$this->set('top_src',$top_src);
		$this->set('resource',$resource);
	}
	//编辑页
	function edit($id){
		/*判断权限*/
		$this->operator_privilege('system_resource_view');
		/*end*/
		$this->pageTitle = "编辑信息库 - 信息库管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'信息库管理','url'=>'/system_resources/');
		$this->navigations[] = array('name'=>'编辑信息库','url'=>'');
		$this->set('navigations',$this->navigations);

		if($this->RequestHandler->isPost()){
			$this->data['InformationResource']['orderby'] = !empty($this->data['InformationResource']['orderby'])?$this->data['InformationResource']['orderby']:50;
			
			$this->InformationResource->save($this->data);
				foreach($this->data['InformationResourceI18n'] as $v){
              	    $system_resourceI18n_info = array(
		             				'id'=>	isset($v['id'])?$v['id']:'null',
		                           	'locale'=>	$v['locale'],
		                           	'system_resource_id'=>  $id+0 ,
		                           	'name'=>isset($v['name'])?$v['name']:'',
		                			'description'=>	isset($v['description'])?$v['description']:'',
		                			'modified'=>date("Y-m-d H:i:s")
		             );
		         $this->InformationResourceI18n->saveall(array('InformationResourceI18n'=>$system_resourceI18n_info));//更新多语言

		        }
			foreach( $this->data['InformationResourceI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑系统信息库:'.$userinformation_name ,'operation');
    	    }
			$this->flash("信息库 ".$userinformation_name." 编辑成功。点击这里继续编辑该菜单。",'/InformationResources/edit/'.$id,10);

		}
		//echo $id;
		$this->data = $this->InformationResource->localeformat($id);
	//	pr($this->data);exit;
		$this->InformationResource->set_locale($this->locale);
		$parentmenu = $this->InformationResource->findAll("InformationResource.parent_id='0'");
		$this->set('parentmenu',$parentmenu);
	
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$this->data["InformationResourceI18n"][$this->locale]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);

	}
	function add(){
		/*判断权限*/
		$this->operator_privilege('system_resource_view');
		/*end*/		
		$this->pageTitle = "添加信息库 - 信息库管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'信息库管理','url'=>'/system_resources/');
		$this->navigations[] = array('name'=>'新增信息库','url'=>'');
		$this->InformationResource->set_locale($this->locale);
		$this->set('navigations',$this->navigations);
		$result = $this->InformationResource->find("first",array("fields"=>"DISTINCT InformationResource.id","order"=>"InformationResource.id desc"));
		$newid = $result['InformationResource']['id']+1;
		$this->set('newid',$newid);
		if($this->RequestHandler->isPost()){
		//	pr($this->data['InformationResource']);exit;
			$this->data['InformationResource']['orderby'] = !empty($this->data['InformationResource']['orderby'])?$this->data['InformationResource']['orderby']:50;
			$this->InformationResource->saveAll(array("InformationResource"=>$this->data["InformationResource"]));
			$id=$this->InformationResource->getLastInsertId();
			//pr($this->data);exit;
			foreach($this->data['InformationResourceI18n'] as $k => $v){
				$v['system_resource_id']=$id;
				$this->InformationResourceI18n->saveAll(array("InformationResourceI18n"=>$v)); 
			}
			foreach( $this->data['InformationResourceI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加系统信息库:'.$userinformation_name ,'operation');
    	    }
			$this->flash("信息库 ".$userinformation_name."  添加成功。点击这里继续编辑该信息库。",'/system_resources/edit/'.$id,10);
		}
		$this->InformationResource->set_locale($this->locale);
		$resource_type = $this->InformationResource->findAll("parent_id='0'");
		//pr($resource_type);exit;
		$this->set('resource_type',$resource_type);
	}
	function remove($id){
		/*判断权限*/
		$this->operator_privilege('system_resource_view');
		/*end*/
		$system_info = $this->InformationResource->findById($id);
		$result = $this->InformationResource->findCount("parent_id='$id'");
		if($result)
			$this->flash('删除失败，改信息库还有子信息库','/InformationResources/','');
		else{
			$this->InformationResource->del($id);
			//操作员日志
  //  	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
 //   	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除系统信息库:'.$system_info['InformationResourceI18n']['name'] ,'operation');
  //  	    }
			$this->flash('删除成功',"/InformationResources/",'');
		}
	}

}

?>