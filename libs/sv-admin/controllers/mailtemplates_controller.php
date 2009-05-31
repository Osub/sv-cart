<?php
/*****************************************************************************
 * SV-Cart 邮件模板管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: mailtemplates_controller.php 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
class MailtemplatesController extends AppController {

	var $name = 'Mailtemplates';
	var $helpers = array('Html');
	var $components = array ('Pagination','RequestHandler','Email'); 
	var $uses = array("MailTemplate","MailTemplateI18n");
	
	function index(){
		/*判断权限*/
		$this->operator_privilege('mail_template_view');
		/*end*/
		$this->pageTitle = "邮件模板管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'邮件模板管理','url'=>'/mailtemplates/');
	   	$this->set('navigations',$this->navigations);
		//echo $this->locale."adsf";
	    $this->MailTemplate->set_locale($this->locale);
	    $shop_name = $this->configs['shop_name'];
		$MailTemplate_list=$this->MailTemplate->findAll();
		foreach($MailTemplate_list as $k=>$v){
			$title = $v['MailTemplateI18n']['title'];
			@eval("\$title = \"$title\";");
			$v['MailTemplateI18n']['title'] = @$title;
			$MailTemplate_list[$k] = $v;
		}
		//pr($this->configs['shop_name']);
		$this->set('MailTemplate_list',$MailTemplate_list);
	}
	
	function edit($id){
		/*判断权限*/
		$this->operator_privilege('mail_template_operation');
		/*end*/
		$this->pageTitle = "编辑邮件模板 - 邮件模板管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'邮件模板管理','url'=>'/mailtemplates/');
		$this->navigations[] = array('name'=>'编辑邮件模板','url'=>'');
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
		                           'html_body'=>isset($v['html_body'])?$v['html_body']:''
		                     );
		                     $this->MailTemplateI18n->saveall(array('MailTemplateI18n'=>$mailTemplateI18n_info));//更新多语言
            }
			$this->MailTemplate->save($this->data); //保存
			foreach( $this->data['MailTemplateI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$title = $v['title'];
					eval("\$title = \"$title\";");
					$userinformation_name = $title;
				}
			}
			$this->flash("邮件模板 ".$userinformation_name." 编辑成功。点击继续编辑该邮件模板",'/mailtemplates/edit/'.$id,10);
			
			
			
			
		}
		$this->data = $this->MailTemplate->localeformat($id);
		//pr($mailtemplate);
		$this->set('this->data',$this->data);

	}
    function remove($id){
		/*判断权限*/
		$this->operator_privilege('mail_template_operation');
		/*end*/		
		$this->MailTemplate->deleteAll("MailTemplate.id='".$id."'");
		$this->flash("删除成功",'/mailtemplates/',10);
    }
	function add(){
		/*判断权限*/
		$this->operator_privilege('mail_template_add');
		/*end*/
		$this->pageTitle = "编辑邮件模板 - 邮件模板管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'邮件模板管理','url'=>'/mailtemplates/');
		$this->navigations[] = array('name'=>'编辑邮件模板','url'=>'');
		$this->set('navigations',$this->navigations);
	    $show_name = $this->configs['shop_name'];
		if($this->RequestHandler->isPost()){
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
			$this->flash("邮件模板 ".$userinformation_name." 添加成功。点击继续编辑该邮件模板",'/mailtemplates/edit/'.$id,10);

		}
	}

}

?>