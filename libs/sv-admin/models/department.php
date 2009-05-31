<?php
/*****************************************************************************
 * SV-Cart 部门
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: department.php 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
class Department extends AppModel{
	var $name = 'Department';
	
	var $hasOne = array('DepartmentI18n' =>   
                        array('className'    => 'DepartmentI18n', 
                              'conditions'    =>  '',
                              'order'        =>   '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'department_id'  
                        )
                  );


    function set_locale($locale){
    	$conditions = "DepartmentI18n.locale = '".$locale."'";
    	$this->hasOne['DepartmentI18n']['conditions'] = $conditions;
        
    }	
	
	
	//return array('id'=>'name');别删了
	function findAssoc(){
			$departmentsdata = $this->findAll();
			$departments = array();
			foreach($departmentsdata as $k => $v){
				$departments[$v['Department']['id']] = $v['DepartmentI18n']['name'];
			}
			return $departments;
	}
	
		//数组结构调整
    function localeformat($id){
		$lists=$this->findAll("Department.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Department']=$v['Department'];
				 $lists_formated['DepartmentI18n'][]=$v['DepartmentI18n'];
				 foreach($lists_formated['DepartmentI18n'] as $key=>$val){
				 	  $lists_formated['DepartmentI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}
}
?>