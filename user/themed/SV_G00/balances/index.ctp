<?php
/*****************************************************************************
 * SV-Cart 我的资金
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here',array('cache'=>'+0 hour'))?>
<div id="Products_box">
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?=$SCLanguages['my_balance'];?></b></h1>
	<div id="infos" style="width:739px;">
    		<?if(isset($my_balance_list) && sizeof($my_balance_list)>0){?>
        	<p class="last_integral" style="margin:5px 10px;"><?=$SCLanguages['current'].sprintf($SCLanguages['remaining_balance'],"：<span>".$my_balance."</span>");?><cite><?=sprintf($SCLanguages['today_consumer'],"： <font>".$all_fee."</font>");?></cite></p>
            <ul class="integral_title"><li class="integral"><?=$SCLanguages['amount'];?></li><li class="time"><?=$SCLanguages['time'];?></li><li class="gift"><?=$SCLanguages['operation'].$SCLanguages['type'];?></li><li class="handel"><?=$SCLanguages['operation'];?></li></ul>
            <div class="integral_list">
   
            <?foreach($my_balance_list as $k=>$v){?>
				<ul class="integral_title">
				<li class="integral">&nbsp;&nbsp;
			<?=$svshow->price_format($v['UserBalanceLog']['amount'],$SVConfigs['price_format']);?>	
						</li>
				<li class="time"><?echo $v['UserBalanceLog']['created']?></li>
				<li class="gift" style="text-align:center">&nbsp;&nbsp;
				<?if($v['UserBalanceLog']['log_type'] == 'O'){?><?=$SCLanguages['order_code'];?>
				<?}elseif($v['UserBalanceLog']['log_type'] == 'B'){?><?=$SCLanguages['supply'];?>
				<?}elseif($v['UserBalanceLog']['log_type'] == 'A'){?><?=$SCLanguages['administrator_operation'];?><?}?></li>
				
				<li class="handel btn_list">
				<?if($v['UserBalanceLog']['log_type'] == 'O'){?>
				<p style="margin:0 10px;">
				<?=$html->link("<span>".$SCLanguages['view'].$SCLanguages['order']."</span>","../orders/".$v['Order']['id'],array(),false,false);?>
				</p><?}?>
				<?if($v['UserBalanceLog']['log_type'] == 'B'){?>
					<?if($v['UserBalanceLog']['is_paid'] == 1){?>
						<?=$SCLanguages['has_paied']?>
					<?}else{?>
				<?=$html->link("<span>".$SCLanguages['supply']."</span>","javascript:pay_balance(".$v['UserBalanceLog']['type_id'].");",array(),false,false);?>
					<?}?>
				<?}?>
				</li></ul>
			<?}?>
			</div>
		<?}else{?>
        	<div class="not">
		<br />		<br />
		<?=$html->image("warning_img.gif",array("alt"=>""))?><strong><?=$SCLanguages['no_balance_log'];?></strong><br /><br /></div>
		<?}?>
        </div>
          <div id="pager">
	<?if(!empty($my_balance_list)){?>
	<div style="float:left;margin-left:20px;padding-top:3px;"><?php printf($SCLanguages['totally_records_unpaid'],$total);?></div>
        <div><?php echo $this->element('pagers', array('cache'=>'+0 hour'));?></div>
    <?}?>
</div>
    		<?if(isset($user_account) && sizeof($user_account)>0){?>
        <div id="infos" style="width:739px;">
        	<p class="sufficient"><b><?=$SCLanguages['supply'];?>记录</b>:</p>
        	
            <ul class="integral_title"><li class="integral" style="width:12%;"><?=$SCLanguages['amount'];?></li>
            	<li class="time" style="width:20%;"><?=$SCLanguages['time'];?></li>
            	<li class="pay_name" style="width:20%;"><?=$SCLanguages['payment'];?></li>
            	<li class="gift" style="width:20%;text-align:center"><?=$SCLanguages['operation'].$SCLanguages['type'];?></li><li class="handel"><?=$SCLanguages['operation'];?></li></ul>
            <div class="integral_list">
   <!-- style="text-align:center"-->
            <?foreach($user_account as $k=>$v){?>
				<ul class="integral_title">
				<li class="integral" style="width:12%;">&nbsp;&nbsp;
			<?=$svshow->price_format($v['UserAccount']['amount'],$SVConfigs['price_format']);?>	
						</li>
				<li class="time" style="width:20%;"><?echo $v['UserAccount']['created']?></li>
				  	<li class="pay_name" style="width:20%;"><?=$v['UserAccount']['pay_name'];?></li>
				<li class="gift"  style="width:20%;text-align:center">
				<?=$SCLanguages['supply'];?>
				</li>
				
				<li class="handel btn_list">
					<?if($v['UserAccount']['status'] == 1){?>
						<?=$SCLanguages['paid']?>
					<?}else{?>
				<p style="margin:0 10px;">
				<?=$html->link("<span>".$SCLanguages['supply']."</span>","javascript:pay_balance(".$v['UserAccount']['pay_id'].");",array(),false,false);?>
					</p><?}?>
				</li></ul>
			<?}?>					
			</div>
        </div>			<?}?>	

        
        
<?if(isset($SVConfigs['voucher']) && $SVConfigs['voucher'] == 1){?>       
		<?if(isset($payment_list) && sizeof($payment_list)>0){?> 
<!--充值/配送方式-->
<form  action="javascript:;" onsubmit="ActAmount(this);"method="post" enctype="multipart/form-data" name="ActAmountForm">
        <div id="infos" style="width:739px;">
        	<p class="sufficient"><b><?=$SCLanguages['supply'];?></b>:</p>
            <p class="many_input"><?=$SCLanguages['please_enter'].$SCLanguages['recharge_amount'];?>：<input type="text" name="amount_num" id="amount_num"  onkeyup="clearNoNum(this)"/> <?=$SCLanguages['yuan'];?></p>
            <p class="sufficient"><b><?=$SCLanguages['please_choose'].$SCLanguages['payment'];?></b>:</p>
		
			<table border="0" cellpadding="0" cellspacing="0" class="payment_table" width="100%">
		<?foreach($payment_list as $k=>$v){?>
		     <?if($v['Payment']['code'] == 'bank' && $v['PaymentI18n']['status'] == 1 && $v['Payment']['supply_use_flag'] == 1){?>
				<tr><td width="25%" class="border_right">
					<input type="radio" class="radio" value="<?echo $v['Payment']['id']?>" name="payment_id" id="payment_id"  autocomplete="off"/> <?echo $v['PaymentI18n']['name']?>
				  </td><td class="padding_left"><br /><?=$SCLanguages['account'].$SCLanguages['information'];?><br /><br /><?echo $v['PaymentI18n']['description']?>
				<br /><br />
				<p class="explain_box"><?=$SCLanguages['notes'];?>：<br />1、<?=$SCLanguages['ifpay_through_counter'];?>........<br /><br />2、<?=$SCLanguages['ifpay_through_online_or_what'];?>......</p></td></tr>
		   <?}else if($v['Payment']['code'] !="COD" && $v['Payment']['code'] !="account_pay" &&  $v['PaymentI18n']['status'] == 1 && $v['Payment']['supply_use_flag'] == 1){?> <!-- 2是货到付款 -->
				<tr><td class="border_right" height="80"><input type="radio" class="radio" value="<?echo $v['Payment']['id']?>" name="payment_id" id="payment_id" autocomplete="off"/><?echo $v['PaymentI18n']['name']?></td><td class="padding_left"><?echo $v['PaymentI18n']['description']?></td></tr>
			<?}?>	
		<?}?>	
				<tr><td colspan="2" class="submit_payment big_buttons" align="center"><p style="padding-left:340px"><span class="float_l"><input type="submit" value="<?=$SCLanguages['supply']?>" onfocus="blur()" /></span></p></td></tr>
			</table>
		
        </div>
     </form>	
<!--充值/配送方式 End-->	
<?}?>			<?}?>

	
  </div>
  <br />
<?php echo $this->element('news',array('cache'=>'+0 hour'))?>