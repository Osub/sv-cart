<?php 
/*****************************************************************************
 * SV-Cart 我的优惠券页
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1166 2009-04-30 14:05:59Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?><div id="Products_box">
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['coupon']?></b></h1>
<div id="infos">
<?php if(isset($coupons) && sizeof($coupons)>0){?>
	<ul class="integral_title"><strong>
    <li class="integral" style="width:8%"><?php echo $SCLanguages['coupon']?><?php echo $SCLanguages['code']?></li>
    <li class="time"><?php echo $SCLanguages['coupon']?><?php echo $SCLanguages['apellation']?></li>
    <li class="time" style="width:10%"><?php echo $SCLanguages['coupon']?><?php echo $SCLanguages['amount']?></li>
    <li class="gift" style="width:15%"><?php echo $SCLanguages['min_orders_amount']?></li>
    <li class="handel"><?php echo $SCLanguages['deadline']?></li>
    <li class="handel"><?php echo $SCLanguages['coupon']?><?php echo $SCLanguages['status']?></li>
	</strong></ul>
	<div class="integral_list">	
	<?php foreach($coupons as $k=>$v){?>
	<ul class="integral_title" <?php if($k == (sizeof($coupons)-1)){?>style="border:none;" <?php }?>>
    <li class="integral" style="width:8%"><?php echo $v['Coupon']['sn_code']?></li>
    <li class="time"><?php echo $v['Coupon']['name']?></li>
    <li class="time" style="width:10%"><?php echo $v['Coupon']['fee']?></li>
    <li class="gift" style="width:15%"><?php echo $v['Coupon']['min_amount']?></li>
    <li class="handel"><?php echo $v['Coupon']['use_end_date']?></li>
    <li class="handel">
    	<?php if($v['Coupon']['is_use'] == 1){?>
    	<?php echo $SCLanguages['has_been_used']?>
    	<?php }?>
    	<?php if($v['Coupon']['is_use'] == 0){?>
    	<?php echo $SCLanguages['unused']?>
    	<?php }?>
    	</li>
	</ul>
	<?php }?>
	</div>
<?php }else{?>
    <div class="not">
	<br /><br /><br /><br />
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."warning_img.gif":"warning_img.gif",array("alt"=>""))?><strong><?php echo $SCLanguages['no_coupon'];?></strong>
	<br /><br /><br /><br /><br />
	</div>
<?php }?>
</div>
	
</div>

<?php if(isset($coupons) && sizeof($coupons)>0){?>
  <div id="pager"><?php echo $this->element('pagers', array('cache'=>'+0 hour'));?></div>
<?php }?>

<div id="Products_box">
<div id="infos" style="background:#fff;">
<p class="sufficient"><b><?php echo $SCLanguages['add'];?><?php echo $SCLanguages['coupon'];?></b>:</p>
<br />
<ul class="integral_title" style="background:#fff;border:none;">
	<li class="time" style="width:auto;padding-left:50px;"><?php echo $SCLanguages['please_enter'].$SCLanguages['coupon']." ".strtolower($SCLanguages['code']);?>: <input type="text" style="width:150px;" name="sn_code" id="sn_code" /></li>
	<li class="handel btn_list" style="padding-top:2px;width:auto;"><a href="javascript:add_coupon()" class="float_l"><span><?php echo $SCLanguages['confirm']?></span></a></li>
	<li class="msg"><span style="color:red;" id="sn_code_msg"></span></li>
</ul>
<br />	
</div>
</div>  	  

<?php echo $this->element('news', array('cache'=>array('time'=> "+24 hour",'key'=>'news'.$template_style)));?>
