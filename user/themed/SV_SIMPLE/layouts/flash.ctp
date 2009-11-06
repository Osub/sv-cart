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
 * $Id: flash.ctp 1644 2009-05-22 07:32:08Z zhangshisong $
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
?>

<script type="text/javascript">
	var root_all = "<?php echo $root_all;?>";
	var webroot_dir = "<?php echo $user_webroot;?>";
	var user_webroot = "<?php echo $user_webroot;?>";
	var cart_webroot = "<?php echo $cart_webroot;?>";
	var server_host = "<?php echo $server_host;?>";
	var themePath = "<?php echo $this->themeWeb;?>";
</script>
<?php echo $minify->css(array($this->themeWeb.'css/layout',$this->themeWeb.'css/'.$style_css,$this->themeWeb.'css/'.$lang_css));?>
<?php echo $minify->js(array($this->themeWeb.'js/common.js'));?>

</head>
<body>
<?php echo $this->element('header', array('cache'=>'+0 hour','languages'=>$languages,'navigations_top'=>(isset($navigations['T']))?$navigations['T']:array()));?>


<div class="content">
<div id="ur_here"><?php echo $SCLanguages['current_location_system_remind']?></div>
<!--Main Start-->
<div class="tips">
<h4><?echo $message;?></h4>
<p>
	<?php echo $message;?>
</p>
<p>
	<?php if(isset($back_url)){?>
	<?php echo $html->link($message,$back_url,array(),false,false);?>
	<?php }else if(isset($_SESSION['cart_back_url'])){?>
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['previous'].$SCLanguages['page'],$_SESSION['cart_back_url'],array(),false,false);?>
	<?php unset($_SESSION['cart_back_url']);?>		
	<?php }else{?>
	<?if(isset($url_format)){?>
		<?php echo $url_format;?>
	<?}else{?>
		<?php echo $html->link($message,$url,array(),false,false);?>
	<?}?>			
	<?php }?>
</p>
</div>
<!--Main Start End-->
<?php echo $this->element('footer', array('cache'=>'+0 hour'));?>

</body>
</html>