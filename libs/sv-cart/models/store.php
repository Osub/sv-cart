<?php
/*****************************************************************************
 * SV-Cart 标签
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: tag.php 2699 2009-07-08 11:07:31Z huangbo $
*****************************************************************************/
class Store extends AppModel
{
	var $name = 'Store';
	var $hasOne = array('StoreI18n'=>
						array('className'  => 'StoreI18n',
							  'conditions' => '',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => 'store_id'	
						)
					);
	
	
	function set_locale($locale){
    	$conditions = " StoreI18n.locale = '".$locale."'";
    	$this->hasOne['StoreI18n']['conditions'] = $conditions;
        
    }
	

}
?>