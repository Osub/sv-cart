<?php
/*****************************************************************************
 * SV-Cart 采购单管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: check_online_users_controller.php 2961 2009-07-16 10:19:12Z huangbo $
*****************************************************************************/
class CheckOnlineUsersController extends AppController
{
	var $name='CheckOnlineUsers';	
	var $components=array('Pagination','RequestHandler');	
	var $helpers=array('Pagination','Html');	
	var $uses=array("Cart","OnlineSession","User","Product","ProductI18n","Order","OrderProduct");	
	
	function unserializesession($data) {
	    $vars=preg_split('/([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff^|]*)\|/',
	              $data,-1,PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
	//	for($i=0; $vars[$i]; $i++) $result[$vars[$i++]]=unserialize($vars[$i]);
	    $leng=count($vars);
	    $i=0;
	    while($i<$leng){
	    	$j=$i+1;
	    	$result[$vars[$i]]=unserialize($vars[$j]);
	    	$i+=2;
	    }
	    return $result;
	}
	
	function index()
	{
		$this->operator_privilege('online_user_cart');
		$this->pageTitle='在线用户统计管理'." - ".$this->configs['shop_name'];		 
			$this->navigations[]=array('name'=>'在线用户统计','url'=>'./');
		$this->navigations[] = array('name'=>'列表','url'=>'');			
		$this->set('navigations',$this->navigations);	
		$tem = $this->OnlineSession->findAll();
		$cart=array();
		$info=array();
		foreach($tem as $k=>$v){
			$info[$k]=$this->unserializesession($v['OnlineSession']['data']);
			$info[$k]['session_id']=$v['OnlineSession']['id'];
		}
		//pr($info);exit;
		$online_info = array();
		foreach($info as $k=>$v){
			if(isset($v['User'])){
				$online_info[$k]['User']['name']=$v['User']['User']['name'];
				$online_info[$k]['User']['login_time']=$v['User']['User']['last_login_time'];
				$online_info[$k]['User']['register']=$v['User']['User']['created'];
				$online_info[$k]['User']['latest_modify'] = '';
				if(isset($v['svcart']['products'])){
					$cart = $this->Cart->find('all',
						                               array(
						                                       'conditions' => array('session_id'=>$v['session_id'],'user_id'=>$v['User']['User']['id'],'1 order by modified DESC LIMIT 1'),//Where的条件
						                                       'fields' => array('modified'),//显示的字段
						                                       'joins' => array(), //关联的表
						                                       'offset' => null,//移动的条数
						                                     )
														);
					$online_info[$k]['User']['latest_modify'] = isset($cart[0]['Cart']['modified'])?$cart[0]['Cart']['modified']:'';
				}else{
				}
			}else{
				$online_info[$k]['User']['name']='未登录用户';
				$online_info[$k]['User']['session_id']=$v['session_id'];
				$online_info[$k]['User']['login_time']='';
				$online_info[$k]['User']['register']='';
			}
			if(isset($v['svcart']['cart_info'])){
				$online_info[$k]['sum_subtotal'] = sprintf($this->configs['price_format'],$v['svcart']['cart_info']['sum_subtotal']);
				$online_info[$k]['products_quantity'] = '0';
			}else{
				$online_info[$k]['sum_subtotal']= sprintf($this->configs['price_format'],'0');
				$online_info[$k]['products_quantity'] = '0';
			}
			if(isset($v['svcart']['products'])){
				foreach($v['svcart']['products'] as $kk=>$vv){
					$online_info[$k]['product_list'][$kk]['name'] = $vv['ProductI18n']['name'];
					$online_info[$k]['product_list'][$kk]['quantity'] = $vv['quantity'];
					$online_info[$k]['product_list'][$kk]['price'] = $vv['Product']['shop_price'];
					$online_info[$k]['product_list'][$kk]['attributes'] = isset($vv['attributes'])?$vv['attributes']:'';
					if(isset($v['User'])){
						$cart = $this->Cart->find(array('session_id'=>$v['session_id'],'user_id'=>$v['User']['User']['id'],'product_id'=>$vv['Product']['id']));
					//	if(!empty($cart)){pr($cart);echo 'in';exit;}
						$online_info[$k]['product_list'][$kk]['add_time'] = $cart['Cart']['created'];
					}else{
						if(isset($vv['Product']['buy_time'])){
							$online_info[$k]['product_list'][$kk]['add_time'] = $vv['Product']['buy_time'];
						}else{
								$online_info[$k]['product_list'][$kk]['add_time'] = '';
						}
					}
				}
				$products_total = 0;
				$products_quantity = 0;
				foreach($online_info[$k]['product_list'] as $kkk=>$vvv){
					$products_total += $vvv['price'] * $vvv['quantity'];
					$products_quantity += $vvv['quantity'];
					$online_info[$k]['product_list'][$kkk]['total'] = sprintf($this->configs['price_format'],$vvv['quantity'] * $vvv['price']);
				//	$vvv['price'] = sprintf($this->configs['price_format'],$vvv['price']);
					$online_info[$k]['product_list'][$kkk]['single_p'] = sprintf($this->configs['price_format'],$vvv['price']);
				
				}
			$online_info[$k]['sum_subtotal'] = sprintf($this->configs['price_format'],$products_total);
			$online_info[$k]['products_quantity'] = $products_quantity;
			}else{
				$online_info[$k]['product_list']=array();
			}
		}


	/*	foreach($tem as $k=>$v){
				$cart_info = $this->Cart->findAll(array('session_id'=>$v['OnlineSession']['id']));
				if(!empty($cart_info)){
					$product_quantity = $this->Cart->find('all',
						                               array(
						                                       'conditions' => (array('session_id'=>$v['OnlineSession']['id'])),//Where的条件
						                                       'fields' => array('count(product_quantity) as product_quantity,sum(product_price) as product_price'),//显示的字段
						                                       'joins' => array(), //关联的表
						                                       'offset' => null,//移动的条数
						                                     )
														);
					$cart_info['Cart_index']['product_quantity'] = $product_quantity[0][0]['product_quantity'];
					$product_total = $this->Cart->find('all',
						                               array(
						                                       'conditions' => (array('session_id'=>$v['OnlineSession']['id'])),//Where的条件
						                                       'fields' => array('sum(product_price) as product_price'),//显示的字段
						                                       'joins' => array(), //关联的表
						                                       'offset' => null,//移动的条数
						                                     )
														);
					$cart_info['Cart_index']['product_total'] = $product_total[0][0]['product_price'];
					$user_info = $this->User->findById($cart_info[0]['Cart']['user_id']);
					$cart_info['Cart_index']['user_name'] = $user_info['User']['name'];
					$cart_info['Cart_index']['created'] = $user_info['User']['created'];
					$cart_info['Cart_index']['user_id'] = $user_info['User']['id'];
					$cart_info['Cart_index']['session_id'] = $v['OnlineSession']['id'];
					$cart_info['Cart_index']['product_list'] = $this->Cart->find('all',array('conditions' => (array('session_id'=>$v['OnlineSession']['id'],'user_id'=>$user_info['User']['id'])))//Where的条件
					                 );
				}
				else{
					$cart_info['Cart_index'] = '';
				}
				$cart[$k] = $cart_info['Cart_index'];
		}*/
		$this->set('cart',$online_info);
	}

	function view($id)
	{
		
		/*判断权限*/
		$this->operator_privilege('online_user_cart');		
		/*end*/
		$this->pageTitle='在线用户统计管理'." - ".$this->configs['shop_name'];		
		$this->navigations[]=array('name'=>'在线用户统计','url'=>'./');
		$this->navigations[] = array('name'=>'详情','url'=>'');		
		$this->set('navigations',$this->navigations);		
		
		$url_params = func_get_args();
		$product_list = $this->Cart->find('all',array('conditions' => (array('session_id'=>$url_params[1],'user_id'=>$url_params[0])))//Where的条件
					                 );
		$user_info = $this->User->findById($url_params[0]);
	//	pr($user_info);
	//	pr($product_list);exit;
		$this->set('user_info',$user_info);
		$this->set('product_list',$product_list);

	}
	
	//处理重新计算的冻结数
	function recalcul_frozen_quantity(){
	    Configure::write('debug',0);
	    //删除cart表中过期的数据
	    if($this->configs['cart_time']=='0')
	    {
	    	$now = date('Y-m-d H:i:s');
	        $oneday_later = strtotime($now)-24*60*60;
	        $special_time = date('Y-m-d H:i:s',$oneday_later);
	    }
	    elseif($this->configs['cart_time']=='1')
	    {
	    	$now = date('Y-m-d H:i:s');
	    	$oneweek_later = strtotime($now)-7*24*60*60;
	    	$special_time = date('Y-m-d H:i:s',$oneweek_later);
	    }
	    elseif($this->configs['cart_time']=='2')
	    {
	    	$now = date('Y-m-d H:i:s');
	    	$onemonth_later = strtotime($now)-30*24*60*60;
	    	$special_time = date('Y-m-d H:i:s',$onemonth_later);
	    }
	    $this->Cart->deleteAll(array('Cart.created <='=>$special_time),false);
	    
	    //根据减库存时机计算冻结数
	    if($this->configs['enable_decrease_stock_time']=='0')
	    {
	    	return true;
	    }
	    elseif($this->configs['enable_decrease_stock_time']=='1')
	    {
	    	$cart= $this->Cart->find('all',array('fields' => array('Cart.product_id','sum(Cart.product_quantity) as
	    	                                      product_quantity'),'group' => array('Cart.product_id')));
	    	if(!empty($cart)){
	    		foreach($cart as $k => $v){
	    			$id = $v['Cart']['product_id'];
	    			$re_frozen_quantity = 0;
	    		    $cart_num = 0;
	    		    $pn = $this->Product->find('list',array('fields'=>array('Product.id','Product.quantity'),
	    		                                            'conditions'=>array('Product.id'=>$id)));
	    		    $cart_num = $v['0']['product_quantity'];
	    		    $re_frozen_quantity = $pn[$id]-$cart_num;
	    		    //更新冻结数
	                $this->Product->updateAll(array('Product.frozen_quantity'=>$re_frozen_quantity),
	                                          array('Product.id'=>$id));
	    		}
	    	}
	    }
	    elseif($this->configs['enable_decrease_stock_time']=='2')
	    {
	    	//未确认订单的id
	    	$orderid = $orderid1 = $orderproduct1 = $cart1 = $orderproduct = $cart = array();
	    	$this->Order->unbindModel(array('hasMany' => array('OrderProduct'))); 
	    	
	    	$orderid1 = $this->Order->find('all',array('fields'=>array('Order.id,Order.status'),
	    	                                          'conditions'=>array('Order.status'=>'0')));
	    	
	    	foreach($orderid1 as $v){
	    		$orderid[] = $v['Order']['id'];
	    	}
	    	
	    	$orderproduct1= $this->OrderProduct->find('all',array('conditions'
	    	=>array('OrderProduct.order_id'=>$orderid),'fields'=>array('OrderProduct.product_id',
	    	'sum(OrderProduct.product_quntity) as product_quntity'),'group' => array('OrderProduct.product_id')));
	    	
	    	$cart1= $this->Cart->find('all',array('fields' => array('Cart.product_id','sum(Cart.product_quantity) as
	    	                                      product_quantity'),'group' => array('Cart.product_id')));
	        
	    	$product_id = array();
	    	foreach($orderproduct1 as $k1=>$v1){
	    		$orderproduct[$v1['OrderProduct']['product_id']] = $v1['0']['product_quntity'];
	    		$product_id[] = $v1['OrderProduct']['product_id'];
	    	}
	    	foreach($cart1 as $k2=>$v2){
	    		$cart[$v2['Cart']['product_id']] = $v2['0']['product_quantity'];
	    		$product_id[] = $v2['Cart']['product_id'];
	    	}
	    	foreach($product_id as $vid){
	    		$cart_num=!empty($cart[$vid])?$cart[$vid]:0;
	    	    $orderpruduct_unconfirm_num=!empty($orderproduct[$vid])?$orderproduct[$vid]:0;
	    	    
	    	    $this->Product->unbindModel(array('hasMany' =>array('OrderProduct','Cart'),
	    	    'hasOne'=>array('ProductI18n','ProviderProduct','ProductDownload','ProductService')));
	    	    
	    	    $pn = $this->Product->find('list',array('fields'=>array('Product.id','Product.quantity'),
	    		                                            'conditions'=>array('Product.id'=>$vid)));
	    	    $re_frozen_quantity = $pn[$vid]-$cart_num-$orderpruduct_unconfirm_num;
	    	    //更新冻结数
	    	    $this->Product->updateAll(array('Product.frozen_quantity'=>$re_frozen_quantity),
	    	                              array('Product.id'=>$vid));
	    	}
	    }
	    //操作员日志
	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
	        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'重新计算商品冻结数','operation');
	    }
	    echo true;
	    die();
	}
	
}

?>