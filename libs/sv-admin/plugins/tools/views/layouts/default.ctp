<?php
/*****************************************************************************
 * SV-Cart 空白页
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: default.ctp 725 2009-04-17 08:00:21Z huangbo $
*****************************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php //echo "<pre/>";print_r($html);?>
<?php echo $html->charset(); ?>
<title><?php echo $title_for_layout; ?></title>
<?php
	echo $html->meta('icon');
	
	echo $html->css('/tools/css/style');

	echo $scripts_for_layout;
	
//	pr($this);
?>
<script type="text/javascript">
	var webroot_dir = "<?=$this->webroot;?>";
</script>
</head>
<body>
<?php echo $this->element('header', array('cache'=>'+0 hour'));?>

<?php echo $content_for_layout; ?>

<?php echo $this->element('footer', array('cache'=>'+0 hour'));?>
		
<?php echo $cakeDebug; ?>
</body>
</html>
