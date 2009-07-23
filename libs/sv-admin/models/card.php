<?php
/*****************************************************************************
 * SV-Cart 贺卡
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: card.php 725 2009-04-17 08:00:21Z huangbo $
*****************************************************************************/
class Card extends AppModel{
	var $name = 'Card';
	var $hasOne = array('CardI18n'=>
						array('className'  => 'CardI18n',
							  'conditions' => '',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => 'card_id'							
						)
					);


	function set_locale($locale){
    	$conditions = " CardI18n.locale = '".$locale."'";
    	$this->hasOne['CardI18n']['conditions'] = $conditions;
        
    }


	//数组结构调整
    function localeformat($id){
		$lists=$this->findAll("Card.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Card']=$v['Card'];
				 $lists_formated['CardI18n'][]=$v['CardI18n'];
				 foreach($lists_formated['CardI18n'] as $key=>$val){
				 	  $lists_formated['CardI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}

}
?>