<?php
/*****************************************************************************
 * SV-Cart ����Ա�˵�
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: test_system_resource.php 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
class SystemResource extends AppModel
{
	var $name = 'SystemResource';
	var $acionts_parent_format=array();
	var $hasOne = array('SystemResourceI18n'=>
						array('className'  => 'SystemResourceI18n',
							  'conditions' => '',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => 'resource_id'							
						)
					);
    
	function set_locale($locale){
    	$conditions = " SystemResourceI18n.locale = '".$locale."'";
    	$this->hasOne['SystemResourceI18n']['conditions'] = $conditions;
    }

   	function tree($actions="all"){//
   	    $conditions=" status ='1' ";
   	   	//$this->set_locale($this->locale);
   	    if($actions!="all"){
   	    $conditions.="AND Operator_menu.operator_action_code in(".$actions.")";
   	    }
		$actions_arr=$this->findAll($conditions,'','orderby asc');
		$this->acionts_parent_format = array();//���¿�
		if(is_array($actions_arr))
			foreach($actions_arr as $k=>$v)
			{	$v['SystemResource']['name'] = $v['SystemResourceI18n']['name'];
				$this->acionts_parent_format[$v['SystemResource']['parent_id']][]=$v;
			}
		return $this->subcat_get('0');
	}
	
   	function alltree(){//
   	    $conditions="";
		$actions=$this->findAll($conditions,'','orderby asc');
		$this->acionts_parent_format = array();//���¿�
		if(is_array($actions))
			foreach($actions as $k=>$v)
			{
				$this->acionts_parent_format[$v['SystemResource']['parent_id']][]=$v;
			}
	//	pr($this->acionts_parent_format);
		return $this->subcat_get('0');
	}
	
	function subcat_get($action_id){
		$subcat=array();
		//echo $action_id;
		//pr($this->acionts_parent_format);
		if(isset($this->acionts_parent_format[$action_id]) && is_array($this->acionts_parent_format[$action_id]))
			foreach($this->acionts_parent_format[$action_id] as $k=>$v)
			{

				$action=$v;
				
				if(isset($this->acionts_parent_format[$v['SystemResource']['id']]) && is_array($this->acionts_parent_format[$v['SystemResource']['id']]) )
				{
					$action['SubMenu']=$this->subcat_get($v['SystemResource']['id']);
				}
				else{
					$action['SubMenu']='';
				}
				$subcat[$k]=$action;
			}
		//pr($action);
		return $subcat;
	}
    
   	function localeformat($id){
		$lists=$this->findAll("SystemResource.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['SystemResource']=$v['SystemResource'];
				 $lists_formated['SystemResourceI18n'][]=$v['SystemResourceI18n'];
				 foreach($lists_formated['SystemResourceI18n'] as $key=>$val){
				 	  $lists_formated['SystemResourceI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}

function find_tree($condition){
   	    
   	   	$conditions = $this->find($condition);
   	   	$tree = $this->findAll("parent_id = ".$conditions['SystemResource']['id']);
   	    return $tree;
	}


}
?>