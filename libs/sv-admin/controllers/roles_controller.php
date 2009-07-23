<?php
/*****************************************************************************
 * SV-Cart 角色管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: roles_controller.php 3184 2009-07-22 06:09:42Z huangbo $
*****************************************************************************/
class RolesController extends AppController {

	var $name = 'OperatorRoles';

	var $helpers = array('Html','Pagination');
	var $components = array ('Pagination','RequestHandler','Email'); // Added 
	var $uses = array("OperatorRole","OperatorRoleI18n","Operator","Operator_action","Operator_actionI18n","Department",'DepartmentI18n');
	

 
	function index(){
		/*判断权限*/
		$this->operator_privilege('role_view');
		/*end*/
		$this->pageTitle = "角色管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'角色管理','url'=>'/stores/');
		$this->set('navigations',$this->navigations);
		
        $this->OperatorRole->set_locale($this->locale);
   	    $condition='';
   	    //角色搜索筛选条件
   	    if(isset($this->params['url']['role_name']) && !empty($this->params['url']['role_name'])){
   	    		$condition ="  OperatorRoleI18n.name like '%".$this->params['url']['role_name']."%'";
	    }
   	    $total = $this->OperatorRole->findCount($condition,0);
	    $sortClass='OperatorRole';
	    $page=1;
	    $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	    $parameters=Array($rownum,$page);
	    $options=Array();
	    $page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
	    
        $res=$this->OperatorRole->findAll($condition,'',"OperatorRole.created DESC",$rownum,$page);
        $condition='';
		$roles=$this->Operator->findAll();
		//pr($res);
		//pr( $role_id );
		$role_list=array();
		$i=1;
		if(is_array($res))
			foreach($res as $k=>$v)
			{
                $role_list[$v['OperatorRole']['id']]['OperatorRole']=$v['OperatorRole'];
                if(is_array($v['OperatorRoleI18n'])){
				    $role_list[$v['OperatorRole']['id']]['OperatorRoleI18n']=$v['OperatorRoleI18n'];
				}

				foreach( $roles as $key=>$value ){
		  			    $role_id = $value['Operator']['role_id'];
		  		    	$arr = explode(";",$role_id);
							if( in_array ($role_list[$v['OperatorRole']['id']]['OperatorRole']['id'], $arr) ){
								$i++;
							}
						}
						$role_list[$v['OperatorRole']['id']]['OperatorRole']['number']=$i;$i=0;
				$action = $role_list[$v['OperatorRole']['id']]['OperatorRole']['actions'];
				$action_id_arr = explode(";",$action);
				//pr($action_id_arr);
				$actions = "";
				$this->Operator_action->set_locale($this->locale);
				for( $j=0; $j<=count($action_id_arr)-1;$j++ ){
					$condition['Operator_action.id'] = $action_id_arr[$j];
					$operator_action = $this->Operator_action->findAll( $condition );
				
					foreach( $operator_action as $kk=>$vv ){
						$actions.= $vv['Operator_actionI18n']['name']."|";
						
					}
				}
				$role_list[$v['OperatorRole']['id']]['OperatorRole']['actionses']=$actions;
			}
			$role_name=isset($this->params['url']['role_name'])?$this->params['url']['role_name']:'';
			
			
		//pr($role_list);
		$this->set('role_list',$role_list);
		$this->set('role_name',$role_name);
	}
	function edit($id){
		/*判断权限*/
		$this->operator_privilege('role_edit');
		/*end*/
		$this->pageTitle = "编辑角色 - 角色管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'角色管理','url'=>'/roles/');
		$this->navigations[] = array('name'=>'角色编辑','url'=>'');
		$departments = $this->Department->findAssoc();	//取得部门列表
		$this->set('departments',$departments);
		$operators = $this->Operator->findAll();//取得操作员列表
		$this->set('operators',$operators);	
		$this->set('navigations',$this->navigations);
		$this->set('role_id',$id);
		if($this->RequestHandler->isPost()){
		
			$this->data['OperatorRole']['orderby'] = !empty($this->data['OperatorRole']['orderby'])?$this->data['OperatorRole']['orderby']:50;
				$this->OperatorRole->deleteall(" OperatorRole.id =". $this->data['OperatorRole']['id'],false); 
				$this->OperatorRoleI18n->deleteall("operator_role_id = ".$this->data['OperatorRole']['id'],false); 
				if(isset($_REQUEST['competence'])){
					$competence = $_REQUEST['competence'];
				 	$competence = implode(";",$competence);
					$this->data['OperatorRole']['actions'] = $competence;
				}
				$this->OperatorRole->saveall($this->data); //保存
				foreach($this->data['OperatorRoleI18n'] as $v){
              	     	    $operatorrolei18n_info=array(
		                           'id'=>	isset($v['id'])?$v['id']:'',
		                           'locale'=>	$v['locale'],
		                           'operator_role_id'=> isset($v['operator_role_id'])?$v['operator_role_id']:$id,
		                           'name'=>	isset($v['name'])?$v['name']:''
		                     );
		                     $this->OperatorRoleI18n->saveall(array('OperatorRoleI18n'=>$operatorrolei18n_info));//更新多语言
              	     }
              	foreach($operators as $k=>$v){
              		if($v['Operator']['role_id'] == 0){
              			if(isset($_REQUEST['operators']) && count($_REQUEST['operators']) > 0){
              				if(in_array($v['Operator']['id'],$_REQUEST['operators'])){
	              				$operators[$k]['Operator']['role_id'] = $this->data['OperatorRole']['id'];
	              				$this->Operator->save($operators[$k]);
              				}
              			}
              		}else{
              			$role_ids = explode(';',$v['Operator']['role_id'].";");
              			foreach($role_ids as $key=>$vaule){
              				if(empty($vaule)){
              					unset($role_ids[$key]);
              				}
              			}
              			if($v['Operator']['id'] == 13){
              	
              			}
              			if(in_array($this->data['OperatorRole']['id'],$role_ids)){
              				if(isset($_REQUEST['operators']) && count($_REQUEST['operators']) > 0){
	              				if(in_array($v['Operator']['id'],$_REQUEST['operators'])){
	              					
	              				}else{
	              					foreach($role_ids as $kkk=>$vvv){
	              						if($vvv == $this->data['OperatorRole']['id']){
	              							unset($role_ids[$kkk]);
	              						}
	              					}
	              				$operators[$k]['Operator']['role_id'] =	implode(";",$role_ids);
	              				$this->Operator->save($operators[$k]);
	              				}
              				}
              			}else{
              				if(isset($_REQUEST['operators']) && count($_REQUEST['operators']) > 0){
              					if(in_array($v['Operator']['id'],$_REQUEST['operators'])){
	              					$operators[$k]['Operator']['role_id'] .= ";".$this->data['OperatorRole']['id'];
	              					$this->Operator->save($operators[$k]);
              					}
              				}
              			}
              		}
              	}
				foreach( $this->data['OperatorRoleI18n'] as $k=>$v ){
					if($v['locale'] == $this->locale){
						$userinformation_name = $v['name'];
					}
				}
				//操作员日志
    	        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑角色:'.$userinformation_name ,'operation');
    	        }
				$this->flash("角色  ".$userinformation_name." 编辑成功。点击继续编辑该角色。",'/roles/edit/'.$id,10);


			
		}
		
		$this->data=$this->OperatorRole->localeformat($id);
		$this->Operator_action->set_locale($this->locale);
		$operatoraction = $this->Operator_action->alltree_hasname();
		$this->set('operatoraction',$operatoraction);
		$this->set('actions_arr',explode(";",$this->data['OperatorRole']['actions']));
		$this->set('operatorrole',$this->data);
	
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$this->data["OperatorRoleI18n"][$this->locale]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);

	}
	
	function add(){
		/*判断权限*/
		$this->operator_privilege('role_add');
		/*end*/
		$this->pageTitle = "添加角色 - 角色管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'角色管理','url'=>'/roles/');
		$this->navigations[] = array('name'=>'角色添加','url'=>'');
		$this->set('navigations',$this->navigations);
		$departments = $this->Department->findAssoc();	//取得部门列表
		$this->set('departments',$departments);
		$operators = $this->Operator->findAll();//取得操作员列表
		$this->set('operators',$operators);	
	  //pr($departments);

		if($this->RequestHandler->isPost()){
			$this->data['OperatorRole']['orderby'] = !empty($this->data['OperatorRole']['orderby'])?$this->data['OperatorRole']['orderby']:50;
			$this->data['OperatorRole']['store_id'] = !empty($this->data['OperatorRole']['store_id'])?$this->data['OperatorRole']['store_id']:0;
			$this->data['OperatorRole']['actions'] = !empty($this->data['OperatorRole']['actions'])?$this->data['OperatorRole']['actions']:0;
			      if(isset($_REQUEST['competence'])){
				       $competence = $_REQUEST['competence'];
				       $competence = implode(";",$competence);
				       $this->data['OperatorRole']['actions'] = $competence;
			       }
			      $this->OperatorRole->saveall($this->data['OperatorRole']); //保存
			      $id=$this->OperatorRole->id;
			      //新增角色多语言
			   	  if(is_array($this->data['OperatorRoleI18n'])){
			          foreach($this->data['OperatorRoleI18n'] as $k => $v){
				            $v['operator_role_id']=$id;
				            $this->OperatorRoleI18n->id='';
				            $this->OperatorRoleI18n->saveall(array("OperatorRoleI18n"=>$v)); 
			           }
			      }
			      if(isset($_REQUEST['operators']) && count($_REQUEST['operators'])>0){
			      	  foreach($_REQUEST['operators'] as $k=>$v){

			      	  	    $operator = $this->Operator->findbyid($v);
			      	  	    if(!empty($operator['Operator']['role_id'])){			      	  	   
								$operator['Operator']['role_id'] .=";".$id;			
			      	  	    }else{
			      	  	    	$operator['Operator']['role_id'] = $id;
			      	  	    }
			      	  	 	$this->Operator->save($operator);
			      	  }
			      }
			      
				foreach( $this->data['OperatorRoleI18n'] as $k=>$v ){
					if($v['locale'] == $this->locale){
						$userinformation_name = $v['name'];
					}
				}
				//操作员日志
    	        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加角色:'.$userinformation_name ,'operation');
    	        }
				$this->flash("角色  ".$userinformation_name." 编辑成功。点击继续编辑该角色。",'/roles/edit/'.$id,10);

			//}
			
		}
		$this->Operator_action->set_locale($this->locale);
		$operatoraction = $this->Operator_action->alltree();
		
		foreach( $operatoraction as $k=>$v ){
			$operatoraction[$k]['Operator_action']['name'] = $v['Operator_actionI18n']['name'];
			if( isset($v['SubAction']) ){
				foreach($v['SubAction'] as $kk=>$vv){
					$operatoraction[$k]['SubAction'][$kk]['Operator_action']['name'] = $vv['Operator_actionI18n']['name'];
				}
			}			
		}
			$this->set('operatoraction',$operatoraction);
		}

	


	
	function remove($id){
		/*判断权限*/
		$this->operator_privilege('role_edit');
		/*end*/
		$pn = $this->OperatorRoleI18n->find('list',array('fields' => array('OperatorRoleI18n.operator_role_id','OperatorRoleI18n.name'),'conditions'=> 
                     array('OperatorRoleI18n.operator_role_id'=>$id,'OperatorRoleI18n.locale'=>$this->locale)));
		$this->OperatorRole->deleteAll("OperatorRole.id='$id'");
		//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除角色:'.$pn[$id],'operation');
    	}
		$this->flash("删除成功",'/roles/',10);
    }
	
}

?>