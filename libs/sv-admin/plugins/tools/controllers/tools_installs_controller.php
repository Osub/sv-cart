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
 * $Id: tools_installs_controller.php 4433 2009-09-22 10:08:09Z huangbo $
*****************************************************************************/
class ToolsInstallsController extends ToolsAppController{
	var $helpers = array('Html','Form','Javascript');
	var $uses = null;
	/* 版权声明页 */
	function home(){
		if($this->check_install_lock()){
			$this->pageTitle = 'SV-Cart'." - ".$this->lang['welcome_title'];
			//$this->set('system_info',$this->get_system_info());
		}
	}
	/* 检测安装环境页 */
	function check(){
		if($this->check_install_lock()){
			$this->pageTitle = 'SV-Cart'." - ".$this->lang['install_step_2'];
			$this->set('system_info',$this->get_system_info());
			$checking_dirs = array( 'libs',
									'img',
									'libs/sv-admin/tmp',
									'libs/sv-cart/tmp',
									'libs/sv-user/tmp'
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
	}
	/* 配置系统页 */
	function setting_ui(){
		if($this->check_install_lock()){
			if(function_exists('apache_get_modules') && $this->check_mod_rewrite())
				$this->set('use_mod_rewrite',1);
			else $this->set('use_mod_rewrite',0);
			if(PHP_VERSION < '5.0.0')
				$this->set('use_minify',0);
			else $this->set('use_minify',1);
			
			$templates = $this->get_templates();
			//pr($templates);
			$this->set('templates',$templates);
			$this->pageTitle = 'SV-Cart'." - ".$this->lang['install_step_3'];
		}
	}
	/* 安装结果页 */
	function setup(){
		if($this->check_install_lock()){
			$this->pageTitle = 'SV-Cart'." - ".'安装结果';
			$db_type    		= isset($_POST['db_type'])      	?   trim($_POST['db_type']) : '';
		    $db_host    		= isset($_POST['db_host'])      	?   trim($_POST['db_host']) : '';
		    $db_user   		 	= isset($_POST['db_user'])      	?   trim($_POST['db_user']) : '';
		    $db_pass   		 	= isset($_POST['db_pass'])      	?   trim($_POST['db_pass']) : '';
		    $db_name    		= isset($_POST['db_name'])      	?   trim($_POST['db_name']) : '';
		    $prefix     		= isset($_POST['db_prefix'])    	?   trim($_POST['db_prefix']) : '';
		    $demo_products      = isset($_POST['demo_products'])	?   $_POST['demo_products'] : '';
		    $use_mod_rewrite    = isset($_POST['use_mod_rewrite'])  ?   $_POST['use_mod_rewrite'] : '';
		    $use_minify         = isset($_POST['use_minify'])       ?   $_POST['use_minify'] : '';
		    $admin['name']      = isset($_POST['admin_name'])   	?   trim($_POST['admin_name']) : '';
		    $admin['pass']      = isset($_POST['admin_password'])   ?   md5(trim($_POST['admin_password'])) : '';
		    $admin['email']     = isset($_POST['admin_email'])      ?   trim($_POST['admin_email']) : '';
		    $authcode['471']    = !empty($_POST['user_register_authcode'])      	 ?   1 : 0;//register_captcha
		    $authcode['455']    = !empty($_POST['user_login_authcode'])         	 ?   1 : 0;//use_captcha
		    $authcode['467']    = !empty($_POST['user_comment_authcode'])       	 ?   1 : 0;//comment_captcha
		    $authcode['468']    = !empty($_POST['admin_login_authcode'])        	 ?   1 : 0;//admin_captcha
		    $authcode['260']    = !empty($_POST['time_zone_set'])        	 ?   $_POST['time_zone_set'] : "-8";//default_timezone
		    $template['name']   = isset($_POST['template_name'])    			     ?   trim($_POST['template_name']) : '';
		    $template['template_style']  = isset($_POST["template_style_".$template['name']]) ?   trim($_POST["template_style_".$template['name']]) : '';
			$template_info = $this->get_template_info($template['name']);
			$template['url'] = $template_info['uri'];
			$template['status'] = 1;
			$template['is_default'] = 1;
			$template['author'] = $template_info['author'];
			$template['version'] = $template_info['version'];
			//print_r($template);die();
			$prefix = "svcart_";
			if($this->create_database_file($db_type, $db_host, $db_user, $db_pass, $db_name, $prefix)){//创建数据库连接文件
				if($this->install_table($db_type, $db_host, $db_user, $db_pass,$db_name,'utf8',$prefix,$admin,$demo_products,$authcode,$template)){//创建数据库数据
					if($use_mod_rewrite)//是否开启路径高级映射功能
						$this->file_row_replace(ROOT . 'core.php','SCRIPT_NAME',"	//Configure::write('App.baseUrl', env('SCRIPT_NAME'));\n");
					else 
						$this->file_row_replace(ROOT . 'core.php','SCRIPT_NAME',"	Configure::write('App.baseUrl', env('SCRIPT_NAME'));\n");
					if($use_minify)//是否支持min压缩
						$this->file_row_replace(ROOT . 'core.php','MinifyAsset',"	Configure::write('MinifyAsset',true);\n");
					else 
						$this->file_row_replace(ROOT . 'core.php','MinifyAsset',"	//Configure::write('MinifyAsset',true);\n");
					
					//if($authcode)
						
					$this->install_lock();//安装上锁
				}
			}
			if(!empty($this->install_err)){
				$this->this_flash($this->lang['install_error_title'].$this->install_err,array('url'=>$this->server_host.$this->admin_webroot.'tools/tools_installs/check','name'=>$this->lang['check_system_environment']),array('url'=>$this->server_host.$this->admin_webroot.'tools/tools_installs/setting_ui','name'=>$this->lang['setup_environment']),'_self');
			}
			else {
				$this->this_flash($this->lang['done'],array('url'=>$this->server_host.str_replace('index.php/','',$this->cart_webroot),'name'=>$this->lang['go_to_home']),array('url'=>$this->server_host.str_replace('index.php/','',$this->admin_webroot),'name'=>$this->lang['go_to_admin']),'_blank',true);
			}
		}
	}
	/* 检测安装是否上锁 */
    function check_install_lock(){
    	if(file_exists(ROOT . '/install.lock')){
	        $this->install_err .= $this->lang['has_locked_installer'];
	        $this->this_flash($this->install_err,array('url'=>$this->server_host.$this->cart_webroot,'name'=>$this->lang['go_to_home']),array('url'=>$this->server_host.$this->admin_webroot,'name'=>$this->lang['go_to_admin']),'_blank');
	        return false;
	    }
	    return true;
    }
    /* 提示页 */
	function this_flash($message,$url_left,$url_right,$target="_self",$success=''){
		$this->set('url_left',$url_left);
		$this->set('url_right',$url_right);
		$this->set('target',$target);
		$this->set('success',$success);
		$this->flash($message,'',3000000);
	}
	function check_database_connect(){
		$db_type = $_POST['db_type'];
		$db_user = $_POST['db_user'];
		$db_pass = $_POST['db_pass'];
		$db_name = $_POST['db_name'];
		$db_host = $_POST['db_host'];

		Configure::write('debug', 0);
		App::import('Core', array('ClassRegistry', 'Overloadable', 'Validation', 'Behavior', 'ConnectionManager', 'Set', 'String'));
		$_this =& ConnectionManager::getInstance();//创建静态对象
		if(!class_exists('DATABASE_CONFIG'))
			include_once(ROOT."database.php.default");//包含数据库配置类
		$_this->config = new DATABASE_CONFIG();//实例化数据库配置类
		//数据库配置
		$_this->config->default = array(
									'driver' => $db_type,
									'persistent' => false,
									'host' => $db_host,
									'login' => $db_user,
									'password' => $db_pass,
									'database' => $db_name,
									'prefix' => $target_prefix,
									'encoding' => $db_charset
								);
		//创建数据库连接
		@$db =& ConnectionManager::getDataSource('default');
		if($db->connected){
			
			echo "yes";die();
		}
		else {
			echo "no";die();
		}
	}
	
	function get_templates(){
	    $available_templates = array();
	    $theme_styles = array();
	    $template_dir        = @opendir(ROOT . '../themed/');
	    while ($file = readdir($template_dir)){
	        if ($file != '.' && $file != '..' && is_dir(ROOT . '../themed/' . $file) && $file != '.svn' && $file != 'index.htm'){
	        	if($template_info = $this->get_template_info($file)){
	        		
	            	$available_templates[] = $template_info;
	            }
	        }
	    }
	    return $available_templates;
	}
	
	function get_template_info($file_name){
	    $info = array();
	    $info['code']       = $file_name;

	    if (file_exists(ROOT . '../themed/' . $file_name . '/readme.txt') && !empty($file_name)){
	        $arr = array_slice(file(ROOT . '../themed/'. $file_name. '/readme.txt'), 0, 8);
	        $template_name      = explode(': ', $arr[0]);
	        $template_uri       = explode(': ', $arr[1]);
	        $template_desc      = explode(': ', $arr[2]);
	        $template_version   = explode(': ', $arr[3]);
	        $template_author    = explode(': ', $arr[4]);
	        $author_uri         = explode(': ', $arr[5]);
	        $template_style     = explode(': ', $arr[7]);
			

	        $info['name']       = isset($template_name[1]) ? trim($template_name[1]) : '';
	        $info['uri']        = isset($template_uri[1]) ? trim($template_uri[1]) : '';
	        $info['desc']       = isset($template_desc[1]) ? trim($template_desc[1]) : '';
	        $info['version']    = isset($template_version[1]) ? trim($template_version[1]) : '';
	        $info['author']     = isset($template_author[1]) ? trim($template_author[1]) : '';
	        $info['author_uri'] = isset($author_uri[1]) ? trim($author_uri[1]) : '';
	        /* 模板样式 */
	        $info['template_styles'] = array();
	        if(!empty($template_style[1]))
	        	$arr = explode(',', $template_style[1]);
	        foreach($arr as $v){
	        	if(file_exists(ROOT . '../themed/' . $file_name ."/screenshot_".$v.".png")){
	        		$style['name'] = $v;
	        		$style['img'] = $this->server_host .$this->root_all. 'themed/' . $file_name . "/screenshot_".$v.".png";
	        		$info['template_styles'][] = $style;
	        	}
	        }
			if(empty($info['template_styles']) && file_exists(ROOT . '../themed/' . $file_name ."/screenshot".".png"))
	        	$info['template_styles'][] = array('name'=>'','img'=>$this->server_host .$this->root_all. 'themed/' . $file_name ."/screenshot".".png");
	    	$info['style_default_img'] = $info['template_styles'][0]['img'];
	    	$info['style_default_name'] = $info['template_styles'][0]['name'];
	    	return $info;
	    }
	    else{
			return false;
	    }
	}
}
?>