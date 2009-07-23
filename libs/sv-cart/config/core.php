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
 * $Id: core.php 2329 2009-06-29 02:09:27Z tangyu $
*****************************************************************************/
	include(ROOT."core.php");
	Configure::write('Session.save', 'database');
	Configure::write('Session.table', 'sessions');
//	Configure::write('Session.database', 'default');
	Configure::write('Session.cookie', 'SVCART');
	Configure::write('Session.timeout', '1200');
	Configure::write('Session.start', true);
	Configure::write('Session.checkAgent', true);
	Configure::write('Security.level', 'low');
?>