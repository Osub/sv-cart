<?php
	$i = (isset($modules)) ? count($modules) : 0;
	
	/* ��Ա�������ϲ���Ĵ��������ļ�������һ�� */
    $modules[$i]['code']    = 'ucenter';
    
    //
    $modules[$i]['install'] = '/ucenter/ucenters/ucenter_install/';
    $modules[$i]['setup'] = '/ucenter/ucenters/setup/';
    $modules[$i]['points_set'] = '/ucenter/ucenters/points_set/';

    /* �����ϵĵ�������������� */
    $modules[$i]['name']    = 'UCenter';

    /* �����ϵĵ���������İ汾 */
    $modules[$i]['version'] = '1.x';

    /* ��������� */
    $modules[$i]['author']  = 'SVCART R&D TEAM';

    /* ������ߵĹٷ���վ */
    $modules[$i]['website'] = 'http://www.seevia.com';

    /* ����ĳ�ʼ��Ĭ��ֵ */
    $modules[$i]['default']['db_host'] = 'localhost';
    $modules[$i]['default']['db_user'] = 'root';
    $modules[$i]['default']['prefix'] = 'uc_';
    $modules[$i]['default']['cookie_prefix'] = 'xnW_';
    

?>