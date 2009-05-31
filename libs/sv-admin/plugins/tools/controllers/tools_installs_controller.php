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
 * $Id: pages_controller.php 1209 2009-05-06 02:12:51Z tangyu $
*****************************************************************************/
class ToolsInstallsController extends ToolsAppController{
	var $helpers = array('Html','Form');
	var $uses = null;
	/* 版权声明页 */
	function home(){
		if($this->check_install_lock()){
			$this->pageTitle = 'SV-Cart'." - ".'版权声明';
			$this->set('system_info',$this->get_system_info());
		}
	}
	/* 检测安装环境页 */
	function check(){
		if($this->check_install_lock()){
			$this->pageTitle = 'SV-Cart'." - ".'配置安装环境';
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
			$this->pageTitle = 'SV-Cart'." - ".'配置系统';
		}
	}
	/* 安装结果页 */
	function setup(){
		if($this->check_install_lock()){
			$this->pageTitle = 'SV-Cart'." - ".'安装结果';
			$db_type    = isset($_POST['db_type'])      ?   trim($_POST['db_type']) : '';
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
			if($this->create_database_file($db_type, $db_host, $db_user, $db_pass, $db_name, $prefix)){//创建数据库连接文件
				if($this->install_table($db_type, $db_host, $db_user, $db_pass,$db_name,'utf8',$prefix,$admin,$demo_products))//创建数据库数据
					$this->install_lock();//安装上锁
			}
			if(!empty($this->install_err)){
				$this->this_flash("安装失败！".$this->install_err,array('url'=>$this->host.'/sv-admin/tools/tools_installs/check','name'=>'查看系统环境'),array('url'=>$this->host.'/sv-admin/tools/tools_installs/setting_ui','name'=>'配置系统'),'_self');
			}
			else {
				$this->this_flash("恭喜您，SV-Cart已经成功地安装完成。",array('url'=>$this->host,'name'=>'前往 SV-Cart 首页'),array('url'=>$this->host.'/sv-admin','name'=>'前往 SV-Cart 后台管理中心'),'_blank',$this->host);
			}
		}
	}
	/* 检测安装是否上锁 */
    function check_install_lock(){
    	if(file_exists(ROOT . '/install.lock')){
	        $this->install_err .= "install.lock文件已存在，要想重复安装，请手动删除文件:/libs/install.lock 然后刷新本页面";
	        $this->this_flash($this->install_err,array('url'=>$this->host,'name'=>'前往 SV-Cart 首页'),array('url'=>$this->host.'/sv-admin','name'=>'前往 SV-Cart 后台管理中心'),'_blank');
	        return false;
	    }
	    return true;
    }
    /* 提示页 */
	function this_flash($message,$url_left,$url_right,$target="_self",$host=''){
		$this->set('url_left',$url_left);
		$this->set('url_right',$url_right);
		$this->set('target',$target);
		$this->set('host',$host);
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
}
?>