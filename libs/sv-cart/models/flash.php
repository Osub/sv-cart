<?php
/*****************************************************************************
 * SV-Cart flash
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: flash.php 1728 2009-05-25 10:28:39Z zhengli $
*****************************************************************************/
class Flash extends AppModel
{
	var $name = 'Flash';
	var $hasMany = array('FlashImage' =>   
                        array('className'    => 'FlashImage',   
        					  'conditions' => "status = '1' ",
     						  'fields' => array("image","title","url"),
                              'order'        => ' orderby ',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'flash_id'  
                        )   
                  );
    var $cacheQueries = true;
    
    function set_locale($locale){
    	$conditions = " and FlashImage.locale = '".$locale."'";
    	$this->hasMany['FlashImage']['conditions'] = $this->hasMany['FlashImage']['conditions'] .= $conditions;
        
    }

}
?>