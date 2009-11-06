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
 * $Id: operator_menu.php 3374 2009-07-29 06:56:01Z shenyunfeng $
*****************************************************************************/
class Batch extends AppModel
{
	var $name = 'Batch';
	var $acionts_parent_format=array();
	var $belongsTo = array('Provider'=>
									array('className'  => 'Provider',
										  'conditions' => '',
										  'order'      => '',
										  'dependent'  => true,
										  'foreignKey' => 'provider_id'							
							),
		
							'Operator'=>
									array('className'  => 'Operator',
										  'conditions' => '',
										  'order'      => '',
										  'dependent'  => true,
										  'foreignKey' => 'update_operator_id'							
							)
					);

   	function tree($actions="all",$locale){//
	   	    $conditions=" status ='1' ";
	   	   	//$this->set_locale($this->locale);
	   	    if($actions!="all"){
	   	    $conditions.="AND Operator_menu.operator_action_code in(".$actions.")";
	   	    }
	   	    $actions_arr = $this->find('all',array('conditions'=>array($conditions),'order' => array('orderby asc')),$this->name.$locale);
			//$actions_arr=$this->findAll($conditions,'','orderby asc');
			
			$this->acionts_parent_format = array();//���¿�
			if(is_array($actions_arr))
				foreach($actions_arr as $k=>$v)
				{	$v['Operator_menu']['name'] = $v['Operator_menuI18n']['name'];
					$this->acionts_parent_format[$v['Operator_menu']['parent_id']][]=$v;
				}
			return $this->subcat_get('0');
		}
	
	
   	function alltree(){//
   	    $conditions="";
		$actions=$this->findAll($conditions,'','');
	//	pr($actions);
	//	echo "************************";
		$this->acionts_parent_format = array();//���¿�
		if(is_array($actions))
			foreach($actions as $k=>$v)
			{
				$this->acionts_parent_format[$v['Batch']['id']]=$v;
			}
	//	pr($this->acionts_parent_format);exit;
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
				
				if(isset($this->acionts_parent_format[$v['Operator_menu']['id']]) && is_array($this->acionts_parent_format[$v['Operator_menu']['id']]) )
				{
					$action['SubMenu']=$this->subcat_get($v['Operator_menu']['id']);
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
		$lists=$this->findAll("Operator_menu.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Operator_menu']=$v['Operator_menu'];
				 $lists_formated['Operator_menuI18n'][]=$v['Operator_menuI18n'];
				 foreach($lists_formated['Operator_menuI18n'] as $key=>$val){
				 	  $lists_formated['Operator_menuI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}

}
?>