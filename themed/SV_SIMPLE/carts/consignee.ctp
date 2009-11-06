<?php 
/*****************************************************************************
 * SV-Cart 非ajax 修改地址用
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: consignee.ctp 3051 2009-07-17 11:51:50Z huangbo $
*****************************************************************************/
?>
<?php echo $minify->js(array('/js/yui/yahoo-dom-event.js','/js/yui/container_core-min.js','/js/yui/element-beta-min.js','/js/yui/connection-min.js','/js/yui/json-min.js','/js/yui/yahoo-min.js',$this->themeWeb.'js/regions.js',$this->themeWeb.'js/common.js'));?>
<?php echo $javascript->link('cart');?>
<div class="consignee">
<?php if(isset($addresses) && sizeof($addresses)>0){?>
<table cellpadding="5" cellspacing="1" class="table_data" width="100%" align="center" id="checkout_shipping_choice">
<tr>
	<td colspan="4"><strong><?php echo $SCLanguages['consignee'].$SCLanguages['information'];?></strong></td>
</tr>
<tr class="rows">
	<th width="25%"><?php echo $SCLanguages['address'];?><?php echo $SCLanguages['label'];?></th>
	<th width="40%"><?php echo $SCLanguages['address'];?></th>
	<th width="25%"><?php echo $SCLanguages['area'];?></th>
	<th width="10%"><?php echo $SCLanguages['operation']?></th>
</tr>
					
<?php foreach($addresses as $i=>$p){?>
<tr class="rows">
	<td><?php echo $p['UserAddress']['name']?></td>
	<td><?php echo $p['UserAddress']['address']?></td>
	<td><?php echo $p['UserAddress']['regions']?></td>
	<td align="center"><?php echo $html->link($SCLanguages['mmodify'],"/carts/consignee/".$p['UserAddress']['id'],array(),false,false);?> <?php echo $html->link($SCLanguages['select'],"/carts/confirm_address/".$p['UserAddress']['id']."/1",array(),false,false);?></td>
</tr>
<?php }?>
</table>
<br />
<?php }?>
<!-- 修改或增加地址 -->	

<?php echo $form->create('carts',array('action'=>'edit_address_act','name'=>'edit_address_act_update','type'=>'POST'));?>
<table cellpadding="5" cellspacing="1" class="table_data" align="center" width="100%">
<tr>
	<td colspan="4"><strong><?php echo $SCLanguages['consignee'].$SCLanguages['information'];?></strong></td>
</tr>
<tr class="rows">
	<td width="15%"><?php echo $SCLanguages['address'];?><?php echo $SCLanguages['label'];?>:</td>
	<td width="35%"><input size="30" name="data[address][name]" id="EditAddressName" value="<?php echo isset($address['UserAddress']['name'])?$address['UserAddress']['name']:'';?>">&nbsp;<font id="edit_address_name" color="red">*</font></td>
	<td width="15%"><?php echo $SCLanguages['region'];?>:</td>
	<td width="35%"><span id="regionsupdate"></span>
	<span id="update_region_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span>
	<font id="edit_address_regions" color="red">*</font></td>
</tr>
<tr class="rows">
	<td><?php echo $SCLanguages['consignee'].$SCLanguages['name'];?>:</td>
	<td><input size="30" name="data[address][consignee]" id="EditAddressConsignee" value="<?php echo isset($address['UserAddress']['consignee'])?$address['UserAddress']['consignee']:'';?>">&nbsp;<font id="edit_address_consignee" color="red">*</font>&nbsp;</td>
	<td><?php echo $SCLanguages['address'];?>:</td>
	<td><input size="30" name="data[address][address]" id="EditAddressAddress" value="<?php echo isset($address['UserAddress']['address'])?$address['UserAddress']['address']:'';?>">&nbsp;<font id="edit_address_address" color="red">*</font>&nbsp;</td>
</tr>
<tr class="rows">
	<td><?php echo $SCLanguages['mobile'];?>:</td>
	<td><input size="30" name="data[address][mobile]"  onKeyUp="is_int(this);" id="EditAddressMobile" value="<?php echo isset($address['UserAddress']['mobile'])?$address['UserAddress']['mobile']:'';?>">&nbsp;<font id="edit_address_mobile" color="red">*</font></td>
	<td><?php echo $SCLanguages['marked_building'];?>:</td>
	<td><input size="30" name="data[address][sign_building]" id="EditAddressSignBuilding" value="<?php echo isset($address['UserAddress']['sign_building'])?$address['UserAddress']['sign_building']:'';?>"></td>
</tr>
<tr class="rows">
	<td><?php echo $SCLanguages['telephone'];?>:
	</td>
	<td>
	<input type="text" name="user_tel0" id="tel_0" size="30"  onKeyUp="is_int(this);" value="<?php if(isset($address['UserAddress']['telephone'])){echo $address['UserAddress']['telephone'];}?>"/>&nbsp;<font color="red" id="edit_address_telephone">*</font>&nbsp;</td>
	<td><?php echo $SCLanguages['post_code'];?>:</td>
	<td><input size="30" name="data[address][zipcode]" id="EditAddressZipcode" value="<?php echo isset($address['UserAddress']['zipcode'])?$address['UserAddress']['zipcode']:'';?>"></td>
</tr>
<tr class="rows">
	<td><?php echo $SCLanguages['email'];?>:</td>
	<td><input size="30" name="data[address][email]" id="EditAddressEmail" value="<?php echo isset($address['UserAddress']['email'])?$address['UserAddress']['email']:'';?>">&nbsp;<font color="red" id="edit_address_email">*</font></td>
	<td><?php echo $SCLanguages['best_shipping_time'];?>:</td>
	<td>
		<input size="30" name="data[address][best_time]" id="EditAddressBestTime" value="<?php echo isset($address['UserAddress']['best_time'])?$address['UserAddress']['best_time']:'';?>">
		<input type='hidden' name="data[address][id]" id="EditAddressId" value="<?php echo isset($address['UserAddress']['id'])?$address['UserAddress']['id']:'';?>"/>
	</td>
</tr>
<tr class="rows">
	<td colspan="4">
	<span class="submit">
	<?php echo $html->link($SCLanguages['confirm'],"javascript:edit_address_no_ajax('update');",array(),false,false)?>
	</span>
	</td>
</tr>
</table>
<?php echo $form->end();?>	
</div>
<script type="text/javascript">
<?php if(isset($address['UserAddress']['regions'])){?>
var regions_add = <?php echo "'".$address['UserAddress']['regions']."'"?>;
<?php }else{?>
var regions_add =  '';
<?php }?>
show_two_regions(regions_add);
</script>							
