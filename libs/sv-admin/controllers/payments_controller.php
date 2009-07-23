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
 * $Id: payments_controller.php 3184 2009-07-22 06:09:42Z huangbo $
*****************************************************************************/
class PaymentsController extends AppController {
	var $name = 'Payments';
	var $helpers = array('Html','Pagination');
	var $components = array('Pagination','RequestHandler');
	var $uses = array('Payment','PaymentI18n','Language');

	function index(){
		/*判断权限*/
		$this->operator_privilege('pay_view');
		/*end*/
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
		$list=$this->Payment->find("Payment.id = '".$id."' and Payment.status = '1'");
		return $list;
	}
	
	function edit( $id ){
		$this->pageTitle = "编辑支付方式 - 支付方式"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'支付方式','url'=>'/payments/');
		$this->navigations[] = array('name'=>'编辑支付方式','url'=>'');
	
		
		if($this->RequestHandler->isPost()){
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
				if($kk == "languages_type"){
					$configs .= "'".$kk."'=> array('name'=> '".$vv['name']."' , 'type' => '".$vv['type']."'";
					if(isset($vv['sub']) && sizeof($vv['sub'])>0){
						$m = 0;
						$configs .=",'value'=>array(";
						foreach($vv['sub'] as $a=>$b){
							$m++;
							$configs .="'".$a."' => array( 'name'=> '".$b['name']."' , 'value' => '".$b['value']."')";
							if($m < count($vv['sub'])){
								$configs .=",";
							}
						}
						$configs .="))";
					}
				}else{
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
	            }
	            	
	            	if($i < count($_REQUEST['payment_arr'])){
	            		$configs .= ",";
	            	}
            	}
            	
            	$configs .= ");";
            }
            $this->data['Payment']['config'] = @$configs;
			$this->Payment->save($this->data); //保存
			
			foreach( $this->data['PaymentI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑支付方式:'.$userinformation_name ,'operation');
    	    }
			$this->flash("支付方式 ".$userinformation_name." 编辑成功。点击继续编辑该支付方式。",'/payments/edit/'.$id,10);
		}
		
		$payment = $this->Payment->localeformat($id);		
		eval($payment['Payment']['config']);
		
		if($payment['Payment']['code'] == 'paypal'){
			$languages = $this->Language->findall();
			$locale = "";
			if(is_array($languages) && sizeof($languages)>0){
				foreach($languages as $k=>$v){
					$locale .= $v['Language']['locale']." ";
					if(!isset($payment_arr['languages_type']['value'][$v['Language']['locale']])){
						$payment_arr['languages_type']['value'][$v['Language']['locale']] = array(
																									"name" =>$v['Language']['name'],
																									"value" => ''
																								//	'select_value' => array( '澳元' => 'AUD','加元' => 'CAD','欧元' => 'EUR','英镑' => 'GBP','日元' => 'JPY','美元' => 'USD','港元' => 'HKD')
																									);
					}else{
						$payment_arr['languages_type']['value'][$v['Language']['locale']]['name'] = $v['Language']['name'];
					}
				}
			}
			$locale_arr = explode(' ',$locale);
			if(is_array($payment_arr['languages_type']['value']) && sizeof($payment_arr['languages_type']['value'])>0){
				foreach($payment_arr['languages_type']['value'] as $k=>$v){
					if(!in_array($k,$locale_arr)){
						unset($payment_arr['languages_type']['value'][$k]);
					}else{
						$payment_arr['languages_type']['value'][$k]['select_value'] = array('请选择'=>'0', '澳元' => 'AUD','加元' => 'CAD','欧元' => 'EUR','英镑' => 'GBP','日元' => 'JPY','美元' => 'USD','港元' => 'HKD');
					}
				}
			}
			//
		//	pr($payment_arr);
		}
		
		$this->set("payment_arr",@$payment_arr);
		$this->set( "payment",$payment );
	
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$payment["PaymentI18n"][$this->locale]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);

	}
	
	function install( $id ){
		$this->Payment->updateAll(
			              array('Payment.status' => '1'),
			              array('Payment.id' => $id)
			           );
		$this->Payment->set_locale($this->locale);
		$Payment_info = $this->Payment->find(array('Payment.id'=>$id));
		//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'安装支付方式:'.$Payment_info['PaymentI18n']['name'] ,'operation');
    	}
     	$this->flash($Payment_info['PaymentI18n']['name']." 安装成功",'/payments/edit/'.$id,10);
	}
	
	function uninstall( $id ){
		$this->Payment->set_locale($this->locale);
		$Payment_info = $this->Payment->find(array('Payment.id'=>$id));
		$this->Payment->updateAll(
			              array('Payment.status' => '0'),
			              array('Payment.id' => $id)
			           );
		//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'卸载支付方式:'.$Payment_info['PaymentI18n']['name'] ,'operation');
    	}
        $this->flash($Payment_info['PaymentI18n']['name']." 卸载成功",'/payments/',10);
	}
}

?>