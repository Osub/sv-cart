<?php 
/*****************************************************************************
 * SV-Cart 卡片管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: batch_card_add_list.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
 
<?php echo $form->create('virtual_cards',array('action'=>'/batch_card_add_firm/'.$product_id.'/'));?>

<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<br />
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."批量添加补货","/batch_card_add/",'',false,false);?></strong></p>

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

	<ul class="product_llist memberlevels MailTemplate">
	<li class="template_name" style="width:10%"><input type="checkbox" name="chkall" value="checkbox" onclick="checkAll(this.form, this);" checked/>编号</li>
	<li class="template_code" style="width:30%">卡片序号</li>
	
	<li class="use" style="width:30%">卡片密码</li>
	
	<li class="hadl_template" style="width:10%">截至使用日期</li></ul>
<!--Competence List-->
<?php $i=1;foreach( $csv_list as $k=>$v ){?>
	<ul class="product_llist memberlevels memberlevels_list MailTemplate">
	<li class="purview template_name" style="width:10%" ><input type="checkbox" name="checkbox[]"  value="<?php echo $i?>" checked /><?php echo $i?></li>
	<li class="template_code" style="width:30%"><input type="text" name="card_sn[<?php echo $i?>]" value="<?php echo $v['card_sn']?>" ></li>
	
	<li class="use" style="width:30%"><input type="text" name="card_password[<?php echo $i?>]" value="<?php echo $v['card_password']?>"></li>
	
	<li class="hadl_template" style="width:10%"><input type="text" name="end_date[<?php echo $i?>]" value="<?php echo $v['end_date']?>"></li>
		</ul>
<?php $i++;}?>
<!--Competence List End-->	
	<p class="submit_btn"><input type="submit" value="确定"  /><input type="reset" value="重置" /></p>
</div>
<!--Main Start End-->
</div>
<?php echo $form->end();?>