<?php
/*****************************************************************************
 * SV-Cart ȱ���Ǽ�
 *===========================================================================
 * ��Ȩ�����Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *�ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 *������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 *===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: add_booking.ctp 1028 2009-04-24 12:23:26Z huangbo $
*****************************************************************************/
ob_start();?>
<div id="loginout">
	<h1><b style="font-size:14px"><?=$SCLanguages['booking'];?></b></h1>
	<div class="border_side">
	<p class="login-alettr">
 	<?=$html->image('icon-10.gif',array("align"=>"middle"));?>
	<b>
	<?php echo $result['message']?></b></p>
		<br/>
		<p class="btns">
			<a href="javascript:close_message();"><?=$html->image('loginout-btn_right.gif');?><?=$SCLanguages['confirm'];?></a>
		</p>
	</div>
	<p><?=$html->image("loginout-bottom.gif",array("align"=>"texttop"))?></p>
</div>
<?
$result['message'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>