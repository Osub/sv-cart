<?php
/*****************************************************************************
 * SV-Cart 结算页用户地址
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: checkout_address.ctp 1232 2009-05-06 12:14:41Z huangbo $
*****************************************************************************/
?>
<p class="address btn_list border_bottom">
<a href="javascript:show_address_edit('<?=$address['UserAddress']['id']?>')" class="amember"><span ><?=$SCLanguages['mmodify']?></span></a>
<?if(isset($addresses_count) && $addresses_count > 1){?>
<a href="javascript:change_address();" class="amember"><span><?=$SCLanguages['rechoose']?></span></a>
<?}?>
<span class="l"></span><span class="r"></span><?php echo $SCLanguages['consignee'].$SCLanguages['information'];?>:
</p>
<?php if(empty($all_virtual)){?>
<table cellpadding="0" cellspacing="0" class="address_table" border="0" align="center">
<tr><td class="lan-name first"><?=$SCLanguages['address'];?><?=$SCLanguages['label'];?>:</td><td class="lan-info"><?=$address['UserAddress']['name'];?></td><td class="lan-name" ><?php echo $SCLanguages['region'];?>:</td><td class="lan-info" colspan="3"><?=$address['UserAddress']['regions'];?></td>
</tr>
<tr>
<td class="lan-name first"><?php echo $SCLanguages['consignee'].$SCLanguages['name'];?>:</td><td class="lan-info"><?=$address['UserAddress']['consignee'];?></td>
<td class="lan-name"><?php echo $SCLanguages['address'];?>:</td><td class="lan-info"><?=$address['UserAddress']['address'];?></td>
</tr>
<tr>
<td class="lan-name first"><?php echo $SCLanguages['mobile'];?>:</td><td class="lan-info"><?=$address['UserAddress']['mobile'];?></td>
<td class="lan-name "><?php echo $SCLanguages['marked_building'];?>:</td><td class="lan-info"><?=$address['UserAddress']['sign_building'];?></td>
</tr>
<tr>
<td class="lan-name first"><?php echo $SCLanguages['telephone'];?>:</td><td class="lan-info"><?=$address['UserAddress']['telephone'];?></td>
<td class="lan-name"><?php echo $SCLanguages['post_code'];?>:</td><td class="lan-info"><?=$address['UserAddress']['zipcode'];?></td>
</tr>
<tr>
<td class="lan-name first"><?php echo $SCLanguages['email'];?>:</td><td class="lan-info"><?=$address['UserAddress']['email'];?></td>
<td class="lan-name"><?php echo $SCLanguages['best_shipping_time'];?>:</td><td class="lan-info"><?=$address['UserAddress']['best_time'];?></td>
</tr>
</table>




<?php }else{?>
<table cellpadding="0" cellspacing="0" class="address_table" border=0 align=center>
<tr><td class="lan-name first"><?=$SCLanguages['address'];?><?=$SCLanguages['label'];?>:</td><td class="lan-info"><?=$address['UserAddress']['name'];?></td>
	
</tr>
<tr>
<td class="lan-name first"><?php echo $SCLanguages['consignee'].$SCLanguages['name'];?>:</td><td class="lan-info"><?=$address['UserAddress']['consignee'];?></td>

</tr>
<tr>
<td class="lan-name first"><?php echo $SCLanguages['mobile'];?>:</td><td class="lan-info"><?=$address['UserAddress']['mobile'];?></td>
</tr>
<tr>
<td class="lan-name first"><?php echo $SCLanguages['telephone'];?>:</td><td class="lan-info"><?=$address['UserAddress']['telephone'];?></td>
</tr>
<tr>
<td class="lan-name first"><?php echo $SCLanguages['email'];?>:</td><td class="lan-info"><?=$address['UserAddress']['email'];?></td>
</tr>
</table>
<?php }?>