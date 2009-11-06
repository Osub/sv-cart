<!--插件搜索-->
<div id="loginout" class="google_shortcut">
	<h1><b>插件搜索快捷窗口</b><?php echo $html->link(" ","javascript:YAHOO.example.container.message.hide();",array("class"=>"close"));?></h1>
	<div class="order_stat athe_infos tongxun" >
	<div id="google_text">
	<div id="buyshop_box">
		 <dl style="padding-top:25px;">
			
			<dd class="buy_btn" style="padding:0;overflow:visible;">
			<span class="float_l"><input class="text_input" type="text" name="plugin_search_value" id="plugin_search_value" /></span>
			<?php echo $html->link("在线搜索","javascript:;",array("onclick"=>"plugin_search_go();","class"=>"cofirm","id"=>"plugin_search_link","target"=>"_blank"));?>
			</dd>
		</dl>
 		<br />
	</div></div>
				
	<p><?php echo $html->image("loginout-bottom.png");?></p>
	</div>
</div>
