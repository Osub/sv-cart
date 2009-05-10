<?php
/*****************************************************************************
 * SV-Cart 编辑支付方式
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: edit.ctp 1273 2009-05-08 16:49:08Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php  echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<br />
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."支付方式列表","/".$_SESSION['cart_back_url'],'',false,false);?></strong></p>

<div class="home_main">
		
		
<?php echo $form->create('Payment',array('action'=>'edit/'.$payment['Payment']['id'],'onsubmit'=>'return payments_check()'));?>
	
	<input type="hidden" name="data[Payment][id]" value="<?=$payment['Payment']['id']?>"/>

	<table width="100%" cellpadding="0" cellspacing="0" class="">
<tr>
<td align="left" width="50%" valign="top" style="padding-right:5px">
<!--Communication Stat-->
	<div class="order_stat athe_infos department_config">
	  <div class="title"><h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  编辑支付方式</h1></div>
	  <div class="box" style="table-layout:fixed">
	  <br />
	    
  	    <dl><strong style="table-layout:fixed"> 支付方式名称:</strong>
			<dd></dd></dl>

<? if(isset($languages) && sizeof($languages)>0){
 	foreach ($languages as $k => $v){?>
		 <dl><dt class="config_lang"><?=$html->image($v['Language']['img01'])?></dt>
			<dd><input type="text"  class="text_inputs" style="width:195px;" id="name<?=$v['Language']['locale']?>" name="data[PaymentI18n][<?=$k?>][name]" <?if(isset($payment['PaymentI18n'][$v['Language']['locale']])){?>value="<?= $payment['PaymentI18n'][$v['Language']['locale']]['name'];?>"<?}else{?>value=""<?}?>/> <font color="#ff0000">*</font></dd></dl>
<?
	}
}?>	
		
		<dl><strong style="table-layout:fixed">支付方式描述:</strong><dd></dd></dl>

<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
			<dl><dt class="config_lang"><?=$html->image($v['Language']['img01'])?></dt><dd><textarea name="data[PaymentI18n][<?=$k?>][description]"><?if(isset($payment['PaymentI18n'][$v['Language']['locale']])){?><?=$payment['PaymentI18n'][$k]['description']?><?}else{?><?}?></textarea></dd></dl>


<?
	}
}?>	

<dl><dt> 是否有效:</dt>
			<dd></dd></dl>
<? if(isset($languages) && sizeof($languages)>0){
 	foreach ($languages as $k => $v){?>
		 <dl><dt class="config_lang"><?=$html->image($v['Language']['img01'])?></dt>
			<dd><input type="radio" name="data[PaymentI18n][<?=$k?>][status]"   value="1" <?if( $payment['PaymentI18n'][$v['Language']['locale']]['status'] == 1 ){ echo "checked"; }  ?> /> 是 <input type="radio" name="data[PaymentI18n][<?=$k?>][status]" value="0" <?if( $payment['PaymentI18n'][$v['Language']['locale']]['status'] == 0 ){ echo "checked"; }  ?> /> 否<font color="#ff0000">*</font></dd></dl>
<?
	}
}?>	
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<input id="PaymentI18n<?=$k;?>Locale" name="data[PaymentI18n][<?=$k;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
	   <?if(isset($payment['PaymentI18n'][$v['Language']['locale']])){?>
	<input id="PaymentI18n<?=$k;?>Id" name="data[PaymentI18n][<?=$k;?>][id]" type="hidden" value="<?= $payment['PaymentI18n'][$v['Language']['locale']]['id'];?>">
	   <?}?>
	   	<input id="PaymentI18n<?=$k;?>PaymentId" name="data[PaymentI18n][<?=$k;?>][payment_id]" type="hidden" value="<?= $payment['Payment']['id'];?>">
<?
	}
}?>

	
	  </div>
	</div>
<!--Communication Stat End-->
</td>
<td valign="top" width="50%" style="padding-left:5px;padding-top:25px;">
<!--Password-->
	<div class="order_stat athe_infos">
	  
	  <div class="box">
		<br />
		  <dl><dt>支付手续费：</dt>
			<dd><input type="text"  class="text_inputs" style="width:120px;" name="data[Payment][fee]" value="<?=$payment['Payment']['fee'] ?>"  /> </dd></dl>
		 <dl><dt class="config_lang">订单是否可用:</dt>
			<dd><input type="radio" name="data[Payment][order_use_flag]"   value="1" <?if( $payment['Payment']['order_use_flag'] == 1 ){ echo "checked"; }  ?> /> 是 <input type="radio" name="data[Payment][order_use_flag]" value="0" <?if( $payment['Payment']['order_use_flag'] == 0 ){ echo "checked"; }  ?> /> 否<font color="#ff0000">*</font></dd></dl>
		 <dl><dt class="config_lang">充值是否可用:</dt>
			<dd><input type="radio" name="data[Payment][supply_use_flag]"   value="1" <?if( $payment['Payment']['supply_use_flag'] == 1 ){ echo "checked"; }  ?> /> 是 <input type="radio" name="data[Payment][supply_use_flag]" value="0" <?if( $payment['Payment']['supply_use_flag'] == 0 ){ echo "checked"; }  ?> /> 否<font color="#ff0000">*</font></dd></dl>

		<dl><dt>货到付款?</dt>
			<dd><input type="radio" name="data[Payment][is_cod]" value="1" <?if( $payment['Payment']['is_cod'] == 1 ){ echo "checked"; }  ?> /> 是 <input type="radio" name="data[Payment][is_cod]" value="0" <?if( $payment['Payment']['is_cod'] == 0 ){ echo "checked"; }  ?> /> 否</dd></dl>
		
		<dl><dt>在线支付?</dt>
			<dd><input type="radio" name="data[Payment][is_online]" value="1" <?if( $payment['Payment']['is_online'] == 1 ){ echo "checked"; }  ?> /> 是 <input type="radio" name="data[Payment][is_online]" value="0" <?if( $payment['Payment']['is_online'] == 0 ){ echo "checked"; }  ?> /> 否</dd></dl>
			<?if(isset($payment_arr) && count($payment_arr)>0){?>
	
			<?foreach($payment_arr as $k=>$v){?>
				<dl><dt><?=$v['name']?>:</dt>
				<dd>
				<?//if($v['type']=="text"){?>
				<input type="text"  class="text_inputs" style="width:120px;" name="payment_arr[<?=$k?>][value]" <?if(isset($v['value'])){?>value="<?= $v['value'];?>"<?}else{?>value=""<?}?>/>
				<?//}?>
				<?if(@$v['type']=="select"){?>
				<select name="payment_arr[<?=$k?>][value]">
				<?  $num = 0;
				if(isset($v['select_value']) && sizeof($v['select_value'])>0){
					foreach($v['select_value'] as $kk=>$vv){?>
				<?if(isset($v['value']) && $v['value'] == $vv){?>
				<option value="<?=$vv?>" selected>
				<?}else{?>
				<option value="<?=$vv?>">
				<?}?>
					<?=$kk?></option>
				<?}}?>
				</select>
					
				<?
				if(isset($v['select_value']) && sizeof($v['select_value'])>0){
					foreach($v['select_value'] as $kk=>$vv){?>
					<?$num++;?>
				<input type="hidden"  class="text_inputs" style="width:120px;" name="payment_arr[<?=$k?>][select_value][<?=$num?>][name]" value="<?=$kk?>"/>
				<input type="hidden"  class="text_inputs" style="width:120px;" name="payment_arr[<?=$k?>][select_value][<?=$num?>][value]" value="<?=$vv?>"/>				
				<?}}?>
				<?}?>
				<input type="hidden"  class="text_inputs" style="width:120px;" name="payment_arr[<?=$k?>][name]" <?if(isset($v['name'])){?>value="<?= $v['name'];?>"<?}else{?>value=""<?}?>/>
				<input type="hidden"  class="text_inputs" style="width:120px;" name="payment_arr[<?=$k?>][type]" <?if(isset($v['type'])){?>value="<?= $v['type'];?>"<?}else{?>value=""<?}?>/>
				</dd></dl>
			<?}?>
		<?}?>
		
		
		<br /><br /><br /><br /><br />	<br /><br /><br /><br /><br />	<br /><br /><br /><br /><br /><br /><br /><br /><br />
		
	  </div>
	</div>
<!--Password End-->

</td>
</tr>
<tr><td colspan="2"><p class="submit_btn"><input type="submit" value="确定" /><input type="reset" value="重置" /></p></td></tr>
</table>
<? echo $form->end();?>

</div>
<!--Main Start End-->
<?=$html->image('content_left.gif',array('class'=>'content_left'))?><?=$html->image('content_right.gif',array('class'=>'content_right'))?>
</div>