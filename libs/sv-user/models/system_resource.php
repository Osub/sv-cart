<?php
/*****************************************************************************
 * SV-Cart ����Ա�˵�
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ��������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * �������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: system_resource.php 3053 2009-07-17 11:59:14Z huangbo $
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
							  'foreignKey' => 'system_resource_id'							
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
	
   	function alltree($condition, $filed, $order, $rownum, $page){//
   	    //$conditions="";
   	  //  $this->set_locale($locale);
		$actions=$this->findAll();
		$this->acionts_parent_format = array();//���¿�
		if(is_array($actions))
			foreach($actions as $k=>$v)
			{  
		       // $v['SystemResource']['name'] = $v['SystemResourceI18n']['name'];
				$this->acionts_parent_format[$v['SystemResource']['parent_id']][]=$v;
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
   	    
   	   	$this->set_locale($this->locale);
   	   	$conditions = $this->find($condition);
   	   	$tree = $this->find("parent_id = ".$conditions['SystemResource']['id']);
   	    return $tree;
	}
//leo20090626
function resource_formated($mystatus=true,$locale){
	$conditions="";
//	$actions=$this->findAll($conditions,'','SystemResource.orderby asc');
	$actions = $this->cache_find('all',array('orderby'=>'SystemResource.orderby asc',
	'fields'=>array('SystemResource.id','SystemResource.parent_id','SystemResource.code','SystemResource.resource_value','SystemResourceI18n.system_resource_id','SystemResourceI18n.name'),
	'conditions'=>array($conditions)),$this->name."resource_formated".$locale);
	$this->acionts_parent_format = array();
	if(is_array($actions)){
		foreach($actions as $k=>$v){
			$this->acionts_parent_format[$v['SystemResource']['parent_id']][]=$v;
		}
		$redource = array();
		foreach( $this->subcat_get('0') as $k=>$v ){
			if($mystatus){
				$redource[$v["SystemResource"]["code"]][$v["SystemResource"]["resource_value"]] = $v["SystemResourceI18n"]["name"];
			}
			if(!empty($v["SubMenu"])){
				foreach($v["SubMenu"] as $kk=>$vv){
					$redource[$v["SystemResource"]["code"]][$vv["SystemResource"]["resource_value"]] = $vv["SystemResourceI18n"]["name"];
				}
			}
		}
		return $redource;
	}
}
}
?>