<!--Google快捷窗口-->

<div id="loginout" class="google_shortcut">
	<h1><b>google翻译快捷窗口</b><?php echo $html->link(" ","javascript:YAHOO.example.container.message.hide();",array("class"=>"close"));?></h1>
	
	<div class="order_stat athe_infos tongxun" >
	<div id="google_text">
	<div id="buyshop_box">
		 <dl style="padding-top:25px;">
			<dt style="width:30%;"><b class="green_2">原文:</b></dt>
			<dd class="buy_btn" style="padding:0;overflow:visible;">
			<span class="float_l"><input class="text_input" type="text" name="original_text" id="original_text" /></span>
			<?php echo $html->link("确定","javascript:;",array("onclick"=>"g_trans();","class"=>"cofirm"));?>
			</dd>
		</dl>
		<?php  if(isset($g_languages) && sizeof($g_languages)>0){
	$i=0;
	foreach ($g_languages as $ke => $va){
		if($va['Language']['locale'] != 'chi'){?>
		<dl>
			<dt style="width:30%;"><b class="green_2"><?php echo $va['Language']['name'];?></b></dt>
			<dd><input class="text_input" type="text" name="<?php echo $va['Language']['google_translate_code']?>" id="g_trans<?php echo $i++;?>" /></dd>
		</dl>
	<?}}}?>
		 <dl><dt><b class="green_2"></b></dt><dd><span id="google_translate_information"></span></dd></dl>

 		<br />
	</div></div>
	<p><?php echo $html->image("loginout-bottom.png");?></p>
	</div>
</div>	

