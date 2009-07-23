<?php 
/*****************************************************************************
 * SV-Cart 电子优惠券管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 2520 2009-07-02 02:01:40Z zhengli $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($coupons);?>

<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle')).'新增优惠券','/coupons/add','',false,false)?> </strong></p>
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th>电子优惠券名称</th>
	<th>优惠券前缀</th>
	<th>优惠券类型</th>
	<th>优惠额度</th>
	<th>最小金额</th>
	<th>发放数量</th>
	<th>使用数量/最大使用数</th>
	<th>操作</th></tr>
<!--Menberleves List-->
<?php if(isset($coupons) && sizeof($coupons)>0){?>
	<?php foreach($coupons as $coupon){?>
	<tr>
	<td><span><?php echo $html->image('picflag.gif',array('align'=>'absmiddle'))?> <strong><?php echo $coupon['CouponTypeI18n']['name']?></strong></span></td>
	<td align="center"><?php echo $coupon['CouponType']['prefix']?></td>
	<td align="center"><?php echo $coupon['CouponType']['send_type_name']?></td>
	<td align="center"><?php echo $coupon['CouponType']['money']?></td>
	<td align="center"><?php echo $coupon['CouponType']['min_products_amount']?></td>
	<td align="center"><?php if(isset($sent_coupons[$coupon['CouponType']['id']]['count_coupon']))echo $sent_coupons[$coupon['CouponType']['id']]['count_coupon'];else echo 0;?></td>
	<td align="center"><?php 
		if($coupon['CouponType']['send_type'] == 5){
		echo $coupon['CouponType']['count_coupon']."/".$coupon['CouponType']['max_use'];
	}else if(isset($sent_coupons[$coupon['CouponType']['id']]['count_coupon_used']))echo $sent_coupons[$coupon['CouponType']['id']]['count_coupon_used'];else echo 0;?></td>
	<td align="center">
	<?php echo $html->link("编辑","/coupons/edit/{$coupon['CouponType']['id']}");?>|
	<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}coupons/remove/{$coupon['CouponType']['id']}')"));?>
	<?php if($coupon['CouponType']['send_type'] == 0 ||$coupon['CouponType']['send_type'] == 1||$coupon['CouponType']['send_type'] == 3 ||$coupon['CouponType']['send_type'] == 5){?>
	| 	<?php echo $html->link("发放","/coupons/send/".$coupon['CouponType']['id']);?>
	<?php }?>
	| 	<?php echo $html->link("查看","/coupons/".$coupon['CouponType']['id']);?>
	</td></tr>
	<?php }?>
	<?php }?>
</table>
<!--Menberleves List End-->	
<div class="pagers" style="position:relative">
<?php echo $this->element('pagers',array('cache'=>'+0 hour'));?>
</div>
</div>
<!--Main Start End-->
</div>