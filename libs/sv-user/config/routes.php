<?php
/*****************************************************************************
 * SV-Cart ·�������ļ�
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: routes.php 3454 2009-08-03 08:04:25Z huangbo $
*****************************************************************************/

	Router::connect('/', array('controller' => 'pages', 'action' => 'home'));
//	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	Router::connect('/tests', array('controller' => 'tests', 'action' => 'index'));
	Router::connect('/:controller/:id',array('action' => 'view'),array('pass' => array('id'),'id' => '[0-9]+'));
	Router::connect('/login', array('controller' => 'pages', 'action' => 'login'));
	Router::connect('/act_login', array('controller' => 'pages', 'action' => 'act_login'));
	Router::connect('/logout', array('controller' => 'pages', 'action' => 'logout'));
	Router::connect('/register', array('controller' => 'pages', 'action' => 'register'));
	Router::connect('/forget_password', array('controller' => 'pages', 'action' => 'forget_password'));
	Router::connect('/captcha', array('controller' => 'pages', 'action' => 'captcha'));
	Router::connect('/edit_password/*', array('controller' => 'pages', 'action' => 'edit_password'));
	Router::connect('/verifyemail/*', array('controller' => 'pages', 'action' => 'verifyemail'));
	Router::connect('/order_received/*', array('controller' => 'pages', 'action' => 'order_received'));
	Router::connect('/check_input', array('controller' => 'pages', 'action' => 'check_input'));
	Router::connect('/check_all', array('controller' => 'pages', 'action' => 'check_all'));
	Router::connect('/act_register', array('controller' => 'pages', 'action' => 'act_register'));
	Router::connect('/send_verify_email/*', array('controller' => 'pages', 'action' => 'send_verify_email'));
	Router::connect('/closed', array('controller' => 'pages', 'action' => 'closed'));
	Router::connect('/messages', array('controller' => 'messages', 'action' => 'view'));
	
?>