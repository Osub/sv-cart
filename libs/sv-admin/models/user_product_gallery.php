<?php
/*****************************************************************************
 * SV-Cart 订单
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: order.php 3477 2009-08-04 11:08:17Z tangyu $
*****************************************************************************/
class UserProductGallery extends AppModel{
	var $name = 'UserProductGallery';
    var $belongsTo=array('User' =>   
                        array('className'    => 'User', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'user_id'  
                        ),'Product' =>   
                        array('className'    => 'Product', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'product_id'  
                        )
                  );


}
?>