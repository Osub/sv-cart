<?php
/*****************************************************************************
 * SV-Cart 提示模板
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: flash.ctp 1209 2009-05-06 02:12:51Z tangyu $
*****************************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $html->charset(); ?>
<meta http-equiv="Refresh" content="<?php echo $pause; ?>;url=<?php echo $url; ?>"/>
<title><?php echo $page_title; ?></title>
<?php
		echo $html->meta('icon');

		echo $html->css('/tools/css/flash_style');

		echo $scripts_for_layout;
		
	//	pr($this);
	?>
<?php if (Configure::read() == 0) { ?>

<?php } ?>
</head>

<body>
<?php echo $this->element('header', array('cache'=>'+0 hour'));?>
<div class="content">
<br />
<!--Main Start-->
<div class="home_main">
	<div class="informations">
	<br /><br /><Br /><br /><Br /><br />
	<p class="ok"><?=$html->image('msg.gif',array('align'=>'absmiddle'))?> &nbsp;&nbsp;<strong><?php echo $message; ?></strong></p>
	<br /><br /><Br /><br /><Br /><br /><Br /><br />
	<p class="handdle ok"><span><?=$html->link($url_left['name'],$url_left['url'],array('target' => $target),false,false);?></span>|<span><?=$html->link($url_right['name'],$url_right['url'],array('target' => $target),false,false);?></span></p>
	<?php if(!empty($host)){?><br /><br /><p class="handdle ok"><span class="float_l add_favorite"><a href="javascript:fav('<?=$host?>','SV-Cart 首页')">收藏  《SV-Cart 首页》</a> | <a href="javascript:fav('<?=$host?>/sv-admin','SV-Cart 后台管理中心')">收藏 《SV-Cart 后台管理中心》</a></span></p><?php }?>
	<br /><Br /><br /><Br /><br /><Br /><br />
	</div>

</div>
<!--Main Start End-->
</div>
<?php //pr($this);?>
<?php echo $this->element('footer', array('cache'=>'+0 hour'));?>
</body>
<?php if(!empty($host)){?>
<script>
function fav(url,title){
 if (document.all)
    {
       window.external.addFavorite(url,title);
    }
 else if (window.sidebar)
    {
       window.sidebar.addPanel(title, url, "");
 	}
}
</script>
<?php }?>
</html>