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
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<div id="Products_box">
    	<h1><span><?=$SCLanguages['coupon']?></span></h1>
        <div id="infos" style="width:739px;">
 			<?if(isset($coupons) && sizeof($coupons)>0){?>
 			<br /><br />
			<ul class="integral_title">
            <li class="integral" style="width:8%"><?=$SCLanguages['coupon']?><?=$SCLanguages['code']?></li>
            <li class="time"><?=$SCLanguages['coupon']?><?=$SCLanguages['apellation']?></li>
            <li class="time" style="width:10%"><?=$SCLanguages['coupon']?><?=$SCLanguages['amount']?></li>
            <li class="gift" style="width:15%"><?=$SCLanguages['min_orders_amount']?></li>
            <li class="handel"><?=$SCLanguages['deadline']?></li>
            <li class="handel"><?=$SCLanguages['coupon']?><?=$SCLanguages['status']?></li>
    		</ul> <div class="integral_list">	
 				<?foreach($coupons as $k=>$v){?>
			<ul class="integral_title">
            <li class="integral" style="width:8%"><?=$v['Coupon']['sn_code']?></li>
            <li class="time"><?=$v['Coupon']['name']?></li>
            <li class="time" style="width:10%"><?=$v['Coupon']['fee']?></li>
            <li class="gift" style="width:15%"><?=$v['Coupon']['min_amount']?></li>
            <li class="handel"><?=$v['Coupon']['use_end_date']?></li>
            <li class="handel">
            	<?if($v['Coupon']['is_use'] == 1){?>
            	<?=$SCLanguages['has_been_used']?>
            	<?}?>
            	<?if($v['Coupon']['is_use'] == 0){?>
            	<?=$SCLanguages['unused']?>
            	<?}?>
            	</li>
    		</ul> 
  				<?}?>
 			<?}else{?>
        	<div class="not">
		<br />		<br />
		<?=$html->image("warning_img.gif",array("alt"=>""))?><strong>没有任何优惠券</strong><br /><br /></div> 				
 				<?}?>
 			</div>
        </div>

  
  <div id="pager">
    <?if(isset($coupons) && sizeof($coupons)>0){?>
       <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
   <?}?></div>
  <br />
<div id="Products_box">
<form  action="javascript:;" onsubmit="ActAmount(this);"method="post" enctype="multipart/form-data" name="ActAmountForm">
        <div id="infos" style="width:739px;">
        	<p class="sufficient"><b><?=$SCLanguages['add'];?><?=$SCLanguages['coupon'];?></b>:</p>
 <div class="btn_list" style="padding-top:10px;">
            <p class="many_input"><?=$SCLanguages['please_enter'].$SCLanguages['coupon'].$SCLanguages['code'];?>：<input type="text" style="width:150px;" name="sn_code" id="sn_code" /> 
<span id="sn_code_msg" style="color:red;"></span>
<p class="float_l" style="padding:1px 4px 0 160px;*margin-top:-2px;">
<a href="javascript:add_coupon()" class="float_l"><span><?=$SCLanguages['confirm']?></span></a></p></div>  
   </div>
     </form>  	  
</div>  	  
  	  
  	  
  	  
  	  
  	  
  	  
  	  
  	  
  	  
  	  
  	  
  	  
  	  
  	  
  	  
  	  
<?php echo $this->element('news', array('cache'=>'+0 hour'));?>
<?php echo $this->element('calendar', array('cache'=>'+0 hour'));?>