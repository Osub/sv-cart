<?
/*****************************************************************************
 * SV-Cart ѡ������
 *===========================================================================
 * ��Ȩ�����Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *�ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 *������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 *===========================================================================
 * $����: �Ϻ�ʵ��$
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