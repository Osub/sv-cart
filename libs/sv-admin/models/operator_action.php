<?php
/*****************************************************************************
 * SV-Cart 操作员操作权限
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: operator_action.php 2418 2009-06-30 02:03:55Z zhengli $
*****************************************************************************/
class Operator_action extends AppModel
{
	var $name = 'Operator_action';
	var $hasOne = array('Operator_actionI18n' =>   
                        array('className'    => 'Operator_actionI18n',   
                              'conditions'       => '',  
        					  'order'       => 'Operator_action.id', 
                              'dependent'    =>  true,   
                              'foreignKey'   => 'operator_action_id'  
                        )   
                  );
	

    var $acionts_parent_format=array();
    
    function set_locale($locale){
    	$conditions = " Operator_actionI18n.locale = '".$locale."'";
    	$this->hasOne['Operator_actionI18n']['conditions'] = $conditions;
    }
    
   	function tree($level){//
   	    $conditions=" status ='1' AND Operator_action.level='".$level."'";
		$actions=$this->findAll($conditions,'','orderby asc');
		if(is_array($actions))
			foreach($actions as $k=>$v)
			{
				$this->acionts_parent_format[$v['Operator_action']['parent_id']][]=$v;
			}
		//pr($this->categories_parent_format);
		return $this->subcat_get(0);
	}
	function alltree(){//
   	    $conditions="";
		$actions=$this->findAll($conditions,'','orderby asc');
		$this->acionts_parent_format = array();
		if(is_array($actions))
			foreach($actions as $k=>$v)
			{
				$this->acionts_parent_format[$v['Operator_action']['parent_id']][]=$v;
			}
		return $this->subcat_get(0);
	}
	function alltree_hasname(){
		$actions=$this->findAll();
		$this->acionts_parent_format = array();
		if(is_array($actions)){
			foreach($actions as $k=>$v){	
				$v['Operator_action']['name']  = $v['Operator_actionI18n']['name'] ;
				//$v['Operator_action']['descrption'] = $v['Operator_actionI18n']['descrption'] ;
				$this->acionts_parent_format[$v['Operator_action']['parent_id']][]=$v;
			}
		}
		return $this->subcat_get(0);
	}

	function subcat_get($action_id){
		$subcat=array();
		if(isset($this->acionts_parent_format[$action_id]) && is_array($this->acionts_parent_format[$action_id]))
			foreach($this->acionts_parent_format[$action_id] as $k=>$v)
			{

				$action=$v;
				if(isset($this->acionts_parent_format[$v['Operator_action']['id']]) && is_array($this->acionts_parent_format[$v['Operator_action']['id']]) )
				{
					$action['SubAction']=$this->subcat_get($v['Operator_action']['id']);
				}
				else{
					
				}
				$subcat[$k]=$action;
			}
		return $subcat;
	}
    
    function find_action($condition,$locale){
   	    $all_action = $this->cache_find('all',array('conditions'=>array($condition)),$this->name.$locale);
    	
    	return $all_action;
    }

}
?>