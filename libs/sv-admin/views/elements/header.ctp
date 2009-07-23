<?php 
/*****************************************************************************
 * SV-Cart 头部
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: header.ctp 3268 2009-07-23 06:02:01Z huangbo $
*****************************************************************************/
?><?=$javascript->link('gears_init');?>
<script>
var STORE_NAME = 'SV_Cart_Store_Admin'
var localServer;
//location.pathname
var filesToCapture = [
  <?if(isset($gears_file) && sizeof($gears_file)>0){?><?foreach($gears_file as $k=>$v){?>"<? echo $v;?>"<?if((sizeof($gears_file)-1) != $k){?>,<?}?><?}?><?}?>
];
</script>
<div id="header">
	<div class="tools">
	<div class="logo"><?php echo $html->image('logo.gif')?></div>
	<div class="toolsbar">
	<p>
	<span><b><?php if(isset($Operator_Name)){echo $Operator_Name;}else{ echo $operatorLogin['Operator']['name'];}?></b></span>
	<span class="green_3">您上一次登录时间: <font style="font-size:11px;"><?php if(isset($Operator_Longin_Date)){ echo $Operator_Longin_Date;}else{echo $operatorLogin['Operator']['last_login_time'];}?></font></span>
	<span class="green_3">您的IP地址：<font style="font-size:11px;"><?php if(isset($Operator_Ip)){ echo $Operator_Ip;}else{ echo $operatorLogin['Operator']['last_login_ip'];}?></font></span>
	<span><?php echo $html->link("修改登录密码","javascript:;",array("onclick"=>"amend_password()"),false,false);?></span> |
	<span><?php echo $html->link($html->image('icon01.gif',array('align'=>'absmiddle','style'=>"margin:-2px 2px 0 0;*margin:0 2px 0 0;")).'退出',"/log_out",'',false,false)?></span>
	</p>
	<p>
	<span><?php echo $html->link("网店首页",$server_host.$cart_webroot,array("target"=>"_blank"),false,false);?></span> |
	<span><?php echo $html->link("管理首页","/",'',false,false);?></span> |
	<span><?php echo $html->link("SV-Cart官网","http://www.seevia.cn",array("target"=>"_blank"),false,false);?></span> |
	<span><?php echo $html->link("SV-Cart社区","http://www.sv-cart.org/bbs",array("target"=>"_blank"),false,false);?></span>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php  if(isset($g_languages) && $g_languages_count > 1){?>
	<span><?php echo $html->link("Google翻译","javascript:;",array("onclick"=>"google_shortcut()"),false,false);?></span> |
	<?php }?>
	<span><?php echo $html->link("清除缓存","javascript:;",array("onclick"=>"clear_cache_bt()"),false,false);?></span> 
	<span style="display:none;"><?php echo $html->link("gears","javascript:;",array("onclick"=>"show_gears()"),false,false);?></span>
	</p>
	</div>
	</div>
		<?if(isset($SVConfigs['admin_gears_setting']) && $SVConfigs['admin_gears_setting'] == 1){?>
		<script type="text/javascript">show_gears();
function show_gears() {
  if (!window.google || !google.gears) {
 //   document.getElementById("no_gears").style.display = "";
  //  document.getElementById("no_gears_a").style.display = "";
    return;
  }

  try {
    localServer =
        google.gears.factory.create('beta.localserver');
  } catch (ex) {
 // 	alert("Could not create local server");
  //  document.getElementById("error_gears").style.display = "";
	//       document.getElementById("error_gears_a").style.display = "";
    return;
  }
  
  createStore();
}
	function createStore() {
	  if (!checkProtocol()) {
	  	alert("must be hosted on an HTTP server");
	  	return;
	  }
	  // If the store already exists, it will be opened
	  try {
	    localServer.createStore(STORE_NAME);
	    capture();
	  } catch (ex) {
	    //alert('Could not create store');
	     //  document.getElementById("error_gears").style.display = "";
	    //   document.getElementById("error_gears_a").style.display = "";
	  }
	}
	function checkProtocol() {
	  if (location.protocol.indexOf('http') != 0) {
	    //setError('This sample must be hosted on an HTTP server');
	    return false;
	  } else {
	    return true;
	  }
	}
	function capture() {
	  var store = localServer.openStore(STORE_NAME);
	  if (!store) {
	    //alert('Please create a store for the captured resources');
//	    document.getElementById("error_gears").style.display = "";
//	    document.getElementById("error_gears_a").style.display = "";
	    return;
	  }
	  // Capture this page and the js library we need to run offline.
//	    document.getElementById("msg_gears").style.display = "";
//	  document.getElementById("success_gears").style.display = "";
	  store.capture(filesToCapture, captureCallback);
	  
	}
	function captureCallback(url, success, captureId) {
	  //alert(url + ' captured ' + (success ? 'succeeded' : 'failed'));
	}	
			</script>
		<?}?><!--menu start-->
<div id="topmenu" class="svcarmenubar svcartmenubarnav">
<div class="bd menu_bg">
	<ul class="first-of-type main_nav">
	<?php 
//	$Operator_menu=$this->requestAction("commons/operator_menus/");
	if(isset($Operator_menu)&& sizeof($Operator_menu)>0){
				 foreach($Operator_menu as $key=>$v){
				 $id="id=\"Operator_menu_$key\"";
				  ?>
<li class="svcartmenubaritem first-of-type">
    <?php if(isset($v['Operator_menu'])&& !empty($v['Operator_menu'])){?>
	<a class="svcartmenubaritemlabel"><?php echo $v['Operator_menu']['name']?></a>
	<?php //echo $html->link("{$v['Operator_menu']['name']}","",array("class"=>"svcartmenubaritemlabel"),false,false);?>
	<?php }?>
	<div <?php echo $id;?> class="svcartmenu">
         <?php if(isset($v['SubMenu'])&&  !empty($v['SubMenu'])){?>
          <div class="bd">
             <ul>
        <?php if(isset($v['SubMenu']) && sizeof($v['SubMenu'])>0){?>
        <?php foreach($v['SubMenu'] as $k=>$val){?>
        <li class="svcartmenuitem">
        <?php echo $html->link("{$val['Operator_menu']['name']}","{$val['Operator_menu']['link']}",array("class"=>"svcartmenuitemlabel"),false,false);?> 

        </li>
         <?php }?>
         <?php }?>
      </ul>
      </div>
         <p style='margin-top:0;'><?php echo $html->image('menu_bottom.gif')?></p>
     <?php }?>
         
     </div>
	</li>
<?php }}?>
	</ul>
</div>
</div>
<!--menu End-->

</div>
<!--对话框-->
<div id="amend_password" style="display:none">	
<div id="loginout" >
	<h1><b>修改当前管理员密码</b></h1>
	
	<div class="order_stat athe_infos tongxun" >
	<div id="pwd_text">
	<div id="buyshop_box">
		<p class="login-alettr" style="border:0;padding-bottom:15px;">管理员:<b><?php if(isset($Operator_Name)){echo $Operator_Name;}else{ echo $operatorLogin['Operator']['name'];}?></b></p>
		 <dl><dt><b class="green_2">旧密码:</b></dt><dd><input class="text_input" type="password" id="old_pwd" /></dd></dl>
		 <dl><dt><b class="green_2">新密码:</b></dt><dd><input class="text_input" type="password" id="new_pwd" /></dd></dl>
		 <dl><dt><b class="green_2">确认密码:</b></dt><dd><input class="text_input" type="password" id="new_pwd_confirm" /></dd></dl>
		 <dl><dt><b class="green_2"></b></dt><dd><span id="pwd_information"></span></dd></dl>

 		<br />
		<p class="buy_btn mar"><?php echo $html->link("关闭","javascript:password_big_panel.hide();");?>
		<?php echo $html->link("确定","javascript:;",array("onclick"=>"confirm_password();"));?></p>
	</div></div>
		<div id="pwd_confirm" style="display:none">
		<div id="buyshop_box">
		<p class="login-alettr" style="border:0;padding-bottom:15px;"><b>密码修改成功!</b></p>
		<br />
		<p class="buy_btn" style="padding-right:170px;"><?php echo $html->link("确定","javascript:password_big_panel.hide();");?></p>
		</div></div>
		
	<p><?php echo $html->image("loginout-bottom.png");?></p>
	</div>
</div>	
</div>
		
<!--Google快捷窗口-->
<div id="google_shortcut" style="display:none">	
<div id="loginout" class="google_shortcut">
	<h1><b>google翻译快捷窗口</b><?php echo $html->link(" ","javascript:google_big_panel.hide();",array("class"=>"close"));?></h1>
	
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
</div>
		
<!--清除缓存对话框-->
<div id="clear_cache_div" style="display:none">	
<div id="loginout" >
	<h1><b>清除缓存</b></h1>
	
	<div class="order_stat athe_infos tongxun" >
	<div id="cc_text">
	<div id="buyshop_box">
		
		<p class="login-alettr" style="border:0;padding-bottom:15px;">请选择要清除缓存的模块:</p>
		<dl><dt><b class="green_2"><input type="checkbox" name="app_chkall" id="app_chkall" value="checkbox" onclick="app_checkAll();" checked/></b></dt><dd>全选</dd></dl>
		<?php foreach($app_model as $k=>$v){?>
		 <dl><dt><b class="green_2"><input type='checkbox' name="app_checkbox" value="<?php echo $v['dir_name'];?>" checked onclick="check_checked();"/></b></dt><dd><?php echo $v['name'];?></dd></dl>
		<?php }?>
 		<br />
		<p class="buy_btn mar"><?php echo $html->link("关闭","javascript:cc_big_panel.hide();");?>
		<?php echo $html->link("确定","javascript:;",array("onclick"=>"clear_cache();"));?></p>
		
		</div>
	</div>
		<div id="cc_confirm" style="display:none">
		<div id="buyshop_box">
		<p class="login-alettr" style="border:0;padding-bottom:15px;"><b id='clear_cache_msg'>缓存清除成功</b></p>
		<br />
		<p class="buy_btn" style="padding-right:170px;"><?php echo $html->link("确定","javascript:cc_big_panel.hide();");?></p>
		</div></div>
		
	<p><?php echo $html->image("loginout-bottom.png");?></p>
	</div>
</div>	
</div>
<!-- gears对话框 -->
<div id="layer_gears"  style="display:none;background:#fff;">
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
		<a class="cursor"  onclick="window.location = 'http://gears.google.com/?action=install';" >安装gears</a>		<a href='javascript:layer_gears_obj.hide();'>取消</a>

		</font>
		<font id="error_gears_a" style="display:none;">
		<a class="cursor" onclick="window.location = 'http://gears.google.com/?action=install';">安装gears</a>		<a href='javascript:layer_gears_obj.hide();'>取消</a>

		</font>
			
		</span></p>
		<font id="success_gears" style="display:none;">
		<p class="buy_btn" style="padding-right:170px;"><?php echo $html->link("关闭","javascript:layer_gears_obj.hide();");?></p>
		</font>
	</div>
</div>
</div>
<!--End gears对话框-->	
<script type="text/javascript">
	//修改密码确认
	function confirm_password(){
		var old_pwd = document.getElementById('old_pwd');
		var new_pwd = document.getElementById('new_pwd');
		var new_pwd_confirm = document.getElementById('new_pwd_confirm');
		
		var pwd_information = document.getElementById('pwd_information');
		if(new_pwd.value!=new_pwd_confirm.value&&new_pwd_confirm.value!=""){
			pwd_information.innerHTML = "两次密码输入不一样";
			return false;
		}else{
			pwd_information.innerHTML = "";
		}
		if(old_pwd.value!=""&&new_pwd.value==""){
			pwd_information.innerHTML = "新密码不能为空";
			return false;
		}
		if(old_pwd.value!=""&&new_pwd_confirm.value==""){
			pwd_information.innerHTML = "新密码不能为空";
			return false;
		}
		
		var sUrl = webroot_dir+"operators/ajax_amend_now_pwd/"+old_pwd.value+"/"+new_pwd.value;
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, confirm_password_callback);
		

	}

	var confirm_password_Success = function(o){
		var new_pwd = document.getElementById('new_pwd');
		var new_pwd_confirm = document.getElementById('new_pwd_confirm');
		var pwd_information = document.getElementById('pwd_information');
		var old_pwd = document.getElementById('old_pwd');
		if(o.responseText==0){
			old_pwd.value="";
			new_pwd.value="";
			new_pwd_confirm.value="";
			pwd_information.innerHTML = "密码输入错误!"
			
		}else{
			pwd_information.innerHTML = "";
			old_pwd.value="";
			new_pwd.value="";
			new_pwd_confirm.value="";
			document.getElementById('pwd_confirm').style.display = "block";
			document.getElementById('pwd_text').style.display = "none";
		}
	}
	
	var confirm_password_Failure = function(o){
		//alert("error");
	}

	var confirm_password_callback ={
		success:confirm_password_Success,
		failure:confirm_password_Failure,
		timeout : 10000,
		argument: {}
	};
	//修改密码对话框
	function amend_password(){
		document.getElementById('amend_password').style.display = "block";
		document.getElementById('pwd_text').style.display = "block";
		document.getElementById('pwd_confirm').style.display = "none";
		password_big_panel.show();
	}

	//遮罩层JS
	function initPage_password(){
		tabView = new YAHOO.widget.TabView('contextPane'); 
        password_big_panel = new YAHOO.widget.Panel("amend_password", 
							{
								visible:false,
								draggable:false,
								modal:true,
								style:"margin 0 auto",
								fixedcenter: true
							} 
						); 
		password_big_panel.render();
		
	}
	initPage_password();
	
	
	//google翻译遮罩层JS
	function initPage_g_translate(){
		tabView = new YAHOO.widget.TabView('contextPanel'); 
        google_big_panel = new YAHOO.widget.Panel("google_shortcut", 
							{
								visible:false,
								draggable:false,
								modal:true,
								style:"margin 0 auto",
								fixedcenter: true
							} 
						); 
		google_big_panel.render();
	}
	initPage_g_translate();
	
	//google快捷窗口
	function google_shortcut(){
		document.getElementById('google_shortcut').style.display = "block";
		document.getElementById('google_text').style.display = "block";
		document.getElementById('pwd_confirm').style.display = "none";
		google_big_panel.show();
   }
   
   //实现google接口翻译功能
   	function g_trans(){
	
	    var original_text = document.getElementById('original_text').value;
   	    var lang_obj = document.getElementById("g_language");
 	 //   var lang_value = lang_obj.options[lang_obj.selectedIndex].value;
 	 //   var g_translation = document.getElementById('g_translation');
 	    var google_translate_information = document.getElementById('google_translate_information');
 	    
 	    
 	    if(original_text.length <= 0){
	   		google_translate_information.innerHTML = "请填写原文";
	   		return false;
	   }else{
	   		google_translate_information.innerHTML = "";
	   }
	   var i=0;
	   while(true){
			if(document.getElementById('g_trans'+i) == null){
				break;
			}
			var lang_value = document.getElementById('g_trans'+i).name;
			var g_translation = document.getElementById('g_trans'+i);
			var sUrl = webroot_dir+"pages/g_translate/"+lang_value+"/"+original_text+"/"+i;
			var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, g_trans_callback);
			i++;
 		}
	}
	
	var g_trans_Success = function(o){
		var result = o.responseText;
		result = result.split("|");
		var g_trans = document.getElementById('g_trans'+result[1]);
		g_trans.value = result[0];
		//try{
		//	var result = YAHOO.lang.JSON.parse(o.responseText); 
	/*	}catch (e){
			alert("e="+e);
			alert(o.responseText);
			alert("Invalid data");
		}*/
	//	alert("result="+o.responseText);
	}
	
	var g_trans_Failure = function(o){
		alert("error:"+o.statusText);
	}
	
	var g_trans_callback ={
		success:g_trans_Success,
		failure:g_trans_Failure,
		timeout : 10000,
		argument: {}
	};
	
	//清除缓存
	function clear_cache_bt(){
		document.getElementById('clear_cache_div').style.display = "block";
		document.getElementById('cc_text').style.display = "block";
		document.getElementById('cc_confirm').style.display = "none";
		cc_big_panel.show();
	}

	//遮罩层JS
	function initPage_cc(){
		tabView = new YAHOO.widget.TabView('contextPane'); 
        cc_big_panel = new YAHOO.widget.Panel("clear_cache_div", 
							{
								visible:false,
								draggable:false,
								modal:true,
								style:"margin 0 auto",
								fixedcenter: true
							} 
						); 
		cc_big_panel.render();
		
	}
	initPage_cc();
	function clear_cache(){
	    var app_checkbox = document.getElementsByName('app_checkbox');
	    if(app_checkbox.length > 0){
	    	var sPost = Array();
	    	var j = 0;
			for(var i=0;i<app_checkbox.length;i++){
				if(app_checkbox[i].checked === true){
					sPost[j] = app_checkbox[j].value;
					j++;
				}
			}
			if(sPost.length>0){
		    	var sUrl = webroot_dir+"pages/clear_cache";
		   		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, clear_cache_callback, 'dir_name='+sPost.join(','));
	    	}
	    }
	    
	}

	var clear_cache_Success = function(oResponse){
		document.getElementById('clear_cache_msg').innerHTML = '共清除缓存文件:'+oResponse.responseText+'个';
		document.getElementById('cc_confirm').style.display = "block";
		document.getElementById('cc_text').style.display = "none";
	}
	var clear_cache_Failure = function(o){
		alert("error");
	}
	var clear_cache_callback ={
		success:clear_cache_Success,
		failure:clear_cache_Failure,
		timeout : 100000,
		argument: {}
	};
	function app_checkAll(){
		var app_checkbox = document.getElementsByName('app_checkbox');
		if(document.getElementById('app_chkall').checked == true){
			for(var i=0;i<app_checkbox.length;i++){
				app_checkbox[i].checked = true;
			}
		}
		else{
			for(var i=0;i<app_checkbox.length;i++){
				app_checkbox[i].checked = false;
			}
		}
	}
	function check_checked(){
		var app_checkbox = document.getElementsByName('app_checkbox');
		for(var i=0;i<app_checkbox.length;i++){
			if(app_checkbox[i].checked == false){
				document.getElementById('app_chkall').checked = false;
				return ;
			}
				
		}
		document.getElementById('app_chkall').checked = true;
	}
	function show_gears(){
   //	 	document.getElementById("no_gears").style.display = "none";
  	//  	document.getElementById("no_gears_a").style.display = "none";
    //	document.getElementById("error_gears").style.display = "none";
//	    document.getElementById("error_gears_a").style.display = "none";		
//	    document.getElementById("msg_gears").style.display = "none";		
		
		gears_init();
//		layer_gears();
//		document.getElementById('layer_gears').style.display = "block";
//		layer_gears_obj.show();
	}
	function layer_gears_hide(){
	//	document.getElementById('layer_gears').style.display = "none";
	}	
	
	function layer_gears(){
	//	tabView = new YAHOO.widget.TabView('contextPane'); 
        layer_gears_obj = new YAHOO.widget.Panel("layer_gears", 
							{
								visible:false,
								draggable:false,
								modal:true,
								style:"margin 0 auto",
								fixedcenter: true
							} 
						); 
		layer_gears_obj.render();
	}	

	
	
</script>