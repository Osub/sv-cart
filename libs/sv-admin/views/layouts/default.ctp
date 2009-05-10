<?php
/*****************************************************************************
 * SV-Cart 默认模板
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: default.ctp 899 2009-04-22 15:03:02Z huangbo $
*****************************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $html->charset(); ?>
<title><?php echo $title_for_layout; ?> - <?php __('Powered by Seevia'); ?></title>
	<?php
		echo $html->meta('icon');
		echo $html->css('style');
		echo $scripts_for_layout;
		//pr($alt);

	?>
	
<?=$javascript->link('/../js/yui/yahoo-dom-event.js');?>
<?=$javascript->link('/../js/yui/container_core-min.js');?>
<?=$javascript->link('/../js/yui/menu-min.js');?>
<?=$javascript->link('/../js/yui/element-beta-min.js');?>
<?=$javascript->link('/../js/yui/animation-min.js');?>
<?=$javascript->link('/../js/yui/connection-min.js');?>
<?=$javascript->link('/../js/yui/json-min.js');?>
<?=$javascript->link('/../js/yui/container-min.js');?>
<?=$javascript->link('/../js/yui/tabview-min.js');?><!--删除层遮罩-->

<script type="text/javascript">
	var webroot_dir = "<?=$this->webroot;?>";
	var themePath = "<?=$this->themeWeb;?>";
	var now_locale = "<?=$now_locale?>";//当前语言
</script>
<?=$javascript->link('common');?>
<!--菜单-->
<script type="text/javascript">
    YAHOO.util.Event.onContentReady("topmenu", function () {

        var oMenuBar = new YAHOO.widget.MenuBar("topmenu", { 
                                                    autosubmenudisplay: true, 
                                                    hidedelay: 750, 
                                                    lazyload: true });
        oMenuBar.render();

    });
    
</script>
<!--菜单end-->
</head>
<body class="yui-skin-sam svcart-skin-g00"  id="svcart-com" onload="layer_dialog();" >

<?php
	if(@!isset($this->params['url']['status'])){
		echo $this->element('header', array('cache'=>'+0 hour'));
	}
?>
<?php echo $content_for_layout; ?>
<?php 
	if(@!isset($this->params['url']['status'])){
		echo $this->element('footer', array('cache'=>'+0 hour'));
	}
	?>
<?php echo $cakeDebug; ?>
<!--对话框-->
<input type="hidden" value="" id="img_src_text_number">
<input type="hidden" value="" id="assign_dir">
<div id="layer_dialog" style="display:none;">
<div id="loginout" >
	<h1><b>系统提示</b></h1>
	<div id="buyshop_box">
		<p class="login-alettr">
		<?=$html->image("icon-10.gif",array('align'=>'absmiddle','class'=>'sub_icon'));?>
		<b>
		<span id="dialog_content"></span>
		</b>
		</p>
		<br /><input type="hidden" id="confirm">
		<p class="buy_btn mar" ><span id="button_replace"><?=$html->link("取消","javascript:;",array("onclick"=>"layer_dialog_obj.hide()"));?>
		<?=$html->link("确定","javascript:;",array("onclick"=>"confirm_record()"));?></span></p>
	</div>
	<p><?=$html->image("loginout-bottom.gif");?></p>
</div>
</div>
<!--End 对话框-->

</body>
</html>