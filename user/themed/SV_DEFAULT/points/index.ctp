<?php 
/*****************************************************************************
 * SV-Cart 我的积分页
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
<?php echo $javascript->link('calendar');?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<div id="Products_box">
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['points']?></b></h1>
	<div class="infos">
        	<p class="history_detail find-btns">
        	<a class="float_r" style="margin-top:5px;"><input onfocus="blur()" class="find" type="button" onclick="javascript:points_search();" value="<?php echo $SCLanguages['search']?>" /></a>
			
			<span><?php echo $SCLanguages['time']?>: <input type="text" id="date" name="date" value="" class="text" readonly style="*margin-right:3px;" /><button class="calendar" id="show" title="Show Calendar" style="*margin-top:0;">
			<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'calendar.png':'calendar.png',array('width'=>'18' ,'height'=>'18' ,'alt'=>'Calendar'))?></button>－<input type="text" id="date2" name="date2" value=""  class="text" readonly style="*margin-right:3px;" /><button class="calendar" id="show2" title="Show Calendar" style="*margin-top:0;"><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'calendar.png':'calendar.png',array('width'=>'18' ,'height'=>'18' ,'alt'=>'Calendar'))?></button>
			&nbsp;&nbsp;<?php echo $SCLanguages['points']?>: <input class="text" type="text" name="min_points" id="min_points" value="<?php echo $min_points?>" />－<input class="text" type="text" name="max_points" id="max_points" value="<?php echo $max_points?>" />
			</span>
			<b><?php echo $SCLanguages['history_details']?></b>
			</p>
            <ul class="integral_title">
            <li class="time" style="width:23%"><strong><?php echo $SCLanguages['exchange'].$SCLanguages['time']?></strong></li>
            <li class="integral" style="width:23%"><strong><?php echo $SCLanguages['exchange'].$SCLanguages['points']?></strong></li>
            <li class="gift"style="width:23%"><strong><?php echo $SCLanguages['operation'].$SCLanguages['type']?></strong></li>
            <li class="handel" style="width:22%"><strong><?php echo $SCLanguages['remark']?></strong></li></ul>
            <div class="integral_list">
    		<?php if(isset($my_points) && sizeof($my_points)>0){?>
		    <?php foreach($my_points as $k=>$v){?>
				<ul class="integral_title" >
				<li class="time" style="width:23%"><?php echo $v['UserPointLog']['created']?></li>
				<li class="integral" style="width:23%"><?php echo $v['UserPointLog']['point']?><?php echo $SCLanguages['point_unit']?></li>
				<li class="gift" style="width:23%;margin-left:25px;">
				<?php if ($v['UserPointLog']['log_type'] == 'B'){?>
				<?php echo $systemresource_info['point_log_type']['B']?>
				<?php }elseif ($v['UserPointLog']['log_type'] == 'O'){?>
				<?php echo $systemresource_info['point_log_type']['O']?>
				<?php }elseif($v['UserPointLog']['log_type'] == 'R'){?>
				<?php echo $systemresource_info['point_log_type']['R']?>
				<?php }elseif($v['UserPointLog']['log_type'] == 'C'){?>
				<?php echo $SCLanguages['order']?><?php echo $SCLanguages['return']?><?php }else{?>&nbsp;<?php }?></li>
				
				<li class="handel"   style="width:22%">
				<?php //if ($v['UserPointLog']['log_type'] == 'O'){?>
				<?php if(isset($v['Order']['Order']['id'])){?>
				<?php echo $SCLanguages['order_code']?>:<?php echo $html->link("<span>".$v['Order']['Order']['order_code']."</span>","../orders/".$v['Order']['Order']['id'],array('style'=>'text-decoration:underline;',"target"=>"_blank"),false,false);?>
				<?php }?></li>
				</ul>
				<?php }?>
				<?php }?>	
	<!-- 小计 -->				
			<ul class="integral_title" style="padding:10px 0 10px 32px;">
	        <?php echo $SCLanguages['order_generated']?>: <?php echo $b_point?> <?php echo $SCLanguages['point_unit']?>&nbsp;&nbsp;&nbsp;&nbsp;
	        <?php echo $SCLanguages['register_presented']?>: <?php echo $r_point?> <?php echo $SCLanguages['point_unit']?>&nbsp;&nbsp;&nbsp;&nbsp;
	        <?php echo $SCLanguages['order']?><?php echo $SCLanguages['use']?>: <?php echo $o_point?> <?php echo $SCLanguages['point_unit']?>&nbsp;&nbsp;&nbsp;&nbsp;
	        <?php echo $SCLanguages['order']?><?php echo $SCLanguages['return']?>: <?php echo $c_point?> <?php echo $SCLanguages['point_unit']?>
			</ul>		
	<!-- 小计 -->
	<p class="last_integral" align="right"><?php echo $SCLanguages['current'].$SCLanguages['point']?>：<span><?php echo $my_point?></span><?php echo $SCLanguages['point_unit']?>&nbsp;&nbsp;<?=$SCLanguages['rank_point']?>:<span><?=(!empty($user_point)?$user_point:0)?></span><?php echo $SCLanguages['point_unit']?></p>
			</div>
        </div>
  </div>

<div id="pager">
	<span class="totally"><?php printf($SCLanguages['totally_records_unpaid'],$total);?></span>
    <?php if(!empty($my_points)){?>
       <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
   <?php }?>
</div>
  <br />
    
    
<div id="Products_box">
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['supply_records']?></b></h1>
	<div class="infos">
            <ul class="integral_title">
            <li class="time" style="width:23%"><strong><?php echo $SCLanguages['amount']?></strong></li>
            <li class="integral" style="width:23%"><strong><?php echo $SCLanguages['time']?></strong></li>
            <li class="gift"style="width:23%"><strong><?php echo $SCLanguages['operation'].$SCLanguages['type'];?></strong></li>
            <li class="handel" style="width:22%"><strong><?php echo $SCLanguages['operation']?></strong></li></ul>
            <div class="integral_list">
    		<?php if(isset($user_account) && sizeof($user_account)>0){?>
		    <?php foreach($user_account as $k=>$v){?>
				<ul class="integral_title" >
				<li class="time" style="width:23%">
					<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
						<?php echo $svshow->price_format($v['UserAccount']['amount']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
					<?php }else{?>
						<?php echo $svshow->price_format($v['UserAccount']['amount'],$this->data['configs']['price_format']);?>	
					<?php }?>					
				</li>
				<li class="integral" style="width:23%"><?php echo $v['UserAccount']['created']?></li>
				<li class="gift" style="width:23%;margin-left:25px;">
					<?php echo $systemresource_info['balance_log_type']['B'];?>
				</li>
				
				<li class="handel"   style="width:22%">
					<?php if($v['UserAccount']['status'] == 1){?>
						<?php echo $SCLanguages['already_result']?>
					<?php }else{?>
						<?php echo $html->link("<span>".$SCLanguages['supply']."</span>","javascript:pay_balance(".$v['UserAccount']['pay_id'].");",array(),false,false);?>
					<?php }?>
				</li>
				</ul>
				<?php }?>
				<?php }?>	
			</div>
        </div>
    
<?php if(isset($SVConfigs['payment_point']) && $SVConfigs['payment_point'] == 1){?>
		<?php if(isset($payment_list) && sizeof($payment_list)>0){?> 
<!--充值/配送方式-->
<form  action="javascript:;" onsubmit="payment_point(this);"method="post" name="ActAmountForm">
        <div class="infos">
        	<p class="sufficient"><b><?php echo $SCLanguages['supply'];?></b>:</p>
            <p class="many_input"><?php echo $SCLanguages['please_enter'].$SCLanguages['recharge_amount'];?>：<input type="text" name="amount_num" id="amount_num"  onkeyup="clearNoNum(this)"/> <?php echo $SCLanguages['yuan'];?>   <?php  printf($SCLanguages['point_lv'],$SVConfigs['buy_point_proportion']);?></p>
            <p class="sufficient"><b><?php echo $SCLanguages['please_choose'].$SCLanguages['payment'];?></b>:</p>
		
			<table border="0" cellpadding="0" cellspacing="0" class="payment_table" width="100%">
		<?php foreach($payment_list as $k=>$v){?>
		     <?php if($v['Payment']['code'] == 'bank' && $v['PaymentI18n']['status'] == 1){?>
				<tr>
					<td width="25%" class="border_right">
					<input type="radio" class="radio" onclick="javascript:confirm_pay(<?=$v['Payment']['id']?>);" value="<?php echo $v['Payment']['id']?>" name="payment_id" id="payment_id"  autocomplete="off"/> <?php echo $v['PaymentI18n']['name']?>
				    </td>
					<td class="padding_left"><br /><?php echo $SCLanguages['account'].$SCLanguages['information'];?><br /><br /><?php echo $v['PaymentI18n']['description']?>
				<br /><br />
				<p class="explain_box"><?php echo $SCLanguages['notes'];?>：<br />1、<?php echo $SCLanguages['ifpay_through_counter'];?>........<br /><br />2、<?php echo $SCLanguages['ifpay_through_online_or_what'];?>......</p></td></tr>
		   <?php }else if($v['Payment']['code'] !="COD" && $v['Payment']['code'] !="account_pay" &&  $v['PaymentI18n']['status'] == 1){?> <!-- 2是货到付款 -->
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
        
<?php echo $this->element('news', array('cache'=>array('time'=> "+0 hour",'key'=>'news'.$template_style)));?>
<?php echo $this->element('calendar', array('cache'=>'+0 hour'));?>