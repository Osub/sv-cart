<?php
/*****************************************************************************
 * SV-Cart 查看用户
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: view.ctp 1883 2009-05-31 11:20:54Z huangbo $
*****************************************************************************/
?>



<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."会员列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<!--Main Start-->
<div class="home_main">
<?php echo $form->create('User',array('action'=>'view' ,'onsubmit'=>'return users_check();'));?>
<input id="UserId" name="data[User][id]" type="hidden" value="<?= $this->data['User']['id'];?>">
<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑会员</h1></div>
	  <div class="box">
	  <br />
  	    <dl><dt class="config_lang">会员名称：</dt>
  	<input type="hidden" name="data[User][name]" value="<?=$this->data['User']['name'];?>">
			<dd><font size="3" face="arial"><?=$this->data['User']['name'];?></font></dd></dl>
		<dl><dt class="config_lang">邮件地址：</dt>
			<dd><input type="text" class="text_inputs" style="width:265px;" id="user_email" name="data[User][email]" value="<?=$this->data['User']['email'];?>"/> <font color="#F94671">*</font></dd></dl>
		<dl><dt class="config_lang">会员等级：</dt><dd>
		<select style="width:230px;" name="data[User][rank]">
		<option value="-1">用户等级</option>
		<option value="0" <?if($this->data['User']['rank'] == 0){?>selected<?}?>>普通用户</option>
		<?if(isset($rank_list) && sizeof($rank_list)>0){?>
		<?foreach($rank_list as $k=>$v){?>
		  <option value="<?echo $v['UserRank']['id']?>" <?if($v['UserRank']['id'] == $this->data['User']['rank']){?>selected<?}?>><?echo $v['UserRank']['name']?></option>
		<?}}?>
		</select></dd></dl>

		<dl style="padding:5px 0;*padding:6px 0;"><dt style="padding-top:1px" class="config_lang">性别：</dt><dd class="best_input">
		<input type="radio" name="data[User][sex]" <?if($this->data['User']['sex'] == 0){?>checked="checked"<?}?> value="0"/>保密
		<input type="radio" name="data[User][sex]" <?if($this->data['User']['sex'] == 1){?>checked="checked"<?}?> value="1"/>男
		<input type="radio" name="data[User][sex]"  <?if($this->data['User']['sex'] == 2){?>checked="checked"<?}?> value="2"/>女</dd></dl>
        <dl><dt>出生日期：</dt><dd>
          <input style="width:80px;"  type="text" id="date" name="data[User][birthday]"  value="<?echo $this->data['User']['birthday']?>" /><button type="button" id="show" title="Show Calendar" class="calendar" style="margin-top:0;"><?=$html->image("calendar.gif")?></button></dd></dl>
		<?if(isset($user_infoarr) && sizeof($user_infoarr)>0){?>
		<?foreach($user_infoarr as $k=>$v){?>
		 <?if($v['UserInfo']['backend'] == 1){?>
		 	 <?if($v['UserInfo']['type'] == "text"){?>
		<dl><dt class="config_lang"><?echo $v['UserInfo']['name']?>：</dt>
		       <input id="ValueId" name="info_value_id[<?echo @$v['value']['user_info_id']?>]" type="hidden" value="<?echo $v['UserInfo']['id']?>">
			<dd><input type="text" class="text_inputs" style="width:265px;" name="info_value[<?echo @$v['value']['user_info_id']?>]" value="<?echo @$v['value']['value']?>"/></dd></dl>
		<?}?>
		<?if(@$v['UserInfo']['type'] == "radio"){?>
		<dl><dt class="config_lang"><?echo @$v['UserInfo']['name']?>：</dt>
		       <input id="ValueId" name="info_value_id[<?echo @$v['value']['user_info_id']?>]" type="hidden" value="<?echo $v['UserInfo']['id']?>">
			<dd>
			<?$one_arr = explode(";",@$v['UserInfo']['values']);?>
			<?foreach($one_arr as $kkk=>$vvv){$two_arr = explode(":",$vvv);?>
				<input type="radio" name="info_value[<?echo @$v['UserInfo']['id']?>]" value="<?=$two_arr[0]?>" <?if(@$v['value']['value']==$two_arr[0]){echo "checked";}?>><?=$two_arr[1]?>
			<?}?>

	</dd></dl>
		<?}?>	<?if(@$v['UserInfo']['type'] == "checkbox"){?>
		<dl><dt class="config_lang"><?echo @$v['UserInfo']['name']?>：</dt>
		       <input id="ValueId" name="info_value_id[<?echo @$v['value']['user_info_id']?>]" type="hidden" value="<?echo $v['UserInfo']['id']?>">
			<dd>
			<?$one_arr = explode(";",@$v['UserInfo']['values']);?>
			<?foreach($one_arr as $kkk=>$vvv){$two_arr = explode(":",$vvv);?>
				<input type="checkbox" name="info_value[<?echo @$v['UserInfo']['id']?>][]" value="<?=$two_arr[0]?>" <?if(in_array($two_arr[0],explode(";",@$v['value']['value']))){echo "checked";}?> ><?=$two_arr[1]?>
			<?}?>

	</dd></dl>
		<?}?>
		 	 <?if($v['UserInfo']['type'] == "textarea"){?>
		<dl><dt class="config_lang"><?echo $v['UserInfo']['name']?>：</dt>
		       <input id="ValueId" name="info_value_id[<?echo @$v['value']['user_info_id']?>]" type="hidden" value="<?echo $v['UserInfo']['id']?>">
			<dd><textarea type="text" class="text_inputs" style="width:265px;" name="info_value[<?echo @$v['value']['user_info_id']?>]" /><?echo @$v['value']['value']?></textarea></dd></dl>
		<?}?> <?if(@$v['UserInfo']['type'] == "select"){?>
		<dl><dt class="config_lang"><?echo @$v['UserInfo']['name']?>：</dt>
		       <input id="ValueId" name="info_value_id[<?echo @$v['value']['user_info_id']?>]" type="hidden" value="<?echo $v['UserInfo']['id']?>">
			<dd>
			<?$one_arr = explode(";",$v['UserInfo']['values']);?>
			<select class="text_inputs" style="width:265px;" name="info_value[<?echo @$v['UserInfo']['id']?>]" >
			<?foreach($one_arr as $kkk=>$vvv){$two_arr = explode(":",$vvv);?>
				<option value="<?=$two_arr[0]?>" <?if(@$v['value']['value']==$two_arr[0]){echo "selected";}?>><?=$two_arr[1]?></option>
			<?}?>
			</select>
	</dd></dl>
		<?}?>
				<?}?>
		<?}}?>
	<!--	<dl><dt class="config_lang">信用额度：</dt>
			<dd><input type="text" class="text_inputs" style="width:115px;" /></dd></dl>	-->
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;padding-top:25px;">
<!--Password-->
	<div class="order_stat athe_infos tongxun">
	  
	  <div class="box">
		
		<dl><dt>新密码：</dt>
			<dd><input type="password" class="text_inputs" style="width:270px;" id="user_new_password" name="data[User][new_password]"/> <font color="#F94671">*</font></dd></dl>
		<dl><dt>重复新密码：</dt>
			<dd><input type="password" class="text_inputs" style="width:270px;" id="user_new_password2" name="data[User][new_password2]"/> <font color="#F94671">*</font></dd></dl>
	  </div>
	</div>
<!--Password End-->

<!--Bankcroll-->
	<div class="order_stat athe_infos tongxun" style="margin-top:13px;_margin-top:14px;">
	  
	  <div class="box">
		<dl class="bankcroll">
			<dt>可用资金:</dt>
			<dd class="best_input" style="width:50%;">
			<span style="width:50%;float:left;"><font><?=$this->data['User']['balance'];?></font>
			<font face="tahoma">[<?=$html->link("查看明细","/balances/?user_id={$this->data['User']['id']}",'',false,false);?>]</font></span>
			<font style="float:left;"><input type="radio" name="balance_type" value="1" checked>加
			<input type="radio" name="balance_type" value="0">减
			<input type="text" class="text_inputs" style="width:50px;" id="user_balance" name="balance" value="0"/></font>
			</dd>
		</dl>
		<dl class="bankcroll">
			<dt>冻结资金:</dt>
			<dd class="best_input" style="width:50%;">
			<span style="width:50%;float:left;"><font><?=$this->data['User']['frozen'];?></font>
			<font face="tahoma">[<?=$html->link("查看明细","/balances/?user_id={$this->data['User']['id']}",'',false,false);?>]</font></span>
			<font style="float:left;"><input type="radio" name="frozen_type" value="1" checked>加
			<input type="radio" name="frozen_type" value="0">减
			<input type="text" class="text_inputs" style="width:50px;" id="user_frozen" name="frozen" value="0"/></font>
			</dd></dl>
		<dl class="bankcroll">
			<dt>消费积分:</dt>
			<dd class="best_input" style="width:50%;">
			<span style="width:50%;float:left;"><font><?=$this->data['User']['point'];?></font>
			<font face="tahoma">[<?=$html->link("查看明细","/points/?user_id={$this->data['User']['id']}",'',false,false);?>]</font></span>
			<font style="float:left;"><input type="radio" name="point_type" value="1" checked>加
			<input type="radio" name="point_type" value="0">减
			<input type="text" class="text_inputs" style="width:50px;" id="user_point" name="point" value="0"/></font>
			</dd>
		</dl>
		<dl class="bankcroll">
			<dt>等级积分:</dt>
			<dd>
			<font>0</font>
			<font face="tahoma">[<?=$html->link("查看明细","/memberlevels/",'',false,false);?>]</font></dd></dl>	
		<dl class="bankcroll"><dt>注册时间:</dt>
			<dd><?echo $this->data['User']['created'];?> </dd></dl>
		<dl class="bankcroll"><dt>最后登录时间:</dt>
			<dd><?echo $this->data['User']['last_login_time'];?> </dd></dl>
	  </div>
	</div>
<!--Bankcroll End-->
</td>
</tr>
<tr><td colspan="2"><p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p></td></tr>
</table>
<? echo $form->end();?>
<!--Addresse List-->
	<div class="order_stat operators">
	  <div class="title">
	  <h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  收货地址</h1></div>
	  <div class="box users_configs">
  	    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="pay_addresse">
		<tr>
			<th width="24%">收货人</th><th width="28%">地址</th><th width="30%">联系方式</th><th width="17%">其他</th>
		</tr>
		<tr>
			<td align="center" width="24%"><?echo $user_address['UserAddress']['consignee']?></td>
			<td width="28%"><p>
			</p><p><?echo $user_address['UserAddress']['address']?></p></td>
			<td width="30%"><p>电话：<?echo $user_address['UserAddress']['telephone']?></p><p>手机：<?echo $user_address['UserAddress']['mobile']?></p><p>Email：<?echo $user_address['UserAddress']['email']?></p></td>
			<td width="17%"><p>最佳送时间：<?echo $user_address['UserAddress']['best_time']?></p><p>标志建筑：<?echo $user_address['UserAddress']['sign_building']?></p></td>
		</tr>
		</table>
		
	  </div>
	  </div>
<!--Addresse List End-->
<br />
<!--Orders List-->
	<div class="order_stat operators">
	  <div class="title">
	  <h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  订单列表</h1></div>
	  <div class="box users_configs">
  	    <ul class="orders_title">
	<li class="number">订单号</li><li class="time">下单时间</li><li class="take_over">收货人</li><li class="expenses">费用</li><li class="payment">支付方式</li><li class="deliver">配送方式</li><li class="state">订单状态</li><li class="hadle">操作</li></ul>
<!--List Start-->
<?if(isset($orders_list) && sizeof($orders_list)){?>
	  <?foreach($orders_list as $k=>$v){?>
	<ul class="orders_title orders-list">
	<li class="number"><?=$html->link($v['Order']['order_code'],"/orders/".$v['Order']['id'],array('target'=>'_blank'),false,false);?></li>
	<li class="time">
		<span><?echo $v['Order']['consignee']?></span>
		<span><?echo $v['Order']['created']?></span></li>
	<li class="take_over">
		<span><?echo $v['Order']['consignee']?>[TEL:<?echo $v['Order']['telephone']?>]</span>
		<span><?echo $v['Order']['address']?></span></li>
	<li class="expenses">
		<span>总金额: <?echo $v['Order']['subtotal']?></span>
		<span>应付金额:<?echo $v['Order']['should_pay']?></span></li>
		<li class="payment"><?echo $v['Order']['payment_name']?></li>
		<li class="deliver"><?echo $v['Order']['shipping_name']?></li>
		<li class="state"><?if($v['Order']['status'] == 0){?>未确认&nbsp;<?}elseif($v['Order']['status'] == 1){?>已确认&nbsp;<?}elseif($v['Order']['status'] == 2){?>已取消&nbsp;<?}elseif($v['Order']['status'] == 3){?>无效&nbsp;<?}elseif($v['Order']['status'] == 4){?>退货&nbsp;<?}?>
		<?if($v['Order']['payment_status'] == 0){?>未付款&nbsp;<?}elseif($v['Order']['payment_status'] == 1){?>付款中&nbsp;<?}elseif($v['Order']['payment_status'] == 2){?>已付款&nbsp;<?}?>
		<?if($v['Order']['shipping_status'] == 0){?>未发货&nbsp;<?}elseif($v['Order']['shipping_status'] == 1){?>已发货&nbsp;<?}elseif($v['Order']['shipping_status'] == 2){?>已收货&nbsp;<?}elseif($v['Order']['shipping_status'] == 3){?>备货中&nbsp;<?}?></li>
		<li class="hadle"><?=$html->link("查看","/orders/{$v['Order']['id']}",array('target'=>'_blank'),false,false);?></li></ul>
<?}}?>		

		<p style="clear:both;"></p>
	  </div>
	  </div>
<!--Orders List End-->
<br />
<!--bankcrollLog List-->
	<div class="order_stat operators">
	  <div class="title">
	  <h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  资金日志</h1></div>
	  <div class="box users_configs">
  	    <ul class="product_llist procurements">
		<li class="name">金额</li>
		<li class="number">时间</li>
		<li class="item_number">操作类型</li>
		<li><p>备注</p></li>
		</ul>
<?if(isset($balances_list) && sizeof($balances_list)){?>
<?foreach($balances_list as $k=>$v){?>
	<ul class="product_llist procurements procurements_list">
	<li class="name"><?echo $v['UserBalanceLog']['amount'];?></li>
	<li class="number"><?echo $v['UserBalanceLog']['created'];?></li>
	<li class="item_number"><?if($v['UserBalanceLog']['log_type'] == 'O'){?>订单号<?}elseif($v['UserBalanceLog']['log_type'] == 'B'){?>充值<?}elseif($v['UserBalanceLog']['log_type'] == 'R'){?>退款<?}elseif($v['UserBalanceLog']['log_type'] == 'A'){?>管理员操作<?}?></li>
	<li><p><?echo $v['UserBalanceLog']['system_note'];?></p></li>
	</ul>
<?}}?>
	  </div>
	  </div>
<!--bankcrollLog List End-->
<br />
<!--IntegralLog List-->
	<div class="order_stat operators">
	  <div class="title">
	  <h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  积分日志</h1></div>
	  <div class="box users_configs">
  	    <ul class="product_llist procurements">
		<li class="name">兑换我的积分</li>
		<li class="number">兑换时间</li>
		<li class="item_number">操作类型</li>
		<li><p>备注</p></li>
	</ul>
	<?if(isset($points_list) && sizeof($points_list)>0){?>
<?foreach($points_list as $k=>$v){?>
	<ul class="product_llist procurements procurements_list">
	
	<li class="name"><?echo $v['UserPointLog']['point'];?></li>
	<li class="number"><?echo $v['UserPointLog']['created'];?></li>
	<li class="item_number"><?if($v['UserPointLog']['log_type'] == 'R'){?>注册赠送<?}elseif($v['UserPointLog']['log_type'] == 'B'){?>订单产生<?}elseif($v['UserPointLog']['log_type'] == 'O'){?>订单使用<?}elseif($v['UserPointLog']['log_type'] == 'A'){?>管理员操作<?}elseif($v['UserPointLog']['log_type'] == 'C'){?>订单返回<?}?></li>
	<li><p><?echo $v['UserPointLog']['system_note'];?></p></li>
	</ul>	
<?}}?>
	  </div>
	  <br />
	  </div>
<!--IntegralLog List End-->
</div>
<!--Main Start End-->
<?=$html->image('content_left.gif',array('class'=>'content_left'))?><?=$html->image('content_right.gif',array('class'=>'content_right'))?>
</div>
		  <!--时间控件层start-->
	<div id="container_cal" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal2" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal2"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal3" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal3"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal4" style="border-top:1px solid #808080;border-bottom:1px solid #808080;display:none">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal4"></div><div style="clear:both;"></div></div>
	</div>
<!--end-->