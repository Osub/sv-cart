<?php 
/*****************************************************************************
 * SV-Cart 虚拟卡批量补货
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: batch_card_add.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>

<?php echo $form->create('virtual_cards',array('action'=>'/batch_card_add_list/'.$product_id.'/','enctype'=>'multipart/form-data'));?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start--><br />
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."补货列表","/virtual_cards/card/".$product_id,'',false,false);?></strong></p>

<div class="home_main" id="guides_1">
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	<?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	<?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	批量补货</h1></div>
	<div class="box">
	<div class="shop_config menus_configs guides" style="width:500px;">
	<br />	
	<dl><dt style="width:100px;">分隔符： </dt>
	<dd><input type="text" style="width:50px;*width:180px;border:1px solid #649776;font-size:larger ; " name="separator" value=","  /></dd>&nbsp<font color="#ff0000" >*</font></dl>

	<dl><dt style="width:100px;" >上传文件： </dt>
	<dd><input type="file" name="uploadfile" style="width:260px;" size="40" ></dd></dl>

使用说明：<br />

   1. 上传文件应为CSV文件	<br />
      CSV文件第一列为卡片序号；第二列为卡片密码；第三列为使用截至日期。 <br />
      (用EXCEL创建csv文件方法：在EXCEL中按卡号、卡片密码、截至日期的顺序填写数据，完成后直接保存为csv文件即可) <br />
   2. 密码，和截至日期可以为空，截至日期格式为2006-11-6 <br />
   3. 卡号、卡片密码、截至日期中不要使用中文 <br />
	</div>
	</div>
		<p class="submit_btn"><input type="submit" value="确定"  /><input type="reset" value="重置" /></p>
	</div>
</div>
<?php echo $form->end();?>
