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
 * $Id: routes.php 1201 2009-05-05 13:30:17Z huangbo $
*****************************************************************************/

	Router::connect('/', array('controller' => 'pages', 'action' => 'home'));
	Router::connect('/closed', array('controller' => 'pages', 'action' => 'closed'));
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'home'));
	Router::connect('/tests', array('controller' => 'tests', 'action' => 'index'));
	Router::connect('/articles/', array('controller' => 'articles', 'action' => 'index'));
	Router::parseExtensions('rss','xml'); 
	Router::connect('/sitemaps', array('controller' => 'sitemaps', 'action' => 'index')); 
	Router::connect('/sitemap', array('controller' => 'sitemaps', 'action' => 'view')); 

	Router::connect('/:controller/:id',array('action' => 'view'),array('pass' => array('id'),'id' => '[0-9]+'));
?>