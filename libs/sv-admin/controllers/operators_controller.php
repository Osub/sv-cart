<?php
/*****************************************************************************
 * SV-Cart 操作员管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: operators_controller.php 4691 2009-09-28 10:11:57Z huangbo $
*****************************************************************************/
class OperatorsController extends AppController {
	var $name = 'Operators';
	var $helpers = array('Html','Pagination');
	var $components = array ('Pagination','RequestHandler'); 
	var $uses = array('Operator','OperatorRole','Department','Operator_action','Language');
	
	function index () {
		/*判断权限*/
		$this->operator_privilege('operator_view');
		/*end*/
		$this->pageTitle = "操作员管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'内部管理','url'=>'');
		$this->navigations[] = array('name'=>'操作员管理','url'=>'/operators/');
		$this->set('navigations',$this->navigations);
		$this->Department->set_locale($this->locale);
		$condition='';
		//操作员搜索筛选条件
		if(isset($this->params['url']['operator_email']) && !empty($this->params['url']['operator_email'])){
	   	       $condition["Operator.email like"]="%".$this->params['url']['operator_email']."%";
	    }
	    if(isset($this->params['url']['operator_depart']) && ($this->params['url']['operator_depart'] != '所有部门')){
	   	       $condition["Operator.department_id"]=$this->params['url']['operator_depart'];
	   	       $this->set("operator_depart",$this->params['url']['operator_depart']);
	    }
	    if(isset($this->params['url']['operator_name']) && !empty($this->params['url']['operator_name'])){
	    	   $condition["Operator.name like"]="%".$this->params['url']['operator_name']."%";
	    }
   	    $total = $this->Operator->findCount($condition,0);
	    $sortClass='Operator';
	    $page=1;
	    $rownum=20;
	    $parameters=Array($rownum,$page);
	    $options=Array();
		$page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
		$departments = $this->Department->findAssoc();//取得部门列表
		$this->OperatorRole->set_locale($this->locale);
		$roles = $this->OperatorRole->findAll();//取得角色列表
		$operators = $this->Operator->findAll($condition, '', 'Operator.created', $rownum, $page);//取得操作员列表		
		
		foreach($operators as $k => $v){
			$v['Operator']['roles'] = array();
				if(!empty($v['Operator']['role_id'])){
					$v['Operator']['roles'] = explode(";", $v['Operator']['role_id']);
				}
			$operators[$k] = $v;
			$operators[$k]['Operator']['role_name'] = "";
			foreach( $v['Operator']['roles'] as $kk=>$vv ){
				foreach($roles as $kkk=>$vvv){
					if($vvv['OperatorRole']['id'] == $vv){
					
						$operators[$k]['Operator']['role_name'].=$vvv['OperatorRoleI18n']['name']."<br />";
					}
				}
			}
		}
		
		$operator_email=isset($this->params['url']['operator_email'])?$this->params['url']['operator_email']:'';
		$operator_depart=isset($this->params['url']['operator_depart'])?$this->params['url']['operator_depart']:'';
		$operator_name=isset($this->params['url']['operator_name'])?$this->params['url']['operator_name']:'';
		//pr($roles);
		$this->set('departments',$departments);
		$this->set('operators',$operators);
		$this->set('roles',$roles);
		$this->set('operator_email',$operator_email);
		$this->set('operator_depart',$operator_depart);
		$this->set('operator_name',$operator_name);
	}
	function edit($id) {
		/*判断权限*/

		$this->operator_privilege('Operator_edit');
		$this->pageTitle = "编辑操作员 - 操作员管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'内部管理','url'=>'');
		$this->navigations[] = array('name'=>'操作员管理','url'=>'/operators/');
		$this->navigations[] = array('name'=>'编辑操作员','url'=>'');
		
		
		$this->Department->set_locale($this->locale);
		if($this->RequestHandler->isPost()){
			$this->data['Operator']['store_id'] = !empty($this->data['Operator']['store_id'])?$this->data['Operator']['store_id']:"0";
			$this->data['Operator']['role_id'] = !empty($this->data['Operator']['role_id'])?$this->data['Operator']['role_id']:"0";
			$this->data['Operator']['desktop'] = !empty($this->data['Operator']['desktop'])?$this->data['Operator']['desktop']:"0";
		   $operator_info=$this->Operator->findbyid($this->data['Operator']['id']);
		   if(!empty($this->params['form']['oldpassword']) && !empty($this->params['form']['newpassword']) && !empty($this->params['form']['confirmpassword'])){
		               if(strcmp(md5($this->params['form']['oldpassword']),$operator_info['Operator']['password']) != 0){
		       	             $this->flash("输入旧密码不正确",'/operators/edit/'.$this->data['Operator']['id'],10,false);
		               }
		               if(strcmp($this->params['form']['newpassword'],$this->params['form']['confirmpassword']) != 0){
		       	             $this->flash("两次输入的新密码不一样",'/operators/edit/'.$this->data['Operator']['id'],10,false);
		               }
		               else{
		             	     $this->data['Operator']['password']=md5($this->params['form']['newpassword']);
		               }
		       }
		       else{
		       	        //echo $user_info['User']['password'];
		       	        $this->data['Operator']['password']=$operator_info['Operator']['password'];
		       }
			//检验用户名唯一性
			if($this->Operator->check_unique_name($this->data['Operator']['name'],$this->data['Operator']['id'])){
				$this->flash("编辑失败，用户名已占用",'/operators/edit/'.$this->data['Operator']['id'],5,false);
			}
			else{
				   if(isset($this->params['form']['operator_role']) && !empty($this->params['form']['operator_role'])){
				            $this->data['Operator']['role_id'] = implode(';',$this->params['form']['operator_role']);
				   }
				   if(isset($this->params['form']['operator_action']) && !empty($this->params['form']['operator_action'])){
				            $this->data['Operator']['actions'] = implode(';',$this->params['form']['operator_action']);
				   }
				$this->Operator->save($this->data);
				
                //操作员日志
    	        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑操作员:'.$this->data['Operator']['name'] ,'operation');
    	        }
				$this->flash("操作员  ".$this->data['Operator']['name']." 编辑成功。点击这里继续编辑该操作员。",'/operators/edit/'.$id,10);

			}
		}
		
		$this->Operator_action->set_locale($this->locale);
		$operator_actions = $this->Operator_action->alltree_hasname();
		//pr($operator_actions);
		$this->OperatorRole->set_locale($this->locale);
		$res = $this->OperatorRole->findAll();
	//	pr($res);
		$operator_roles = array();
		foreach($res as $k=>$v){
			$operator_roles[$v['OperatorRole']['id']]['OperatorRole']=$v['OperatorRole'];
			$operator_roles[$v['OperatorRole']['id']]['OperatorRole']['name'] = '';
			$operator_roles[$v['OperatorRole']['id']]['OperatorRoleI18n'][]=$v['OperatorRoleI18n'];
			if(!empty($operator_roles[$v['OperatorRole']['id']]['OperatorRoleI18n']))foreach($operator_roles[$v['OperatorRole']['id']]['OperatorRoleI18n'] as $vv){
				$operator_roles[$v['OperatorRole']['id']]['OperatorRole']['name']  = $vv['name'] ;
			}
		}
        //pr($operator_actions);
		
		$departments = $this->Department->findAll();
		$this->data = $this->Operator->findById($id);
		/*foreach( $operator_roles as $k=>$v ){
			
			$operator_roles[$k]['OperatorRole']['actions_arr'] = explode(";",$v['OperatorRole']['actions']);
		}*/
		//pr($operator_roles);
		$this->data['Operator']['role_arr'] = explode(';',$this->data['Operator']['role_id']);
		$this->data['Operator']['action_arr'] = explode(';',$this->data['Operator']['actions']);
		
		

		$this->set('operator_actions',$operator_actions);
		$this->set('operator_roles',$operator_roles);
		$this->set('departments',$departments);
		
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$this->data["Operator"]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);


	}
   function remove($id){
		/*判断权限*/
		$this->operator_privilege('Operator_edit');
		
		$pn = $this->Operator->find('list',array('fields' => array('Operator.id','Operator.name'),'conditions'=> 
                                        array('Operator.id'=>$id)));
		$this->Operator->del($id);
		//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除操作员:'.$pn[$id] ,'operation');
    	}
		$this->flash("删除成功",'/operators/',10);
   }
   function add(){
		/*判断权限*/
		$this->operator_privilege('operator_add');
		$this->pageTitle = "新增操作员 - 操作员管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'内部管理','url'=>'');
		$this->navigations[] = array('name'=>'操作员管理','url'=>'/operators/');
		$this->navigations[] = array('name'=>'新增操作员','url'=>'');
		$this->set('navigations',$this->navigations);
		$this->Department->set_locale($this->locale);
   	    if($this->RequestHandler->isPost()){
			$this->data['Operator']['store_id'] = !empty($this->data['Operator']['store_id'])?$this->data['Operator']['store_id']:"0";
			$this->data['Operator']['role_id'] = !empty($this->data['Operator']['role_id'])?$this->data['Operator']['role_id']:"0";
			$this->data['Operator']['desktop'] = !empty($this->data['Operator']['desktop'])?$this->data['Operator']['desktop']:"0";
   	    	$this->data['Operator']['id'] = "";
   	   	   	if($this->Operator->check_unique_name($this->data['Operator']['name'])){
				$this->flash("添加失败，用户名已占用",'/operators/add/',5,false);
			}
			else{
				if(!empty($this->data['Operator']['password']))
				   if(isset($this->params['form']['operator_role']) && !empty($this->params['form']['operator_role'])){
				            $this->data['Operator']['role_id'] = implode(';',$this->params['form']['operator_role']);
				   }
				   if(isset($this->params['form']['operator_action']) && !empty($this->params['form']['operator_action'])){
				            $this->data['Operator']['actions'] = implode(';',$this->params['form']['operator_action']);
				   }
				$this->data['Operator']['password'] = md5($this->data['Operator']['password']);
				$this->Operator->saveAll($this->data); 
				$id=$this->Operator->id;
				//操作员日志
    	        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加操作员:'.$this->data['Operator']['name'] ,'operation');
    	        }
				$this->flash("操作员  ".$this->data['Operator']['name']." 添加成功。点击这里继续编辑该操作员。",'/operators/edit/'.$id,10);
			}
		}
		$res = $this->OperatorRole->findAll();
		$operator_roles = array();
		foreach($res as $k=>$v){
			$operator_roles[$v['OperatorRole']['id']]['OperatorRole']=$v['OperatorRole'];
			if(!empty($v['OperatorRoleI18n']))
			       $operator_roles[$v['OperatorRole']['id']]['OperatorRole']['name'] = '';
			       $operator_roles[$v['OperatorRole']['id']]['OperatorRoleI18n'][]=$v['OperatorRoleI18n'];
			       foreach($operator_roles[$v['OperatorRole']['id']]['OperatorRoleI18n'] as $vv){
			       	   	if($vv['locale']==$this->locale){
				            $operator_roles[$v['OperatorRole']['id']]['OperatorRole']['name']  = $vv['name'] ;
			       		}
			       }
	//		$operator_roles[$k] = $v;
		}
		$this->Operator_action->set_locale($this->locale);
		$operator_actions = $this->Operator_action->alltree_hasname();
		$departments = $this->Department->findAll();
		
		
		$this->set('departments',$departments);
		$this->set('operator_roles',$operator_roles);
		$this->set('operator_actions',$operator_actions);
   }
   
   	function ajax_amend_now_pwd($pwd="",$new_pwd=""){
		Configure::write('debug',0);
   		$md5_new_pwd = md5($new_pwd);
   		$md5_pwd = md5($pwd);
   		$operator_id = $_SESSION['Operator_Info']['Operator']['id'];
		if( !empty($_REQUEST["Operator_time_zone"]) ){
			$_SESSION['Operator_Info']['Operator']['time_zone'] = $_REQUEST["Operator_time_zone"];
   			$this->Operator->updateAll(
				         	array('Operator.time_zone' => "'". $_REQUEST["Operator_time_zone"]."'"),
							array('Operator.id' => $operator_id)
			         );

		}
		if($pwd!=""&&$new_pwd!=""){
	   		$operator_password = $_SESSION['Operator_Info']['Operator']['password'];
	   		if( $md5_pwd != $operator_password){
	   			$pwd_status = "0";
	   			echo $pwd_status;
	   			die();
	   		}else{
	   			$pwd_status = "1";
	   		}
	   		
	   		$this->Operator->updateAll(
					         	array('Operator.password' => "'$md5_new_pwd'"),
								array('Operator.id' => $operator_id)
					         	
				         );
			$_SESSION['Operator_Info']['Operator']['password'] = $md5_new_pwd;
			
		}else{
			echo 1;
		}
   		
   		die();
   	}
   	
}
?>