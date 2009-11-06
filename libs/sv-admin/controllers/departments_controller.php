<?php
/*****************************************************************************
 * SV-Cart 部门管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: departments_controller.php 4691 2009-09-28 10:11:57Z huangbo $
*****************************************************************************/ 
class DepartmentsController extends AppController {
	var $name = 'Departments';
	var $helpers = array('Html');
	var $components = array ('Pagination','RequestHandler','Email'); // Added 
	var $uses = array("Department",'DepartmentI18n');
	
	function index(){
		/*判断权限*/
		$this->operator_privilege('department_view');
		/*end*/
		$this->pageTitle = "部门管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'内部管理','url'=>'');
		$this->navigations[] = array('name'=>'部门管理','url'=>'/departments/');
		$this->set('navigations',$this->navigations);
		
		$this->Department->set_locale($this->locale);
   		$department_list=$this->Department->findAll('','','orderby');
   		$this->set('department_list',$department_list);
   	   
	}
	
	function edit($id){
		/*判断权限*/
		$this->operator_privilege('department_operation');
		/*end*/
		$this->pageTitle = "编辑部门 - 部门管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'内部管理','url'=>'');
		$this->navigations[] = array('name'=>'部门管理','url'=>'/departments/');
		$this->navigations[] = array('name'=>'编辑部门','url'=>'');
		
		
		if($this->RequestHandler->isPost()){
			$this->Department->save($this->data); //保存
			foreach($this->data['DepartmentI18n'] as $v){
            	$departmentI18n_info=array(
		             				'id'=>	isset($v['id'])?$v['id']:'',
		                           'locale'=>	$v['locale'],
		                           'card_id'=> isset($v['department_id'])?$v['department_id']:$id,
		                           'name'=>	isset($v['name'])?$v['name']:'',
		                           'description'=>	$v['description']
		    	);
		            
			$this->DepartmentI18n->saveall(array('DepartmentI18n'=>$departmentI18n_info));//更新多语言
			}
			foreach( $this->data['DepartmentI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
			if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑部门:'.$userinformation_name ,'operation');
    	    }
			$this->flash("部门  ".$userinformation_name." 编辑成功。点击这里继续编辑该部门。",'/departments/edit/'.$id,10);

			
		}
		$this->data=$this->Department->localeformat($id);
	//	pr($this->data);
		$this->set('departments_info',$this->data);
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$this->data["DepartmentI18n"][$this->locale]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);

	}
	
    function remove($id){
    	/*判断权限*/
		$this->operator_privilege('department_operation');
		/*end*/
		$pn = $this->DepartmentI18n->find('list',array('fields' => array('DepartmentI18n.department_id','DepartmentI18n.name'),'conditions'=> 
                                        array('DepartmentI18n.department_id'=>$id,'DepartmentI18n.locale'=>$this->locale)));
        
		$this->Department->deleteAll("Department.id='$id'");
		if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除部门:'.$pn[$id] ,'operation');
    	}
		$this->flash("删除成功",'/departments/',10);
    }

	function add(){
		/*判断权限*/
		$this->operator_privilege('department_add');
		/*end*/
		$this->pageTitle = "新增部门 - 部门管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'内部管理','url'=>'');
		$this->navigations[] = array('name'=>'部门管理','url'=>'/departments/');
		$this->navigations[] = array('name'=>'新增部门','url'=>'');
		$this->set('navigations',$this->navigations);


   	    if($this->RequestHandler->isPost()){
			$this->data['Department']['orderby'] = !empty($this->data['Department']['orderby'])?$this->data['Department']['orderby']:50;
			$this->Department->saveall($this->data['Department']); //保存
			$id=$this->Department->id;

			//新增多语言
			if(is_array($this->data['DepartmentI18n']))
				foreach($this->data['DepartmentI18n'] as $k => $v){
					$v['department_id']=$id;
					$this->DepartmentI18n->id='';
					$this->DepartmentI18n->save($v); 
				}
				foreach( $this->data['DepartmentI18n'] as $k=>$v ){
					if($v['locale'] == $this->locale){
						$userinformation_name = $v['name'];
					}
				}
				if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加部门:'.$userinformation_name ,'operation');
    	        }
				$this->flash("部门  ".$userinformation_name." 添加成功。点击这里继续编辑该部门。",'/departments/edit/'.$id,10);
			}
   	   
   }
}

?>