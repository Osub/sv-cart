<?php 
/*****************************************************************************
 * SV-Cart 结算页促销商品
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_promotion.ctp 4078 2009-09-04 11:42:15Z huangbo $
*****************************************************************************/
?>
<h5 style="margin-top:2px;"><?php echo $SCLanguages['promotion'].$SCLanguages['activity'];?>:</h5>
<table cellpadding="0" cellspacing="0" class="address_table" width="100%" style="border:none;">
    <tr>
    <td class="lan-name first border_bottom" width="30%" colspan="2"><strong><?php echo $SCLanguages['title'];?></strong></td>
    <td class="lan-name border_bottom" width="35%"><strong><?php echo $SCLanguages['content'];?></strong></td>
    <td class="lan-name border_bottom" width="15%"><strong><?php echo $SCLanguages['type'];?></strong></td>
    <td class="lan-name border_bottom" width="20%"><strong><?php echo $SCLanguages['favorable_content'];?></strong></td>
    </tr>
    
    <?php if(isset($promotions) && sizeof($promotions)>0){?>
    <?php foreach($promotions as $k=>$v){?>
    <tr>
	    <td class="lan-name first" colspan="2"><?php if($v['Promotion']['type'] == 0 || $v['Promotion']['type'] == 1){?><label for="radios<?php echo $k?>"><input id="radios<?php echo $k?>" type="radio" name="address_id" value="<?php echo $v['Promotion']['id'];?>" onclick="javascript:confirm_promotion(<?php echo $v['Promotion']['type'];?>,<?php echo $v['Promotion']['id']?>,<?php echo $v['Promotion']['type_ext']?>,'<?php echo $v['PromotionI18n']['title']?>','<?php echo $v['PromotionI18n']['meta_description']?>');" style='margin:-3px 3px 0 0;vertical-align:middle' /> <?php echo $v['PromotionI18n']['title'];?></label><?php }else{?><?php echo $v['PromotionI18n']['title'];?><?}?></td>
	    <td class="lan-name"><?php echo $v['PromotionI18n']['meta_description'];?> </td>
	    <td class="lan-name">
	    <?php if($v['Promotion']['type'] == 0){echo $SCLanguages['save_to_market_price'];}?>
	    <?php if($v['Promotion']['type'] == 1){echo $SCLanguages['discount'];}?>
	    <?php if($v['Promotion']['type'] == 2){echo $SCLanguages['favorable_products'];}?>
	    </td>
	    <td class="lan-name">
	    <?php if($v['Promotion']['type'] == 0){
	    echo "-"?>
		<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
		<?php echo $svshow->price_format($v['Promotion']['type_ext']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>
		<?php }else{?>
		<?php echo $svshow->price_format($v['Promotion']['type_ext'],$this->data['configs']['price_format']);?>	
		<?php }?></td>
	    <?php }?>
	    <?php if($v['Promotion']['type'] == 1){echo $v['Promotion']['type_ext']."% </td>";}?>
	    <?php if(isset($v['products']) && count($v['products'])>0){?>
		<?php if($v['Promotion']['type'] == 2){?>
		<?php printf($SCLanguages['chosen_products'],$v['Promotion']['type_ext']);?></td>
	</tr>
	<?php if(isset($v['products']) && sizeof($v['products'])>0){?>
	<?php foreach($v['products'] as $key=>$value){ ?>
	<tr>
	    <td class="lan-name first" width="15"><input id="product_radios<?php echo $key?>" type="checkbox" name="product_id" value="<?php echo $value['Product']['id'];?>" onclick="javascript:add_promotion_product(<?php echo $v['Promotion']['id']?>,<?php echo $value['Product']['id'];?>,<?php echo $value['Product']['now_fee']?>,'<?php echo $value['ProductI18n']['name']?>');" style='margin:-3px 3px 0 0;vertical-align:middle' /></td>
	    <td class="lan-name"><?php echo $value['ProductI18n']['name'];?></td>
	    <td class="lan-name"><?php $txt = 0;?>
	    <?php if(isset($promotion_product_attribute_lists[$value['Product']['id']])){?>
	  		<?php foreach($promotion_product_attribute_lists[$value['Product']['id']] as $x=>$b){
	  			if(sizeof($b)>1){
	  			echo $x;?>
	  			<select id="attr_<?php echo $v['Promotion']['id'];?>_<?php echo $value['Product']['id'];?>_<?php echo $txt;?>">
	  			<?php foreach($b as $c=>$d){?>
	  			<option value="<?php echo $x.':'.$d['ProductAttribute']['product_type_attribute_value'];?>">
	  			<?php echo $d['ProductAttribute']['product_type_attribute_value'];?></option><?php  }?></select><?$txt++;}?>
	  	<?php }}?></td>
   	    <td class="lan-name">&nbsp;</td>
	    <td class="lan-name"><strike><?php echo $SCLanguages['original_price'];?>
	<?//php echo $svshow->price_format($value['Product']['market_price'],$SVConfigs['price_format']);?>
		<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
			<?php echo $svshow->price_format($value['Product']['market_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>
		<?php }else{?>
			<?php echo $svshow->price_format($value['Product']['market_price'],$this->data['configs']['price_format']);?>	
		<?php }?>
		</strike>
		<br /><?php echo $SCLanguages['current_price'];?>
	<?//php echo $svshow->price_format($value['Product']['now_fee'],$SVConfigs['price_format']);?>	
		<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
		<?php echo $svshow->price_format($value['Product']['now_fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>
		<?php }else{?>
		<?php echo $svshow->price_format($value['Product']['now_fee'],$this->data['configs']['price_format']);?>
		<?php }?></td>
    </tr>
	<?php }?>
	<?php }?>
	<?php }}?>
	</tr>
<?php }}?>
</table>
<br />