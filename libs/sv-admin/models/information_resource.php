<?php
/*****************************************************************************
 * SV-Cart 操作员菜单
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: system_resource.php 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
class InformationResource extends AppModel
{
	var $name = 'InformationResource';
	var $acionts_parent_format=array();
	var $hasOne = array('InformationResourceI18n'=>
						array('className'  => 'InformationResourceI18n',
							  'conditions' => '',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => 'information_resource_id'							
						)
					);
    
	function set_locale($locale){
    	$conditions = " InformationResourceI18n.locale = '".$locale."'";
    	$this->hasOne['InformationResourceI18n']['conditions'] = $conditions;
    }

   	function tree($conditions,$orderby,$rownum,$page){//
   	    $actions_arr = $this->findAll($conditions." and InformationResource.parent_id='0'",'',$orderby,$rownum,$page);
   	    $actions_arr_sub_array = $actions_arr;
   	    $actions_arr_sub = array();
   	    foreach($actions_arr as $k=>$v){
   	    	$actions_arr_sub = $this->findAll(array('parent_id'=>$v['InformationResource']['id']));
	   	       	if(!empty($actions_arr_sub)){
		   	    	foreach($actions_arr_sub as $kk=>$vv){
		   	        	$actions_arr_sub_array[] = $actions_arr_sub[$kk];
		   	    	}
   	    	}
   	    }
   	    $actions_arr = $actions_arr_sub_array;
		$this->acionts_parent_format = array();//先致空
		if(is_array($actions_arr))
			foreach($actions_arr as $k=>$v)
			{	
				$v['InformationResource']['name'] = $v['InformationResourceI18n']['name'];
				$this->acionts_parent_format[$v['InformationResource']['parent_id']][]=$v;
			}
		return $this->subcat_get('0');
	}
	
   	function alltree($condition, $filed, $order, $rownum, $page){//
   	    //$conditions="";
   	  //  $this->set_locale($locale);
		$actions=$this->findAll();
		$this->acionts_parent_format = array();//先致空
		if(is_array($actions))
			foreach($actions as $k=>$v)
			{  
		       // $v['InformationResource']['name'] = $v['InformationResourceI18n']['name'];
				$this->acionts_parent_format[$v['InformationResource']['parent_id']][]=$v;
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
				
				if(isset($this->acionts_parent_format[$v['InformationResource']['id']]) && is_array($this->acionts_parent_format[$v['InformationResource']['id']]) )
				{
					$action['SubMenu']=$this->subcat_get($v['InformationResource']['id']);
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
		$lists=$this->findAll("InformationResource.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['InformationResource']=$v['InformationResource'];
				 $lists_formated['InformationResourceI18n'][]=$v['InformationResourceI18n'];
				 foreach($lists_formated['InformationResourceI18n'] as $key=>$val){
				 	  $lists_formated['InformationResourceI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}

function find_tree($condition){
   	    
   	   	$this->set_locale($this->locale);
   	   	$conditions = $this->find($condition);
   	   	$tree = $this->find("parent_id = '".$conditions['InformationResource']['id']."'");
   	    return $tree;
	}
//leo20090626
function resource_formated($mystatus=true){
	$conditions="";
	$actions=$this->findAll($conditions,'','InformationResource.orderby asc');
	$this->acionts_parent_format = array();
	if(is_array($actions)){
		foreach($actions as $k=>$v){
			$this->acionts_parent_format[$v['InformationResource']['parent_id']][]=$v;
		}
		$redource = array();
		foreach( $this->subcat_get('0') as $k=>$v ){
			if($mystatus){
				$redource[$v["InformationResource"]["code"]][$v["InformationResource"]["resource_value"]] = $v["InformationResourceI18n"]["name"];
			}
			if(!empty($v["SubMenu"])){
				foreach($v["SubMenu"] as $kk=>$vv){
					$redource[$v["InformationResource"]["code"]][$vv["InformationResource"]["resource_value"]] = $vv["InformationResourceI18n"]["name"];
				}
			}
		}
		return $redource;
	}
}
function information_formated($mystatus=true,$locale){
	$conditions="";
	$actions = $this->cache_find('all',array('orderby'=>'InformationResource.orderby asc',
	'fields'=>array('InformationResource.id','InformationResource.parent_id','InformationResource.code','InformationResource.information_value','InformationResourceI18n.information_resource_id','InformationResourceI18n.name'),
	'conditions'=>array($conditions)),$this->name."resource_formated".$locale);
	$this->acionts_parent_format = array();
	if(is_array($actions)){
		foreach($actions as $k=>$v){
			$this->acionts_parent_format[$v['InformationResource']['parent_id']][]=$v;
		}
		$redource = array();
		foreach( $this->subcat_get('0') as $k=>$v ){
			if($mystatus){
				$redource[$v["InformationResource"]["code"]][$v["InformationResource"]["information_value"]] = $v["InformationResourceI18n"]["name"];
			}
			if(!empty($v["SubMenu"])){
				foreach($v["SubMenu"] as $kk=>$vv){
					$redource[$v["InformationResource"]["code"]][$vv["InformationResource"]["information_value"]] = $vv["InformationResourceI18n"]["name"];
				}
			}
		}
		return $redource;
	}
}
}
?>