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
 * $Id: add.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
ob_start();?>
<div id="loginout">
	<h1><b><?php echo $SCLanguages['add'];?><?php echo $SCLanguages['comments'];?></b></h1>
	<div class="border_side" id="buyshop_box">
		<p class="login-alettr">
 	<?php echo $html->image('icon-10.gif',array("align"=>"middle"));?>
	<b><?php echo $result['message']?></b></p>
		<p class="buy_btn" style='padding-right:145px;'>
		<br />
		<?php echo $html->link($SCLanguages['confirm'],"javascript:window.location.reload();");?></p>
	</div>
	 	<?php echo $html->image('loginout-bottom.gif',array("align"=>"texttop"));?>
</div>
<?php 	
	$result['message'] = ob_get_contents();
	ob_end_clean();
	echo json_encode($result);
?>