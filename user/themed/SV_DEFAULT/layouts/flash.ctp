<?php 
/*****************************************************************************
 * SV-Cart flash模板
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: flash.ctp 3099 2009-07-20 08:27:54Z huangbo $
*****************************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $html->charset(); ?>
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
	var root_all = "<?php echo $root_all;?>";
	var webroot_dir = "<?php echo $user_webroot;?>";
	var admin_webroot = "<?php echo $admin_webroot;?>";
	var user_webroot = "<?php echo $user_webroot;?>";
	var cart_webroot = "<?php echo $cart_webroot;?>";
	var server_host = "<?php echo $server_host;?>";
	var themePath = "<?php echo $this->themeWeb;?>";
</script>
<?php echo $minify->css(array($this->themeWeb.'css/layout',$this->themeWeb.'css/component',$this->themeWeb.'css/login',$this->themeWeb.'css/menu',$this->themeWeb.'css/containers',$this->themeWeb.'css/autocomplete',$this->themeWeb.'css/calendar',$this->themeWeb.'css/treeview',$this->themeWeb.'css/container',$this->themeWeb.'css/'.$style_css,$this->themeWeb.'css/'.$lang_css));?>
<?php echo $minify->js(array('/../js/yui/yahoo-dom-event.js','/../js/yui/container_core-min.js','/../js/yui/menu-min.js','/../js/yui/element-beta-min.js','/../js/yui/animation-min.js','/../js/yui/connection-min.js','/../js/yui/container-min.js','/../js/yui/json-min.js','/../js/yui/button-min.js','/../js/yui/calendar-min.js',$this->themeWeb.'js/regions.js',$this->themeWeb.'js/common.js'));?>

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
</head>
<body class="svcart-skin-g00" id="svcart-com">
<div id="header">
	<?php if(isset($SVConfigs['shop_temporal_closed']) && $SVConfigs['shop_temporal_closed'] == 1){?>
	<div id="logo"><?php echo $html->link($html->image('logo.gif',array("alt"=>"SV-Cart")),"/","",false,false);?></div>
	<?php }else{?>
	<?php echo $this->element('header', array('cache'=>'+0 hour','languages'=>$languages,'navigations_top'=>(isset($navigations['T']))?$navigations['T']:array()));?>
	<?php }?>
</div>

<div id="container">
<div class="contents">
<div id="ur_here"><?php echo $SCLanguages['current_location_system_remind']?></div>
<!--Main Start-->
<div class="home_main">
	<div class="informations">
	<br /><br /><Br /><br /><Br /><br />
	<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'msg.gif':'msg.gif',array('align'=>'middle'))?> &nbsp;&nbsp;<strong>
	<?php //pr($_SESSION['cart_back_url']);?>
	<?php if(isset($back_url)){?>
	<?php echo $html->link($message,$back_url,array(),false,false);?>		
	<?php }else if(isset($_SESSION['cart_back_url'])){?>
	<?php echo $html->link($message,$_SESSION['cart_back_url'],array(),false,false);?>		
	<?php }else{?>
	<?php echo $html->link($message,$url,array(),false,false);?>		
	<?php }?>
	</strong></p>
	<br /><br /><Br /><br /><Br /><br /><Br /><br />
	<p class="handdle"><span>
	<?php if(isset($back_url)){?>
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['previous'].$SCLanguages['page'],$back_url,array(),false,false);?>		
	<?php }else if(isset($_SESSION['cart_back_url'])){?>
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['previous'].$SCLanguages['page'],$_SESSION['cart_back_url'],array(),false,false);?>		
	<?php unset($_SESSION['cart_back_url']);?>
	<?php }else{?>
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['previous'].$SCLanguages['page'],$url,array(),false,false);?>		
	<?php }?>
	</span>|<span><?php echo $html->link($SCLanguages['return'].$SCLanguages['user_center'], '/')?></span></p>
	<br /><Br /><br /><Br /><br /><Br /><br />
	</div>
</div>
<!--Main Start End-->
</div>
<div id="footer"><?php echo $this->element('footer', array('cache'=>'+0 hour'));?></div>
<?php echo $this->element('dragl', array('cache'=>'+0 hour'));?>
</body>
</html>