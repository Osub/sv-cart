<?php if(isset($languages) && sizeof($languages)>0){foreach ($languages as $kk => $vv){if($vv['Language']['locale']!="chi"){continue;}?>
	
<span id="<?php echo @$vv['Language']['locale'];?>_user_or_order_opencloase_status" <?php if($affiliate_config["ConfigI18n"][$vv["Language"]["locale"]]["value"]['config']['separate_by']!=1){echo "style='display:none'";}?> <?php if($affiliate_config["ConfigI18n"][$vv["Language"]["locale"]]["value"]['on']!=1){echo "style='display:none'";}?>>
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<!--<tr><td align="center"><?php echo $html->image($vv['Language']['img01'])?></td></tr>-->
</table>
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<?php foreach( $affiliate_config['ConfigI18n'][$vv['Language']['locale']]['value']["item"] as $k=>$v){?>

<tr><input type="hidden" name="data[<?php echo $vv['Language']['locale']?>][item][<?php echo $k;?>][level_point]" value="<?php echo $v['level_point']?>">
	<input type="hidden" name="data[<?php echo $vv['Language']['locale']?>][item][<?php echo $k;?>][level_money]" value="<?php echo $v['level_money']?>">
	<td align="center" width="10%"><?php echo $addid = $k+1?></td>
	<td align="center" width="40%"><?php echo $v["level_point"]?></td>
	<td align="center" width="40%"><?php echo $v["level_money"]?></td>
	<td align="center" width="10%"><?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','del_recomment_config({$k},\"{$vv['Language']['locale']}\")',5)"));?></td>
</tr>
<?php }?>

<tr>
	<td align="center"></td>
	<td align="center"><input type="text" style="width:100px;border:1px solid #649776" id="mypoint" /></td>
	<td align="center"><input type="text" style="width:100px;border:1px solid #649776" id="mymoney" /></td>
	<td align="center"><?php echo $html->link("新增","javascript:;",array("onclick"=>"add_recomment_config(".$addid.",'".$vv['Language']['locale']."')"));?></td>
</tr>

</table>
</span>
<?php }}?>
