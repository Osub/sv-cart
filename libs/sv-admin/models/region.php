<?php
/*****************************************************************************
 * SV-Cart 地区
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: region.php 1261 2009-05-08 07:18:58Z huangbo $
*****************************************************************************/
class Region extends AppModel
{
	var $name = 'Region';
	var $hasOne = array('RegionI18n'     =>array
	             ( 
					'className'    => 'RegionI18n',   
					'order'        => '',   
					'dependent'    =>  true,   
					'foreignKey'   => 'region_id'
				)
                 	   );
    var $region_parents_arr = array();
    
	function set_locale($locale){
    	$conditions = " RegionI18n.locale = '".$locale."'";
    	$this->hasOne['RegionI18n']['conditions'] = $conditions;
        
	}
	/********* 地区列表  ************/
	function getarealist($pid,$locale="zh_cn"){
		$this->set_locale($locale);
		$condition=" parent_id = '".$pid."' ";
 		$lists=$this->findAll($condition,'','Region.id ');
           foreach($lists as $k=>$v){
           	     if($v['RegionI18n']['name'] == ''){
           	     	    $lists[$k]['RegionI18n']['name']='未命名';
           	     }
           }
         // pr($lists);
		return $lists;
	}
//查找地区.
	function locales_formated($id){
		$condition=" Region.id = '".$id."' ";
 		$lists=$this->findAll($condition);
		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				    $lists_formated[$v['Region']['id']]['Region']=$v['Region'];
				if(is_array($v['RegionI18n'])){
				    $lists_formated[$v['Region']['id']]['RegionI18n'][]=$v['RegionI18n'];
				}
				$lists_formated[$v['Region']['id']]['Region']['name']='';
				foreach($lists_formated[$v['Region']['id']]['RegionI18n'] as $key => $val){
						         $lists_formated[$v['Region']['id']]['Region']['name'] .=$val['name'] . " | ";
					        }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}
	function get_parents($id){
		$condition=" id = '".$id."' ";
 		$region = $this->findById($id);
 		if(!empty($region))
 			$this->region_parents_arr[] = array('id'=>$region['Region']['id'],'name'=>$region['RegionI18n']['name']);
 		if(!empty($region['Region']['parent_id'])){
 			return $this->get_parents($region['Region']['parent_id']);
 		}
 		else return $this->region_parents_arr;
	}
}
?>