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
 * $Id: default_full.ctp 1215 2009-05-06 05:46:48Z huangbo $
*****************************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $html->charset(); ?>
<meta name="description" content="<?php if(isset($meta_description)){echo $meta_description;} ?>">
<meta name="keywords" content="<?php if(isset($meta_keywords)){echo $meta_keywords;} ?>" />
<title><?php echo $title_for_layout; ?> - Powered by Seevia</title>
<?echo $html->meta('icon');
echo $html->css('style');
if(isset($_SESSION['Config']['locale'])){
echo $html->css($_SESSION['Config']['locale']);
}else{
echo $html->css('chi');
}
echo $scripts_for_layout;
?>
<?=$javascript->link('/../js/yui/yahoo-dom-event.js');?>
<?=$javascript->link('/../js/yui/container_core-min.js');?>
<?=$javascript->link('/../js/yui/menu-min.js');?>
<?=$javascript->link('/../js/yui/element-beta-min.js');?>
<?=$javascript->link('/../js/yui/animation-min.js');?>
<?=$javascript->link('/../js/yui/connection-min.js');?>
<?=$javascript->link('/../js/yui/json-min.js');?>
<?=$javascript->link('/../js/yui/container-min.js');?>
<script type="text/javascript">
	var webroot_dir = "<?=$this->webroot;?>";
	var themePath = "<?=$this->themeWeb;?>";
</script>
<?=$javascript->link('common.js');?>
<script type="text/javascript">
// 这里把JS用到的所有语言都赋值到这里
<?php if(isset($js_languages) && sizeof($js_languages)>0){?>
<?php foreach($js_languages as $k=>$v){?>
var <?php echo $k;?> = "<?php echo $v;?>";
<? }?>
<?}?>
</script>
<body class="svcart-skin-g00" id="svcart-com">
	<div id="container">
		<div id="header">
			<?php echo $this->element('header', array('cache'=>'+0 hour','languages'=>$languages,'navigations_top'=>(isset($navigations['T']))?$navigations['T']:array()));?>
		</div>
		<div id="content">
				<?php echo $content_for_layout; ?>
		</div>
	</div>
	<div id="footer">
		<? echo $this->element('footer', array('cache'=>'+0 hour','navigations_footer'=>(isset($navigations['F']))?$navigations['F']:array()));?>
	</div>
	<?php echo $this->element('dragl', array('cache'=>'+0 hour'));?>
	<?php echo $cakeDebug; ?>
</body>
</html>
