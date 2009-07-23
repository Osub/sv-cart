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
 * $Id: index.ctp 2081 2009-06-10 10:10:12Z shenyunfeng $
*****************************************************************************/
?>
<?php echo $this->element('ur_here',array('cache'=>'+0 hour'))?>
<div id="Products_box">
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['my_balance'];?></b></h1>
	<div id="infos">
    		<?php if(isset($my_balance_list) && sizeof($my_balance_list)>0){?>
        	<p class="last_integral" style="margin:5px 10px;"><?php echo $SCLanguages['current'].sprintf($SCLanguages['remaining_balance'],"：<span>".$my_balance."</span>");?><cite><?php echo sprintf($SCLanguages['today_consumer'],"： <font>".$all_fee."</font>");?></cite></p>
            <ul class="integral_title"><li class="integral"><?php echo $SCLanguages['amount'];?></li><li class="time"><?php echo $SCLanguages['time'];?></li><li class="gift"><?php echo $SCLanguages['operation'].$SCLanguages['type'];?></li><li class="handel"><?php echo $SCLanguages['operation'];?></li></ul>
            <div class="integral_list">
   
            <?php foreach($my_balance_list as $k=>$v){?>
				<ul class="integral_title">
				<li class="integral">&nbsp;&nbsp;
			<?php echo $svshow->price_format($v['UserBalanceLog']['amount'],$SVConfigs['price_format']);?>	
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
						<?php echo $html->link("<span>".$SCLanguages['supply']."</span>","javascript:pay_balance(".$v['UserBalanceLog']['type_id'].");",array(),false,false);?>
					<?php }?>
				<?php }?>
				</li></ul>
			<?php }?>
			</div>
		<?php }else{?>
        	<div class="not">
		<br />		<br />
		<?php echo $html->image("warning_img.gif",array("alt"=>""))?><strong><?php echo $SCLanguages['no_balance_log'];?></strong><br /><br /></div>
		<?php }?>
        </div>
          <div id="pager">
	<?php if(!empty($my_balance_list)){?>
	<div style="float:left;margin-left:20px;padding-top:3px;"><?php printf($SCLanguages['totally_records_unpaid'],$total);?></div>
        <div><?php echo $this->element('pagers', array('cache'=>'+0 hour'));?></div>
    <?php }?>
</div>
    		<?php if(isset($user_account) && sizeof($user_account)>0){?>
        <div id="infos">
        	<p class="sufficient"><b><?php echo $SCLanguages['supply'];?>记录</b>:</p>
        	
            <ul class="integral_title"><li class="integral" style="width:12%;"><?php echo $SCLanguages['amount'];?></li>
            	<li class="time" style="width:20%;"><?php echo $SCLanguages['time'];?></li>
            	<li class="pay_name" style="width:20%;"><?php echo $SCLanguages['payment'];?></li>
            	<li class="gift" style="width:20%;text-align:center"><?php echo $SCLanguages['operation'].$SCLanguages['type'];?></li><li class="handel"><?php echo $SCLanguages['operation'];?></li></ul>
            <div class="integral_list">
   <!-- style="text-align:center"-->
            <?php foreach($user_account as $k=>$v){?>
				<ul class="integral_title">
				<li class="integral" style="width:12%;">&nbsp;&nbsp;
			<?php echo $svshow->price_format($v['UserAccount']['amount'],$SVConfigs['price_format']);?>	
						</li>
				<li class="time" style="width:20%;"><?php echo $v['UserAccount']['created']?></li>
				  	<li class="pay_name" style="width:20%;"><?php echo $v['UserAccount']['pay_name'];?></li>
				<li class="gift"  style="width:20%;text-align:center">
				<?php echo $SCLanguages['supply'];?>
				</li>
				
				<li class="handel btn_list">
					<?php if($v['UserAccount']['status'] == 1){?>
						<?php echo $SCLanguages['paid']?>
					<?php }else{?>
							
							
						<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
							<?php echo $form->create('balances',array('action'=>'pay_balance','name'=>'pay_balance'.$k,'type'=>'POST'));?>
							<input type="hidden" name='id' value="<?php echo $v['UserAccount']['pay_id']?>">
							<p style="margin:0 10px;">	<?php echo $html->link("<span>".$SCLanguages['supply']."</span>","javascript:pay_balance_no_ajax(".$k.");",array(),false,false);?></p>
							<?php echo $form->end();?>
						<?php }else{?>								
							<p style="margin:0 10px;">
							<?php echo $html->link("<span>".$SCLanguages['supply']."</span>","javascript:pay_balance(".$v['UserAccount']['pay_id'].");",array(),false,false);?>
							</p>
						<?php }?>
					<?php }?>
				</li></ul>
			<?php }?>					
			</div>
        </div>			<?php }?>	

        
        
<?php if(isset($SVConfigs['voucher']) && $SVConfigs['voucher'] == 1){?>       
		<?php if(isset($payment_list) && sizeof($payment_list)>0){?> 
<!--充值/配送方式-->
	<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
<?php echo $form->create('balances',array('action'=>'balance_deposit','name'=>'balance_deposit','type'=>'POST'));?>
	<?php }else{?>
	<form  action="javascript:;" onsubmit="ActAmount(this);"method="post" enctype="multipart/form-data" name="ActAmountForm">
	<?php }?>
        <div id="infos">
        	<p class="sufficient"><b><?php echo $SCLanguages['supply'];?></b>:</p>
            <p class="many_input"><?php echo $SCLanguages['please_enter'].$SCLanguages['recharge_amount'];?>：<input type="text" name="amount_num" id="amount_num"  onkeyup="clearNoNum(this)"/> <?php echo $SCLanguages['yuan'];?></p>
            <p class="sufficient"><b><?php echo $SCLanguages['please_choose'].$SCLanguages['payment'];?></b>:</p>
		
			<table border="0" cellpadding="0" cellspacing="0" class="payment_table" width="100%">
		<?php foreach($payment_list as $k=>$v){?>
		     <?php if($v['Payment']['code'] == 'bank' && $v['PaymentI18n']['status'] == 1 && $v['Payment']['supply_use_flag'] == 1){?>
				<tr><td width="25%" class="border_right">
					<input type="radio" class="radio" value="<?php echo $v['Payment']['id']?>" name="payment_id" id="payment_id"  autocomplete="off"/> <?php echo $v['PaymentI18n']['name']?>
				  </td><td class="padding_left"><br /><?php echo $SCLanguages['account'].$SCLanguages['information'];?><br /><br /><?php echo $v['PaymentI18n']['description']?>
				<br /><br />
				<p class="explain_box"><?php echo $SCLanguages['notes'];?>：<br />1、<?php echo $SCLanguages['ifpay_through_counter'];?>........<br /><br />2、<?php echo $SCLanguages['ifpay_through_online_or_what'];?>......</p></td></tr>
		   <?php }else if($v['Payment']['code'] !="COD" && $v['Payment']['code'] !="account_pay" &&  $v['PaymentI18n']['status'] == 1 && $v['Payment']['supply_use_flag'] == 1){?> <!-- 2是货到付款 -->
				<tr><td class="border_right" height="80"><input type="radio" class="radio" value="<?php echo $v['Payment']['id']?>" name="payment_id" id="payment_id" autocomplete="off"/><?php echo $v['PaymentI18n']['name']?></td><td class="padding_left"><?php echo $v['PaymentI18n']['description']?></td></tr>
			<?php }?>	
		<?php }?>	
				<tr><td colspan="2" class="submit_payment big_buttons" align="center"><p style="padding-left:340px"><span class="float_l"><input type="submit" value="<?php echo $SCLanguages['supply']?>" onfocus="blur()" /></span></p></td></tr>
			</table>
		
        </div>
	 <?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
<?php echo $form->end();?>
     <?php }else{?>
     </form>
     <?php }?>
<!--充值/配送方式 End-->	
	<?php }?>
<?php }?>

	
  </div>
  <br />
<?php echo $this->element('news',array('cache'=>'+0 hour'))?>