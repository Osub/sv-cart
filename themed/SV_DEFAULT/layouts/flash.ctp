<?php 
/*****************************************************************************
 * SV-Cart flash
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: flash.ctp 2761 2009-07-10 09:06:59Z shenyunfeng $
*****************************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $html->charset(); ?> 
<meta name="Author" content="上海实玮网络科技有限公司" />
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
	var timeout_please_try_again = "<?php echo $SCLanguages['timeout_please_try_again'];?>";
	var root_all = "<?php echo $root_all;?>";
	var webroot_dir = "<?php echo $cart_webroot;?>";
	var admin_webroot = "<?php echo $admin_webroot;?>";
	var user_webroot = "<?php echo $user_webroot;?>";
	var cart_webroot = "<?php echo $cart_webroot;?>";
	var server_host = "<?php echo $server_host;?>";
	var themePath = "<?php echo $this->themeWeb;?>";
// 这里把JS用到的所有语言都赋值到这里
<?php if(isset($js_languages) && sizeof($js_languages)>0){?>
<?php foreach($js_languages as $k=>$v){?>
var <?php echo $k;?> = "<?php echo $v;?>";
<?php }?>
<?php }?>
<?php if(isset($search_autocomplete_image) && sizeof($search_autocomplete_image)>0){?>
<?php foreach($search_autocomplete_image as $k=>$v){?>
var <?php echo $k;?> = "<?php echo $v;?>";
<?php }?>
<?php }?>
</script>
<?php echo $minify->css(array($this->themeWeb.'css/layout',$this->themeWeb.'css/component',$this->themeWeb.'css/login',$this->themeWeb.'css/menu',$this->themeWeb.'css/containers',$this->themeWeb.'css/autocomplete',$this->themeWeb.'css/'.$style_css,$this->themeWeb.'css/'.$lang_css));?>
<?php echo $minify->js(array('/js/yui/yahoo-dom-event.js','/js/yui/container_core-min.js','/js/yui/menu-min.js','/js/yui/element-beta-min.js','/js/yui/animation-min.js','/js/yui/connection-min.js','/js/yui/container-min.js','/js/yui/json-min.js',$this->themeWeb.'js/common.js','/js/swfobject.js'));?>
</head>
<body class="svcart-skin-g00" id="svcart-com">
<?php echo $this->element('dragl', array('cache'=>'+0 hour'));?>
<div id="header">
	<?php if(isset($SVConfigs['shop_temporal_closed']) && $SVConfigs['shop_temporal_closed'] == 1){?>
	<div id="logo"><?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'logo.gif':'logo.gif',array("alt"=>"SV-Cart")),"/","",false,false);?></div>
	<?php }else{?>
	<?php echo $this->element('header', array('cache'=>'+0 hour','languages'=>$languages,'navigations_top'=>(isset($navigations['T']))?$navigations['T']:array()));?>
	<?php }?>
</div>
<div id="container">
<div class="contents">
<div id="ur_here"><?php echo $SCLanguages['current_location_system_remind']?></div>
<p class="height_5"></p>
<!--Main Start-->
<div class="home_main">
	<div class="informations">
	<br /><br /><Br /><br /><Br /><br />
	<?php if(isset($shop_logo) && $shop_logo != ""){?>
	<?php echo $html->image($shop_logo,array('align'=>'middle'))?>
	<?php }?>
	<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'msg.gif':'msg.gif',array('align'=>'middle'))?> &nbsp;&nbsp;<strong>
		<?php echo $html->link($message,$url,array(),false,false);?>			
			</strong></p>
	<?php if(isset($closed_reason)){?>
	<p>网站关闭原因: &nbsp;&nbsp;<strong>
		<?php echo $html->link($closed_reason,$url,array(),false,false);?>					
		</strong></p>
	<?php }?>
	
	<br /><br /><Br /><br /><Br /><br /><Br /><br />
	<p class="handdle"><span>
		<?php if(isset($SVConfigs['shop_temporal_closed']) && $SVConfigs['shop_temporal_closed'] != 1){?>
		<?php echo $html->link($SCLanguages['return'].$SCLanguages['previous'].$SCLanguages['page'],$url,array(),false,false);?>					
		<?php }?>	
	</span></p>
	<br /><Br /><br /><Br /><br /><Br /><br />
	</div>

</div>
<!--Main Start End-->
</div>
<div id="footer"><?php echo $this->element('footer', array('cache'=>'+0 hour'));?></div>
</body>
</html>