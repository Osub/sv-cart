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
class MailHistoriesController extends AppController {

	var $name = 'MailHistories';
	var $helpers = array('Pagination','Html');
	var $components = array ('Pagination','RequestHandler','Email'); 
	var $uses = array("MailSendHistory");
	
	function index(){
		/*判断权限*/
		$this->operator_privilege('email_list_view');
		/*end*/
		$this->pageTitle = "邮件发送历史"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'邮件管理','url'=>'');
		$this->navigations[] = array('name'=>'邮件发送历史','url'=>'/mail_histories/');
	   	$this->set('navigations',$this->navigations);
	   	$condition = "";
	   	
        if(isset($this->params['url']['kword_name']) && $this->params['url']['kword_name']!=''){
        	$condition["and"]["or"]["sender_name like"] = "%".$this->params['url']['kword_name']."%";
        	$condition["and"]["or"]["receiver_email like"] = "%".$this->params['url']['kword_name']."%";
        	$condition["and"]["or"]["cc_email like"] = "%".$this->params['url']['kword_name']."%";
        	$condition["and"]["or"]["bcc_email like"] = "%".$this->params['url']['kword_name']."%";
        	$condition["and"]["or"]["title like"] = "%".$this->params['url']['kword_name']."%";
            $this->set('kword_name',$this->params['url']['kword_name']);
        }
        if(isset($this->params['url']['date']) && $this->params['url']['date']!=''){
        	$condition["and"]["created >="] = $this->params['url']['date']." 00:00:00";
            $this->set('date',$this->params['url']['date']);
        }
        if(isset($this->params['url']['date2']) && $this->params['url']['date2']!=''){
        	$condition["and"]["created <="] = $this->params['url']['date2']." 23:59:59";
            $this->set('date2',$this->params['url']['date2']);
        }

        $total=$this->MailSendHistory->findCount($condition,0);
        $sortClass='MailSendHistory';
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=Array($rownum,$page);
        $options=Array();
        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
    	$MailSendHistory_info = $this->MailSendHistory->find("all",array("conditions"=>$condition,"order"=>"id desc","page"=>$page,"limit"=>$rownum));
		$this->set('mailsendhistory',$MailSendHistory_info);
	}
}

?>