<?php
/*****************************************************************************
 * SV-Cart ����ղ�
 *===========================================================================
 * ��Ȩ���� �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *�ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 *������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 *===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: add.ctp 899 2009-04-22 15:03:02Z huangbo $
*****************************************************************************/
?>
<?ob_start();?>
<div id="loginout">
	<h1><b><?=$SCLanguages['favorite'].$SCLanguages['products'];?></b></h1>
	<div style="border-left:1px solid #909592;border-right:1px solid #909592;background:#fff">
		<p class="login-alettr">	<?=$html->image('icon-10.gif',array("align"=>"middle"));?>
	<b><?=$result['message'];?></b></p>
		<p class="btns">
			<a href="javascript:close_message();"><?=$html->image('loginout-btn_right.gif');?><?=$SCLanguages['close'];?></a>
		</p>
	</div>
	<p><?=$html->image('loginout-bottom.gif')?></p>
</div>
<?
	$result['message'] = ob_get_contents();
	ob_end_clean();
	echo json_encode($result);
?>