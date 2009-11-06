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
 * $Id: operator_menu.php 5493 2009-11-03 10:47:49Z huangbo $
*****************************************************************************/
class Operator_menu extends AppModel
{
	var $name = 'Operator_menu';
	var $acionts_parent_format=array();
	var $hasOne = array('Operator_menuI18n'=>
						array('className'  => 'Operator_menuI18n',
							  'conditions' => '',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => 'operator_menu_id'							
						)
					);
    var $cacheQueries = true;
	function set_locale($locale){
    	$conditions = " Operator_menuI18n.locale = '".$locale."'";
    	$this->hasOne['Operator_menuI18n']['conditions'] = $conditions;
    }

   	function tree($actions="all",$locale){//
		$cache_key = md5($this->name."_".$locale);
		$menu_formatcode = cache::read($cache_key);
		if($menu_formatcode){
			
			return $menu_formatcode;
		}else{

	   	    $conditions=" status ='1' ";
	   	   	//$this->set_locale($this->locale);
	   	    if($actions!="all"){
	   	    $conditions.="AND Operator_menu.operator_action_code in(".$actions.")";
	   	    }
	   	    $actions_arr = $this->cache_find('all',array('conditions'=>array($conditions),'fields'=>array("Operator_menu.operator_action_code,Operator_menu.link,Operator_menu.orderby,Operator_menu.parent_id,Operator_menu.id,Operator_menuI18n.name"),'order' => array('orderby asc')),$this->name.$locale);
			//$actions_arr=$this->findAll($conditions,'','orderby asc');
			
			$this->acionts_parent_format = array();//先致空
			if(is_array($actions_arr))
				foreach($actions_arr as $k=>$v)
				{	$v['Operator_menu']['name'] = $v['Operator_menuI18n']['name'];
					$this->acionts_parent_format[$v['Operator_menu']['parent_id']][]=$v;
				}
			cache::write($cache_key,$this->subcat_get('0'));
			return $this->subcat_get('0');
		}
	}
	
   	function alltree(){//
   	    $conditions="";
		$actions=$this->findAll($conditions,'','orderby asc');
		$this->acionts_parent_format = array();//先致空
		if(is_array($actions))
			foreach($actions as $k=>$v)
			{
				$this->acionts_parent_format[$v['Operator_menu']['parent_id']][]=$v;
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