<?php
/*****************************************************************************
 * SV-Cart 商品类型
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: producttype.php 1370 2009-05-14 10:35:18Z shenyunfeng $
*****************************************************************************/
class ProductType extends AppModel
{
	var $name = 'ProductType';
	var $hasOne = array('ProductTypeI18n' =>   
                        array('className'    => 'ProductTypeI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'type_id'  
                        )
                  );
  	
	function set_locale($locale){
    	$conditions = " ProductTypeI18n.locale = '".$locale."'";
    	$this->hasOne['ProductTypeI18n']['conditions'] = $conditions;
        
    }
    

//class_end
}
?>