<?ob_start();?>
<div id="loginout" class="loginout">
	<h1><b><?//=$SCLanguages['subscribe']?></b></h1>
	<div class="border_side" id="buyshop_box">
		<p class="login-alettr">
 	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'icon-10.gif':'icon-10.gif',array("align"=>"middle"));?>
	<b>
	<?if($result['type'] == 0){?>
	<?=$SCLanguages['email']?>:<?=$result['email'];?><br/>
			<?=$SCLanguages['message_to_email_for_check']?>。
	<?}else{?>
		<?=$result['msg'];?>
		<?}?>
		</b></p>
		<p class="buy_btn" style='padding-right:145px;'>
		<br />
		<?php echo $html->link($SCLanguages['confirm'],"javascript:close_message();");?>
		</p>
	</div>
	 	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'loginout-bottom.gif':'loginout-bottom.gif',array("align"=>"texttop"));?>
</div>			
			
			
<?
$result['message'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>