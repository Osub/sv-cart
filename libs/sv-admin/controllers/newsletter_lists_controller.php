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
 * $Id: votes_controller.php 3179 2009-07-22 05:09:18Z zhengli $
*****************************************************************************/
class NewsletterListsController extends AppController {

	var $name = 'NewsletterLists';
    var $components=array('Pagination','RequestHandler','Email');
    var $helpers=array('Pagination','Html','Form');
    var $uses=array("NewsletterList","SystemResource");
    function index(){
    	/*判断权限*/
		$this->operator_privilege('newsletter_list_view');
		/*end*/
    	$this->pageTitle="邮件订阅管理"." - ".$this->configs['shop_name'];
    	$this->navigations[] = array('name'=>'邮件管理','url'=>'');
        $this->navigations[]=array('name' => '邮件订阅管理','url' => '/newsletter_lists/');
        $this->set('navigations',$this->navigations);
        $newsletterlist_data = $this->NewsletterList->find("all");
		//资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated(false);
		$this->set("systemresource_info",$systemresource_info);
        $this->set("newsletterlist_data",$newsletterlist_data);
	}
	function export(){
		$condition["status"] = "1";
		$newsletterlist_data = $this->NewsletterList->find("all",array("conditions"=>$condition));
	    $out = '';
	    foreach ($newsletterlist_data as $key => $val)
	    {
	        $out .= $val["NewsletterList"]["email"]."\n";
	    }
	    $contentType = 'text/plain';
	    $len = strlen($out);
	    header('Last-Modified: ' . gmdate('D, d M Y H:i:s',time()+31536000) .' GMT');
	    header('Pragma: no-cache');
	    header('Content-Encoding: none');
	    header('Content-type: ' . $contentType);
	    header('Content-Length: ' . $len);
	    header('Content-Disposition: attachment; filename="email_list.txt"');
	    echo $out;
	    Configure::write('debug',0);
	    exit;
	}
	function change_status($status){
    	foreach( $_REQUEST["checkboxes"] as $k=>$v ){
    		if($status=="unsubscribe"){
    			$order_info = array(
    				"status"=>"2",
    				"id"=>$v
    			);
    			
    			$this->NewsletterList->save($order_info);
    		}
    		if($status=="remove"){
    			$this->NewsletterList->del($v);
    		}
    		if($status=="confirm"){
    			$order_info = array(
    				"status"=>"1",
    				"id"=>$v
    			);
    			
    			$this->NewsletterList->save($order_info);
    		}
        }
		$this->flash("邮件订阅操作成功，点击这里返回列表页。",'/newsletter_lists/',10);
	}
}

?>