<?php
	$i = (isset($modules)) ? count($modules) : 0;
	
	/* 会员数据整合插件的代码必须和文件名保持一致 */
    $modules[$i]['code']    = 'ucenter';
    
    //
    $modules[$i]['install'] = '/ucenter/ucenters/ucenter_install/';
    $modules[$i]['setup'] = '/ucenter/ucenters/setup/';
    $modules[$i]['points_set'] = '/ucenter/ucenters/points_set/';

    /* 被整合的第三方程序的名称 */
    $modules[$i]['name']    = 'UCenter';

    /* 被整合的第三方程序的版本 */
    $modules[$i]['version'] = '1.x';

    /* 插件的作者 */
    $modules[$i]['author']  = 'SVCART R&D TEAM';

    /* 插件作者的官方网站 */
    $modules[$i]['website'] = 'http://www.seevia.com';

    /* 插件的初始的默认值 */
    $modules[$i]['default']['db_host'] = 'localhost';
    $modules[$i]['default']['db_user'] = 'root';
    $modules[$i]['default']['prefix'] = 'uc_';
    $modules[$i]['default']['cookie_prefix'] = 'xnW_';
    

?>