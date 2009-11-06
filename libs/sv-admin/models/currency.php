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
class Currency extends AppModel{
	var $name = 'Currency';
	var $hasOne = array('CurrencyI18n'=>
						array('className'  => 'CurrencyI18n',
							  'conditions' => '',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => 'currency_id'							
						)
					);


	function set_locale($locale){
    	$conditions = " CurrencyI18n.locale = '".$locale."'";
    	$this->hasOne['CurrencyI18n']['conditions'] = $conditions;
        
    }


	//数组结构调整
    function localeformat($id){
		$lists=$this->findAll("Currency.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Currency']=$v['Currency'];
				 $lists_formated['CurrencyI18n'][]=$v['CurrencyI18n'];
				 foreach($lists_formated['CurrencyI18n'] as $key=>$val){
				 	  $lists_formated['CurrencyI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}

}
?>