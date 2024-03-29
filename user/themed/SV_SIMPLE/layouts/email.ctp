<?php 
/*****************************************************************************
 * SV-Cart email模板
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: email.ctp 1644 2009-05-22 07:32:08Z zhangshisong $
*****************************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $html->charset(); ?>
<title><?php __('SV-Cart: ??? '); ?><?php echo $title_for_layout; ?></title>
<?php echo $html->meta('icon');
$lang_css = isset($_SESSION['Config']['locale']) ? $_SESSION['Config']['locale']:'chi';
?>
<?php echo $minify->css(array($this->themeWeb.'css/layout',$this->themeWeb.'css/calendar',$this->themeWeb.'css/style',$this->themeWeb.'css/'.$lang_css));?>
<?php echo $minify->js(array($this->themeWeb.'/js/regions.js',$this->themeWeb.'/js/common.js'));?>
<script type="text/javascript">
    YAHOO.util.Event.onContentReady("productsandservices", function () {

        var oMenuBar = new YAHOO.widget.MenuBar("productsandservices", { 
                                                    autosubmenudisplay: true, 
                                                    hidedelay: 750, 
                                                    lazyload: true });
        oMenuBar.render();

    });

</script>
</head>
<body class="svcart-skin-g00" id="svcart-com">
<?php echo $this->element('header', array('cache'=>'+0 hour'));?>

<?php echo $content_for_layout; ?>

<?php echo $this->element('footer', array('cache'=>'+0 hour'));?>
<?php echo $this->element('dragl', array('cache'=>'+0 hour'));?>
<?php echo $cakeDebug; ?>
</body>
</html>
