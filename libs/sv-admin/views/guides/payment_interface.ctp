<?php if(isset($payment_arr) && count($payment_arr)>0){?>
	
			<?php foreach($payment_arr as $k=>$v){?>
				<dl><dt><?php echo $v['name']?>:</dt>
				<dd>
				<input type="text"  class="text_inputs" style="width:120px;" name="payment_arr[<?php echo $k?>][value]" <?php if(isset($v['value'])){?>value="<?php echo  $v['value'];?>"<?php }else{?>value=""<?php }?>/>
				<input type="hidden"  class="text_inputs" style="width:120px;" name="payment_arr[<?php echo $k?>][name]" <?php if(isset($v['name'])){?>value="<?php echo  $v['name'];?>"<?php }else{?>value=""<?php }?>/>
				</dd></dl>
			<?php }?>
		<?php }?>