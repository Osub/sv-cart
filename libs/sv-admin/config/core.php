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
 * $Id: core.php 2329 2009-06-29 02:09:27Z tangyu $
*****************************************************************************/
	include(ROOT."core.php");
	Configure::write('Session.save', 'php');
//	Configure::write('Session.table', 'sessions');
//	Configure::write('Session.database', 'default');
	Configure::write('Session.cookie', 'SV-ADMIN');
	Configure::write('Session.timeout', '120');
	Configure::write('Session.start', true);
	Configure::write('Session.checkAgent', true);
	Configure::write('Security.level', 'medium');
?>