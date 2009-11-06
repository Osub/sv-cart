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
 * $Id: core.php 4515 2009-09-24 11:50:47Z tangyu $
*****************************************************************************/
	Configure::write('debug', 0);
	Configure::write('App.encoding', 'UTF-8');
	Configure::write('App.baseUrl', env('SCRIPT_NAME'));
//	Configure::write('Cache.disable', true);
	Configure::write('Cache.check', true);
	define('LOG_ERROR', 2);
//	Configure::write('Asset.filter.css', 'css.php');
//	Configure::write('Asset.filter.js', 'custom_javascript_output_filter.php');
//	Configure::write('Acl.classname', 'DbAcl');
//	Configure::write('Acl.database', 'default');
	Cache::config('default', array('engine' => 'File'));
//	Configure::write('MinifyAsset',true);
	Configure::write('Security.salt', 'a1b9f79d12e5d1f3db8393165155b839');
?>
