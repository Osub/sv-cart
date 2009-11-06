<!-- gears对话框 -->
<div id="loginout" >
	<h1><b>gears</b></h1>
	<div id="buyshop_box">
		<p class="login-alettr">
		<b>
		<span id="dialog_content">
			<font id="no_gears" style="display:none;">
			没有安装 gears
			</font>
			<font id="error_gears" style="display:none;">
			gears 错误
			</font>		
			<font id="msg_gears" style="display:none;">
		优化成功
			</font>					
		</span>
		</b>
		</p>
		<br />
			
		<p class="buy_btn mar" ><span id="button_replace">
		<font id="no_gears_a" style="display:none;">
		<a class="cursor"  onclick="window.location = 'http://gears.google.com/?action=install';" >安装gears</a>		<a href='javascript:YAHOO.example.container.message.hide();'>取消</a>

		</font>
		<font id="error_gears_a" style="display:none;">
		<a class="cursor" onclick="window.location = 'http://gears.google.com/?action=install';">安装gears</a>		<a href='javascript:YAHOO.example.container.message.hide();'>取消</a>

		</font>
			
		</span></p>
		<font id="success_gears" style="display:none;">
		<p class="buy_btn" style="padding-right:170px;"><?php echo $html->link("关闭","javascript:layer_gears_obj.hide();");?></p>
		</font>
	</div>
</div>
<!--End gears对话框-->	
