<?php 
/*****************************************************************************
 * SV-Cart ����ѡ��
 *===========================================================================
 * ��Ȩ���� �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *�ⲻ��һ��������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 *�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 *===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: change_region.ctp 2485 2009-06-30 11:33:00Z huangbo $
*****************************************************************************/
ob_start();
	$result['content'] = ob_get_contents();
	$result['regions'] = $low_region;
	$result['targets']  = !empty($targets) ? stripslashes(trim($targets)) : '';
	ob_end_clean();
	echo json_encode($result);
?>