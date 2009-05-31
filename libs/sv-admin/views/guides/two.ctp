<?php
/*****************************************************************************
 * SV-Cart 商店设置向导
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: two.ctp 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
?>
<?=$javascript->link('shipping');?>
<?php echo $form->create('guides',array('action'=>'/three/'));?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start-->
<br />
<div class="home_main" id="guides_1">
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	<?=$html->image('tab_left.gif',array('class'=>'left'))?>
	<?=$html->image('tab_right.gif',array('class'=>'right'))?>
	设置支付方式及配送方式</h1></div>
	<div class="box">
	<div class="shop_config menus_configs">
	
	<dl><dt style="width:350px;">配送方式： </dt>
	<dd>
	<select name="data[ShippingArea][ShippingArea][shipping_id]" style="width:100px;"  onchange="shipping_config(this)" >
		<option value="">请选择...</option>
<? if(isset($shipping_info) && sizeof($shipping_info)>0){
	 foreach( $shipping_info as $k=>$v ){?>
		<option value="<?=$v['Shipping']['id']?>"><?=$v['Shipping']['name']?></option>
	<?}}?>
	</select>
	</dd>
		
	</dl>
	
	<span id="sipping_none_block" style="display:none">
	<dl><dt style="width:415px;">区域名称:</dt>
	<dd></dd></dl>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
	<dl><dt style="width:415px;"><?=$html->image($v['Language']['img01'])?></dt>
	<dd>
	<input name="data[ShippingArea][ShippingAreaI18n][<?=$k?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">

	<input name="data[ShippingArea][ShippingAreaI18n][<?=$k?>][name]" type="text" style="width:120px;*width:180px;border:1px solid #649776" />
	</dd>
	</dl>
<?}}?>
	<dl><dt style="width:415px;">区域:</dt>
	<dd>
	<div><span id="regions"></span><span id="region_loading" style="display:none;"><?=$html->image('regions_loader.gif')?></span>
</div>
		<?=$javascript->link('regions');?>
	        <script type="text/javascript">show_regions("");</script>

		</dd>
	</dl>
	<dl><dt style="width:415px;">1000克以内费用:</dt>
	<dd>
	<input name="money[][value]" type="text" style="width:120px;*width:180px;border:1px solid #649776" />
	<input name="money[][value]" type="hidden" value="0" style="width:120px;*width:180px;border:1px solid #649776" />
	<input name="money[][value]" type="hidden" value="0" style="width:120px;*width:180px;border:1px solid #649776" />
	
	</dd>
	</dl>
	<dl><dt style="width:415px;">免费额度:</dt>
	<dd>
	<input name="data[ShippingArea][ShippingArea][free_subtotal]" type="text" style="width:120px;*width:180px;border:1px solid #649776" /><br /><br />
	</dd>
	</dl>
	</span>

	<dl><dt style="width:350px;">支付方式： </dt>
	<dd>
	<select name="payment_arrs[payment_arr][id]" onchange="payment_config(this)" style="width:100px;" >
		<option value="">请选择...</option>
<? if(isset($payment_info) && sizeof($payment_info)>0){
	foreach( $payment_info as $k=>$v ){?>
		<option value="<?=$v['Payment']['id']?>"><?=$v['Payment']['name']?></option>
	<?}}?>
	</select>
	
	</dd>
	</dl>
		
	<?foreach( $payment_info as $kkk=>$vvv){eval($vvv['Payment']['config']);?>
		<a id="payment_inputs_<?=$vvv['Payment']['id']?>" name="paynone[]" style="display:none;text-decoration:none" >
			<dl><dt style="width:415px;">支付方式描述:</dt>
			<dd></dd></dl>
<? if(isset($languages) && sizeof($languages)>0){
	foreach ($languages as $k => $v){?>
		<dl><dt style="width:415px;"><?=$html->image($v['Language']['img01'])?></dt>
		<dd><textarea name="data[PaymentI18n][<?=$kkk?>][<?=$vvv['PaymentI18n'][$v['Language']['locale']]['id']?>][description]" style="*width:180px;border:1px solid #649776"><?=@$vvv['PaymentI18n'][$v['Language']['locale']]['description']?></textarea></dd></dl>
<?}}?>
			<?if(isset($payment_arr) && count($payment_arr)>0){?>
				<?foreach($payment_arr as $k=>$v){?>
					<dl><dt style="width:415px;"><?=$v['name']?>:</dt>
					<dd>
					<input type="text"  class="text_inputs" style="width:120px;" name="payment_arr[<?=$k?>][value]" <?if(isset($v['value'])){?>value="<?= $v['value'];?>"<?}else{?>value=""<?}?>  />
					<input type="hidden"  class="text_inputs" style="width:120px;"  name="payment_arr[<?=$k?>][name]" <?if(isset($v['name'])){?>value="<?= $v['name'];?>"<?}else{?>value=""<?}?>  />
					<input type="hidden"  class="text_inputs" style="width:120px;"  name="payment_arr[<?=$k?>][id]" <?if(isset($vvv['Payment']['id'])){?>value="<?=$vvv['Payment']['id'];?>"<?}else{?>value=""<?}?>  />
					</dd></dl>
				<?}?>
			<? $payment_arr=array();}?>
		</a><?}?>
	</div>
	</div>
	<p class="submit_btn"><input type="button" value="上一步" onclick="history.go(-1)" /><input type="submit" value="下一步"  /><input type="button" value="退出向导" onclick="break_config()" /></p>
	</div>
</div>
<? echo $form->end();?>
<script type="text/javascript">
	//配送方式


window.onload = function(){
	region_country('country');
}
function shipping_config(obj){
	var shipping_ment = document.getElementById('sipping_none_block');
	if(obj.value!=""){
		shipping_ment.style.display = "block";
	}else{
		shipping_ment.style.display = "none";
	}
}

//支付方式
function payment_config(obj){
	var paynone = document.getElementsByName('paynone[]');
	for( var i=0;i<paynone.length;i++ ){
		paynone[i].style.display = 'none';
	}
	document.getElementById('payment_inputs_'+obj.value).style.display="block";
	
	
	
}
</script>