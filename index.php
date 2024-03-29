<?php
/*****************************************************************************
 * SV-Cart 根
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.php 3428 2009-07-31 11:48:18Z huangbo $
*****************************************************************************/
	if(!file_exists((dirname(__FILE__))."/libs/" . "database.php")){
		header('Location: ./sv-admin/index.php/tools/tools_installs/home');
		exit;
	}
	if (!defined('DS')) {
		define('DS', DIRECTORY_SEPARATOR);
	}

	if (!defined('ROOT')) {
		define('ROOT', (dirname(__FILE__))."/libs/");//	define('ROOT', dirname(dirname(dirname(__FILE__))));
	}

	if (!defined('APP_DIR')) {
		define('APP_DIR', 'sv-cart'); //	define('APP_DIR', basename(dirname(dirname(__FILE__))));
	}

	if (!defined('CAKE_CORE_INCLUDE_PATH')) {
		define('CAKE_CORE_INCLUDE_PATH', ROOT);
	}

	if (!defined('WEBROOT_DIR')) {
		define('WEBROOT_DIR', basename(dirname(__FILE__)));
	}

	if (!defined('WWW_ROOT')) {
		define('WWW_ROOT', dirname(__FILE__) . DS);
	}

	if (!defined('CORE_PATH')) {
		if (function_exists('ini_set') && ini_set('include_path', CAKE_CORE_INCLUDE_PATH . PATH_SEPARATOR . ROOT . DS . APP_DIR . DS . PATH_SEPARATOR . ini_get('include_path'))) {
			define('APP_PATH', null);
			define('CORE_PATH', null);
		} else {
			define('APP_PATH', ROOT . DS . APP_DIR . DS);
			define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
		}
	}
	if (!include(CORE_PATH . 'cake' . DS . 'bootstrap.php')) {
		trigger_error("CakePHP core could not be found.  Check the value of CAKE_CORE_INCLUDE_PATH in APP/webroot/index.php.  It should point to the directory containing your " . DS . "cake core directory and your " . DS . "vendors root directory.", E_USER_ERROR);
	}
	
	if (!include(ROOT . 'sv_dispatcher.php')) {
		trigger_error("SV-Cart Business core could not be found. Contact SV-Cart Official. http://www.seevia.cn");
	}
	
	if (isset($_GET['url']) && $_GET['url'] === 'favicon.ico') {
		return;
	} else {
		$Dispatcher = new SV_Dispatcher();
		$Dispatcher->dispatch($url);
	}
	if (Configure::read() > 0) {
		echo "<!-- " . round(getMicrotime() - $TIME_START, 4) . "s -->";
	}

?>