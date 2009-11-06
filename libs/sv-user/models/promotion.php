<?php
/*****************************************************************************
 * SV-Cart 促销
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: promotion.php 725 2009-04-17 08:00:21Z huangbo $
*****************************************************************************/
class Promotion extends AppModel{
	var $name = 'Promotion';
	var $hasOne = array('PromotionI18n' =>   
                        array('className'    => 'PromotionI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'promotion_id'  
                        )
                  );
	function set_locale($locale){
    	$conditions = " PromotionI18n.locale = '".$locale."'";
    	$this->hasOne['PromotionI18n']['conditions'] = $conditions;
    }
}
?>