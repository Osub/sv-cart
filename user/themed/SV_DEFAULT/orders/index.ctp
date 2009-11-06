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
 * $Id: index.ctp 3673 2009-08-17 09:57:45Z huangbo $
*****************************************************************************/
?>
<?php echo $javascript->link('calendar');?>
<div id="Products_box">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?><h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['my_order']?></b></h1>
        <div id="order_box" >
      		<?php if(isset($my_orders) && sizeof($my_orders)>0){?>
      		<?php $all_price=0;?>
      		<?php $need_paid=0;?>
    	<p class="note OrderNote"><span style="float:left;"><b><?php echo $SCLanguages['order'].$SCLanguages['status']?>：</b><select name="order_status" id="order_status">
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
    	</select></span>
       <span style="margin:2px 20px 0 5px !important;margin:5px 20px 0 5px;	height:25px;">
       <b><?php echo $SCLanguages['time'];?>：</b> <input type="text" id="date" name="date" value="" size="8" readonly /><button class="calendar" id="show" title="Show Calendar">
       		<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'calendar.png':'calendar.png',array('width'=>'18' ,'height'=>'18' ,'alt'=>'Calendar'))?>
       		</button>－<input type="text" id="date2" name="date2" value=""  size="8" readonly/><button class="calendar" id="show2" title="Show Calendar">
       		<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'calendar.png':'calendar.png',array('width'=>'18' ,'height'=>'18' ,'alt'=>'Calendar'))?>
       		</button>
      &nbsp;&nbsp;<b><?php echo $SCLanguages['order_code']?>：</b> <input name="order_id" id="order_id" style="width:100px" size="8" />
      <input type="button" onfocus="blur()" value="<?php echo $SCLanguages['search']?>" class="query_submit cursor color_67" onclick="show_status_order()" /></span></p>
        
        <p class="title">
        	<span class="order_number"><strong><?php echo $SCLanguages['order_code']?></strong></span>
            <span class="order_time"><strong><?php echo $SCLanguages['order_time']?></strong></span>
            <span class="order_menny"><strong><?php echo $SCLanguages['total_order_value']?></strong></span>
            <span class="order_menny"><strong><?php echo $SCLanguages['payable_amount']?></strong></span>
            <span class="order_estate"><strong><?php echo $SCLanguages['order'].$SCLanguages['status']?></strong></span>
            <span class="handel"><strong><?php echo $SCLanguages['operation']?></span></strong></p>
   		
   		<?php foreach($my_orders as $k=>$v){?>
        <p class="title order_list">
        	<span class="order_number"><br /><?php echo $v['Order']['order_code']?></span>
            <span class="order_time"><br /><?php echo $v['Order']['created']?></span>
            <span class="order_menny"><br />
            <?//php echo $svshow->price_format($v['Order']['total'],$SVConfigs['price_format']);?>	
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($v['Order']['total']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($v['Order']['total'],$this->data['configs']['price_format']);?>	
			<?php }?>            
            
            <?php $all_price+=$v['Order']['total'];?>
			</span>
            <span class="order_menny"><br />
			<?//php echo $svshow->price_format($v['Order']['need_paid'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($v['Order']['need_paid']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($v['Order']['need_paid'],$this->data['configs']['price_format']);?>	
			<?php }?>     				
				
				
      		<?php $need_paid+=($v['Order']['need_paid']);?>
            </span>
            <span class="order_estate"><br />

            <!-- 订单状态 -->
            <?php if($v['Order']['status'] == 0){?>
            <?php echo $systemresource_info['order_status']['0']?>
            <?php }?>
           	<?php if($v['Order']['status'] == 1){?>
            <?php echo $systemresource_info['order_status']['1']?>
            <?php }?>
            <?php if($v['Order']['status'] == 2){?>
            <?php echo $systemresource_info['order_status']['2']?>
            <?php }?>
            <?php if($v['Order']['status'] == 3){?>
            <?php echo $systemresource_info['order_status']['3']?>
            <?php }?>
            <?php if($v['Order']['status'] == 4){?>
            <?php echo $systemresource_info['order_status']['4']?>
            <?php }?>
            <!-- 支付状态 -->
            <?php if($v['Order']['payment_status'] == 0){?>
            <?php echo $systemresource_info['payment_status']['0']?>
            <?php }?>
           	<?php if($v['Order']['payment_status'] == 1){?>
            <?php echo $systemresource_info['payment_status']['1']?>
            <?php }?>
            <?php if($v['Order']['payment_status'] == 2){?>
            <?php echo $systemresource_info['payment_status']['2']?>
            <?php }?>
            <!-- 配送状态 -->
            <?php if($v['Order']['shipping_status'] == 0){?>
            <?php echo $systemresource_info['shipping_status']['0']?>
            <?php }?>
           	<?php if($v['Order']['shipping_status'] == 1){?>
            <?php echo $systemresource_info['shipping_status']['1']?>
            <?php }?>
            <?php if($v['Order']['shipping_status'] == 3){?>
            <?php echo $systemresource_info['shipping_status']['3']?>
            <?php }?>
            <?php if($v['Order']['shipping_status'] == 2){?>
            <?php echo $systemresource_info['shipping_status']['2']?>
            <?php }?>
            
            </span>
            
            <span class="handel btn_list">
            <?php if(!($v['Order']['status'] < 2 && $v['Order']['payment_status'] != 2  && $v['Order']['payment_status'] != 2)){?>
            <br />
            <?php }?>
			<?php echo $html->link("<span>".$SCLanguages['view']."</span>","/orders/".$v['Order']['id'],array("target"=>"_blank"),false,false);?>            	                    
			<?php if($v['Order']['status'] < 2 && $v['Order']['payment_status'] != 2  && $v['Order']['payment_status'] != 2){?>
            <a href="javascript:order_pay(<?php echo $v['Order']['id']?>,<?php echo $v['Order']['status']?>,'<?php echo $SCLanguages['order_not_paid'];?>');">
            <span><?php echo $SCLanguages['pay']?></span>
            </a>
            <?php }?>
            
            <?php if($v['Order']['status'] < 2 && $v['Order']['payment_status'] != 2 && $v['Order']['payment_status'] != 1 && $v['Order']['payment_id'] != 2){?>
            <a href="javascript:layer_dialog_show(<?php echo $v['Order']['id']?>,'<?php echo $SCLanguages['if_cancel_order']?>',3,'<?php echo $SCLanguages['confirm']?>','<?php echo $SCLanguages['cancel']?>');"><span><?php echo $SCLanguages['cancel']?></span></a>
            <?php }?>
            	
            <?php if($v['Order']['status'] < 2 && $v['Order']['payment_status'] == 2 && $v['Order']['shipping_status'] == 1){?>
            <a href="javascript:confirm_order(<?php echo $v['Order']['id']?>)">
            <span><?php echo $SCLanguages['confirm']?></span>
            </a>
            <?php }?>
            </span></p>
		    <?php }?>
        	<p class="title order_list">
        	<span class="order_number">&nbsp;</span>
            <span class="order_time">&nbsp;</span>
            <span class="order_menny">
			<?//php echo $svshow->price_format($all_price,$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($all_price*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($all_price,$this->data['configs']['price_format']);?>	
			<?php }?>     				
				
				
			</span>
            <span class="order_menny">
			<?//php echo $svshow->price_format($need_paid,$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($need_paid*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($need_paid,$this->data['configs']['price_format']);?>	
			<?php }?>    				
				
				
            </span>
            <span class="order_estate"><?php echo $SCLanguages['unpaid']?>(<?php echo $no_paid?>)/<?php echo $SCLanguages['waitting_for_confirm']?>(<?php echo $no_confirm?>)</span>
            <span class="handel">&nbsp;</span></p>		    	
		    	
		    <?php }else{?> 
        	<div class="not">
		<br /><br /><br />
		<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."warning_img.gif":"warning_img.gif",array("alt"=>""))?><strong><?php echo $SCLanguages['no_order']?></strong>
				<br /><br /><br />
		</div>
   	 	 <?php }?>
   	  </div>

    </div>
<div id="pager">
    <?php if(!empty($my_orders)){?>
<span class="totally"><?php printf($SCLanguages['totally_records_unpaid'],$total);?></span>
        <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
    <?php }?>
</div>
<?php echo $this->element('calendar', array('cache'=>'+0 hour'));?>
  <br /><br />
<?php echo $this->element('news', array('cache'=>array('time'=> "+0 hour",'key'=>'news'.$template_style)));?>
<script>/*
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