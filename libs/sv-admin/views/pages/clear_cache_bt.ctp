<!--清除缓存对话框-->
<div id="loginout" >
	<h1><b>清除缓存</b></h1>
	<div class="order_stat athe_infos tongxun" >
	<div id="cc_text">
	<div id="buyshop_box">
		
		<p class="login-alettr" style="border:0;padding-bottom:15px;">请选择要清除缓存的模块:</p>
		<dl><dt><b class="green_2"><input type="checkbox" name="app_chkall" id="app_chkall" value="checkbox" onclick="app_checkAll();" checked /></b></dt><dd>全选</dd></dl>
		<?php foreach($app_model as $k=>$v){?>
		 <dl><dt><b class="green_2"><input type='checkbox' name="app_checkbox" value="<?php echo $v['dir_name'];?>" checked onclick="check_checked();" /></b></dt><dd><?php echo $v['name'];?></dd></dl>
		<?php }?>
 		<br />
		<p class="buy_btn mar"><?php echo $html->link("关闭","javascript:YAHOO.example.container.message.hide();");?>
		<?php echo $html->link("确定","javascript:;",array("onclick"=>"clear_cache();"));?></p>
		
		</div>
	</div>
		<div id="cc_confirm" style="display:none">
		<div id="buyshop_box">
		<p class="login-alettr" style="border:0;padding-bottom:15px;"><b id='clear_cache_msg'>缓存清除成功</b></p>
		<br />
		<p class="buy_btn" style="padding-right:170px;"><?php echo $html->link("确定","javascript:YAHOO.example.container.message.hide();");?></p>
		</div></div>
		
	<p><?php echo $html->image("loginout-bottom.png");?></p>
	</div>
</div>
