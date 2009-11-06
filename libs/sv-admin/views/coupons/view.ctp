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
 * $Id: view.ctp 3743 2009-08-19 06:43:32Z huangbo $
*****************************************************************************/
?>
<?php echo $javascript->link('coupon');?>	
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($coupons);?>

<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle')).'优惠券列表','/coupons/','',false,false)?> </strong></p>
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<?php if($coupon_type == 0){?>
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th style="width:12%;">编号</th>
	<th style="width:15%;">优惠券类型</th>
	<th style="width:15%;">订单号</th>
	<th style="width:15%;">使用会员</th>
	<th style="width:15%;">使用时间</th>
	<th style="width:15%;">邮件通知</th>
	<th style="width:12%;">操作</th></tr>
<!--Menberleves List-->
<?php if(isset($coupons) && sizeof($coupons)>0){?>
	<?php foreach($coupons as $k=>$coupon){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><?php echo $coupon['Coupon']['id']?></td>
	<td><?php echo $coupon['Coupon']['sn_code']?></td>
	<td><?php if($coupon['Coupon']['order_id'] > 0){echo $coupon['Coupon']['order_id'];}?></td>
	<td><?php if($coupon['Coupon']['user_id'] > 0){echo $coupon['Coupon']['user_name'];}?></td>
	<td><?php if($coupon['Coupon']['order_id'] > 0){echo $coupon['Coupon']['used_time'];}else{echo "未使用";}?></td>
	<td><?php if($coupon['Coupon']['emailed'] == 0){?>未通知<?php }else if($coupon['Coupon']['emailed'] == 1){?>已发成功<?php }?></td>
	<td>
	<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}coupons/remove_coupon/{$coupon['Coupon']['id']}')"));?>
	<?php if($coupon['Coupon']['emailed'] == 0 && $coupon['Coupon']['order_id'] == 0){?>
	|
	<?php echo $html->link("发邮件","javascript:;",array("onclick"=>"send_coupon_email({$coupon['Coupon']['id']});"));?>
	<?php }?>
	</td></tr>
	<?php }?>
	<?php }?>
</table>
</div>
<?php }?>
<?php if($coupon_type != 0 && $coupon_type != 5){?>
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th style="width:15%;">编号</th>
	<th style="width:23%;">优惠券类型</th>
	<th style="width:21%;">订单号</th>
	<th style="width:20%;">使用会员</th>
	<th style="width:20%;">使用时间</th>
</tr>
<!--Menberleves List-->
<?php if(isset($coupons) && sizeof($coupons)>0){?>
	<?php foreach($coupons as $k=>$coupon){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><?php echo $coupon['Coupon']['id']?></td>
	<td><?php echo $coupon['Coupon']['sn_code']?></td>
	<td><?php if($coupon['Coupon']['order_id'] > 0){echo $coupon['Coupon']['order_id'];}?></td>
	<td><?php if($coupon['Coupon']['user_id'] > 0){echo $coupon['Coupon']['user_name'];}?></td>
	<td><?php if($coupon['Coupon']['order_id'] > 0){echo $coupon['Coupon']['used_time'];}else{echo "未使用";}?></td>
</tr>
	<?php }?>
	<?php }?>
</table>
</div>
<?php }?>
<?php if($coupon_type == 5){?>
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th style="width:15%;">编号</th>
	<th style="width:22%;">优惠券类型</th>
	<th style="width:15%;">使用数量</th>
	<th style="width:15%;">最大使用数</th>
	<th style="width:15%;">红包折扣</th>
	<th style="width:17%;">操作</th>
</tr>
<!--Menberleves List-->
<?php if(isset($coupons) && sizeof($coupons)>0){?>
	<?php foreach($coupons as $k=>$coupon){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><?php echo $coupon['Coupon']['id']?></td>
	<td><?php echo $coupon['Coupon']['sn_code']?></td>
	<td><?php echo $coupon['Coupon']['max_use_quantity'];?></td>
	<td><?php echo $coupon['Coupon']['max_buy_quantity'];?></td>
	<td><?php echo $coupon['Coupon']['order_amount_discount'];?></td>
	<td><?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}coupons/remove_coupon/{$coupon['Coupon']['id']}')"));?></td>
</tr>
	<?php }?>
	<?php }?>
</table></div>
<?php }?>
<!--Menberleves List End-->	
<div class="pagers" style="position:relative">
<?php echo $this->element('pagers',array('cache'=>'+0 hour'));?>
</div>
	
</div>
<!--Main Start End-->
</div>