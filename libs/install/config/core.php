<?php
/*****************************************************************************
 * SV-Cart 参数控制文件
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: core.php 1283 2009-05-10 13:48:29Z huangbo $
*****************************************************************************/

	Configure::write('debug', 0);
	Configure::write('App.encoding', 'UTF-8');
	//Configure::write('App.baseUrl', env('SCRIPT_NAME'));
	Configure::write('Cache.disable', true);
	//Configure::write('Cache.check', true);
	define('LOG_ERROR', 2);
	Configure::write('Session.save', 'php');
//	Configure::write('Session.table', 'sessions');
//	Configure::write('Session.database', 'default');
	Configure::write('Session.cookie', 'SV-ADMIN');
	Configure::write('Session.timeout', '120');
	Configure::write('Session.start', true);
	Configure::write('Session.checkAgent', true);
	Configure::write('Security.level', 'high');
	Configure::write('Security.salt', 'a1b9f79d12e5d1f3db8393165155b839');
//	Configure::write('Asset.filter.css', 'css.php');
//	Configure::write('Asset.filter.js', 'custom_javascript_output_filter.php');
//	Configure::write('Acl.classname', 'DbAcl');
//	Configure::write('Acl.database', 'default');
	Cache::config('default', array('engine' => 'File'));
?>