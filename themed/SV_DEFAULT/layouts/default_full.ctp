<?php 
/*****************************************************************************
 * SV-Cart 模板
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: default_full.ctp 4808 2009-10-09 10:05:22Z huangbo $
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
	var use_captcha = "<?php echo $this->data['configs']['use_captcha'];?>";
	var verify_code = "<?php echo $SCLanguages['verify_code'];?>";
	var not_clear = "<?php echo $SCLanguages['not_clear'];?>";	
	var time_out_relogin_js = "<?php echo $SCLanguages['time_out_relogin'];?>";
	var style_js = "<?php echo $style_js;?>";
	var wait_message = "<?php echo $SCLanguages['wait_for_operation'];?>";
	var timeout_please_try_again = "<?php echo $SCLanguages['timeout_please_try_again'];?>";
	var page_confirm = "<?php echo $SCLanguages['confirm'];?>";
	var root_all = "<?php echo $root_all;?>";
	var webroot_dir = "<?php echo $cart_webroot;?>";
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
<body class="svcart-skin-g00" id="svcart-com" style="visibility:hidden">
<?php echo $this->element('dragl', array('cache'=>'+0 hour'));?>
<div id="header">
	<?php echo $this->element('header', array('cache'=>'+0 hour','languages'=>(isset($languages))?$languages:array(),'navigations_top'=>(isset($navigations['T']))?$navigations['T']:array()));?>
</div>
<div id="container">
	<?php echo $content_for_layout; ?>
</div>
<div id="footer">
	<?php echo $this->element('footer', array('cache'=>'+0 hour','categories_tree'=>(isset($categories_tree))?$categories_tree:array(),'brands'=>(isset($brands))?$brands:array(),'navigations_footer'=>(isset($navigations['F']))?$navigations['F']:array(),'navigations_footer'=>(isset($navigations['B']))?$navigations['B']:array()));?>
</div>
<?php echo $cakeDebug; ?>
	
<!--对话框-->
<input type="hidden" value="" id="img_src_text_number" />
<input type="hidden" value="" id="assign_dir" />
<div id="layer_dialog"  style="display:none;">
<div class="loginout">
	<h1 class="hd"><b>&nbsp;</b></h1>
	<div id="buyshop_box" style="background:#ffffff;">
		<p class="login-alettr">
		<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."msg.gif":"msg.gif",array('class'=>'sub_icon'));?>
		<b>
		<span id="dialog_content"></span>
		</b>
		</p>
		<br /><input type="hidden" id="confirm" />

		<p class="buy_btn mar" ><span id="button_replace">
		<a href='javascript:layer_dialog_obj.hide();'><?php echo $SCLanguages['cancel']?></a>
		<a href='javascript:confirm_record();'><?php echo $SCLanguages['confirm']?></a>
		</span></p>
	</div>
	<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."loginout-bottom.gif":"loginout-bottom.gif");?></p>
</div>
</div>
<!--End 对话框-->			
<!--订单查询对话框-->
<div id="search_order" style="display:none;">
<div class="loginout" >
	<h1><b><?=$SCLanguages['order']?><?=$SCLanguages['search']?></b></h1>
		<?php echo $this->element('order', array('cache'=>array('time'=> "+0 hour",'key'=>'order'.$template_style)));?>
	<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."loginout-bottom.gif":"loginout-bottom.gif");?></p>
</div>
</div>
<!--End 订单查询对话框-->	
<!--订阅对话框-->
<div id="add_newsletter" style="display:none;">
<div class="loginout" >
	<h1><b><?=$SCLanguages['subscribe']?></b></h1>
		<?php echo $this->element('newsletter', array('cache'=>array('time'=> "+0 hour",'key'=>'newsletter'.$template_style)));?>
	<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."loginout-bottom.gif":"loginout-bottom.gif");?></p>
</div>
</div>
<!--End 订阅对话框-->
<!--相册弹出 对话框-->
<div id="layer_gallery">
<?=$html->link($html->image("closelabel.gif"),"javascript:layer_gallery_hide();",array("class"=>"close"),false,false);?>
<p id="gallery_content"></p>
</div>
<!--End 相册弹出 对话框-->		
</body>
</html>
