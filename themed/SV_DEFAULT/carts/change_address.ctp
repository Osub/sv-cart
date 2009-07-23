<?php 
/*****************************************************************************
 * SV-Cart 更改地址
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: change_address.ctp 3195 2009-07-22 07:15:51Z huangbo $
*****************************************************************************/
ob_start();?>
<?php if($result['type'] == 0 ){?>
<h5>
<?php echo $html->link("<span>".$SCLanguages['mmodify']."</span>","javascript:show_address_edit('null')",array("class"=>"amember"),false,false);?>
<?php echo $SCLanguages['please_choose']?><?php echo $SCLanguages['consignee']?><?php echo $SCLanguages['information']?>:
</h5>
<table cellpadding="0" cellspacing="0" class="address_table" border=0 align=center id="checkout_shipping_choice">

<tr>
<td class="lan-name first"><?php echo $SCLanguages['address'];?><?php echo $SCLanguages['label'];?></td>
<td class="lan-name first"><?php echo $SCLanguages['address'];?></td>
<td class="lan-name first"><?php echo $SCLanguages['area'];?></td>
</tr>
<?php if(isset($addresses) && sizeof($addresses)>0){?>
<?php foreach($addresses as $i=>$p){?>
<tr>
<td class="lan-name first"><input type="radio" name="address_id" value="<?php echo $p['UserAddress']['id'];?>" onclick="javascript:confirm_address(<?php echo $p['UserAddress']['id'];?>)" id="address_id<?php echo $p['UserAddress']['id'];?>" class="radio" /><label for="address_id<?php echo $p['UserAddress']['id'];?>"><?php echo $p['UserAddress']['name']?></label></td>
<td class="lan-name first"><?php echo $p['UserAddress']['address']?></td>
<td class="lan-name first"><?php echo $p['UserAddress']['regions']?></td>
</tr>
<?php }?>
<?php }?>
</table>
<?php }else{?>
<?php echo $result['message'];?>
<?php }?>
<?php 
$result['checkout_address'] = ob_get_contents();
ob_end_clean();
ob_start();
?>
<?php if($result['type'] == 0 ){?>
<h5 id="address_btn_list"><?php echo $SCLanguages['shipping_method'];?>:</h5>
<p class="border_b" style='margin:0 10px;' align='center'><br /><br />
	<b>
	<?php echo $SCLanguages['edit_region_or_contact_cs'];?>
	</b>
<br /><br /><br /></p>

<?php }else{?>
<?php echo $result['message'];?>
<?php }?>
<?php 
$result['checkout_shipping'] = ob_get_contents();
ob_end_clean();
ob_start();?>
<?php if($result['type'] == 0 ){?>
<?php echo $this->element('checkout_total', array('cache'=>'+0 hour'));?>
<?php }else{?>
<?php echo $result['message'];?>
<?php }?>
<?php 
$result['checkout_total'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>
