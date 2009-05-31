<?php
/*****************************************************************************
 * SV-Cart 登录页
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: page.ctp 1670 2009-05-25 00:47:18Z huangbo $
*****************************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $html->charset(); ?>
<title><?php echo $title_for_layout; ?> - <?php __('Powered by Seevia'); ?></title>
<?php
		echo $html->meta('icon');
?>

<script type="text/javascript">
	var webroot_dir = "<?=$this->webroot;?>";
	var themePath = "<?=$this->themeWeb;?>";
</script>
<?=$minify->css(array('/css/layout','/css/admin','/css/calendar','/css/menu','/css/container','/css/treeview','/css/image','/css/swfupload','/css/tabview','css/style'));?>
<?=$minify->js(array('/../js/yui/yahoo-dom-event.js','/../js/yui/animation-min.js','/../js/yui/connection-min.js','/../js/yui/container-min.js','/../js/yui/json-min.js','/js/common.js','/js/forget_pwd.js','/../js/swfobject.js'));?>

</head>
<body id="body" class="yui-skin-sam svcart-skin-g00">
<div class="home" style="height:550px">
		<div class="login_box">
			<p class="logo"><?=$html->image('logo.png')?></p>
	<?php echo $content_for_layout; ?>
	<?php echo $cakeDebug; ?>
		</div>
</div>
<div class="home_footer">
	<p class="copyright">© 2009 上海实玮网络科技有限公司 版权所有</p>
	<p class="pwoered"><?=$html->link("Powered by SV-Cart ","http://www.seevia.cn",'',false,false);?></p>
</div>
</body>
	
</html>
