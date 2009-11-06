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
class FavoritesListsController extends AppController {

	var $name = 'FavoritesLists';
    var $components=array('Pagination','RequestHandler','Email');
    var $helpers=array('Pagination','Html','Form');
    var $uses=array("UserFavorite","Product","SystemResource","User","MailSendQueue","MailTemplate");
    function index(){
    	$this->operator_privilege('favorites_list_view');
    	$this->pageTitle="关注管理"." - ".$this->configs['shop_name'];
    	$this->navigations[] = array('name'=>'邮件管理','url'=>'');
        $this->navigations[]=array('name' => '关注管理','url' => '/favorites_lists/');
        $this->set('navigations',$this->navigations);
    	$condition["status"] = "1";
    	$total=$this->UserFavorite->findCount($condition,0);
        $sortClass='UserFavorite';
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=Array($rownum,$page);
        $options=Array();
        list($page)=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
        $userfavorite_data=$this->UserFavorite->find("all",array("conditions"=>$condition,"order"=>"modified desc","limit"=>$rownum,"page"=>$page));

		$product_id[] = 0;
		$product_category_id[] = 0;
		$articles_category_id[] = 0;
		$brands_id[] = 0;
		$articles_id[] = 0;
		foreach( $userfavorite_data as $k=>$v ){
			if( $v["UserFavorite"]["type"] == "p" ){
				$product_id[] = $v["UserFavorite"]["type_id"];
			}
			if( $v["UserFavorite"]["type"] == "pc" ){
				$product_category_id[] = $v["UserFavorite"]["type_id"];
			}
			if( $v["UserFavorite"]["type"] == "ac" ){
				$articles_category_id[] = $v["UserFavorite"]["type_id"];
			}
			if( $v["UserFavorite"]["type"] == "b" ){
				$brands_id[] = $v["UserFavorite"]["type_id"];
			}
			if( $v["UserFavorite"]["type"] == "a" ){
				$articles_id[] = $v["UserFavorite"]["type_id"];
			}
		}
		$favorite_last = array();
		if(count($product_id)>1){
	        $this->Product->hasMany = array();
			$this->Product->hasOne = array('ProductI18n'=>array
													( 
													  'className'    => 'ProductI18n',   
						                              'order'        => '',   
						                              'dependent'    =>  true,   
						                              'foreignKey'   => 'product_id'
						                        	 )
	                 	   );
	        $product_data = $this->Product->set_locale($this->locale);
			$product_data = $this->Product->find("all",array("conditions"=>array("Product.id"=>$product_id)));
			$product_list = array();
			foreach( $product_data as $k=>$v ){
				$product_list[$v["Product"]["id"]] = $v["ProductI18n"]["name"];
			}
			
			foreach( $userfavorite_data as $k=>$v ){
				$userfavorite_data[$k]["UserFavorite"]["type_id_name"] = "商品：".$product_list[$v["UserFavorite"]["type_id"]];
			}
		}
		if(count($product_category_id)>1){
		
		}
		if(count($articles_category_id)>1){
		
		}
		if(count($brands_id)>1){
		
		}
		if(count($articles_id)>1){
		
		}
		//资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated(false);
		$this->set("userfavorite_data",$userfavorite_data);
		$this->set("systemresource_info",$systemresource_info);
	}
	
	
	//单个插入队列表
	function addtolist($id,$pri){
		$userfavorite_info = $this->UserFavorite->findbyid($id);
		if( $userfavorite_info["UserFavorite"]["type"] == "p"){
	        $this->Product->hasMany = array();
			$this->Product->hasOne = array('ProductI18n'=>array
													( 
													  'className'    => 'ProductI18n',   
						                              'order'        => '',   
						                              'dependent'    =>  true,   
						                              'foreignKey'   => 'product_id'
						                        	 )
	                 	   );
	        $product_info = $this->Product->set_locale($this->locale);
			$product_info = $this->Product->findbyid($userfavorite_info["UserFavorite"]["type_id"]);
			$user_info = $this->User->findbyid($userfavorite_info["UserFavorite"]["user_id"]);
			$product_name = $product_info["ProductI18n"]["name"];
			$user_name = $user_info["User"]["name"];
			
			$shop_name=$this->configs['shop_name'];//template
			$shop_url=$this->server_host.$this->cart_webroot;//template
			$send_date=date('Y-m-d H:m:s');//template
			//读模板
			$template='favorites_list';
			$this->MailTemplate->set_locale($this->locale);
			$template=$this->MailTemplate->find("code = '$template' and status = '1'");
			//模板赋值
			$html_body=$template['MailTemplateI18n']['html_body'];
			eval("\$html_body = \"$html_body\";");
            $text_body=$template['MailTemplateI18n']['text_body'];
            eval("\$text_body = \"$text_body\";");
            //主题赋值
            $title = $template['MailTemplateI18n']['title'];
            eval("\$title = \"$title\";");
		    $mailsendqueue = array(
		       		"sender_name"=>$shop_name,//发送从姓名
		       		"receiver_email"=>$user_name.";".$user_info['User']['email'],//接收人姓名;接收人地址
		         	"cc_email"=>";",//抄送人
		         	"bcc_email"=>";",//暗送人
		          	"title"=>$title,//主题 
		           	"html_body"=>$html_body,//内容
		          	"text_body"=>$text_body,//内容
		         	"sendas"=>"html",
		        	"pri"=>$pri
		     	);

            $this->MailSendQueue->saveAll(array("MailSendQueue"=>$mailsendqueue));//保存邮件队列
            if(isset($this->configs['email_the_way'])&&$this->configs['email_the_way'] == 1){
            	$this->requestAction('/mail_sends/?status=1'); 
            }

		}
		$this->flash("插入队列表成功，点击这里返回列表！",'/favorites_lists/',10);
	}
	//批量插入队列表
	function batch_addtolist(){
		$start_date = $_REQUEST["date"];
		$toppri = $_REQUEST["toppri"];
		$condition["status ="] = "1";
		if( $start_date !="" ){
			$condition["modified >="] = $start_date." 00:00:00";
		}
		$userfavorite_data=$this->UserFavorite->find("all",array("conditions"=>$condition,"order"=>"modified desc"));
		foreach( $userfavorite_data as $k=>$userfavorite_info ){
			if( $userfavorite_info["UserFavorite"]["type"] == "p"){
		        $this->Product->hasMany = array();
				$this->Product->hasOne = array('ProductI18n'=>array
														( 
														  'className'    => 'ProductI18n',   
							                              'order'        => '',   
							                              'dependent'    =>  true,   
							                              'foreignKey'   => 'product_id'
							                        	 )
		                 	   );
		        $product_info = $this->Product->set_locale($this->locale);
				$product_info = $this->Product->findbyid($userfavorite_info["UserFavorite"]["type_id"]);
				$user_info = $this->User->findbyid($userfavorite_info["UserFavorite"]["user_id"]);
				$product_name = $product_info["ProductI18n"]["name"];
				$user_name = $user_info["User"]["name"];
				
				$shop_name=$this->configs['shop_name'];//template
				$shop_url=$this->server_host.$this->cart_webroot;//template
				$send_date=date('Y-m-d H:m:s');//template
				//读模板
				$template='favorites_list';
				$this->MailTemplate->set_locale($this->locale);
				$template=$this->MailTemplate->find("code = '$template' and status = '1'");
				//模板赋值
				$html_body=$template['MailTemplateI18n']['html_body'];
				eval("\$html_body = \"$html_body\";");
	            $text_body=$template['MailTemplateI18n']['text_body'];
	            eval("\$text_body = \"$text_body\";");
	            //主题赋值
	            $title = $template['MailTemplateI18n']['title'];
	            eval("\$title = \"$title\";");
			    $mailsendqueue = array(
			       		"sender_name"=>$shop_name,//发送从姓名
			       		"receiver_email"=>$user_name.";".$user_info['User']['email'],//接收人姓名;接收人地址
			         	"cc_email"=>";",//抄送人
			         	"bcc_email"=>";",//暗送人
			          	"title"=>$title,//主题 
			           	"html_body"=>$html_body,//内容
			          	"text_body"=>$text_body,//内容
			         	"sendas"=>"html",
			        	"pri"=>$toppri
			     	);

	            $this->MailSendQueue->saveAll(array("MailSendQueue"=>$mailsendqueue));//保存邮件队列
	            if(isset($this->configs['email_the_way'])&&$this->configs['email_the_way'] == 1){
	            	$this->requestAction('/mail_sends/?status=1'); 
	            }
			}
		}
		$this->flash("批量插入队列表成功，点击这里返回列表！",'/favorites_lists/',10);
	}
}

?>