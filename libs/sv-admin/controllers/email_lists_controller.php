<?php
/*****************************************************************************
 * SV-Cart 杂志管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: mailtemplates_controller.php 3627 2009-08-13 09:43:45Z zhengli $
*****************************************************************************/
class EmailListsController extends AppController {

	var $name = 'EmailLists';
	var $helpers = array('Html','Tinymce','fck');
	var $components = array ('Pagination','RequestHandler','Email'); 
	var $uses = array("MailTemplate","MailTemplateI18n","SystemResource","UserRank","NewsletterList","MailSendQueue","User");
	
	function index(){
		/*判断权限*/
		$this->operator_privilege('email_list_view');
		/*end*/
		$this->pageTitle = "杂志管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'邮件管理','url'=>'');
		$this->navigations[] = array('name'=>'杂志管理','url'=>'/mailtemplates/');
	   	$this->set('navigations',$this->navigations);
		//echo $this->locale."adsf";
	    $this->MailTemplate->set_locale($this->locale);
	    $shop_name = $this->configs['shop_name'];
	    $condition["type"] = "magazine";
		$MailTemplate_list=$this->MailTemplate->findAll($condition);
		foreach($MailTemplate_list as $k=>$v){
			$title = $v['MailTemplateI18n']['title'];
			@eval("\$title = \"$title\";");
			$v['MailTemplateI18n']['title'] = @$title;
			$MailTemplate_list[$k] = $v;
		}
		//pr($this->configs['shop_name']);
		
		//资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated(false);
        $this->UserRank->set_locale($this->locale);
        $user_rank_data = $this->UserRank->find("all");
        $this->set('MailTemplate_list',$MailTemplate_list);
		$this->set("systemresource_info",$systemresource_info);
		$this->set("user_rank_data",$user_rank_data);

	}
	
	function edit($id){
		/*判断权限*/
		$this->operator_privilege('email_list_edit');
		/*end*/

		$this->pageTitle = "编辑杂志 - 杂志管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'邮件管理','url'=>'');
		$this->navigations[] = array('name'=>'杂志管理','url'=>'/mailtemplates/');
		$this->navigations[] = array('name'=>'编辑杂志','url'=>'');
		$this->set('navigations',$this->navigations);
	    $shop_name = $this->configs['shop_name'];
		if($this->RequestHandler->isPost()){
			$id = $this->data['MailTemplate']['id'];
			//$this->MailTemplate->deleteall("id = '$id'",false); 
			//$this->MailTemplateI18n->deleteall("mail_template_id = '$id'",false); 
			foreach($this->data['MailTemplateI18n'] as $v){
              	     	    $mailTemplateI18n_info=array(
		                           'id'=>	isset($v['id'])?$v['id']:'',
		                           'locale'=>	$v['locale'],
		                           'mail_template_id'=> isset($v['mail_template_id'])?$v['mail_template_id']:$id,
		                           'title'=>	isset($v['title'])?$v['title']:'',
		                           'text_body'=> isset($v['text_body'])?$v['text_body']:'',
		                           'html_body'=>isset($v['html_body'])?$v['html_body']:'',
		                           'description'=>isset($v['html_body'])?$v['description']:''
		                     );
		                     $this->MailTemplateI18n->saveall(array('MailTemplateI18n'=>$mailTemplateI18n_info));//更新多语言
            }
            $this->data["MailTemplate"]["type"] = "magazine";
			$this->MailTemplate->save($this->data); //保存
			foreach( $this->data['MailTemplateI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$title = $v['title'];
					eval("\$title = \"$title\";");
					$userinformation_name = $title;
				}
			}
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑杂志:'.$userinformation_name ,'operation');
    	    }
			$this->flash("杂志 ".$userinformation_name." 编辑成功。点击这里继续编辑该杂志",'/email_lists/edit/'.$id,10);
			
			
			
			
		}
		$this->data = $this->MailTemplate->localeformat($id);
		
		$this->set('this->data',$this->data);
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$this->data["MailTemplateI18n"][$this->locale]["title"],'url'=>'');
	    $this->set('navigations',$this->navigations);

	}
    function remove($id){
    	
		$pn = $this->MailTemplateI18n->find('list',array('fields' => array('MailTemplateI18n.mail_template_id','MailTemplateI18n.title'),'conditions'=> 
                        array('MailTemplateI18n.mail_template_id'=>$id,'MailTemplateI18n.locale'=>$this->locale)));	
		$this->MailTemplate->deleteAll("MailTemplate.id='".$id."'");
		//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除杂志:'.$pn[$id] ,'operation');
    	}
		$this->flash("删除成功",'/mailtemplates/',10);
    }
	function add(){
		/*判断权限*/
		$this->operator_privilege('email_list_edit');
		/*end*/
		$this->pageTitle = "编辑杂志 - 杂志管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'邮件管理','url'=>'');
		$this->navigations[] = array('name'=>'杂志管理','url'=>'/mailtemplates/');
		$this->navigations[] = array('name'=>'编辑杂志','url'=>'');
		$this->set('navigations',$this->navigations);
	    $show_name = $this->configs['shop_name'];
		if($this->RequestHandler->isPost()){
			$this->data["MailTemplate"]["type"] = "magazine";
			$this->MailTemplate->save($this->data); //保存
		    $id=$this->MailTemplate->id;
			//新增多语言
			if(is_array($this->data['MailTemplateI18n']))
				foreach($this->data['MailTemplateI18n'] as $k => $v){
					$v['mail_template_id']=$id;
					$this->MailTemplateI18n->id='';
					$this->MailTemplateI18n->save($v); 
				}
				foreach( $this->data['MailTemplateI18n'] as $k=>$v ){
					if($v['locale'] == $this->locale){
						$title = $v['title'];
						eval("\$title = \"$title\";");
						$userinformation_name = $title;
					}
			}
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加杂志:'.$userinformation_name ,'operation');
    	    }
			$this->flash("杂志 ".$userinformation_name." 添加成功。点击这里继续编辑该杂志",'/email_lists/edit/'.$id,10);

		}
	}
	
	function insert_email_queue($usermode,$toppri,$id){
		$mailtemplate_data = $this->MailTemplate->findbyid($id);
		if( $usermode == "newsletter_user" ){
			$condition["status"] = "1";
			$newsletterlist_data = $this->NewsletterList->find("all",array("conditions"=>$condition));
			foreach( $newsletterlist_data as $k=>$v){
				$shop_name=$this->configs['shop_name'];//template
			    $mailsendqueue = array(
			       		"sender_name"=>$shop_name,//发送从姓名
			       		"receiver_email"=>" ".";".$v['NewsletterList']['email'],//接收人姓名;接收人地址
			         	"cc_email"=>";",//抄送人
			         	"bcc_email"=>";",//暗送人
			          	"title"=>$mailtemplate_data["MailTemplateI18n"]["title"],//主题 
			           	"html_body"=>$mailtemplate_data["MailTemplateI18n"]["html_body"],//内容
			          	"text_body"=>$mailtemplate_data["MailTemplateI18n"]["text_body"],//内容
			         	"sendas"=>"html",
			        	"pri"=>$toppri
			     	);
	            $this->MailSendQueue->saveAll(array("MailSendQueue"=>$mailsendqueue));//保存邮件队列
	            if(isset($this->configs['email_the_way'])&&$this->configs['email_the_way'] == 1){
	            	$this->requestAction('/mail_sends/?status=1'); 
	            }
			}
			$mailpdate = array(
				"last_send"=>date("Y-m-d h:i:s"),
				"id"=>$id
			);
			$this->MailTemplate->save($mailpdate);
		}elseif($usermode == "user_all"){
			$condition["status"] = "1";
			$user_data = $this->User->find("all",array("conditions"=>$condition));
			foreach( $user_data as $k=>$v){
				$shop_name=$this->configs['shop_name'];//template
			    $mailsendqueue = array(
			       		"sender_name"=>$shop_name,//发送从姓名
			       		"receiver_email"=>$v['User']['name'].";".$v['User']['email'],//接收人姓名;接收人地址
			         	"cc_email"=>";",//抄送人
			         	"bcc_email"=>";",//暗送人
			          	"title"=>$mailtemplate_data["MailTemplateI18n"]["title"],//主题 
			           	"html_body"=>$mailtemplate_data["MailTemplateI18n"]["html_body"],//内容
			          	"text_body"=>$mailtemplate_data["MailTemplateI18n"]["text_body"],//内容
			         	"sendas"=>"html",
			        	"pri"=>$toppri
			     	);
	            $this->MailSendQueue->saveAll(array("MailSendQueue"=>$mailsendqueue));//保存邮件队列
	            if(isset($this->configs['email_the_way'])&&$this->configs['email_the_way'] == 1){
	            	$this->requestAction('/mail_sends/?status=1'); 
	            }
			}
			$mailpdate = array(
				"last_send"=>date("Y-m-d h:i:s"),
				"id"=>$id
			);
			$this->MailTemplate->save($mailpdate);

		}elseif($usermode>0){
			$condition["rank"] = $usermode;
			$condition["status"] = "1";
			$user_data = $this->User->find("all",array("conditions"=>$condition));
			foreach( $user_data as $k=>$v){
				$shop_name=$this->configs['shop_name'];//template
			    $mailsendqueue = array(
			       		"sender_name"=>$shop_name,//发送从姓名
			       		"receiver_email"=>$v['User']['name'].";".$v['User']['email'],//接收人姓名;接收人地址
			         	"cc_email"=>";",//抄送人
			         	"bcc_email"=>";",//暗送人
			          	"title"=>$mailtemplate_data["MailTemplateI18n"]["title"],//主题 
			           	"html_body"=>$mailtemplate_data["MailTemplateI18n"]["html_body"],//内容
			          	"text_body"=>$mailtemplate_data["MailTemplateI18n"]["text_body"],//内容
			         	"sendas"=>"html",
			        	"pri"=>$toppri
			     	);
	            $this->MailSendQueue->saveAll(array("MailSendQueue"=>$mailsendqueue));//保存邮件队列
	            if(isset($this->configs['email_the_way'])&&$this->configs['email_the_way'] == 1){
	            	$this->requestAction('/mail_sends/?status=1'); 
	            }
			}
			$mailpdate = array(
				"last_send"=>date("Y-m-d h:i:s"),
				"id"=>$id
			);
			$this->MailTemplate->save($mailpdate);

		}
		$this->flash("操作成功，点击这里返回列表",'/email_lists/',10);
	}
}

?>