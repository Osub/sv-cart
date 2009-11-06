<?php 
/*****************************************************************************
 * SV-Cart 结算页促销商品选定
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_promotion_confirm.ctp 3949 2009-08-31 07:34:05Z huangbo $
*****************************************************************************/
?>
<h5>
<a href="javascript:change_promotion();" class="amember"><span><?php echo $SCLanguages['mmodify']?></span></a>
<?php echo $SCLanguages['promotion'].$SCLanguages['activity'];?>：
</h5>
<table cellpadding="0" cellspacing="0" class="address_table" width="100%">
    <tr>
    <td width="30%" class="lan-name first" colspan="2"><strong><?php echo $SCLanguages['title'];?></strong></td>
    <td width="35%" class="lan-name"><strong><?php echo $SCLanguages['content'];?></strong></td>
    <td width="15%" class="lan-name"><strong><?php echo $SCLanguages['type'];?></strong></td>
    <td width="20%" class="lan-name"><strong><?php echo $SCLanguages['favorable_content'];?></strong></td>
    </tr>
    <tr>
    <td class="lan-name first" colspan="2"><?php echo $svcart['promotion']['title'];?> </td>
    <td class="lan-name"><?php echo $svcart['promotion']['meta_description'];?> </td>
    <td class="lan-name">
    <?php if($svcart['promotion']['type'] == 0){echo $SCLanguages['save_to_market_price'];}?>
    <?php if($svcart['promotion']['type'] == 1){echo $SCLanguages['discount'];}?>
    <?php if($svcart['promotion']['type'] == 2){echo $SCLanguages['favorable_products'];}?>
    </td>
    <td class="lan-name">	
    <?php if($svcart['promotion']['type'] == 0){echo "-";?>
    	<?//php echo $svshow->price_format($svcart['promotion']['promotion_fee'],$SVConfigs['price_format']);?>
    		
		<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
			<?php echo $svshow->price_format($svcart['promotion']['promotion_fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
		<?php }else{?>
			<?php echo $svshow->price_format($svcart['promotion']['promotion_fee'],$this->data['configs']['price_format']);?>	
		<?php }?>
				
    <?php }?>
    <?php if($svcart['promotion']['type'] == 1){echo $svcart['promotion']['promotion_fee']."%";}?>
	<?php if(isset($svcart['promotion']['Promotion']['type']) && $svcart['promotion']['Promotion']['type'] == 2){?>
<?php printf($SCLanguages['chosen_products'],$svcart['promotion']['Promotion']['type_ext']);?>
	</td> 
	</tr>
	<?php if(isset($svcart['Product_by_Promotion']) && sizeof($svcart['Product_by_Promotion'])>0){?>
	<?php foreach($svcart['Product_by_Promotion'] as $kk=>$vv){ ?>
	<tr>
	    <td class="lan-name first" colspan="2"><?php echo $vv['ProductI18n']['name'];?></td>
	    <td class="lan-name">
		<?php echo $vv['Product']['attr'];?>
	    </td>
   	    <td class="lan-name"></td>   
	    <td class="lan-name"><?php echo $SCLanguages['original_price'];?>
	    <?//php echo $svshow->price_format($vv['Product']['market_price'],$SVConfigs['price_format']);?>
		<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
			<?php echo $svshow->price_format($vv['Product']['market_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
		<?php }else{?>
			<?php echo $svshow->price_format($vv['Product']['market_price'],$this->data['configs']['price_format']);?>	
		<?php }?>	    
	     -<?php echo $SCLanguages['current_price'];?>
	    
	    <?//php echo $svshow->price_format($vv['Product']['now_fee'],$SVConfigs['price_format']);?>
		<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
			<?php echo $svshow->price_format($vv['Product']['now_fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
		<?php }else{?>
			<?php echo $svshow->price_format($vv['Product']['now_fee'],$this->data['configs']['price_format']);?>	
		<?php }?>	    	
	    	
	    	</td>
    </tr>
	<?php }?>
	<?php }?>
	
	<?php if(isset($svcart['promotion']['products']) && sizeof($svcart['promotion']['products'])){?>
	<?php foreach($svcart['promotion']['products'] as $key=>$value){ ?>
	<tr>
	    <td class="lan-name first" width="15"><input id="product_radios<?php echo $key?>" type="checkbox" name="product_id" value="<?php echo $value['Product']['id'];?>" onclick="javascript:add_promotion_product(<?php echo $svcart['promotion']['id']?>,<?php echo $value['Product']['id'];?>,<?php echo $value['Product']['now_fee']?>,'<?php echo $value['ProductI18n']['name']?>');" style='margin:-3px 3px 0 0;vertical-align:middle' /></td>
	    <td class="lan-name"><?php echo $value['ProductI18n']['name'];?></td>
	    <td class="lan-name">
	    	    			  		 
	    	    <?php if(isset($promotion_product_attribute_lists[$value['Product']['id']])){?>
	    	    	 <?php $txt = 0;?>
	  				<?php foreach($promotion_product_attribute_lists[$value['Product']['id']] as $x=>$b){
	  					if(sizeof($b)>1){
	  					echo $x;?>
	  					<select id="attr_<?php echo $svcart['promotion']['id'];?>_<?php echo $value['Product']['id'];?>_<?php echo $txt;?>">
	  						<?php foreach($b as $c=>$d){?>
	  						<option value="<?php echo $d['ProductAttribute']['product_type_attribute_value'];?>">
	  						<?php echo $d['ProductAttribute']['product_type_attribute_value'];?></option><?php  }$txt++;}?></select>
	  				<?php }}?>
	    
	    </td>
   	    <td class="lan-name"></td>   
	    <td class="lan-name"><?php echo $SCLanguages['original_price'];?>
	    	<?//php echo $svshow->price_format($value['Product']['market_price'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($value['Product']['market_price']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($value['Product']['market_price'],$this->data['configs']['price_format']);?>	
			<?php }?>		    	
	    	 -<?php echo $SCLanguages['current_price'];?>
	    	<?//php echo $svshow->price_format($value['Product']['now_fee'],$SVConfigs['price_format']);?>
	    		
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
				<?php echo $svshow->price_format($value['Product']['now_fee']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
				<?php echo $svshow->price_format($value['Product']['now_fee'],$this->data['configs']['price_format']);?>	
			<?php }?>		    		 
	    		 
	   </td>
    </tr>
	<?php }?>
	<?php }?>
	
<?php }?>
</table>
<br />