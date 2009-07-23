<?php
/*****************************************************************************
 * SV-Cart ��������
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
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
    //����ĳ��������ִ�еĲ����б�����Ȩ���ж�
    function operable_list($order){
    	 //ȡ�ö���״̬������״̬������״̬ 
         $os = $order['Order']['status'];
         $ss = $order['Order']['shipping_status'];
         $ps = $order['Order']['payment_status'];


        //ȡ�ö���֧����ʽ�Ƿ�������� 
        $payment=$this->requestAction("/payments/payment_info/".$order['Order']['payment_id']."");
        $is_cod  = $payment['Payment']['is_cod'] == 1;

        //����״̬���ؿ�ִ�в��� 
        $list = array();
        if ($os == 0){
                 //״̬��δȷ�� => δ���δ���� 
                 $list['confirm']    = true; // ȷ��
                 $list['invalid']    = true; // ��Ч
                 $list['cancel']     = true; // ȡ��
                 if ($is_cod){
                      //�������� 
                      $list['prepare'] = true; // ���
                      $list['ship'] = true; // ����
                 }
                else{
                     //���ǻ������� 
                     $list['pay'] = true;  // ����
                }
        }
       elseif ($os == 1){
               //״̬����ȷ�� 
               if ($ps == 0){
               //״̬����ȷ�ϡ�δ���� 
                    if ($ss == 0 || $ss == 3){
                          //״̬����ȷ�ϡ�δ���δ������������У�
                          $list['cancel'] = true; // ȡ��
                          $list['invalid'] = true; // ��Ч
                         if ($is_cod){
                             //�������� 
                             if ($ss == 0){
                                  $list['prepare'] = true; // ���
                              }
                                  $list['ship'] = true; // ����
                                  $list['pay'] = true; // �����ȷ���
                          }
                         else{
                             //���ǻ�������
                             $list['pay'] = true; // ����
                         }
                    }
                   else{
                         //״̬����ȷ�ϡ�δ����ѷ��������ջ� => ��������
                         $list['pay'] = true; // ����
                         if ($ss == 1){
                               $list['receive'] = true; // �ջ�ȷ��
                         }
                         $list['unship'] = true; // ��Ϊδ����
                         $list['return'] = true; // �˻�

                   }
               }
              else{
                    //״̬����ȷ�ϡ��Ѹ���͸����� 
                    if ($ss == 0 || $ss == 3){
                          //״̬����ȷ�ϡ��Ѹ���͸����С�δ����������У� => ���ǻ�������
                          if ($ss == 0){
                                $list['prepare'] = true; // ���
                          }
                          $list['ship'] = true; // ����
                          $list['unpay'] = true; // ��Ϊδ����
                          if ($os){
                                $list['cancel'] = true; // ȡ��
                          }
                     }
                    else{
                        //״̬����ȷ�ϡ��Ѹ���͸����С��ѷ��������ջ� 
                        if ($ss == 1){
                             $list['receive'] = true; // �ջ�ȷ��
                        }
                        if (!$is_cod){
                             $list['unship'] = true; // ��Ϊδ����
                        }
                        if ($is_cod){
                             $list['unpay']  = true; // ��Ϊδ����
                        }
                        $list['return'] = true; // �˻��������˿
                    }
               }
        }
        elseif ($os == 2){
              //״̬��ȡ�� 
              $list['confirm'] = true;
              $list['remove'] = true;
        }
        elseif ($os == 3){
               //״̬����Ч 
               $list['confirm'] = true;
               $list['remove'] = true;
        }
        elseif ($os == 4){
             //״̬���˻� 
             $list['confirm'] = true;
        }

        //�ۺ� 
        $list['after_service'] = true;
        return $list;
    }
    //��������������־
    function update_order_action($arr){
    	     $this->saveAll(array('OrderAction'=>$arr));
    }
}
?>