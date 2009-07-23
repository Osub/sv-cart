<?php
/*****************************************************************************
 * SV-Cart 订单操作
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: order_action.php 2840 2009-07-14 09:58:08Z zhengli $
*****************************************************************************/
class OrderAction extends AppModel{
	var $name = 'OrderAction';

    var $hasOne = array('Operator' =>   
                        array('className'    => 'Operator', 
                              'conditions'    =>  'Operator.id=OrderAction.from_operator_id',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => ''  
                        )
                  );
    //返回某个订单可执行的操作列表，包括权限判断
    function operable_list($order){
    	 //取得订单状态、发货状态、付款状态 
         $os = $order['Order']['status'];
         $ss = $order['Order']['shipping_status'];
         $ps = $order['Order']['payment_status'];


        //取得订单支付方式是否货到付款 
        $payment=$this->requestAction("/payments/payment_info/".$order['Order']['payment_id']."");
        $is_cod  = $payment['Payment']['is_cod'] == 1;

        //根据状态返回可执行操作 
        $list = array();
        if ($os == 0){
                 //状态：未确认 => 未付款、未发货 
                 $list['confirm']    = true; // 确认
                 $list['invalid']    = true; // 无效
                 $list['cancel']     = true; // 取消
                 if ($is_cod){
                      //货到付款 
                      $list['prepare'] = true; // 配货
                      $list['ship'] = true; // 发货
                 }
                else{
                     //不是货到付款 
                     $list['pay'] = true;  // 付款
                }
        }
       elseif ($os == 1){
               //状态：已确认 
               if ($ps == 0){
               //状态：已确认、未付款 
                    if ($ss == 0 || $ss == 3){
                          //状态：已确认、未付款、未发货（或配货中）
                          $list['cancel'] = true; // 取消
                          $list['invalid'] = true; // 无效
                         if ($is_cod){
                             //货到付款 
                             if ($ss == 0){
                                  $list['prepare'] = true; // 配货
                              }
                                  $list['ship'] = true; // 发货
                                  $list['pay'] = true; // 付款先放着
                          }
                         else{
                             //不是货到付款
                             $list['pay'] = true; // 付款
                         }
                    }
                   else{
                         //状态：已确认、未付款、已发货或已收货 => 货到付款
                         $list['pay'] = true; // 付款
                         if ($ss == 1){
                               $list['receive'] = true; // 收货确认
                         }
                         $list['unship'] = true; // 设为未发货
                         $list['return'] = true; // 退货

                   }
               }
              else{
                    //状态：已确认、已付款和付款中 
                    if ($ss == 0 || $ss == 3){
                          //状态：已确认、已付款和付款中、未发货（配货中） => 不是货到付款
                          if ($ss == 0){
                                $list['prepare'] = true; // 配货
                          }
                          $list['ship'] = true; // 发货
                          $list['unpay'] = true; // 设为未付款
                          if ($os){
                                $list['cancel'] = true; // 取消
                          }
                     }
                    else{
                        //状态：已确认、已付款和付款中、已发货或已收货 
                        if ($ss == 1){
                             $list['receive'] = true; // 收货确认
                        }
                        if (!$is_cod){
                             $list['unship'] = true; // 设为未发货
                        }
                        if ($is_cod){
                             $list['unpay']  = true; // 设为未付款
                        }
                        $list['return'] = true; // 退货（包括退款）
                    }
               }
        }
        elseif ($os == 2){
              //状态：取消 
              $list['confirm'] = true;
              $list['remove'] = true;
        }
        elseif ($os == 3){
               //状态：无效 
               $list['confirm'] = true;
               $list['remove'] = true;
        }
        elseif ($os == 4){
             //状态：退货 
             $list['confirm'] = true;
        }

        //售后 
        $list['after_service'] = true;
        return $list;
    }
    //新增订单操作日志
    function update_order_action($arr){
    	     $this->saveAll(array('OrderAction'=>$arr));
    }
}
?>