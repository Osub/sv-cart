<?php
/*****************************************************************************
 * SV-Cart 后台控制
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: pages_controller.php 1215 2009-05-06 05:46:48Z huangbo $
*****************************************************************************/
class PagesController extends AppController {
	//var $name = "Pages";
	var $helpers = array('Html');
	var $uses = array();
	function home(){
		$this->pageTitle = 'SV-Cart'." - ".'版权声明';
		if($this->check_install_lock()){
				$this->set('url_left',array('url'=>'/../','name'=>'前往 SV-Cart 首页'));
				$this->set('url_right',array('url'=>'/../sv-admin','name'=>'前往 SV-Cart 后台管理中心'));
				$this->set('target',"_blank");
				$this->flash($this->install_err,'',3000000);
		}
		$this->set('system_info',$this->get_system_info());
	}
	function check(){
		$this->pageTitle = 'SV-Cart'." - ".'配置安装环境';
		if($this->check_install_lock()){
				$this->set('url_left',array('url'=>'/../','name'=>'前往 SV-Cart 首页'));
				$this->set('url_right',array('url'=>'/../sv-admin','name'=>'前往 SV-Cart 后台管理中心'));
				$this->set('target',"_blank");
				$this->flash($this->install_err,'',3000000);
		}
		$this->set('system_info',$this->get_system_info());
		$checking_dirs = array( 'libs',
								'img',
								'libs/sv-admin/tmp',
								'libs/sv-cart/tmp',
								'libs/sv-user/tmp',
								'libs/install/tmp'
								);
		$dir_checking = $this->check_dirs_priv($checking_dirs);
		if(!function_exists('apache_get_modules'))
			$this->set('mod_rewrite',2);//无法确认
		else if($this->check_mod_rewrite())
			$this->set('mod_rewrite',1);//开启
		else $this->set('mod_rewrite',0);//未开启
		$this->set('checking_result',$dir_checking['result']);
		$this->set('dir_checking',$dir_checking['detail']);
	}
	function setting_ui(){
		$this->pageTitle = 'SV-Cart'." - ".'配置系统';
	}
	function setup(){
		$this->pageTitle = 'SV-Cart'." - ".'安装结果';
		if(!$this->check_install_lock()){
		    $db_host    = isset($_POST['db_host'])      ?   trim($_POST['db_host']) : '';
		    $db_user    = isset($_POST['db_user'])      ?   trim($_POST['db_user']) : '';
		    $db_pass    = isset($_POST['db_pass'])      ?   trim($_POST['db_pass']) : '';
		    $db_name    = isset($_POST['db_name'])      ?   trim($_POST['db_name']) : '';
		    $prefix     = isset($_POST['db_prefix'])    ?   trim($_POST['db_prefix']) : '';
		    $demo_products     = isset($_POST['demo_products'])    ?   $_POST['demo_products'] : '';
		    $admin['name']    = isset($_POST['admin_name'])      ?   trim($_POST['admin_name']) : '';
		    $admin['pass']    = isset($_POST['admin_password'])      ?   md5(trim($_POST['admin_password'])) : '';
		    $admin['email']    = isset($_POST['admin_email'])      ?   trim($_POST['admin_email']) : '';
			//print_r($admin);die();
			$prefix = "svcart_";
			if($this->create_database_file($db_host, $db_user, $db_pass, $db_name, $prefix)){
				$this->install_table($db_host, $db_user, $db_pass,$db_name,'utf8',$prefix,$admin,$demo_products);
			}
			if(!empty($this->install_err)){
				@mysql_close();
				$this->set('url_left',array('url'=>'/check/','name'=>'查看系统环境'));
				$this->set('url_right',array('url'=>'/setting_ui/','name'=>'配置系统'));
				$this->set('target',"_self");
				$this->flash("安装失败！".$this->install_err,'',3000000);
			}
			else {
				@mysql_close();
				$this->set('url_left',array('url'=>'/../','name'=>'前往 SV-Cart 首页'));
				$this->set('url_right',array('url'=>'/../sv-admin','name'=>'前往 SV-Cart 后台管理中心'));
				$this->set('target',"_blank");
				$host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
				$webroot = str_replace("/".WEBROOT_DIR."/","",$this->webroot);
				$host = "http://".$host.$webroot;	
				$this->set("host",$host);
				$this->flash("恭喜您，SV-Cart已经成功地安装完成。",'',3000000);
			}
		}
		else {
				$this->set('url_left',array('url'=>'/../','name'=>'前往 SV-Cart 首页'));
				$this->set('url_right',array('url'=>'/../sv-admin','name'=>'前往 SV-Cart 后台管理中心'));
				$this->set('target',"_blank");
				$this->flash($this->install_err,'',3000000);
		
		}
	}
	
}
?>