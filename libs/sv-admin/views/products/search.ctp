<?php
/*****************************************************************************
 * SV-Cart 商品待处理缺货
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: search.ctp 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
?>
<?=$javascript->link('listtable');?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));//pr($bookingproducts)?>
<!--Main Start-->
<br />
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<?php echo $form->create('',array('action'=>''));?>

	<ul class="product_llist unchecks product_wanted">
	<li class="number"><input type="checkbox" name="checkbox" value="checkbox" onclick="selectAll(this,'checkbox');" />编号</li>
	<li class="username">联系人</li>
	<li class="email" style="text-align:center;">Email地址</li>
	<li class="object msg_headers">缺货商品名</li>
	<li class="type">商品货号</li>
	<li class="comment_time msg_time" style="width:10%">登记时间<?=$html->image('sort_desc.gif',array('align'=>'absmiddle'))?></li>
	<li class="satus">状态</li>
	<li class="wanted_hadle">操作</li></ul>
<!--Products Wanted-->
<?if(isset($bookingproducts) && sizeof($bookingproducts)>0){?>
<?php foreach($bookingproducts as $bookingproduct){?>
	<ul class="product_llist unchecks unchecks_list product_wanted">
	<li class="number"><input type="checkbox" name="checkbox[]" value="checkbox" /><?php echo $bookingproduct['BookingProduct']['product_id']?></li>
	<li class="username"><span><?php echo $bookingproduct['BookingProduct']['contact_man']?></span></li>
	<li class="email"><span><?php echo $bookingproduct['BookingProduct']['email']?></span></li>
	<li class="object"><span><?=$html->link("{$assocproduct[$bookingproduct['BookingProduct']['product_id']]['ProductI18n']['name']}","/products/{$bookingproduct['BookingProduct']['product_id']}",'',false,false);?></span></li>
	<li class="type"><?php if(isset($assocproduct[$bookingproduct['BookingProduct']['product_id']]['Product']['code']))echo $assocproduct[$bookingproduct['BookingProduct']['product_id']]['Product']['code']?></li>
	<li class="comment_time msg_time" style="width:10%"><?php echo $bookingproduct['BookingProduct']['booking_time']?></li>
	
	<li class="satus"><?php if($bookingproduct['BookingProduct']['is_dispose'])echo '已处理';else echo '待处理';?></li>
	<li class="wanted_hadle">
	<?php echo $html->link("查看","../../products/{$bookingproduct['BookingProduct']['product_id']}");?>|<?php echo $html->link("编辑","{$bookingproduct['BookingProduct']['product_id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}products/search_remove/{$bookingproduct['BookingProduct']['id']}')"));?>

</li></ul>
<?php }}?>

<!--Products Wanted End-->	
<? echo $form->end();?>
  <div class="pagers" style="position:relative">
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
</div>
<!--Main Start End-->
</div>