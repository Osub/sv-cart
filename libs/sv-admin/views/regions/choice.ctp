<?
/*****************************************************************************
 * SV-Cart 选择区域
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: choice.ctp 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
ob_start();?>
<?foreach($regions_selects as $k=>$r){?>
		<?if(isset($r['select']) && sizeof($r['select']) == 2){?>
			<?foreach($r['select'] as $kk=>$vv){?>
				<?$r['default'] = $kk;?>
			<?}?>
	<?}?>	
	
<?if(isset($address_id)){?>
    <?=$form->select('Address.Region.'.$k.$address_id,$r['select'],$r['default'],array("onchange"=>"reload_edit_regions($address_id)"),false); ?>
<?}else{?>
    <?=$form->select('Address.Region.'.$k,$r['select'],$r['default'],array("onchange"=>"reload_regions()"),false); ?>
<?}?>
<?}?>
<?
$result['type']=0;
$result['message'] = ob_get_contents();
if(isset($address_id)){
	$result['address_id']=$address_id;
}
ob_end_clean();
echo json_encode($result);
?>