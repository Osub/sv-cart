<?php
/*****************************************************************************
 * SV-Cart 留言管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: messages_controller.php 3225 2009-07-22 10:59:01Z huangbo $
*****************************************************************************/
class MessagesController extends AppController {
	var $name = 'Messages';
	var $helpers = array('Html','Pagination');
	var $components = array ('Pagination','RequestHandler','Email'); 
	var $uses = array("MailTemplate","UserMessage","User",'ProductType','SystemResource',"Order","Product","ProductI18n");
	

	function index($user_id="none") {
		/*判断权限*/
		$this->operator_privilege('message_view');
		/*end*/
		$this->pageTitle = "留言管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'留言管理','url'=>'/messages/');
		$this->set('navigations',$this->navigations);
		$condition='';
		if( isset($user_id) && $user_id != 'none' ){

			$userlist = $this->User->findById($user_id);
		
			$condition["UserMessage.user_name LIKE"]="%".$userlist['User']['name']."%";
		}
		if( isset($this->params['url']['mods']) && $this->params['url']['mods'] != '' ){
			$condition["UserMessage.msg_type ="]=$this->params['url']['mods'];
			$this->set('modssss',$this->params['url']['mods']);
		}
		if( isset($this->params['url']['title']) && $this->params['url']['title'] != '' ){
			$condition["UserMessage.msg_title LIKE"]=	"%".$this->params['url']['title']."%";
			$this->set('titles',$this->params['url']['title']);
		}
		if( isset($this->params['url']['end_time']) && $this->params['url']['end_time'] != '' ){
			$condition["UserMessage.created <"] = $this->params['url']['end_time'];
			$this->set('end_time',$this->params['url']['end_time']);
		}
		if( isset($this->params['url']['start_time']) && $this->params['url']['start_time'] != '' ){
			$condition["UserMessage.created >"] = $this->params['url']['start_time'];
			$this->set('start_time',$this->params['url']['start_time']);
		}
		$condition["UserMessage.parent_id ="]=0;		
	   	$total = $this->UserMessage->findCount($condition,0);
		$sortClass='UserMessage';
		$page=1;
	    $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
		$parameters=Array($rownum,$page);
		$options=Array();
		$page  = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
		
		$UserMessage_list=$this->UserMessage->findAll($condition,'',"created desc",$rownum,$page);
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated(false);
       	//
       	//20090722新增
       	$this->Order->hasMany = array();
       	$this->Order->hasOne=array();
       	$order_data = $this->Order->find("all",array("fields"=>array("Order.id","Order.order_code")));
       	$order_list = array();
        foreach( $order_data as $k=>$v ){
         	$order_list[$v["Order"]["id"]] = $v;
        }
        $this->Product->hasMany = array();
		$this->Product->hasOne = array('ProductI18n'=>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 )
                 	   );
        $fields[]="Product.id";
        $fields[]="ProductI18n.name"; 
        $this->Product->set_locale($this->locale);
		$products_data=$this->Product->find("all",array("order"=>"Product.id desc","fields"=>$fields));
       	
       	$products_list = array();
       	foreach( $products_data as $k=>$v ){
       		$products_list[$v["Product"]["id"]] = $v["ProductI18n"]["name"];
       	}
       	
       	$this->set('order_list',$order_list);
       	$this->set('products_list',$products_list);
		//end 
       	$this->set('systemresource_info',$systemresource_info);//资源库信息

	   	$this->set('UserMessage_list',$UserMessage_list);

	}

	function search(){
		/*判断权限*/
		$this->operator_privilege('message_undeal_view');
		/*end*/
		$this->pageTitle = "待处理留言"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'待处理留言','url'=>'/messages/search/unprocess');
		$this->set('navigations',$this->navigations);
		
		$condition["UserMessage.status ="]="0";
		$condition["UserMessage.parent_id ="]="0";
		$total = $this->UserMessage->findCount($condition,0);
	    $sortClass='UserMessage';
	    $page=1;
	    $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	    $parameters=Array($rownum,$page);
	    $options=Array();
	    $page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);	 
	   	$UserMessage_list=$this->UserMessage->findAll($condition,'',"id desc",$rownum,$page);
	   	
	   	foreach( $UserMessage_list as $k=>$v ){
	   		$user_id = $UserMessage_list[$k]['UserMessage']['user_id'];
	   		$wh['id'] = $user_id;
	   		$User_list=$this->User->findAll($wh);
	   		$UserMessage_list[$k]['UserMessage']['name'] = ""; 
	   		$UserMessage_list[$k]['UserMessage']['rank'] = ""; 
	   		
	   		foreach( $User_list as $key=>$value ){
	   			$UserMessage_list[$k]['UserMessage']['name'] = $value['User']['name']; 
	   			$UserMessage_list[$k]['UserMessage']['rank'] = $value['User']['rank']; 
	   		}
	   	}
	   	

	   	$this->set('UserMessage_list',$UserMessage_list);
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated(false);
        $this->set('systemresource_info',$systemresource_info);
       	//
       	//20090722新增
       	$this->Order->hasMany = array();
       	$this->Order->hasOne=array();
       	$order_data = $this->Order->find("all",array("fields"=>array("Order.id","Order.order_code")));
       	$order_list = array();
        foreach( $order_data as $k=>$v ){
         	$order_list[$v["Order"]["id"]] = $v;
        }
        $this->Product->hasMany = array();
		$this->Product->hasOne = array('ProductI18n'=>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 )
                 	   );
        $fields[]="Product.id";
        $fields[]="ProductI18n.name"; 
        $this->Product->set_locale($this->locale);
		$products_data=$this->Product->find("all",array("order"=>"Product.id desc","fields"=>$fields));
       	
       	$products_list = array();
       	foreach( $products_data as $k=>$v ){
       		$products_list[$v["Product"]["id"]] = $v["ProductI18n"]["name"];
       	}
       	
       	$this->set('order_list',$order_list);
       	$this->set('products_list',$products_list);
		//end 
	   	
	   	
	   	
	   	
	   	
		if(isset($_REQUEST['page'])&& !empty($_REQUEST['page'])){
			$this->set('ex_page',$this->params['url']['page']);
		}
				
		/*CSV导出*/
		if(isset($_REQUEST['export'])&&$_REQUEST['export']==="export")
		{
			$filename = '待处理留言导出'.date('Ymd').'.csv';
			$ex_data= "待处理留言统计报表,";
			$ex_data.= "日期,";
			$ex_data.= date('Y-m-d')."\n";
			$ex_data.= "编号,";
			$ex_data.= "用户名,";
			$ex_data.= "会员等级,";
			$ex_data.= "留言标题,";
			$ex_data.= "类型,";
			$ex_data.= "留言时间\n";

			foreach($UserMessage_list as $k=>$v) {
				$ex_data.= $v['UserMessage']['id'].",";
				$ex_data.= $v['UserMessage']['name'].",";
				$ex_data.= $v['UserMessage']['rank'].",";
				$ex_data.= $v['UserMessage']['msg_title'].",";
				$ex_data.= $v['UserMessage']['msg_type'].",";
				$ex_data.= $v['UserMessage']['created']."\n";				
			}
			
		 	Configure::write('debug',0);
			header("Content-type: text/csv; charset=gb2312");
			header ("Content-Disposition: attachment; filename=".iconv('utf-8','gb2312',$filename));
			header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
			header('Expires:   0');
			header('Pragma:   public');
			echo iconv('utf-8','gb2312',$ex_data."\n");
			exit;		
		}				   		   	
	}

	function remove($id){
		/*判断权限*/
		$this->operator_privilege('message_view_cancel');
		/*end*/
		$pn = $this->UserMessage->find('list',array('fields' =>
		              array('UserMessage.id','UserMessage.msg_title'),'conditions'=> array('UserMessage.id'=>$id)));
		$this->UserMessage->deleteAll("UserMessage.id='$id'");
		//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除留言:'.$pn[$id] ,'operation');
    	}
		$this->flash("删除成功",'/messages/',10);
	}
	function remove_search($id){
		$pn = $this->UserMessage->find('list',array('fields' =>
		              array('UserMessage.id','UserMessage.msg_title'),'conditions'=> array('UserMessage.id'=>$id)));
		$this->UserMessage->deleteAll("UserMessage.id='$id'");
		//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除待处理留言:'.$pn[$id] ,'operation');
    	}
		$this->flash("删除成功",'/messages/search/',10);
	}
	function view($id){
		/*判断权限*/
		$this->operator_privilege('message_view_cancel');
		/*end*/
		$this->pageTitle = "回复留言 - 留言管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'留言管理','url'=>'/operators/');
		$this->navigations[] = array('name'=>'回复留言','url'=>'');
		$usermessage = $this->UserMessage->findById( $id );
		$user_info = $this->User->findById($usermessage["UserMessage"]["user_id"]);
		$this->navigations[] = array('name'=>$user_info["User"]["name"],'url'=>'');
		$this->set('navigations',$this->navigations);
		//pr( $usermessage );
		if($this->RequestHandler->isPost()){
			if($this->data['UserMessage']['msg_content'] != "" ){
				$this->UserMessage->deleteAll("UserMessage.parent_id=".$this->data['UserMessage']['parent_id']);
				$this->data['UserMessage']['created'] = date('Y-m-d H:i:s');
				$this->UserMessage->save( $this->data );
				$this->UserMessage->updateAll(
			              array('UserMessage.status' => "1"),
			              array('UserMessage.id' => $id)
			           );
			    		$usermessage = $this->UserMessage->findById( $id );
						$wh['parent_id'] = $id;
						$restore = $this->UserMessage->find( $wh );
						$usermessage = $this->UserMessage->findById( $id );
						$this->MailTemplate->set_locale($this->locale);
				$template = 'message_revert';
				$template=$this->MailTemplate->find("code = '$template' and status = '1'");
				$this->UserMessage->deleteAll("UserMessage.parent_id=".$this->data['UserMessage']['parent_id']);
				$this->UserMessage->save( $this->data );
				$this->UserMessage->updateAll(
			              array('UserMessage.status' => "1"),
			              array('UserMessage.id' => $id)
			           );
	    		$shop_name=$this->configs['shop_name'];
				$usermessage = $this->UserMessage->findById( $id );
				$wh['parent_id'] = $id;
				$restore = $this->UserMessage->find( $wh );
				$sent_date=date('Y-m-d H:m:s');
				$restore_content = $restore['UserMessage']['msg_content'];
				$msg_content = $usermessage['UserMessage']['msg_content'];
				$user_name = $usermessage['UserMessage']['user_name'];
				$created = $usermessage['UserMessage']['created'];
				$msg_title = $usermessage['UserMessage']['msg_title'];
				$msg_type = $usermessage['UserMessage']['msg_type'];
				if($msg_type == 0){
					$msg_type = "留言";
				}
				else if($msg_type == 1){
					$msg_type = "投诉";
				}
				else if($msg_type == 2){
					$msg_type = "询问";
				}
				else if($msg_type == 3){
					$msg_type = "售后";
				}
				/* 商店网址 */
				$shop_url = $this->server_host.$this->cart_webroot;
				$url = $shop_url."/user/messages/";
				$subject=$template['MailTemplateI18n']['title'];
				eval("\$subject = \"$subject\";");
				$this->Email->subject = "=?utf-8?B?" . base64_encode($subject) . "?=";

				
				$this->Email->sendAs = 'html';
				$this->Email->is_ssl = $this->configs['smtp_ssl'];
				$this->Email->is_mail_smtp=$this->configs['mail_service'];

				$this->Email->smtp_port = $this->configs['smtp_port'];
				$this->Email->smtpHostNames = $this->configs['smtp_host'];
				$this->Email->smtpUserName = $this->configs['smtp_user'];
				$this->Email->smtpPassword = "".$this->configs['smtp_pass']."";
				$this->Email->fromName = $shop_name;
				$this->Email->from = "".$this->configs['smtp_user']."";
				
				$template_str = $template['MailTemplateI18n']['html_body'];
				eval("\$template_str = \"$template_str\";");
				$this->Email->html_body = $template_str;
			    $text_body = $template['MailTemplateI18n']['text_body'];
			    eval("\$text_body = \"$text_body\";");
			  	$this->Email->text_body = $text_body;
				$this->Email->to = $usermessage['UserMessage']['user_email'];
				@$this->Email->send();
				//操作员日志
    	        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'回复留言:'.$msg_title ,'operation');
    	        }
				$this->flash("留言 ".$msg_title." 回复成功",'/messages/',10);
			}else{
				$this->flash("- 回复内容不能为空!",'/messages/view/'.$id,10,false);
			}
		}
		
		$wh['parent_id'] = $id;
		$restore = $this->UserMessage->find( $wh );
		//$restore = $this->UserMessage->findAll( $wh );
		//pr( $restore );
		$this->set("usermessage",$usermessage);
		if( !empty( $restore ) ){
			$this->set("restore",$restore);
		}
	}

	function view_search($id){
		$this->pageTitle = "回复留言 - 留言管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'留言管理','url'=>'/operators/');
		$this->navigations[] = array('name'=>'回复留言','url'=>'');
		$usermessage = $this->UserMessage->findById( $id );
		$user_info = $this->User->findById($usermessage["UserMessage"]["user_id"]);
		$this->navigations[] = array('name'=>$user_info["User"]["name"],'url'=>'');
		$this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
			if($this->data['UserMessage']['msg_content'] != "" ){
				$this->MailTemplate->set_locale($this->locale);
				$template = 'message_revert';
				$template=$this->MailTemplate->find("code = '$template' and status = '1'");
				$this->UserMessage->deleteAll("UserMessage.parent_id=".$this->data['UserMessage']['parent_id']);
				$this->UserMessage->save( $this->data );
				$this->UserMessage->updateAll(
			              array('UserMessage.status' => "1"),
			              array('UserMessage.id' => $id)
			           );
	    		$shop_name=$this->configs['shop_name'];
				$usermessage = $this->UserMessage->findById( $id );
				$wh['parent_id'] = $id;
				$restore = $this->UserMessage->find( $wh );
				$sent_date=date('Y-m-d H:m:s');
				$restore_content = $restore['UserMessage']['msg_content'];
				$msg_content = $usermessage['UserMessage']['msg_content'];
				$user_name = $usermessage['UserMessage']['user_name'];
				$created = $usermessage['UserMessage']['created'];
				$msg_title = $usermessage['UserMessage']['msg_title'];
				$msg_type = $usermessage['UserMessage']['msg_type'];
				if($msg_type == 0){
					$msg_type = "留言";
				}
				else if($msg_type == 1){
					$msg_type = "投诉";
				}
				else if($msg_type == 2){
					$msg_type = "询问";
				}
				else if($msg_type == 3){
					$msg_type = "售后";
				}
				/* 商店网址 */
				$shop_url = $this->server_host.$this->cart_webroot;
				$url = $shop_url."/user/messages/";
				$subject=$template['MailTemplateI18n']['title'];
				eval("\$subject = \"$subject\";");
				$this->Email->subject = "=?utf-8?B?" . base64_encode($subject) . "?=";

				
				$this->Email->sendAs = 'html';
				$this->Email->is_ssl = $this->configs['smtp_ssl'];
				$this->Email->is_mail_smtp=$this->configs['mail_service'];

				$this->Email->smtp_port = $this->configs['smtp_port'];
				$this->Email->smtpHostNames = $this->configs['smtp_host'];
				$this->Email->smtpUserName = $this->configs['smtp_user'];
				$this->Email->smtpPassword = "".$this->configs['smtp_pass']."";
				$this->Email->fromName = $shop_name;
				$this->Email->from = "".$this->configs['smtp_user']."";
				
				$template_str = $template['MailTemplateI18n']['html_body'];
				eval("\$template_str = \"$template_str\";");
				$this->Email->html_body = $template_str;
			    $text_body = $template['MailTemplateI18n']['text_body'];
			    eval("\$text_body = \"$text_body\";");
			  	$this->Email->text_body = $text_body;
				$this->Email->to = $usermessage['UserMessage']['user_email'];
				@$this->Email->send();
				//操作员日志
    	        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'回复留言:'.$msg_title ,'operation');
    	        }
				$this->flash("留言 ".$msg_title." 回复成功",'/messages/search/',10);
			}else{
				$this->flash("- 回复内容不能为空!",'/messages/view_search/'.$id,10,false);
			}
		}
		
		$wh['parent_id'] = $id;
		$restore = $this->UserMessage->find( $wh );
		//pr( $restore );
		$this->set("usermessage",$usermessage);
		if( !empty( $restore ) ){
			$this->set("restore",$restore);
		}
	}
	
	//批量处理
 	function batch(){
 		
   	  if( isset( $this->params['url']['act_type'] ) && !empty( $this->params['url']['checkbox'] ) ){
	   	    $id_arr = $this->params['url']['checkbox'];
           	$condition = "";
           	
           	for( $i=0;$i<=count( $id_arr )-1;$i++ ){
           		if ( $this->params['url']['act_type'] == 'delete' ){
           			
           			$condition['id'] = $id_arr[$i];
                    $this->UserMessage->deleteAll( $condition );
                    //操作员日志
    	            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	            $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'批量删除留言' ,'operation');
    	            }
                    if( $this->params['url']['search'] != "search" ){
           				$this->flash("删除成功",'/messages/','');
           			}else{
           				$this->flash("删除成功",'/messages/search/','');
           			}
           		}
           	}
	   }else{
	   	   	if( $this->params['url']['search'] != "search" ){
	   			$this->flash("请选择",'/messages/','');
			}else{
				$this->flash("请选择",'/messages/search/','');
			}
	   }
   }
}
?>