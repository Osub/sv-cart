<?php 
/*****************************************************************************
 * SV-Cart 模板
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: default.ctp 3233 2009-07-22 11:41:02Z huangbo $
*****************************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $html->charset(); ?>
<meta name="Author" content="上海实玮网路科技有限公司" />
<meta name="description" content="<?php if(isset($meta_description)){echo $meta_description;} ?>" />
<meta name="keywords" content="<?php if(isset($meta_keywords)){echo $meta_keywords;} ?>" />
<title><?php echo $title_for_layout; ?> - Powered by Seevia</title>
<?php echo $html->meta('icon');
$lang_css = isset($_SESSION['Config']['locale']) ? $_SESSION['Config']['locale']:'chi';
$style_css = (isset($template_style) && $template_style != "")?"style_".$template_style:"style";
$style_js = (isset($template_style) && $template_style != "")?"/".$template_style:"/green";
?>

<script type="text/javascript">
	var style_js = "<?php echo $style_js;?>";
	var wait_message = "<?php echo $SCLanguages['wait_for_operation'];?>";
	var timeout_please_try_again = "<?php echo $SCLanguages['timeout_please_try_again'];?>";
	var page_confirm = "<?php echo $SCLanguages['confirm'];?>";
	var page_cancel = "<?php echo $SCLanguages['cancel'];?>";
	var root_all = "<?php echo $root_all;?>";
	var webroot_dir = "<?php echo $user_webroot;?>";
	var admin_webroot = "<?php echo $admin_webroot;?>";
	var user_webroot = "<?php echo $user_webroot;?>";
	var cart_webroot = "<?php echo $cart_webroot;?>";
	var server_host = "<?php echo $server_host;?>";
	var themePath = "<?php echo $this->themeWeb;?>";
</script>
<?php echo $html->css('layout');?>
<?php echo $minify->css(array($this->themeWeb.'css/layout',$this->themeWeb.'css/component',$this->themeWeb.'css/login',$this->themeWeb.'css/menu',$this->themeWeb.'css/containers',$this->themeWeb.'css/autocomplete',$this->themeWeb.'css/calendar',$this->themeWeb.'css/treeview',$this->themeWeb.'css/container',$this->themeWeb.'css/'.$style_css,$this->themeWeb.'css/'.$lang_css));?>
<?php echo $minify->js(array('/../js/yui/yahoo-dom-event.js','/../js/yui/container_core-min.js','/../js/yui/menu-min.js','/../js/yui/element-beta-min.js','/../js/yui/animation-min.js','/../js/yui/connection-min.js','/../js/yui/container-min.js','/../js/yui/json-min.js','/../js/yui/button-min.js','/../js/yui/calendar-min.js','/../js/yui/yahoo-min.js','/../js/yui/treeview-min.js',$this->themeWeb.'js/regions.js',$this->themeWeb.'js/common.js'));?>


<script type="text/javascript">
//左列菜单
            YAHOO.util.Event.onContentReady("productsandservices", function () {
                var oMenu = new YAHOO.widget.Menu("productsandservices", { 
                                                        position: "static", 
                                                        hidedelay:  750, 
                                                        lazyload: true });
                oMenu.render();
            });
</script>
<script type="text/javascript">

// 这里把JS用到的所有语言都赋值到这里
<?php if(isset($js_languages) && sizeof($js_languages)>0){?>
<?php foreach($js_languages as $k=>$v){?>
var <?php echo $k;?> = "<?php echo $v;?>";
<?php }?>
<?php }?>
//themeWeb
</script>
</head>
		<?php //pr($this);?>
<body class="svcart-skin-g00" id="svcart-com" style="visibility:hidden">
<div id="header">
	<?php if(isset($languages)){?>
	<?php echo $this->element('header', array('cache'=>'+0 hour','languages'=>$languages,'navigations_top'=>(isset($navigations['T']))?$navigations['T']:array()));?>
	<?php }else{?>
	<div id="logo"><?php echo $html->link($html->image('logo.gif',array("alt"=>"SV-Cart")),"/","",false,false);?></div>
	<?php }?>
</div>
<div id="container">
	<div id="content">
		<div id="Left">
		<?php if(isset($languages)){?>
		<?php echo $this->element('menber_menu', array('cache'=>'+0 hour'));?>
		<?php echo $this->element('help', array('cache'=>array('time'=> "+24 hour",'key'=>'help'.$template_style)));?>
		</div>
		<div id="Right"><?php echo $content_for_layout; ?></div>
		<?php }else{?>
		<?php echo $content_for_layout; ?>
		<?php }?>		
	</div>
</div>
<?php if(isset($languages)){?>
<div id="footer"><?php echo $this->element('footer', array('cache'=>'+0 hour'));?></div>
<?php echo $this->element('dragl', array('cache'=>'+0 hour'));?>
<?php }?>
<?php echo $cakeDebug; ?>
	
<!--对话框-->

<div id="layer_dialog"  style="display:none;background:#fff;">
<input type="hidden" value="" id="img_src_text_number"/>
<input type="hidden" value="" id="assign_dir"/>
<div id="loginout" >
	<h1><b></b></h1>
	<div id="buyshop_box">
		<p class="login-alettr">
		<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."msg.gif":"msg.gif",array('class'=>'sub_icon vmiddle'));?>
		<b>
		<span id="dialog_content"></span>
		</b>
		</p>
		<br /><input type="hidden" id="confirm"/>

		<p class="buy_btn mar" ><span id="button_replace">
		<a href='javascript:layer_dialog_obj.hide();'><?php echo $SCLanguages['cancel']?></a>
		<a href='javascript:confirm_record();'><?php echo $SCLanguages['confirm']?></a>
		</span></p>
	</div>
	<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."loginout-bottom.gif":"loginout-bottom.gif");?></p>
</div>
</div>
<!--End 对话框-->		
<!-- gears对话框 -->
<div id="layer_gears"  style="display:none;background:#fff;">
<div id="loginout" >
	<h1><b><?=$SCLanguages['google_gears']?></b></h1>
	<div id="buyshop_box">
		<p class="login-alettr">
		<b>
		<span id="dialog_content">
			<font id="no_gears" style="display:none;">
			<?=$SCLanguages['not_yet_been_installed']?><?=$SCLanguages['google_gears']?>
			</font>
			<font id="error_gears" style="display:none;">
			<?=$SCLanguages['google_gears']?><?=$SCLanguages['run_error_may_reinstall']?>
			</font>		
			<font id="msg_gears" style="display:none;">
			<?=$SCLanguages['speed_up_for_website']?><?=$SCLanguages['successfully']?>
			</font>					
		</span>
		</b>
		</p>
		<br />
			
		<p class="buy_btn mar" ><span id="button_replace">
		<font id="no_gears_a" style="display:none;">
		<a class="cursor"  onclick="window.location = 'http://gears.google.com/?action=install';" ><?=$SCLanguages['install_now']?> <?=$SCLanguages['google_gears']?></a>
		</font>
		<font id="error_gears_a" style="display:none;">
		<a class="cursor" onclick="window.location = 'http://gears.google.com/?action=install';"><?=$SCLanguages['reinstall']?> <?=$SCLanguages['google_gears']?></a>
		</font>
		<a href='javascript:layer_gears_obj.hide();'><?php echo $SCLanguages['cancel']?></a>
		</span></p>
	</div>
	<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."loginout-bottom.gif":"loginout-bottom.gif");?></p>
</div>
</div>
<!--End gears对话框-->	
</body>
</html>