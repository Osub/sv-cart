<?php
/*****************************************************************************
 * SV-Cart �ύ����
 *===========================================================================
 * ��Ȩ�����Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *�ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 *������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 *===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: add.ctp 1028 2009-04-24 12:23:26Z huangbo $
*****************************************************************************/
ob_start();?>
<div id="loginout">
	<h1><b><?=$SCLanguages['add'];?><?=$SCLanguages['comments'];?></b></h1>
	<div class="border_side" id="buyshop_box">
		<p class="login-alettr">
 	<?=$html->image('icon-10.gif',array("align"=>"middle"));?>
	<b><?php echo $result['message']?></b></p>
		<p class="buy_btn" style='padding-right:145px;'>
		<br />
		<?=$html->link($SCLanguages['confirm'],"javascript:window.location.reload();");?></p>
	</div>
	 	<?=$html->image('loginout-bottom.gif',array("align"=>"texttop"));?>
</div>
<?php	
	$result['message'] = ob_get_contents();
	ob_end_clean();
	echo json_encode($result);
?>