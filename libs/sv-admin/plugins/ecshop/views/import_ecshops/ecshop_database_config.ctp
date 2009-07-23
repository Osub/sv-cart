<?php
/*****************************************************************************
 * SV-Cart Ecshop导入
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1393 2009-05-15 07:40:52Z zhengli $
*****************************************************************************/
?>
<?php echo $form->create('ecshops',array('action'=>'/ecshop_database_config/','id'=>'theform'));?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start-->
<br />
<div class="home_main" id="guides_1">
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	<?=$html->image('tab_left.gif',array('class'=>'left'))?>
	<?=$html->image('tab_right.gif',array('class'=>'right'))?>
	Ecshop导入插件</h1></div>
	<div class="box">
	<div class="shop_config menus_configs guides" style="width:500px;">
	<br />
	<dl><dt style="width:150px;"></dt>
	<dd><strong><span>数据库连接保存成功,点击下面按钮测试库据主库连接是否正常.</span></strong></dd></dl>
	<dl style="display:none"><dt style="width:140px;">分类: </dt>
	<dd></dd></dl>
	<dl style="display:none"><dt style="width:140px;">商品: </dt>
	<dd></dd></dl>
	<dl style="display:none"><dt style="width:140px;">文章: </dt>
	<dd></dd></dl>
	<dl style="display:none"><dt style="width:140px;">订单: </dt>
	<dd></dd></dl>
	</div>
	</div>
	<p class="submit_btn">
	<input type="button" value="测试连接" onclick="check_ecshop_database_config()" />
	<input type="button" value="开始导入" onclick="start_import_ecshop()" style="display:none" />
	
	</p>
	</div>
</div>
<? echo $form->end();?>
<script type="text/javascript">


</script>
数据库连接保存成功,点击下面按钮开始导入ecshop数据.