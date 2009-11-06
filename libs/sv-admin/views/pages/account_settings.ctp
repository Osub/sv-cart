<div id="loginout" >
	<h1><b>账户设置</b></h1>
	<div class="order_stat athe_infos tongxun" >
	<div id="pwd_text">
	<div id="buyshop_box">
		<p class="login-alettr" style="border:0;padding-bottom:15px;">管理员:<b><?php if(isset($Operator_Name)){echo $Operator_Name;}else{ echo $operatorLogin['Operator']['name'];}?></b></p>
		 <dl><dt><b class="green_2">旧密码:</b></dt><dd><input class="text_input" type="password" id="old_pwd" /></dd></dl>
		 <dl><dt><b class="green_2">新密码:</b></dt><dd><input class="text_input" type="password" id="new_pwd" /></dd></dl>
		 <dl><dt><b class="green_2">确认密码:</b></dt><dd><input class="text_input" type="password" id="new_pwd_confirm" /></dd></dl>
		 <dl><dt><b class="green_2">时区设置:</b></dt>
		<select style="width:130px;*width:130px;" id="Operator_time_zone">
		<?php foreach( $config_timezone as $k=>$v ){$str = explode(":",$v);?>
			<option value="<?php echo $str[0];?>" <?php if($str[0]==@$_SESSION["Operator_Info"]["Operator"]["time_zone"]){ echo "selected";} ?>><?php echo $str[1];?></option>
		<?php }?>
		</select>
		 <dd></dd></dl>
		 <dl><dt><b class="green_2"></b></dt><dd><span id="pwd_information"></span></dd></dl>

 		<br />
		<p class="buy_btn mar"><?php echo $html->link("关闭","javascript:YAHOO.example.container.message.hide();");?>
		<?php echo $html->link("确定","javascript:;",array("onclick"=>"confirm_password();"));?></p>
	</div></div>
		<div id="pwd_confirm" style="display:none">
		<div id="buyshop_box">
		<p class="login-alettr" style="border:0;padding-bottom:15px;"><b>修改成功!</b></p>
		<br />
		<p class="buy_btn" style="padding-right:170px;"><?php echo $html->link("确定","javascript:YAHOO.example.container.message.hide();");?></p>
		</div></div>
		
	<p><?php echo $html->image("loginout-bottom.png");?></p>
	</div>
</div>	
