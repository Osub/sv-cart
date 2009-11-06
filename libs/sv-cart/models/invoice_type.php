<?php
/*****************************************************************************
 * SV-Cart 品牌
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: brand.php 3896 2009-08-26 02:11:38Z zhangshisong $
*****************************************************************************/
class InvoiceType extends AppModel
{
	var $name = 'InvoiceType';
	var $cacheQueries = true;
	var $cacheAction = "1 day";
	
	var $hasOne = array('InvoiceTypeI18n' =>   
                        array('className'    => 'InvoiceTypeI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'invoice_type_id'  
                        )   
                  );
    

	function set_locale($locale){
    	$conditions = " InvoiceTypeI18n.locale = '".$locale."'";
    	$this->hasOne['InvoiceTypeI18n']['conditions'] = $conditions;
    }
	
}
?>