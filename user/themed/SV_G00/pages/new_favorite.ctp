<?php
/*****************************************************************************
 * SV-Cart �����ղ�
 *===========================================================================
 * ��Ȩ���� �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *�ⲻ��һ��������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 *�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 *===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: new_favorite.ctp 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/

ob_start();
?>
<h1 class="hd"><? echo $msg; ?></h1>
<?
$result['content'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>