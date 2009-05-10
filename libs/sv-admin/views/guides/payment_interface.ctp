<?if(isset($payment_arr) && count($payment_arr)>0){?>
	
			<?foreach($payment_arr as $k=>$v){?>
				<dl><dt><?=$v['name']?>:</dt>
				<dd>
				<input type="text"  class="text_inputs" style="width:120px;" name="payment_arr[<?=$k?>][value]" <?if(isset($v['value'])){?>value="<?= $v['value'];?>"<?}else{?>value=""<?}?>/>
				<input type="hidden"  class="text_inputs" style="width:120px;" name="payment_arr[<?=$k?>][name]" <?if(isset($v['name'])){?>value="<?= $v['name'];?>"<?}else{?>value=""<?}?>/>
				</dd></dl>
			<?}?>
		<?}?>