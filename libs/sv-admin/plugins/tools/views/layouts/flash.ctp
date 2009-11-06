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
 * $Id: flash.ctp 3186 2009-07-22 06:34:50Z huangbo $
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

		echo $html->css('/tools/css/style');

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
<p><?php echo $html->image("/tools/img/".$local_lang."/4_01.gif")?></p>
	<div class="informations">
	<br /><br /><br />
	<p class="ok gray"><?php if(!empty($success)){?><?php echo $html->image("/tools/img/".$local_lang."/yes.gif",array('align'=>'absmiddle'));?><?php }?><strong><?php echo $message; ?></strong></p>
	<!--<p class="ok gray"><strong>基于安全的考虑，请在安装完成后删除 install 目录!</strong></p>-->
	<br /><br /><br />
	<p class="handdle ok">
	<span><?php echo $html->link($url_left['name'],$url_left['url'],array('target' => $target),false,false);?></span>|<span><?php echo $html->link($url_right['name'],$url_right['url'],array('target' => $target),false,false);?></span>
	</p>
	<?php if(!empty($success)){?>
	<p class="handdle ok">
	<span class="float_l add_favorite"><a href="javascript:fav('<?php echo $url_left['url']?>','<?php echo $lang['home']?>')"><?php echo $lang['fav_home']?></a> | <a href="javascript:fav('<?php echo $url_right['url']?>','<?php echo $lang['admin']?>')"><?php echo $lang['fav_admin']?></a></span>
	</p>
	<?php }?>
	<br /><br /><br /><br /><br /><br /><br /><br />
	</div>
<p><?php echo $html->image("/tools/img/".$local_lang."/1_02.gif")?></p>
</div>
<!--Main Start End-->
</div>
<?php //pr($this);?>
<?php echo $this->element('footer', array('cache'=>'+0 hour'));?>
</body>
<?php if(!empty($success)){?>
<script type="text/javascript">
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