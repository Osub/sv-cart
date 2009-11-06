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
 * $Id: order.php 3493 2009-08-05 11:14:12Z tangyu $
*****************************************************************************/
class Order extends AppModel{
	var $name = 'Order';
	var $uses = array('UnionUser','UnionReffererOrder');
	var $hasMany = array('OrderProduct' =>   
                        array('className'    => 'OrderProduct', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'order_id'  
                        )
                  );
    var $belongsTo=array('User' =>   
                        array('className'    => 'User', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'user_id'  
                        )
                  );
    //更新订单状态
    function update_order($arr){
            $this->save(array('Order'=>$arr));
    }
    function order_affiliatelog(){
     }

}
?>