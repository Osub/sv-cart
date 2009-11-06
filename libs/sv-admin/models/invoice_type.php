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
class InvoiceType extends AppModel{
	var $name = 'InvoiceType';
	var $hasOne = array('InvoiceTypeI18n'=>
						array('className'  => 'InvoiceTypeI18n',
							  'conditions' => '',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => 'invoice_type_id'							
						)
					);


	function set_locale($locale){
    	$conditions = " InvoiceTypeI18n.locale = '".$locale."'";
    	$this->hasOne['InvoiceTypeI18n']['conditions'] = $conditions;
        
    }


	//数组结构调整
    function localeformat($id){
		$lists=$this->findAll("InvoiceType.id = '".$id."'");
		foreach($lists as $k => $v){
				 $lists_formated['InvoiceType']=$v['InvoiceType'];
				 $lists_formated['InvoiceTypeI18n'][]=$v['InvoiceTypeI18n'];
				 foreach($lists_formated['InvoiceTypeI18n'] as $key=>$val){
				 	  $lists_formated['InvoiceTypeI18n'][$val['locale']]=$val;
				 }
			}
		return $lists_formated;
	}

}
?>