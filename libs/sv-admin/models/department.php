<?php
/*****************************************************************************
 * SV-Cart ����
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
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
	
	
	//return array('id'=>'name');��ɾ��
	function findAssoc(){
			$departmentsdata = $this->findAll();
			$departments = array();
			foreach($departmentsdata as $k => $v){
				$departments[$v['Department']['id']] = $v['DepartmentI18n']['name'];
			}
			return $departments;
	}
	
		//����ṹ����
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