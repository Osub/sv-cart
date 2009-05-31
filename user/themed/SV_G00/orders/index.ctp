<?php
/*****************************************************************************
 * SV-Cart 我的订单
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1670 2009-05-25 00:47:18Z huangbo $
*****************************************************************************/
?>
<?=$javascript->link('calendar');?>
<div id="Products_box">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?=$SCLanguages['my_order']?></b></h1>
        <div id="order_box" >
      		<?if(isset($my_orders) && sizeof($my_orders)>0){?>
      		<?$all_price=0;?>
      		<?$need_paid=0;?>
    	<p class="note OrderNote"><span style="float:left;"><b><?=$SCLanguages['order'].$SCLanguages['status']?>：</b><select name="order_status" id="order_status">
    	<?if($order_status == 0){?>
    	<option value="0" selected><?=$SCLanguages['please_choose']?></option>
    	<?}else{?>
    	<option value="0"><?=$SCLanguages['please_choose']?></option>
    	<?}?>
    	<?if($order_status == 1){?>
    	<option value="1" selected><?=$SCLanguages['unconfirmed']?></option>
    	<?}else{?>
    	<option value="1"><?=$SCLanguages['unconfirmed']?></option>
    	<?}?>
    	<?if($order_status == 2){?>
    	<option value="2" selected><?=$SCLanguages['unpaid']?></option>
    	<?}else{?>
    	<option value="2"><?=$SCLanguages['unpaid']?></option>
    	<?}?>
    	<?if($order_status == 3){?>
    	<option value="3" selected><?=$SCLanguages['undelivered']?></option>
    	<?}else{?>
    	<option value="3"><?=$SCLanguages['undelivered']?></option>
    	<?}?>
    	</select></span>
       <span style="margin:2px 20px 0 5px !important;margin:5px 20px 0 5px;	height:25px;">
       <b><?=$SCLanguages['time'];?>：</b> <input type="text" id="date" name="date" value="" size="8" readonly />
       		<button class="Calendar" id="show" title="Show Calendar">
       		<?=$html->image('calendar.png',array('width'=>'18' ,'height'=>'18' ,'alt'=>'Calendar'))?>
       		</button>－<input type="text" id="date2" name="date2" value=""  size="8" readonly/>
       		<button class="Calendar" id="show2" title="Show Calendar">
       		<?=$html->image('calendar.png',array('width'=>'18' ,'height'=>'18' ,'alt'=>'Calendar'))?>
       		</button>
      &nbsp;&nbsp;<b><?=$SCLanguages['order_code']?>：</b> <input name="order_id" id="order_id" style="width:100px" size="8" />
      <input type="button" onfocus="blur()" value="<?=$SCLanguages['search']?>" class="query_submit cursor color_67" onclick="show_status_order()" /></span></p>
        
        <p class="title">
        	<span class="order_number"><?=$SCLanguages['order_code']?></span>
            <span class="order_time"><?=$SCLanguages['order_time']?></span>
            <span class="order_menny"><?=$SCLanguages['total_order_value']?></span>
            <span class="order_menny"><?=$SCLanguages['payable_amount']?></span>
            <span class="order_estate"><?=$SCLanguages['order'].$SCLanguages['status']?></span>
            <span class="handel"><?=$SCLanguages['operation']?></span></p>
   		
   		<?foreach($my_orders as $k=>$v){?>
        <p class="title order_list">
        	<span class="order_number"><br /><br /><?echo $v['Order']['order_code']?></span>
            <span class="order_time"><br /><br /><?echo $v['Order']['created']?></span>
            <span class="order_menny"><br /><br /><?=$svshow->price_format($v['Order']['total'],$SVConfigs['price_format']);?>	
            <?$all_price+=$v['Order']['total'];?>
			</span>
            <span class="order_menny"><br /><br />
			<?=$svshow->price_format($v['Order']['need_paid'],$SVConfigs['price_format']);?>
      		<?$need_paid+=($v['Order']['need_paid']);?>
            </span>
            <span class="order_estate"><br /><br />

            <!-- 订单状态 -->
            <?if($v['Order']['status'] == 0){?>
            <?=$SCLanguages['unconfirmed']?>
            <?}?>
           	<?if($v['Order']['status'] == 1){?>
            <?=$SCLanguages['has_confirmed']?>
            <?}?>
            <?if($v['Order']['status'] == 2){?>
            <?=$SCLanguages['has_been_canceled']?>
            <?}?>
            <?if($v['Order']['status'] == 3){?>
            <?=$SCLanguages['invalid']?>
            <?}?>
            <?if($v['Order']['status'] == 4){?>
            <?=$SCLanguages['return']?>
            <?}?>
            <!-- 支付状态 -->
            <?if($v['Order']['payment_status'] == 0){?>
            <?=$SCLanguages['unpaid']?>
            <?}?>
           	<?if($v['Order']['payment_status'] == 1){?>
            <?=$SCLanguages['paying']?>
            <?}?>
            <?if($v['Order']['payment_status'] == 2){?>
            <?=$SCLanguages['paid']?>
            <?}?>
            <!-- 配送状态 -->
            <?if($v['Order']['shipping_status'] == 0){?>
            <?=$SCLanguages['undelivered']?>
            <?}?>
           	<?if($v['Order']['shipping_status'] == 1){?>
            <?=$SCLanguages['delivered']?>
            <?}?>
            <?if($v['Order']['shipping_status'] == 3){?>
            <?=$SCLanguages['stocking']?>
            <?}?>
            <?if($v['Order']['shipping_status'] == 2){?>
            <?=$SCLanguages['goods_have_received']?>
            <?}?>
            
            </span>
            
            <span class="handel btn_list">
            <?if(!($v['Order']['status'] < 2 && $v['Order']['payment_status'] != 2  && $v['Order']['payment_status'] != 2)){?>
            <br />
            <?}?>
			<?=$html->link("<span>".$SCLanguages['view']."</span>","/orders/".$v['Order']['id'],array("target"=>"_blank"),false,false);?>            	                    
			<?if($v['Order']['status'] < 2 && $v['Order']['payment_status'] != 2  && $v['Order']['payment_status'] != 2){?>
            <a href="javascript:order_pay(<?echo $v['Order']['id']?>,<?echo $v['Order']['status']?>,'<?=$SCLanguages['order_not_paid'];?>');">
            <span><?=$SCLanguages['pay']?></span>
            </a>
            <?}?>
            
            <?if($v['Order']['status'] < 2 && $v['Order']['payment_status'] != 2 && $v['Order']['payment_status'] != 1 && $v['Order']['payment_id'] != 2){?>
            <a href="javascript:cancle_order(<?echo $v['Order']['id']?>,'<? echo $v['Order']['payment_status']?>','<? echo $v['Order']['shipping_status']?>','<?=$SCLanguages['if_cancel_order']?>')">
            <span><?=$SCLanguages['cancel']?></span>
            </a>
            <?}?>
            	
            <?if($v['Order']['status'] < 2 && $v['Order']['payment_status'] == 2 && $v['Order']['shipping_status'] == 1){?>
            <a href="javascript:confirm_order(<?echo $v['Order']['id']?>)">
            <span><?=$SCLanguages['confirm']?></span>
            </a>
            <?}?>
            </span></p>
		    <?}?>
        	<p class="title order_list">
        	<span class="order_number">&nbsp;</span>
            <span class="order_time">&nbsp;</span>
            <span class="order_menny">
			<?=$svshow->price_format($all_price,$SVConfigs['price_format']);?>
			</span>
            <span class="order_menny">
			<?=$svshow->price_format($need_paid,$SVConfigs['price_format']);?>
            </span>
            <span class="order_estate"><?=$SCLanguages['unpaid']?><?echo $no_paid?> / <?=$SCLanguages['waitting_for_confirm']?><?echo $no_confirm?></span>
            <span class="handel">&nbsp;</span></p>		    	
		    	
		    <?}else{?> 
        	<div class="not">
		<br /><br />
		<?=$html->image("warning_img.gif",array("alt"=>""))?><strong><?=$SCLanguages['no_order']?></strong></div>
   	 	 <?}?>
   	  </div>

    </div>
<div id="pager">
    <?if(!empty($my_orders)){?>
<span class="totally"><?php printf($SCLanguages['totally_records_unpaid'],$total);?></span>
        <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
    <?}?>
</div>
<?php echo $this->element('calendar', array('cache'=>'+0 hour'));?>
  <br /><br />
  <?php echo $this->element('news', array('cache'=>'+0 hour'));?>
<script>
function GoPage(pagecount){
var goPage=document.getElementById('go_page').value;
if(goPage > pagecount){
  alert(page_number_expand_max);
}
else{
window.location.href="?page="+goPage;
}
}
function show_last5(){
  document.getElementById('last5').style.display="block";
}
function cancle_order(OrderId,PaymentStatus,ShippingStatus,Msg){
if(confirm(Msg)){
  if(PaymentStatus == 2){
     alert(order_paid_not_cancel);
     return;
  }
  if(ShippingStatus == 1){
     alert(order_delivered_not_cancel);
     return;
  }
  else{
     window.location.href=webroot_dir+"orders/cancle_order/"+OrderId;
  }
}
else{
    return;
}
}
function show_status_order(){
   var OrderStatus=document.getElementById('order_status').value;
   var StartDate=document.getElementById('date').value;
   var EndDate=document.getElementById('date2').value;
   var OrderId=document.getElementById('order_id').value;
   if(StartDate == ""){
   StartDate=0;
   }
   if(EndDate == ""){
   EndDate=0;
   }
   window.location.href=webroot_dir+"orders/index/"+OrderStatus+"/"+StartDate+"/"+EndDate+"/"+OrderId;
}
</script>