<?php
/*****************************************************************************
 * SV-Cart ���������ļ�
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
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