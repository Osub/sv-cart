<?php
/*****************************************************************************
 * SV-Cart 类型
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: type.php 725 2009-04-17 08:00:21Z huangbo $
*****************************************************************************/
class Type extends AppModel
{
	var $name = 'Type';
		var $hasOne = array('TypeI18n'     =>array
												( 
												  'className'    => 'TypeI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'type_id'
					                        	 )
                 	   );
    
	function set_locale($locale){
    	$conditions = " TypeI18n.locale = '".$locale."'";
    	$this->hasOne['TypeI18n']['conditions'] = $conditions;
        
    }

	function gettypeformat(){
		$condition="";
		$lists=$this->findAll($condition);
		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				 $lists_formated[$v['Type']['id']]['Type']=$v['Type'];
				 $lists_formated[$v['Type']['id']]['TypeI18n'][]=$v['TypeI18n'];
				 $lists_formated[$v['Type']['id']]['Type']['name']='';
				 foreach($lists_formated[$v['Type']['id']]['TypeI18n'] as $key=>$val){
				 	  $lists_formated[$v['Type']['id']]['Type']['name'] .=$val['name'] . " | ";
				 }
			}
		//pr($lists_formated);
		return $lists_formated;
	}
}
?>