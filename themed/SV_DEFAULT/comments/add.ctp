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
 * $Id: add.ctp 3779 2009-08-19 10:40:08Z huangbo $
*****************************************************************************/
ob_start();?>
<div id="loginout" class="loginout">
	<h1><b><?php echo $SCLanguages['add'];?><?php echo $SCLanguages['comments'];?></b></h1>
	<div class="border_side" id="buyshop_box">
		<p class="login-alettr">
 	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'icon-10.gif':'icon-10.gif',array("align"=>"middle"));?>
	<b><?php echo $result['message']?></b></p>
		<p class="buy_btn" style='padding-right:145px;'>
		<br />
	<?if($result['type'] == 0){?>
		<?php echo $html->link($SCLanguages['confirm'],"javascript:window.location.reload();");?>
	<?}else{?>
		<?php echo $html->link($SCLanguages['confirm'],"javascript:close_message();");?>
	<?}?>
	
		</p>
	</div>
	 	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'loginout-bottom.gif':'loginout-bottom.gif',array("align"=>"texttop"));?>
</div>
<?php 	
	$result['message'] = ob_get_contents();
	ob_end_clean();
	echo json_encode($result);
?>