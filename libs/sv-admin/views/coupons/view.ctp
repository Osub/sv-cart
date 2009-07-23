<?php 
/*****************************************************************************
 * SV-Cart 查看电子优惠券
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: view.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<?php echo $javascript->link('coupon');?>	
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($coupons);?>

<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle')).'优惠券列表','/coupons/','',false,false)?> </strong></p>
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<?php if($coupon_type == 0){?>
	<ul class="product_llist memberlevels">
	<li class="coupon_name_c" style="width:12%;">编号</li>
	<li class="effective" style="width:15%;">优惠券类型</li>
	<li class="piture" style="width:15%;">订单号</li>
	<li class="expense" style="width:15%;">使用会员</li>
	<li class="gratis" style="width:15%;">使用时间</li>
	<li class="gratis" style="width:15%;">邮件通知</li>
	<li class="hadle_coupons" style="width:12%;">操作</li></ul>
<!--Menberleves List-->
<?php if(isset($coupons) && sizeof($coupons)>0){?>
	<?php foreach($coupons as $coupon){?>
	<ul class="product_llist memberlevels memberlevels_list coupons">
	<li class="coupon_name_c" style="width:12%;"><span><?php echo $html->image('picflag.gif',array('align'=>'absmiddle'))?> <strong><?php echo $coupon['Coupon']['id']?></strong></span></li>
	<li class="effective" style="width:15%;"><?php echo $coupon['Coupon']['sn_code']?></li>
	<li class="piture" style="width:15%;"><?php if($coupon['Coupon']['order_id'] > 0){echo $coupon['Coupon']['order_id'];}?></li>
	<li class="expense" style="width:15%;"><?php if($coupon['Coupon']['user_id'] > 0){echo $coupon['Coupon']['user_name'];}?></li>
	<li class="gratis" style="width:15%;"><?php if($coupon['Coupon']['order_id'] > 0){echo $coupon['Coupon']['used_time'];}else{echo "未使用";}?></li>
	<li class="gratis" style="width:15%;">
			<?php if($coupon['Coupon']['emailed'] == 0){?>
			未通知
			<?php }else if($coupon['Coupon']['emailed'] == 1){?>
			已发成功
			<?php }?>
	</li>
	<li class="hadle_coupons" style="width:12%;">
	<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}coupons/remove_coupon/{$coupon['Coupon']['id']}')"));?>
	<?php if($coupon['Coupon']['emailed'] == 0 && $coupon['Coupon']['order_id'] == 0){?>
	|
	<?php echo $html->link("发邮件","javascript:;",array("onclick"=>"send_coupon_email({$coupon['Coupon']['id']});"));?>
	<?php }?>
	</li></ul>
	<?php }?>
	<?php }?>
<?php }?>
<?php if($coupon_type != 0 && $coupon_type != 5){?>
	<ul class="product_llist memberlevels">
	<li class="coupon_name_c" style="width:15%;">编号</li>
	<li class="effective" style="width:23%;">优惠券类型</li>
	<li class="piture" style="width:21%;">订单号</li>
	<li class="expense" style="width:20%;">使用会员</li>
	<li class="gratis" style="width:20%;">使用时间</li>
</ul>
<!--Menberleves List-->
<?php if(isset($coupons) && sizeof($coupons)>0){?>
	<?php foreach($coupons as $coupon){?>
	<ul class="product_llist memberlevels memberlevels_list coupons">
	<li class="coupon_name_c" style="width:15%;"><span><?php echo $html->image('picflag.gif',array('align'=>'absmiddle'))?> <strong><?php echo $coupon['Coupon']['id']?></strong></span></li>
	<li class="effective" style="width:23%;"><?php echo $coupon['Coupon']['sn_code']?></li>
	<li class="piture" style="width:21%;"><?php if($coupon['Coupon']['order_id'] > 0){echo $coupon['Coupon']['order_id'];}?></li>
	<li class="expense" style="width:20%;"><?php if($coupon['Coupon']['user_id'] > 0){echo $coupon['Coupon']['user_name'];}?></li>
	<li class="gratis" style="width:20%;"><?php if($coupon['Coupon']['order_id'] > 0){echo $coupon['Coupon']['used_time'];}else{echo "未使用";}?></li>
</ul>
	<?php }?>
	<?php }?>
<?php }?>
<?php if($coupon_type == 5){?>
	<ul class="product_llist memberlevels">
	<li class="coupon_name_c" style="width:15%;">编号</li>
	<li class="effective" style="width:22%;">优惠券类型</li>
	<li class="piture"  style="width:15%;">使用数量</li>
	<li class="expense" style="width:15%;">最大使用数</li>
	<li class="gratis" style="width:15%;">红包折扣</li>
	<li class="gratis" style="width:17%;">操作</li>
</ul>
<!--Menberleves List-->
<?php if(isset($coupons) && sizeof($coupons)>0){?>
	<?php foreach($coupons as $coupon){?>
	<ul class="product_llist memberlevels memberlevels_list coupons">
	<li class="coupon_name_c" style="width:15%;"><span><?php echo $html->image('picflag.gif',array('align'=>'absmiddle'))?> <strong><?php echo $coupon['Coupon']['id']?></strong></span></li>
	<li class="effective" style="width:22%;"><?php echo $coupon['Coupon']['sn_code']?></li>
	<li class="piture" style="width:15%;"><?php echo $coupon['Coupon']['max_use_quantity'];?></li>
	<li class="expense" style="width:15%;"><?php echo $coupon['Coupon']['max_buy_quantity'];?></li>
	<li class="gratis" style="width:15%;"><?php echo $coupon['Coupon']['order_amount_discount'];?></li>
	<li class="gratis" style="width:17%;">	<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}coupons/remove_coupon/{$coupon['Coupon']['id']}')"));?></li>
</ul>
	<?php }?>
	<?php }?>
<?php }?>
<!--Menberleves List End-->	
<div class="pagers" style="position:relative">
<?php echo $this->element('pagers',array('cache'=>'+0 hour'));?>
</div>
	
</div>
<!--Main Start End-->
</div>