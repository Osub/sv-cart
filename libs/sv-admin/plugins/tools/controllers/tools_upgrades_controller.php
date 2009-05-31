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
class ToolsUpgradesController extends ToolsAppController{
	var $helpers = array('Html','Form');
	var $uses = array('Config');
	/* 说明页 */
	function home(){
		if($this->check_upgrade()){
			$this->pageTitle = 'SV-Cart'." - ".'升级说明';
			$this->set('system_info',$this->get_system_info());
		}
	}
	/* 系统检测页 */
	function check(){
		if($this->check_upgrade()){
			$this->pageTitle = 'SV-Cart'." - ".'检测系统环境';
			if(file_exists(ROOT."database.php")){
				include_once(ROOT."database.php");
				$config = new DATABASE_CONFIG();
				$system_info[] = array('数据库类型',$config->default['driver']);
				$system_info[] = array('数据库主机',$config->default['host']);
				$system_info[] = array('用户名',$config->default['login']);
				$system_info[] = array('密码','******');
				$system_info[] = array('数据库名',$config->default['database']);
				$system_info[] = array('表前缀',$config->default['prefix']);
				$system_info[] = array('编码',$config->default['encoding']);
				$this->set('system_info',$system_info);
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
			else {
				$this->install_err = "libs/database.php"."文件不存在";
				$this->this_flash($this->install_err,array('url'=>$this->host,'name'=>'前往 SV-Cart 首页'),array('url'=>$this->host.'/sv-admin','name'=>'前往 SV-Cart 后台管理中心'),'_blank');
			}
		}
	}
	/* 升级结果页 */
	function upgrade(){
		if($this->check_upgrade()){
			$this->pageTitle = 'SV-Cart'." - ".'升级结果';
			if(file_exists(ROOT."database.php")){
				include_once(ROOT."database.php");
				$config = new DATABASE_CONFIG();
				$db_host = $config->default['host'];
				$db_user = $config->default['login'];
				$db_pw = $config->default['password'];
				$db_name = $config->default['database'];
				$tables = array('svcart_cards','svcart_carts');
				$path = ROOT . WEBROOT_DIR . "/plugins/tools/data/upgrade/"."v1.1"."/dump.sql";
				if(!empty($tables)){
					$this->dump_tables($db_host,$db_user,$db_pw,$db_name,$tables,$path);
				}
				$file_path[] = ROOT . WEBROOT_DIR . "/plugins/tools/data/upgrade/"."v1.1"."/structure.sql";//sql文件路径
				$file_path[] = ROOT . WEBROOT_DIR . "/plugins/tools/data/upgrade/"."v1.1"."/primary.sql";//sql文件路径
				$this->upgrade_tables($db_host,$db_user,$db_pw,$db_name,$file_path);
				if(!empty($this->install_err)){
					$this->this_flash("升级失败！".$this->install_err,array('url'=>$this->host.'/sv-admin/tools/tools_upgrades/check','name'=>'查看系统环境'),array('url'=>$this->host.'/sv-admin/tools/tools_upgrades/rollback','name'=>'恢复数据库数据'),'_self');
				}
				else {
					$this->Config->updateAll(array('ConfigI18n.value'=>"'".'v1.1'."'"),array('Config.code ='=>'version'));
					$this->this_flash("恭喜您，SV-Cart已经成功地升级完成。",array('url'=>$this->host,'name'=>'前往 SV-Cart 首页'),array('url'=>$this->host.'/sv-admin','name'=>'前往 SV-Cart 后台管理中心'),'_blank',$this->host);
				}
			}
			else {
				$this->install_err = "libs/database.php"."文件不存在";
				$this->this_flash($this->install_err,array('url'=>$this->host,'name'=>'前往 SV-Cart 首页'),array('url'=>$this->host.'/sv-admin','name'=>'前往 SV-Cart 后台管理中心'),'_blank');
			}
		}
	}
	/* 数据恢复 */
	function rollback(){
		if($this->check_upgrade()){
			if(file_exists(ROOT . WEBROOT_DIR . "/plugins/tools/data/upgrade/"."v1.1"."/dump.sql")){
				include_once(ROOT."database.php");
				$config = new DATABASE_CONFIG();
				$db_host = $config->default['host'];
				$db_user = $config->default['login'];
				$db_pw = $config->default['password'];
				$db_name = $config->default['database'];
				$tables = array('svcart_advertisements','svcart_advertisement_i18ns');
				$path = ROOT . WEBROOT_DIR . "/plugins/tools/data/upgrade/"."v1.1"."/dump.sql";
				$this->rollback_tables($db_host,$db_user,$db_pw,$db_name,array(ROOT . WEBROOT_DIR . "/plugins/tools/data/upgrade/"."v1.1"."/dump.sql"));
				if(!empty($this->install_err)){
					$this->this_flash("恢复数据库数据失败！".$this->install_err,array('url'=>$this->host.'/sv-admin/tools/tools_installs/check','name'=>'查看系统环境'),array('url'=>$this->host.'/sv-admin/tools/tools_installs/setting_ui','name'=>'再次恢复数据库'),'_self');
				}
				else {
					$this->this_flash("数据库数据已成功恢复。",array('url'=>$this->host,'name'=>'前往 SV-Cart 首页'),array('url'=>$this->host.'/sv-admin','name'=>'前往 SV-Cart 后台管理中心'),'_blank',$this->host);
				}
			}
			else {
				$this->this_flash("您的数据库数据不需要恢复。",array('url'=>$this->host,'name'=>'前往 SV-Cart 首页'),array('url'=>$this->host.'/sv-admin','name'=>'前往 SV-Cart 后台管理中心'),'_blank',$this->host);
			}
		}
	}
	/* 版本检测 */
    function check_upgrade(){
    	$current_version = $this->get_current_version();
    	$new_version = $this->get_new_version();
    	if($current_version>=$new_version){
	        $this->install_err .= "您的 SV-Cart 已是最新版本，无需升级";
	        $this->this_flash($this->install_err,array('url'=>$this->host,'name'=>'前往 SV-Cart 首页'),array('url'=>$this->host.'/sv-admin','name'=>'前往 SV-Cart 后台管理中心'),'_blank');
	        return false;
	    }
	    return true;
    }
    /* 获取新版本号 */
    function get_new_version(){
    	return "v1.1";
    }
    /* 获取当前版本号 */
    function get_current_version(){
    	$current_version = $this->Config->findByCode('version');
    	return $current_version['ConfigI18n']['value'];
    }
    /* 提示页 */
	function this_flash($message,$url_left,$url_right,$target="_self",$host=''){
		$this->set('url_left',$url_left);
		$this->set('url_right',$url_right);
		$this->set('target',$target);
		$this->set('host',$host);
		$this->flash($message,'',3000000);
	}
}
?>