<?php
/*****************************************************************************
 * SV-Cart 路径设置文件
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: routes.php 3143 2009-07-21 07:47:27Z huangbo $
*****************************************************************************/

	Router::connect('/', array('controller' => 'pages', 'action' => 'home'));
	Router::connect('/closed', array('controller' => 'pages', 'action' => 'closed'));
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'home'));
	Router::connect('/exchanges/*', array('controller' => 'exchanges', 'action' => 'index'));
	Router::connect('/tests', array('controller' => 'tests', 'action' => 'index'));
	Router::connect('/articles/', array('controller' => 'articles', 'action' => 'index'));
	Router::parseExtensions('rss','xml'); 
	Router::connect('/sitemaps', array('controller' => 'sitemaps', 'action' => 'index')); 
	Router::connect('/sitemap', array('controller' => 'sitemaps', 'action' => 'view')); 
	Router::connect('/api/uc.php', array('controller' => 'ucs')); 
	//Router::connect('/api/uc.php', array('controller' => 'ucs')); 
	Router::connect('/categories/*', array('controller' => 'categories', 'action' => 'view')); 
	Router::connect('/:controller/:id',array('action' => 'view'),array('pass' => array('id'),'id' => '[0-9]+'));
?>