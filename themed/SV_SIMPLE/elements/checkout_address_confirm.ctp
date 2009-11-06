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
 * $Id: checkout_address_confirm.ctp 3051 2009-07-17 11:51:50Z huangbo $
*****************************************************************************/
?>
<p class="address btn_list border_bottom">
<?php echo $html->link("<span>".$SCLanguages['mmodify']."</span>","/carts/consignee/",array("class"=>"amember"),false,false);?>
<a href="javascript:show_address_edit('<?php echo $svcart['address']['id']?>')" class="amember"><span ><?php echo $SCLanguages['mmodify']?></span></a>
<?php if(isset($addresses_count) && $addresses_count > 1){?>
		<a href="javascript:change_address();" class="amember"><span><?php echo $SCLanguages['rechoose']?></span></a>
<?php }?>
<span class="l"></span><span class="r"></span><?php echo $SCLanguages['consignee'].$SCLanguages['information'];?>:
</p>
<?php if(empty($all_virtual)){?>
<table cellpadding="0" cellspacing="0" class="address_table" border="0" align="center">
<tr><td class="lan-name first"><?php echo $SCLanguages['address'];?><?php echo $SCLanguages['label'];?>:</td><td class="lan-info"><?php echo $svcart['address']['name'];?></td><td class="lan-name" ><?php echo $SCLanguages['region'];?>:</td><td class="lan-info" colspan="3">
	<?php if(isset($svcart['address']['regionI18n'])){?>
	<?php echo $svcart['address']['regionI18n'];?>
	<?php }else{?>
	<?php echo $svcart['address']['regions'];?>
	<?php }?>
	
	</td>
</tr>
<tr>
<td class="lan-name first"><?php echo $SCLanguages['consignee'].$SCLanguages['name'];?>:</td><td class="lan-info"><?php echo $svcart['address']['consignee'];?></td>
<td class="lan-name"><?php echo $SCLanguages['address'];?>:</td><td class="lan-info"><?php echo $svcart['address']['address'];?></td>
</tr>
<tr>
<td class="lan-name first"><?php echo $SCLanguages['mobile'];?>:</td><td class="lan-info"><?php echo $svcart['address']['mobile'];?></td>
<td class="lan-name "><?php echo $SCLanguages['marked_building'];?>:</td><td class="lan-info"><?php echo $svcart['address']['sign_building'];?></td>
</tr>
<tr>
<td class="lan-name first"><?php echo $SCLanguages['telephone'];?>:</td><td class="lan-info"><?php echo $svcart['address']['telephone'];?></td>
<td class="lan-name"><?php echo $SCLanguages['post_code'];?>:</td><td class="lan-info"><?php echo $svcart['address']['zipcode'];?></td>
</tr>
<tr>
<td class="lan-name first"><?php echo $SCLanguages['email'];?>:</td><td class="lan-info"><?php echo $svcart['address']['email'];?></td>
<td class="lan-name"><?php echo $SCLanguages['best_shipping_time'];?>:</td><td class="lan-info"><?php echo $svcart['address']['best_time'];?></td>
</tr>
</table>




<?php }else{?>
<table cellpadding="0" cellspacing="0" class="address_table" border=0 align=center>
<tr><td class="lan-name first"><?php echo $SCLanguages['address'];?><?php echo $SCLanguages['label'];?>:</td><td class="lan-info"><?php echo $svcart['address']['name'];?></td>
	
</tr>
<tr>
<td class="lan-name first"><?php echo $SCLanguages['consignee'].$SCLanguages['name'];?>:</td><td class="lan-info"><?php echo $svcart['address']['consignee'];?></td>

</tr>
<tr>
<td class="lan-name first"><?php echo $SCLanguages['mobile'];?>:</td><td class="lan-info"><?php echo $svcart['address']['mobile'];?></td>
</tr>
<tr>
<td class="lan-name first"><?php echo $SCLanguages['telephone'];?>:</td><td class="lan-info"><?php echo $svcart['address']['telephone'];?></td>
</tr>
<tr>
<td class="lan-name first"><?php echo $SCLanguages['email'];?>:</td><td class="lan-info"><?php echo $svcart['address']['email'];?></td>
</tr>
</table>
<?php }?>