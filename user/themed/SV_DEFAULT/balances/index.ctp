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
 * $Id: index.ctp 5414 2009-10-26 01:45:58Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?><div id="Products_box">
<h1 class="headers"><span class="l">&nbsp;</span><span class="r">&nbsp;</span><b><?php echo $SCLanguages['my_balance'];?></b></h1>
	<div class="infos">
    		<?php if(isset($my_balance_list) && sizeof($my_balance_list)>0){?>
        	<p class="last_integral" style="margin:5px 10px;"><?php echo $SCLanguages['current'].sprintf($SCLanguages['remaining_balance'],"：<span>".$my_balance."</span>");?><cite><?php echo sprintf($SCLanguages['today_consumer'],"： <font>".$all_fee."</font>");?></cite></p>
            <ul class="integral_title">
            	<li class="integral"><?php echo $SCLanguages['amount'];?></li>
            	<li class="time"><?php echo $SCLanguages['time'];?></li>
            	<li class="gift"><?php echo $SCLanguages['operation'].$SCLanguages['type'];?></li>
            	<li class="handel"><?php echo $SCLanguages['operation'];?></li>
            </ul>
            <div class="integral_list">
   			
            <?php foreach($my_balance_list as $k=>$v){?>
				<ul class="integral_title" <?php if($k==sizeof($my_balance_list)-1){?>style="border-bottom:none;"<?php }?>>
				<li class="integral">&nbsp;&nbsp;
			<?//php echo $svshow->price_format($v['UserBalanceLog']['amount'],$SVConfigs['price_format']);?>	
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($v['UserBalanceLog']['amount']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($v['UserBalanceLog']['amount'],$this->data['configs']['price_format']);?>	
			<?php }?>
				</li>
				<li class="time"><?php echo $v['UserBalanceLog']['created']?></li>
				<li class="gift" style="text-align:center">&nbsp;&nbsp;
				<?php if($v['UserBalanceLog']['log_type'] == 'O'){?><?php echo $systemresource_info['balance_log_type']['O'];?>
				<?php }elseif($v['UserBalanceLog']['log_type'] == 'B'){?><?php echo $systemresource_info['balance_log_type']['B'];?>
				<?php }elseif($v['UserBalanceLog']['log_type'] == 'A'){?><?php echo $systemresource_info['balance_log_type']['A'];?><?php }?></li>
				
				<li class="handel btn_list">
				<?php if($v['UserBalanceLog']['log_type'] == 'O'){?>
				<p style="margin:0 10px;">
				<?php echo $html->link("<span>".$SCLanguages['view'].$SCLanguages['order']."</span>","../orders/".$v['Order']['id'],array(),false,false);?>
				</p><?php }?>
				<?php if($v['UserBalanceLog']['log_type'] == 'B'){?>
					<?php if($v['UserBalanceLog']['is_paid'] == 1){?>
						<?php echo $SCLanguages['has_paied']?>
					<?php }else{?>
				<?php echo $html->link("<span>".$SCLanguages['supply']."</span>","javascript:pay_point(".$v['UserBalanceLog']['type_id'].");",array(),false,false);?>
					<?php }?>
				<?php }?>
				</li></ul>
			<?php }?>
			</div>
		<?php }else{?>
        <div class="not">
		<br /><br /><br /><br />
		<?php echo $html->image(isset($img_style_url)?$img_style_url."/"."warning_img.gif":"warning_img.gif",array("alt"=>""))?><strong><?php echo $SCLanguages['no_balance_log'];?></strong>
		<br /><br /><br /><br /><br />
		</div>
		<?php }?>
        </div>
        
<?php if(!empty($my_balance_list)){?>
<div id="pager">
	<div style="float:left;margin-left:20px;padding-top:3px;"><?php printf($SCLanguages['totally_records_unpaid'],$total);?></div>
    <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
<?php }?>

    	<?php if(isset($user_account) && sizeof($user_account)>0){?>
        <div class="infos">
        	<p class="sufficient"><b><?php echo $SCLanguages['supply'];?><?php echo $SCLanguages['record'];?></b>:</p>
        	<br />
            <ul class="integral_title"><strong>
            	<li class="time" style="width:20%;"><?php echo $SCLanguages['time'];?></li>
            	<li class="integral" style="width:12%;"><?php echo $SCLanguages['amount'];?></li>
            	<li class="pay_name" style="width:20%;"><?php echo $SCLanguages['payment'];?></li>
            	<li class="gift" style="width:20%;text-align:center"><?php echo $SCLanguages['operation'].$SCLanguages['type'];?></li><li class="handel"><?php echo $SCLanguages['operation'];?></li>
            </strong></ul>
            <div class="integral_list">
   <!-- style="text-align:center"-->
            <?php foreach($user_account as $k=>$v){?>
				<ul class="integral_title" <?php if((sizeof($user_account)-1) == $k){?>style="border:none;"<?php }?>>
				<li class="time" style="width:20%;"><?php echo $v['UserAccount']['created']?></li>
				<li class="integral" style="width:12%;">&nbsp;&nbsp;
					<?//php echo $svshow->price_format($v['UserAccount']['amount'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($v['UserAccount']['amount']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($v['UserAccount']['amount'],$this->data['configs']['price_format']);?>	
			<?php }?>						
						
						</li>
				<li class="pay_name" style="width:20%;"><?php echo $v['UserAccount']['pay_name'];?></li>
				<li class="gift"  style="width:20%;text-align:center"><?php echo $SCLanguages['supply'];?></li>
				
				<li class="handel btn_list">
					<?php if($v['UserAccount']['status'] == 1){?>
						<?php echo $SCLanguages['paid']?>
					<?php }else{?>
				<p style="margin:0 10px;">
				<?php echo $html->link("<span>".$SCLanguages['supply']."</span>","javascript:pay_balance(".$v['UserAccount']['pay_id'].");",array(),false,false);?>
					</p><?php }?>
				</li></ul>
			<?php }?>					
			</div>
        </div>
        <?php }?>	

        
        
<?php if(isset($SVConfigs['voucher']) && $SVConfigs['voucher'] == 1){?>       
		<?php if(isset($payment_list) && sizeof($payment_list)>0){?> 
<!--充值/配送方式-->
<form  action="javascript:;" onsubmit="ActAmount(this);"method="post" name="ActAmountForm">
        <div class="infos">
        	<p class="sufficient"><b><?php echo $SCLanguages['supply'];?></b>:</p>
            <p class="many_input"><?php echo $SCLanguages['please_enter'].$SCLanguages['recharge_amount'];?>：<input type="text" name="amount_num" id="amount_num"  onkeyup="clearNoNum(this)"/> <?php echo $SCLanguages['yuan'];?></p>
            <p class="sufficient"><b><?php echo $SCLanguages['please_choose'].$SCLanguages['payment'];?></b>:</p>
		
			<table border="0" cellpadding="0" cellspacing="0" class="payment_table" width="100%">
		<?php foreach($payment_list as $k=>$v){?>
		     <?php if($v['Payment']['code'] == 'bank' && $v['PaymentI18n']['status'] == 1 && $v['Payment']['supply_use_flag'] == 1){?>
				<tr>
					<td width="25%" class="border_right">
					<input type="radio" class="radio" onclick="javascript:confirm_pay(<?=$v['Payment']['id']?>);" value="<?php echo $v['Payment']['id']?>" name="payment_id" id="payment_id"  autocomplete="off"/> <?php echo $v['PaymentI18n']['name']?>
				    </td>
					<td class="padding_left"><br /><?php echo $SCLanguages['account'].$SCLanguages['information'];?><br /><br /><?php echo $v['PaymentI18n']['description']?>
				<br /><br />
				<p class="explain_box"><?php echo $SCLanguages['notes'];?>：<br />1、<?php echo $SCLanguages['ifpay_through_counter'];?>........<br /><br />2、<?php echo $SCLanguages['ifpay_through_online_or_what'];?>......</p></td></tr>
		   <?php }else if($v['Payment']['code'] !="COD" && $v['Payment']['code'] !="account_pay" &&  $v['PaymentI18n']['status'] == 1 && $v['Payment']['supply_use_flag'] == 1){?> <!-- 2是货到付款 -->
				<tr><td class="border_right" height="80"><input type="radio" class="radio" onclick="javascript:confirm_pay(<?=$v['Payment']['id']?>);" value="<?php echo $v['Payment']['id']?>" name="payment_id" id="payment_id" autocomplete="off"/><?php echo $v['PaymentI18n']['name']?></td><td class="padding_left"><?php echo $v['PaymentI18n']['description']?></td></tr>
			<?php }?>	
		<?php }?>	<input type="hidden" name="payment_id_hidden" id="payment_id_hidden" value="0" />
				<tr><td colspan="2" class="submit_payment big_buttons" align="center"><p style="padding-left:340px"><span class="float_l"><input type="submit" value="<?php echo $SCLanguages['supply']?>" onfocus="blur()" /></span></p></td></tr>
			</table>
		
        </div>
     </form>	
<!--充值/配送方式 End-->	
<?php }?>
<?php }?>

	
  </div>
  <br />
<?php echo $this->element('news', array('cache'=>array('time'=> "+0 hour",'key'=>'news'.$template_style)));?>
