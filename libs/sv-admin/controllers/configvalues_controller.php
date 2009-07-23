<?php
/*****************************************************************************
 * SV-Cart 商店设置
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: configvalues_controller.php 3276 2009-07-23 09:14:17Z huangbo $
*****************************************************************************/
class ConfigvaluesController extends AppController {
	var $name = 'Configvalues';
	var $helpers = array('Html','Pagination');
	var $components = array('Pagination','RequestHandler','Email');
	var $uses = array('SystemResource','SystemResourceI18n','Config','ConfigI18n','LanguageDictionary');
	function index($group_code="shop_setting"){
		/*判断权限*/
		$this->operator_privilege('shop_view');
		/*end*/
		$this->pageTitle = '商店设置'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'商店设置','url'=>'/configvalues/');
		$this->set('navigations',$this->navigations);
		$this->set('group_codess',$group_code);
		$this->Config->hasOne = array();
		//资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated(false);//find("first",array("conditions"=>array("code"=>"order_status")));
       	//
        $this->set('config_group_code',$systemresource_info["configvalues"]);
	    $this->Config->hasMany = array('ConfigI18n' =>   
                        array('className'    => 'ConfigI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'config_id'  
                        )
                  );
		$condition2["Config.group_code"] = $group_code;
		$condition2["Config.group_code !="] = "email";
		$config = $this->Config->find('all',array('conditions'=>$condition2,'order'=>'Config.orderby,Config.created,Config.id'));
		$basics = array();
		$condition3['name'] = "";
		$name_arr = "";
		foreach($config as $k=>$v){
			$val['Config'] = $v['Config'];
			foreach($v['ConfigI18n'] as $kk=>$vv){
				if($vv['locale'] == $this->locale){
					$val['Config']['name'] = @$vv['name'];
				}
				$val['ConfigI18n'][$vv['locale']] = $vv;
				if($v['Config']['type']=="radio"||$v['Config']['type']=="checkbox"||$v['Config']['type']=="image"){
					$val['ConfigI18n'][$vv['locale']]['options'] = explode("\n",$vv['options']);
				}
				$vv = "";
			}
			$basics[$config[$k]['Config']['group_code']][] = $val;
			$val = "";
		}	
		$sumbasic = count($basics);
		$this->set("sumbasic",$sumbasic);
		$this->set('basics',$basics);
		$this->Config->hasMany = array();
	    $this->Config->hasOne = array('ConfigI18n' =>   
                        array('className'    => 'ConfigI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'config_id'  
                        )   
                  );
	}
	function edit(){
		if($this->RequestHandler->isPost()){
			//pr($this->data);
			foreach($this->data as $k=>$v){
				if(isset($v['value'])&&is_array($v['value'])){
					$v['value'] = implode(';',$v['value']);
				}
				if(isset($v['value']))
					$value = $v['value'];
				else $value = '';
				$value=addslashes($value);
				$this->ConfigI18n->updateAll(array('value' => "'".$value."'"),array('id' => $v['id']));
				
			}
			//操作员日志
        	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
        		$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'修改商店设置' ,'operation');
        	}
				$all_configs = $this->Config->getformatcode_all();
				$update_configs = $all_configs[$this->locale];

			    $spt = '<script type="text/javascript" src="http://api.seevia.cn/record.php?';
			    $spt .= "url=" .$this->server_host.$this->cart_webroot;
			    $spt .= "&shop_name=" .urlencode($update_configs['shop_name']);
			    $spt .= "&shop_title=".urlencode($update_configs['shop_title']);
			    $spt .= "&shop_desc=" .urlencode($update_configs['shop_description']);
			    $spt .= "&shop_keywords=" .urlencode($update_configs['shop_keywords']);
			    $spt .= "&address=".urlencode($update_configs['company_address']);
			    $spt .= "&qq=".$update_configs['qq']."&ww=".$update_configs['ww']."&ym=".$update_configs['ym']."&msn=".$update_configs['msn'];
			    $spt .= "&email=".$update_configs['customer_service_email']."&phone=".$update_configs['customer_service_phone']."&icp=".urlencode($update_configs['icp_number']);
			    $spt .= "&version=".$update_configs['version']."&language=".$this->locale."&php_ver=" .PHP_VERSION. "&mysql_ver=" .mysql_get_server_info();
			    $spt .= "&charset=UTF-8";
			    $spt .= '"></script>';
			    $this->set('spt',$spt);
		    
		    
			$this->flash('商店设置修改成功','/'.$_SESSION['cart_back_url'],'');
		}
	}
	function mail_settings_edit(){
		if($this->RequestHandler->isPost()){
			foreach($this->data as $k=>$v){
				if(isset($v['value'])&&is_array($v['value'])){
					$v['value'] = implode(';',$v['value']);
				}
				if(isset($v['value']))
					$value = $v['value'];
				else $value = '';
				$value=addslashes($value);
				$this->ConfigI18n->updateAll(array("value" => "'".$value."'"),array("id" => $v["id"]));
				
			}
			$this->flash('邮件服务器设置成功','/configvalues/mail_settings/','');
		}
	}
	function mail_settings(){
		/*判断权限*/
		$this->operator_privilege('mail_settings_view');
		/*end*/
		$this->pageTitle = '邮件服务器设置'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'邮件服务器设置','url'=>'/configvalues/mail_settings/');
		$this->set('navigations',$this->navigations);
		$condition2["Config.group_code"] = "email";
		$this->Config->hasOne = array();
	    $this->Config->hasMany = array('ConfigI18n' =>   
                        array('className'    => 'ConfigI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'config_id'  
                        )
                  );


		$config = $this->Config->find('all',array('conditions'=>$condition2,'order'=>'Config.orderby,Config.created,Config.id'));

		$basics = array();
		$condition3['name'] = "";
		$name_arr = "";
		foreach($config as $k=>$v){
			$val['Config'] = $v['Config'];
			foreach($v['ConfigI18n'] as $kk=>$vv){
				if($vv['locale'] == $this->locale){
					$val['Config']['name'] = @$vv['name'];
				}
				$val['ConfigI18n'][$vv['locale']] = $vv;
				if($v['Config']['type']=="radio"||$v['Config']['type']=="checkbox"||$v['Config']['type']=="image"){
					$val['ConfigI18n'][$vv['locale']]['options'] = explode("\n",$vv['options']);
				}
				$vv = "";
			}
			if(empty($name_arr[$val['Config']['group_code']])){
				$condition3['name'] = $val['Config']['group_code'];
				$condition3['locale'] = $this->locale;
				$languagedictionary = $this->LanguageDictionary->find($condition3);
				$name_arr[$val['Config']['group_code']] = $languagedictionary['LanguageDictionary']['value'];
			}
			
			$config[$k]['Config']['group_code'] = $name_arr[$val['Config']['group_code']];
			$basics[$config[$k]['Config']['group_code']][] = $val;
			$val = "";
		}	
		
	
		$sumbasic = count($basics);
		$this->set("sumbasic",$sumbasic);
		$this->set('basics',$basics);
	    $this->Config->hasOne = array('ConfigI18n' =>   
                        array('className'    => 'ConfigI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'config_id'  
                        )   
                  );
	
	}
	function test_email($email_addr,$smtp_host,$smtp_user,$smtp_pass,$smtp_port,$smtp_ssl_value){
		
		$this->Email->sendAs = 'html';
		$this->Email->is_ssl = $smtp_ssl_value;
		$this->Email->is_mail_smtp=$this->configs['mail_service'];
		$this->Email->smtp_port = $smtp_port;
	
		$this->Email->smtpHostNames = "".$smtp_host."";
		$this->Email->smtpUserName = "".$smtp_user."";
		$this->Email->smtpPassword = "".$smtp_pass."";
		$this->Email->fromName = "测试邮件";
		$this->Email->subject = "=?utf-8?B?" . base64_encode($this->configs['shop_name']) . "?=";
		$this->Email->from = "".$this->configs['smtp_user']."";    
		/* 商店网址 */
		$shop_url = $this->server_host.$this->cart_webroot;
		$template_str = "您好！这是一封检测邮件服务器设置的测试邮件。收到此邮件，意味着您的邮件服务器设置正确！您可以进行其它邮件发送的操作了！";
		$this->Email->html_body = $template_str;
		$this->Email->to = "".$email_addr."";
		echo	@$this->Email->send();
		Configure::write('debug',0);
		die();
	}

}

?>