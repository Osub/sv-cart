<?php 
/*****************************************************************************
 * SV-Cart ����ģ��
 *===========================================================================
 * ��Ȩ�����Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *�ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 *������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 *===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: default_search.ctp 2485 2009-06-30 11:33:00Z huangbo $
*****************************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $html->charset(); ?>
<meta name="Author" content="�Ϻ�ʵ������Ƽ����޹�˾" />
<meta name="description" content="<?php if(isset($meta_description)){echo $meta_description;} ?>" />
<meta name="keywords" content="<?php if(isset($meta_keywords)){echo $meta_keywords;} ?>" />
<title><?php echo $title_for_layout; ?>	- Powered by Seevia</title>
<?php echo $html->meta('icon');
echo $html->css('style');
if(isset($_SESSION['Config']['locale'])){
echo $html->css($_SESSION['Config']['locale']);
}else{
echo $html->css('zh_cn');
}
echo $scripts_for_layout;
?>
	<script type="text/javascript" src="/js/yui/yahoo-dom-event.js"></script>
	<script type="text/javascript" src="/js/yui/container_core.js"></script>
	<script type="text/javascript" src="/js/yui/menu.js"></script>
	<script type="text/javascript" src="/js/yui/element-beta-min.js"></script>
	<script type="text/javascript" src="/js/yui/animation-min.js"></script>
	<script type="text/javascript" src="/js/yui/container-min.js"></script>	
	<script type="text/javascript" src="/js/yui/connection-min.js"></script>
	<script type="text/javascript" src="/js/yui/json-min.js"></script>
	<script type="text/javascript" src="/js/yui/autocomplete-min.js"></script>
</head>
<body class="svcart-skin-g00" id="svcart-com">
<?php echo $this->element('dragl', array('cache'=>'+0 hour'));?>
<div id="header"><?php echo $this->element('header', array('cache'=>'+0 hour'));?></div>
<div id="container">
	<div id="content">
		<div id="Left">
		<?php echo $this->element('category', array('cache'=>'+0 hour'));?>
		<?php echo $this->element('history', array('cache'=>'+0 hour'));?>
		</div>
		<div id="Right">
		<?php echo $content_for_layout; ?>
		</div>
	</div>
</div>
<div id="footer"><?php echo $this->element('footer', array('cache'=>'+0 hour'));?></div>
<?php echo $cakeDebug; ?>
</body>
</html>
