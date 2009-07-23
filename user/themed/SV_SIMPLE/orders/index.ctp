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
 * $Id: index.ctp 1635 2009-05-22 06:26:14Z zhengli $
*****************************************************************************/
?>
<?php echo $javascript->link('calendar');?>
<div class="my_order">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<h3><span><?php echo $SCLanguages['my_order']?></span></h3>
<fieldset>
	<legend class="font_yellow"><?php echo $SCLanguages['order'].$SCLanguages['search']?></legend>
<p>	
    	<span class="float_left"><select name="order_status" id="order_status">
    	<option value="0" selected>--<?php echo $SCLanguages['order'].$SCLanguages['status']?>--</option>
	    <?php if($order_status == 0){?>
    	<option value="0" selected><?php echo $SCLanguages['please_choose']?></option>
    	<?php }else{?>
    	<option value="0"><?php echo $SCLanguages['please_choose']?></option>
    	<?php }?>
    	<?php if($order_status == 1){?>
    	<option value="1" selected><?php echo $systemresource_info['order_status']['0']?></option>
    	<?php }else{?>
    	<option value="1"><?php echo $systemresource_info['order_status']['0']?></option>
    	<?php }?>
    	<?php if($order_status == 2){?>
    	<option value="2" selected><?php echo $systemresource_info['payment_status']['0']?></option>
    	<?php }else{?>
    	<option value="2"><?php echo $systemresource_info['payment_status']['0']?></option>
    	<?php }?>
    	<?php if($order_status == 3){?>
    	<option value="3" selected><?php echo $systemresource_info['shipping_status']['0']?></option>
    	<?php }else{?>
    	<option value="3"><?php echo $systemresource_info['shipping_status']['0']?></option>
    	<?php }?>
    	</select>
    	&nbsp;&nbsp;<b><?php echo $SCLanguages['order_code']?>：</b> <input name="order_id" id="order_id" size="20" />&nbsp;&nbsp;</span>
      	<span class="button float_left"><a href="javascript:show_status_order()"><?php echo $SCLanguages['search']?></a></span></p>
</fieldset>
			<?php if(isset($my_orders) && sizeof($my_orders)>0){?>
      		<?php $all_price=0;?>
      		<?php $need_paid=0;?>
			<ul class="table_row">
				<li class="number"><strong><?php echo $SCLanguages['order_code']?></strong></li>
				<li class="time"><strong><?php echo $SCLanguages['order_time']?></strong></li>
				<li class="fee"><strong><?php echo $SCLanguages['weight']?></strong></li>
				<li class="fee"><strong><?php echo $SCLanguages['total_order_value']?></strong></li>
				<li class=""></li>
				<li class="status"><strong><?php echo $SCLanguages['order'].$SCLanguages['status']?></strong></li>
				<li class="handle"><strong><?php echo $SCLanguages['operation']?></strong></li>
			</ul>
			<?php foreach($my_orders as $k=>$v){?>
			</ul>
				<ul class="table_row table_cell">
				<li class="number"><?php echo $v['Order']['order_code']?></li>
				<li class="time"><?php echo $v['Order']['created']?></li>
				<li class="fee"><?php echo isset($product_weights[$v['Order']['id']]) ? $product_weights[$v['Order']['id']] : 0; ?></li>
				<li class="fee">
					<?php echo $svshow->price_format($v['Order']['total'],$SVConfigs['price_format']);?>	
	            	<?php $all_price+=$v['Order']['total'];?>
	            </li>
				<li class=""></li>
				<li class="status">
				<!-- 订单状态 -->
		        <?php if($v['Order']['status'] == 0){?>
            <?php echo $systemresource_info['order_status']['0']?><br />
            <?php }?>
           	<?php if($v['Order']['status'] == 1){?>
            <?php echo $systemresource_info['order_status']['1']?><br />
            <?php }?>
            <?php if($v['Order']['status'] == 2){?>
            <?php echo $systemresource_info['order_status']['2']?><br />
            <?php }?>
            <?php if($v['Order']['status'] == 3){?>
            <?php echo $systemresource_info['order_status']['3']?><br />
            <?php }?>
            <?php if($v['Order']['status'] == 4){?>
            <?php echo $systemresource_info['order_status']['4']?><br />
            <?php }?>
            <!-- 支付状态 -->
            <?php if($v['Order']['payment_status'] == 0){?>
            <?php echo $systemresource_info['payment_status']['0']?><br />
            <?php }?>
           	<?php if($v['Order']['payment_status'] == 1){?>
            <?php echo $systemresource_info['payment_status']['1']?><br />
            <?php }?>
            <?php if($v['Order']['payment_status'] == 2){?>
            <?php echo $systemresource_info['payment_status']['2']?><br />
            <?php }?>
            <!-- 配送状态 -->
            <?php if($v['Order']['shipping_status'] == 0){?>
            <?php echo $systemresource_info['shipping_status']['0']?><br />
            <?php }?>
           	<?php if($v['Order']['shipping_status'] == 1){?>
            <?php echo $systemresource_info['shipping_status']['1']?><br />
            <?php }?>
            <?php if($v['Order']['shipping_status'] == 3){?>
            <?php echo $systemresource_info['shipping_status']['3']?><br />
            <?php }?>
            <?php if($v['Order']['shipping_status'] == 2){?>
            <?php echo $systemresource_info['shipping_status']['2']?><br />
            <?php }?>
				</li>
				<li class="handle">
	 	               
            <?php if(!($v['Order']['status'] < 2 && $v['Order']['payment_status'] != 2  && $v['Order']['payment_status'] != 2)){?>         	                    
			<?php }?>
			<span><?php echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'icon_view.gif':'icon_view.gif',array("align"=>"middle")),"/orders/".$v['Order']['id'],array("target"=>"_blank"),false,false);?></span>
			<?php if($v['Order']['status'] < 2 && $v['Order']['payment_status'] != 2  && $v['Order']['payment_status'] != 2){?>
            <a href="javascript:order_pay(<?php echo $v['Order']['id']?>,<?php echo $v['Order']['status']?>,'<?php echo $SCLanguages['order_not_paid'];?>');">
            <span><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'icon_copy.gif':'icon_copy.gif',array("align"=>"middle"))?></span>
            </a>
            <?php }?>
            
            <?php if($v['Order']['status'] < 2 && $v['Order']['payment_status'] != 2 && $v['Order']['payment_status'] != 1 && $v['Order']['payment_id'] != 2){?>
            <a href="javascript:layer_dialog_show(<?php echo $v['Order']['id']?>,'<?php echo $SCLanguages['if_cancel_order']?>',3,'<?php echo $SCLanguages['confirm']?>','<?php echo $SCLanguages['cancel']?>');"><span><?php $html->image(isset($img_style_url)?$img_style_url."/".'icon_trash.gif':'icon_trash.gif',array("align"=>"middle"))?></span></a>
            <?php }?>
            	
            <?php if($v['Order']['status'] < 2 && $v['Order']['payment_status'] == 2 && $v['Order']['shipping_status'] == 1){?>
            <a href="javascript:confirm_order(<?php echo $v['Order']['id']?>)">
            <span><?php echo $SCLanguages['confirm']?></span>
            </a>
            <?php }?>
            </li>
           </ul>
		    <?php }?>
		    <?php }else{?> 
        	<div class="not">
		<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'warning_img.gif':'warning_img.gif',array("align"=>"middle"))?><strong><?php echo $SCLanguages['no_order']?></strong></div>
   	 	 <?php }?>
   	 	
   </div>
<div id="pager">
    <?php if(!empty($my_orders)){?>
<span class="totally"><?php printf($SCLanguages['totally_records_unpaid'],$total);?></span>
        <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
    <?php }?>
</div>
	

<?//php echo $this->element('calendar', array('cache'=>'+0 hour'));?>
<script>
/*
function GoPage(pagecount){
var goPage=document.getElementById('go_page').value;
if(goPage > pagecount){
  alert(page_number_expand_max);
}
else{
window.location.href="?page="+goPage;
}
}*/
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
	  }else{
	     window.location.href=webroot_dir+"orders/cancle_order/"+OrderId;
	  }
	}
	else{
	    return;
	}
}

function show_status_order(){
   var OrderStatus=document.getElementById('order_status').value;
   var StartDate="";
   var EndDate="";
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