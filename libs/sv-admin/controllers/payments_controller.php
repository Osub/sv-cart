<?php
/*****************************************************************************
 * SV-Cart 支付管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: payments_controller.php 1250 2009-05-07 13:59:20Z huangbo $
*****************************************************************************/
class PaymentsController extends AppController {
	var $name = 'Payments';
	var $helpers = array('Html','Pagination');
	var $components = array('Pagination','RequestHandler');
	var $uses = array('Payment','PaymentI18n');

	function index(){
		$this->pageTitle = '支付方式'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'支付方式','url'=>'/payments/');
		$this->set('navigations',$this->navigations);
		
	    $this->Payment->set_locale($this->locale);
		$condition = '';
		$data = $this->Payment->find('all',array('conditions'=>$condition,'order'=>'Payment.orderby,Payment.created,Payment.id'));
		/*foreach($data as $k=>$v){
			$data[$k]['Payment']['name'] = '';
			$data[$k]['Payment']['description'] = '';
			if(!empty($v['PaymentI18n']))foreach($v['PaymentI18n'] as $vv){
					$data[$k]['Payment']['name'] .= $vv['name'] . "|";
					$data[$k]['Payment']['description'] .= $vv['description'] . "<br/>";
			}
		}*/
		$this->set('payments',$data);
	}
	function search(){
	}
	//liying081212
	function payment_info($id){
		$list=$this->Payment->find("Payment.id = '".$id."' and Payment.status = 1");
		return $list;
	}
	
	function edit( $id ){
		$this->pageTitle = "编辑支付方式 - 支付方式"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'支付方式','url'=>'/payments/');
		$this->navigations[] = array('name'=>'编辑支付方式','url'=>'');
		$this->set('navigations',$this->navigations);
		
		if($this->RequestHandler->isPost()){
		//	pr($_REQUEST['payment_arr']);
			//pr( $this->data );
			//$this->Payment->deleteall("id = '".$this->data['Payment']['id']."'",false);
			//$this->PaymentI18n->deleteall("payment_id = '".$this->data['Payment']['id']."'",false);
			foreach($this->data['PaymentI18n'] as $v){
              	     	    $paymentI18n_info=array(
		                           'id'=>	isset($v['id'])?$v['id']:'',
		                           'locale'=>	$v['locale'],
		                           'payment_id'=> isset($v['payment_id'])?$v['payment_id']:$id,
		                           'name'=>	isset($v['name'])?$v['name']:'',
		                        	'status'=>	isset($v['status'])?$v['status']:'',
		                           'description'=>	isset($v['description'])?$v['description']:'',
		                     );
		            $this->PaymentI18n->saveall(array('PaymentI18n'=>$paymentI18n_info));//更新多语言
            }
           if(isset($_REQUEST['payment_arr']) && count($_REQUEST['payment_arr'])>0){
                $configs = "\$payment_arr = array(";
                $i = 0;
            	foreach($_REQUEST['payment_arr'] as $kk=>$vv){
				$i++;
				$configs .= "'".$kk."'=> array('name'=> '".$vv['name']."','value'=>'".$vv['value']."' , 'type' => '".$vv['type']."'";
	            if(isset($vv['select_value'])){
	            	$n=0;
	            	$configs .= ", 'select_value' => array( ";
	            	foreach($vv['select_value'] as $kkk=>$vvv){
	            		$n++;
	            		$configs .= "'".$vvv['name']."' => '".$vvv['value']."'";
	            		if($n < count($vv['select_value'])){
	            		$configs .= ",";
	            		}
	            	}
	            	$configs .= ")";
	            }
	            $configs .= ")";
	            	
	            	if($i < count($_REQUEST['payment_arr'])){
	            		$configs .= ",";
	            	}
            	}
            	
            	$configs .= ");";
            }
            $this->data['Payment']['config'] = @$configs;
			$this->Payment->save($this->data); //保存
			$this->flash("编辑成功",'/payments/edit/'.$id,10);
		}
		
		$payment = $this->Payment->localeformat($id);
		eval($payment['Payment']['config']);
		$this->set("payment_arr",@$payment_arr);
		
		$this->set( "payment",$payment );
	}
	
	function install( $id ){
		$this->Payment->updateAll(
			              array('Payment.status' => 1),
			              array('Payment.id' => $id)
			           );
         $this->flash("安装成功",'/payments/',10);
	}
	
	function uninstall( $id ){
		$this->Payment->updateAll(
			              array('Payment.status' => 0),
			              array('Payment.id' => $id)
			           );
         $this->flash("卸载成功",'/payments/',10);
	}
}

?>