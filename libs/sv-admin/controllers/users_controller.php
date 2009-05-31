<?php
/*****************************************************************************
 * SV-Cart 用户管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: users_controller.php 1883 2009-05-31 11:20:54Z huangbo $
*****************************************************************************/
class UsersController extends AppController {

	var $name = 'Users';
    var $components = array ('Pagination','RequestHandler'); // Added 
    var $helpers = array('Pagination'); // Added 
    
	var $uses = array("User","UserRank","UserInfo","UserInfoValue","UserAddress","Region","Order","UserBalanceLog","UserPointLog","Order");

 
	function index($orderby='id',$ordertype='ASC'){
		/*判断权限*/
		$this->operator_privilege('member_view');
		/*end*/
	   	$this->pageTitle = "会员管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'会员管理','url'=>'/users/');
	    $condition="";
	   //会员搜索筛选条件
	   if(isset($this->params['url']['user_email']) && $this->params['url']['user_email'] != ''){
	   	    $condition["User.email like"]="%".$this->params['url']['user_email']."%";
	   	    $this->set('user_email',$this->params['url']['user_email']);
	   }
	   if(isset($this->params['url']['user_name']) && $this->params['url']['user_name'] != ''){
	   	    $condition["User.name like"]="%".$this->params['url']['user_name']."%";
	   	    $this->set('user_name',$this->params['url']['user_name']);
	   }
	   if(isset($this->params['url']['user_rank']) && $this->params['url']['user_rank'] != 0){
	   	    $condition["User.rank"]=$this->params['url']['user_rank'];
	   	    $this->set('user_rank',$this->params['url']['user_rank']);
	   }
	   if(isset($this->params['url']['min_balance']) && $this->params['url']['min_balance'] != ''){
	   	    $condition["User.balance >="]=$this->params['url']['min_balance'];
	   	    $this->set('min_balance',$this->params['url']['min_balance']);
	   }
	   if(isset($this->params['url']['max_balance']) && $this->params['url']['max_balance'] != ''){
	   	    $condition["User.balance <="]=$this->params['url']['max_balance'];
	   	    $this->set('max_balance',$this->params['url']['max_balance']);
	   }
	   if(isset($this->params['url']['min_points']) && $this->params['url']['min_points'] != ''){
	   	    $condition["User.point >="]=$this->params['url']['min_points'];
	   	    $this->set('min_points',$this->params['url']['min_points']);
	   }
	   if(isset($this->params['url']['max_points']) && $this->params['url']['max_points'] != ''){
	   	    $condition["User.point <="]=$this->params['url']['max_points'];
	   	    $this->set('max_points',$this->params['url']['max_points']);
	   }
	   if(isset($this->params['url']['date']) && $this->params['url']['date'] != ''){
	   	    $condition["User.created  >="]=$this->params['url']['date'];
	   	    $this->set('date',$this->params['url']['date']);
	   }
	   if(isset($this->params['url']['date2']) && $this->params['url']['date2'] != ''){
	   	    $condition["User.created  <="]=$this->params['url']['date2']." 23:59:59";
	   	    $this->set('date2',$this->params['url']['date2']);
	   }
	   $total = $this->User->findCount($condition,0);
	   $sortClass='User';
	   $page=1;
	   $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	   $parameters=Array($rownum,$page);
	   $options=Array();
	   $page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
   	   $users_list=$this->User->findAll($condition,'',"User.$orderby $ordertype",$rownum,$page);
   	   //用户等级
   	   $this->UserRank->set_locale($this->locale);
   	   $rank_list=$this->UserRank->findrank();
   	   $rank_lists = array();
   	   foreach($rank_list as $k=>$v){
   	   		$rank_lists[$v['UserRank']['id']] = $v;
   	   }
   	   foreach($users_list as $k=>$v){
   	   	   
   	   	   if(!empty($rank_lists[$v['User']['rank']])){
	  	  	       @$users_list[$k]['User']['UserRankname']=@$rank_lists[$v['User']['rank']]['UserRank']['name'];
	  	    }
	  	   else{
	  	  	      $users_list[$k]['User']['UserRankname']='普通会员';
	  	    }
	   }
   	  //pr($rank_list);
   	  $user_rank=isset($this->params['url']['user_rank'])?$this->params['url']['user_rank']:0;
   	  $user_name=isset($this->params['url']['user_name'])?$this->params['url']['user_name']:'';
   	  $min_balance=isset($this->params['url']['min_balance'])?$this->params['url']['min_balance']:'';
   	  $max_balance=isset($this->params['url']['max_balance'])?$this->params['url']['max_balance']:'';
   	  $min_points=isset($this->params['url']['min_points'])?$this->params['url']['min_points']:'';
   	  $max_points=isset($this->params['url']['max_points'])?$this->params['url']['max_points']:'';
   	  $start_date=isset($this->params['url']['start_date'])?$this->params['url']['start_date']:'';
   	  $end_date=isset($this->params['url']['end_date'])?$this->params['url']['end_date']:'';
   	  
   	  
   	  $this->set('orderby',$orderby);
   	  $this->set('ordertype',$ordertype);
   	  $this->set('users_list',$users_list);
   	  $this->set('rank_list',$rank_lists);
   	  $this->set('navigations',$this->navigations);
   	  $this->set('user_rank',$user_rank);
   	  $this->set('user_name',$user_name);
   	  $this->set('min_balance',$min_balance);
   	  $this->set('max_balance',$max_balance);
   	  $this->set('min_points',$min_points);
   	  $this->set('max_points',$max_points);
   	  $this->set('start_date',$start_date);
   	  $this->set('end_date',$end_date);
	  $this->set('navigations',$this->navigations);
	}
	function search($act='unvalidate',$id=''){
		/*判断权限*/
		$this->operator_privilege('member_undeal_view');
		/*end*/
		$user_info = $this->User->findById($id);
		if($act=="cancel"&&($id>0)){
			if($this->User->findById($id)){
					$this->User->updateAll(
					    array('User.verify_status' => '2'),
					    array('User.id' => $id)
					);
			
			$this->flash("会员 ".$user_info['User']['name']." 取消认证成功",'/users/search/',10);
			}
				
		}
		if($act=="userconfirm"&&($id>0)){
			if($this->User->findById($id)){
					$this->User->updateAll(
					    array('User.verify_status' => '3'),
					    array('User.id' => $id)
					);
			$this->flash("会员 ".$user_info['User']['name']." 认证成功",'/users/search/',10);
			}
				
		}
		$this->pageTitle = '待处理会员管理'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'待处理会员管理','url'=>'/users/search/unvalidate');
		$this->set('navigations',$this->navigations);
		
		$condition = "User.verify_status='1'";
		$page = 1;
		$rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
		$parameters = array($rownum,$page);
		$options = array();
		$total = $this->User->findCount($condition,0);
		$sortClass = 'User';
		list($page) = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
		
   	    $users=$this->User->findAll($condition);
		$this->set("users",$users);
	}
/*------------------------------------------------------ */
//-- 编辑会员页
/*------------------------------------------------------ */
	function view($id){
		/*判断权限*/
		$this->operator_privilege('member_operation');
		/*end*/

		$this->pageTitle = "编辑会员-会员管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'会员管理','url'=>'/users/');
		$this->navigations[] = array('name'=>'编辑会员','url'=>'');
		$this->set('navigations',$this->navigations);
		$this->UserRank->set_locale($this->locale);
		  if($this->RequestHandler->isPost()){
		  	   $user_info=$this->User->findbyid($this->data['User']['id']);
		  	   if(!empty($this->data['User']['new_password']) && !empty($this->data['User']['new_password2'])){
		               if(strcmp($this->data['User']['new_password'],$this->data['User']['new_password2']) != 0){
		       	             $this->flash("两次输入的新密码不一样",'/users/'.$this->data['User']['id'],10,false);
		               }
		               else{
		             	     $this->data['User']['password']=md5($this->data['User']['new_password']);
		               }
		       }
		       else{
		       	        //echo $user_info['User']['password'];
		       	        $this->data['User']['password']=$user_info['User']['password'];
		       } 

		       $this->User->save($this->data); 
		       /* 资金 */
               if(!empty($_POST['balance']) && is_numeric($_POST['balance'])){
               	    if($_POST['balance_type']){
               	    	$BalanceLog['UserBalanceLog']['user_id'] = $id;
               	    	$BalanceLog['UserBalanceLog']['amount'] = $_POST['balance'];
               	    	$BalanceLog['UserBalanceLog']['admin_user'] = $_SESSION['Operator_Info']['Operator']['name'];
               	    	$BalanceLog['UserBalanceLog']['admin_note'] = "";
               	    	$BalanceLog['UserBalanceLog']['system_note'] = "管理员:".$_SESSION['Operator_Info']['Operator']['name']." 增加该用户资金";
               	    	$BalanceLog['UserBalanceLog']['log_type'] = "A";
               	    	$BalanceLog['UserBalanceLog']['type_id'] = 0;
               	    	
               	    	$this->UserBalanceLog->save($BalanceLog);
	               		$this->User->updateAll( array('User.balance' => 'User.balance + '.$_POST['balance']),
											    array('User.id =' => "$id")
											);
					}
					else {
               	    	$BalanceLog['UserBalanceLog']['user_id'] = $id;
               	    	$BalanceLog['UserBalanceLog']['amount'] = '-'.$_POST['balance'];
               	    	$BalanceLog['UserBalanceLog']['admin_user'] = $_SESSION['Operator_Info']['Operator']['name'];
               	    	$BalanceLog['UserBalanceLog']['admin_note'] = "";
               	    	$BalanceLog['UserBalanceLog']['system_note'] = "管理员:".$_SESSION['Operator_Info']['Operator']['name']." 减少该用户资金";
               	    	$BalanceLog['UserBalanceLog']['log_type'] = "A";
               	    	$BalanceLog['UserBalanceLog']['type_id'] = 0;
               	    	
               	    	$this->UserBalanceLog->save($BalanceLog);
	               		$this->User->updateAll( array('User.balance' => 'User.balance - '.$_POST['balance']),
											    array('User.id =' => "$id")
											);
               		}
               }
               /* 冻结资金 */
               if(!empty($_POST['frozen']) && is_numeric($_POST['frozen'])){
               	    if($_POST['frozen_type'])
	               		$this->User->updateAll( array('User.frozen' => 'User.frozen + '.$_POST['frozen']),
											    array('User.id =' => "$id")
											);
					else 
	               		$this->User->updateAll( array('User.frozen' => 'User.frozen - '.$_POST['frozen']),
											    array('User.id =' => "$id")
											);
               }
               /* 积分 */
               if(!empty($_POST['point']) && is_numeric($_POST['point'])){
                	if($_POST['point_type']){
               	    	$PointLog['UserPointLog']['user_id'] = $id;
               	    	$PointLog['UserPointLog']['point'] = $_POST['point'];
               	    	$PointLog['UserPointLog']['admin_user'] = $_SESSION['Operator_Info']['Operator']['name'];
               	    	$PointLog['UserPointLog']['admin_note'] = "";
               	    	$PointLog['UserPointLog']['system_note'] = "管理员:".$_SESSION['Operator_Info']['Operator']['name']." 增加该用户积分";
               	    	$PointLog['UserPointLog']['log_type'] = "A";
               	    	$PointLog['UserPointLog']['type_id'] = 0;
               	    	
               	    	$this->UserPointLog->save($PointLog);
               	    	
	               		$this->User->updateAll( array('User.point' => 'User.point + '.$_POST['point']),
											    array('User.id =' => "$id")
											);
					}
					else {
               	    	$PointLog['UserPointLog']['user_id'] = $id;
               	    	$PointLog['UserPointLog']['point'] = '-'.$_POST['point'];
               	    	$PointLog['UserPointLog']['admin_user'] = $_SESSION['Operator_Info']['Operator']['name'];
               	    	$PointLog['UserPointLog']['admin_note'] = "";
               	    	$PointLog['UserPointLog']['system_note'] = "管理员:".$_SESSION['Operator_Info']['Operator']['name']." 扣除该用户积分";
               	    	$PointLog['UserPointLog']['log_type'] = "A";
               	    	$PointLog['UserPointLog']['type_id'] = 0;
               	    	
               	    	$this->UserPointLog->save($PointLog);
	               		$this->User->updateAll( array('User.point' => 'User.point - '.$_POST['point']),
											    array('User.id =' => "$id")
											);
               		}
               }
		       //更新会员项目
		      // pr($this->params);
		      
		       if(!empty($this->params['form']['info_value']) && is_array($this->params['form']['info_value'])){
		       	       $this->UserInfoValue->deleteall(array('user_id'=>$this->data['User']['id']));
		       	      
		       	      foreach($this->params['form']['info_value'] as $k=>$v){
			       	      	  if(is_array($this->params['form']['info_value'][$k])){
										$this->params['form']['info_value'][$k] = implode(';',$this->params['form']['info_value'][$k]);
							  }
							  
		       	      	      $info_value=array(
		                                     'id'=>	"",
		                                     'user_id'=>$this->data['User']['id'],
		                                     'user_info_id'=>	$k,
		                                     'value'=>	!empty($this->params['form']['info_value'][$k])?$this->params['form']['info_value'][$k]:"0"
		                      );
		                     
	                          $this->UserInfoValue->save(array('UserInfoValue'=>$info_value));
 		       	       }
		       }
			
			$this->flash("会员  ".$this->data['User']['name']." 编辑成功。点击继续编辑该会员。",'/users/'.$id,10);
		       

		   }
		   //会员基本信息
		   $this->data=$this->User->findbyid($id);
		   //会员等级信息
		   $rank_list=$this->UserRank->findrank();
		   //pr($rank_list);
		   //用户项目信息
		   $condition=" user_id='".$id."'";
		   $res=$this->UserInfoValue->findall($condition);
		   $values_id=array();
		   foreach($res as $k=>$v){
		   	   $user_info_value[$v['UserInfoValue']['user_info_id']]['UserInfoValue']=$v['UserInfoValue'];
		   	   $values_id[$k]=$v['UserInfoValue']['user_info_id'];
		   }
		  // pr($user_info_value);
		   $this->UserInfo->hasOne = array();
		   $this->UserInfo->hasMany = array('UserInfoI18n' =>   
                        array('className'    => 'UserInfoI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'user_info_id'  
                        )   
                  );
           
		   $user_infoarr=$this->UserInfo->findAll();
		   
		   $arres = array();
		   foreach( $user_infoarr as $k=>$v){
		   		$arres[$v['UserInfo']['id']] = $v;
		   
		   }
		   $user_infoarr = $arres;
		   foreach($user_infoarr as $k=>$v){
		   	     if(@is_array($user_info_value[$k])){
		   	           @$user_infoarr[$k]['value']=$user_info_value[$k]['UserInfoValue'];
		   	      }
		    }
		    //pr($user_infoarr);
		    foreach( $user_infoarr as $k=>$v ){
		    	foreach($v['UserInfoI18n'] as $kk=>$vv){
		    		if($vv['locale'] == $this->locale){
		    			$user_infoarr[$k]['UserInfo']['name'] = $vv['name'];
		    			$user_infoarr[$k]['UserInfo']['values'] = $vv['values'];
		    			
		    		}
		    	}
		    }
		   //默认收货地址
		   $user_address=$this->UserAddress->find(" user_id = '".$id."'");
		   //pr($user_address);
		   //会员订单
		   $orders_list=$this->Order->findAll(" user_id = '".$id."'","","created desc");
			foreach($orders_list as $k=>$v){
				$price_format = $this->configs['price_format'];
				//DAM
				if( isset($this->configs["mlti_currency_module"])&&$this->configs["mlti_currency_module"]==1 ){
					if($v["Order"]["order_locale"]!=' '){
						$price_format = $this->currency_format[$v["Order"]["order_locale"]];
					}else{
						$price_format = $this->configs['price_format'];
					}
				}
				// 
				$orders_list[$k]['Order']['subtotal']	=	sprintf($price_format,$v['Order']['subtotal']);
				$orders_list[$k]['Order']['total']		=	sprintf($price_format,$v['Order']['total']);
				$orders_list[$k]['Order']['should_pay']=sprintf($price_format,$v['Order']['subtotal']-$v['Order']['money_paid']);
   	       }
		   //pr($orders_list);
		   //资金日志
		   $balances_list=$this->UserBalanceLog->findAll(" user_id = '".$id."'");
		   foreach($balances_list as $k=>$v){
		   	      if($v['UserBalanceLog']['log_type'] == 'O'){
		   	      	    $join_order=$this->Order->findbyid($v['UserBalanceLog']['type_id']);
		   	      	    $balances_list[$k]['Order']=$join_order['Order'];
		   	      }
		   }
		  // pr($balances_list);
		   //积分日志
		   $points_list=$this->UserPointLog->findAll(" user_id = '".$id."'");
		   foreach($points_list as $k=>$v){
		   	      if($v['UserPointLog']['log_type'] == 'O' || $v['UserPointLog']['log_type'] == 'B'){
		   	      	    $join_orders=$this->Order->findbyid($v['UserPointLog']['type_id']);
		   	      	    $points_list[$k]['Order']=$join_orders['Order'];
		   	      }
		   }
		   //pr($points_list);
		   
		   
		   $this->set('rank_list',$rank_list);
		   $this->set('user_address',$user_address);
		   $this->set('orders_list',$orders_list);
		   $this->set('user_infoarr',$user_infoarr);
		   $this->set('balances_list',$balances_list);
		   $this->set('points_list',$points_list);
		   $this->set('user_info',$this->data);
		
	}
	function add(){
		$this->pageTitle = "编辑会员-会员管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'会员管理','url'=>'/users/');
		$this->navigations[] = array('name'=>'新增会员','url'=>'');
		$this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
		$this->data['User']['password']=md5($this->data['User']['new_password']);
		$this->data['User']['question']=!empty($this->data['User']['question'])?$this->data['User']['question']:"";
		$this->data['User']['answer']=!empty($this->data['User']['answer'])?$this->data['User']['answer']:"";
		$this->data['User']['balance']=!empty($this->data['User']['balance'])?$this->data['User']['balance']:"0";
		$this->data['User']['frozen']=!empty($this->data['User']['frozen'])?$this->data['User']['frozen']:"0";
		$this->data['User']['login_times']=!empty($this->data['User']['login_times'])?$this->data['User']['login_times']:"0";
		$this->data['User']['login_ipaddr']=!empty($this->data['User']['login_ipaddr'])?$this->data['User']['login_ipaddr']:"";
		$this->data['User']['unvalidate_note']=!empty($this->data['User']['unvalidate_note'])?$this->data['User']['unvalidate_note']:"";
		
		$this->User->saveAll($this->data);
		
		if(!empty($this->params['form']['info_value']) && is_array($this->params['form']['info_value'])){
		       	      foreach($this->params['form']['info_value'] as $k=>$v){
			       	      	  if(isset($this->params['form']['info_value_id'][$k])&&is_array($this->params['form']['info_value_id'][$k])){
										$this->params['form']['info_value_id'][$k] = implode(';',$this->params['form']['info_value_id'][$k]);
							  }
		       	      	      $info_value=array(
		                                     'id'=>	"",
		                                     'user_id'=>$this->User->getLastInsertId(),
		                                     'user_info_id'=>	$this->params['form']['info_value'][$k],
		                                     'value'=>	!empty($this->params['form']['info_value_id'][$k])?$this->params['form']['info_value_id'][$k]:""
		                      );
	                          $this->UserInfoValue->save(array('UserInfoValue'=>$info_value));
 		       	       }
		       }
			$this->flash("会员  ".$this->data['User']['name']." 编辑成功。点击继续编辑该会员。",'/users/'.$this->User->getLastInsertId(),10);
		}
		//用户项目信息
		$this->UserInfo->set_locale($this->locale);
		$user_infoarr=$this->UserInfo->findAll();
		foreach( $user_infoarr as $k=>$v ){
		    $user_infoarr[$k]['UserInfo']['name'] = $v['UserInfoI18n']['name'];
		    $user_infoarr[$k]['UserInfo']['values'] = $v['UserInfoI18n']['values'];
		    			
		}
		
		$this->set('user_infoarr',$user_infoarr);
	}
/*------------------------------------------------------ */
//-- 删除会员
/*------------------------------------------------------ */
	function remove($id){
		/*判断权限*/
		$this->operator_privilege('member_operation');
		/*end*/
		$this->pageTitle = "删除会员-会员管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'会员管理','url'=>'/users/');
		$this->navigations[] = array('name'=>'删除会员','url'=>'');
		$this->User->del($id);
		$this->flash("删除成功",'/users/',10);
   }
/*------------------------------------------------------ */
//-- 批量处理
/*------------------------------------------------------ */
   function batch(){
   	   //批量处理
	   if(isset($this->params['url']['act_type']) && $this->params['url']['act_type'] !="0"){
	   	   $users_id = !empty($this->params['url']['checkboxes']) ? $this->params['url']['checkboxes'] : 0;
         	   if ($this->params['url']['act_type'] == 'del')
               {
                     $condition=array("User.id"=>$users_id);
                     $this->User->deleteAll($condition);
                     $this->flash("删除成功",'/users/','');
                }
	   }
   }

}

?>