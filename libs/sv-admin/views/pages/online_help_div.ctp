<!--在线帮助-->

<div id="loginout" class="google_shortcut">
	<h1><b>在线帮助快捷窗口</b><?php echo $html->link(" ","javascript:YAHOO.example.container.message.hide();",array("class"=>"close"));?></h1>
	
	<div class="order_stat athe_infos tongxun" >
	<div id="google_text">
	<div id="buyshop_box">
		 <dl style="padding-top:25px;">
			
			<dd class="buy_btn" style="padding:0;overflow:visible;">
			<span class="float_l"><input class="text_input" type="text" name="online_help_value" id="online_help_value" /></span>
			<?php echo $html->link("在线搜索","javascript:;",array("onclick"=>"online_help_go();","class"=>"cofirm","id"=>"online_help_link","target"=>"_blank"));?>
			<?php echo $html->link("更多服务","http://www.seevia.cn/products/42",array("target"=>"_blank","onclick"=>"oh_big_panel.hide();","class"=>"cofirm",));?>
			</dd>
		</dl>
 		<br />
	</div></div>
				
	<p><?php echo $html->image("loginout-bottom.png");?></p>
	</div>
</div>	

