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
 * $Id: header.ctp 5328 2009-10-22 08:06:54Z huangbo $
*****************************************************************************/
?><?=$javascript->link('gears_init'); ?>
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
	<div class="logo"><?php echo $html->link($html->image('logo.gif'),"/",array("target"=>"_blank"),false,false);?></div>
	<div class="toolsbar">
	<p>
	<span><b><a href="" title='<?php echo "您上一次登录时间:";if(isset($Operator_Longin_Date)){ echo $Operator_Longin_Date;}else{echo $operatorLogin["Operator"]["last_login_time"];} echo "您的IP地址："; if(isset($Operator_Ip)){ echo $Operator_Ip;}else{ echo $operatorLogin["Operator"]["last_login_ip"];} if(isset($_SESSION["Admin_Locale_Name"]))echo $_SESSION["Admin_Locale_Name"];?>' alt='<?php echo "您上一次登录时间:";if(isset($Operator_Longin_Date)){ echo $Operator_Longin_Date;}else{echo $operatorLogin["Operator"]["last_login_time"];} echo "您的IP地址："; if(isset($Operator_Ip)){ echo $Operator_Ip;}else{ echo $operatorLogin["Operator"]["last_login_ip"];} if(isset($_SESSION["Admin_Locale_Name"]))echo $_SESSION["Admin_Locale_Name"];?>'><?php if(isset($Operator_Name)){echo $Operator_Name;}else{ echo $operatorLogin['Operator']['name'];} ?></a></b></span>
	
	<span><?php echo $html->link("账户设置","javascript:;",array("onclick"=>"account_settings()"),false,false);?></span> |
	<span><?php echo $html->link("在线帮助","javascript:;",array("onclick"=>"online_help_div()"),false,false);?></span>  |
	<span><?php echo $html->link("插件搜索","javascript:;",array("onclick"=>"plugin_search()"),false,false);?></span>  |
	<?php  if(isset($g_languages) && $g_languages_count > 1){?>
	<span><?php echo $html->link("Google翻译","javascript:;",array("onclick"=>"google_shortcut()"),false,false);?></span> |
	<?php }?>
	<span><?php echo $html->link("清除缓存","javascript:;",array("onclick"=>"clear_cache_bt()"),false,false);?></span> |
	<span><?php echo $html->link($html->image('icon01.gif',array('align'=>'absmiddle','style'=>"margin:-2px 2px 0 0;*margin:0 2px 0 0;")).'退出',"/log_out",'',false,false)?></span>
	</p>
	<p>
	<span><strong><?php echo $html->link("浏览商店",$server_host.$cart_webroot,array("target"=>"_blank"),false,false);?></strong></span> |
	<span><?php echo $html->link("管理首页","/",'',false,false);?></span> |
	<span><?php echo $html->link("上海实玮官网","http://www.seevia.cn",array("target"=>"_blank","class"=>"green_3"),false,false);?></span> |
	<span><?php echo $html->link("SV-Cart社区","http://www.sv-cart.org/bbs",array("target"=>"_blank","class"=>"green_3"),false,false);?></span> |
	<span><?php echo $html->link("关于SV-Cart","javascript:sys_about();",array("class"=>"green_3"),false,false);?></span>
	<span><?php echo $html->link("帮助","http://wiki.seevia.cn",array("target"=>"_blank","class"=>"green_3"),false,false);?></span> |
	<span><?php echo $html->link("向导","/guides/",array("target"=>"_blank","class"=>"green_3"),false,false);?></span>
	</p>
	</div>
	</div>

<!--menu start-->
<div id="topmenu" class="svcarmenubar svcartmenubarnav">
<div class="bd menu_bg">
	<ul class="first-of-type main_nav">
    <li class="home"><?php echo $html->link($html->image('home.gif'),"/",'',false,false);?></li>
<?php if(isset($Operator_menu)&& sizeof($Operator_menu)>0){foreach($Operator_menu as $key=>$v){$id="id=\"Operator_menu_$key\"";?>
<li class="svcartmenubaritem first-of-type" <?php if($key==0){?>style="border-left:1px solid #CCCCCC"<?php }?>><?php if(isset($v['Operator_menu'])&& !empty($v['Operator_menu'])){?><a class="svcartmenubaritemlabel"><?php echo $v['Operator_menu']['name']?></a><?php }?>
	<div <?php echo $id;?> class="svcartmenu"><?php if(isset($v['SubMenu'])&&  !empty($v['SubMenu'])){?>
		<div class="bd">
			<ul>
			<?php if(isset($v['SubMenu']) && sizeof($v['SubMenu'])>0){foreach($v['SubMenu'] as $k=>$val){?><li class="svcartmenuitem"><?php echo $html->link("{$val['Operator_menu']['name']}","{$val['Operator_menu']['link']}",array("class"=>"svcartmenuitemlabel"),false,false);?></li>
			<?php }}?></ul>
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
</div>
</div>
</div>
</div>
</div>
</div>



<?if(isset($SVConfigs['admin_gears_setting']) && $SVConfigs['admin_gears_setting'] == 1){?>
		<script type="text/javascript">
			function show_gears() {
			  if (!window.google || !google.gears) {
			    return;
			  }

			  try {
			    localServer =
			        google.gears.factory.create('beta.localserver');
			  } catch (ex) {
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
	show_gears();
</script>
<?}?>