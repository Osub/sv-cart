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
 * $Id: twochoice.ctp 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
ob_start();?>
<?foreach($regions_selects as $k=>$r){?>
<?if(isset($updateaddress_id)){?>
    <?=$form->select('Address.RegionUpdate.'.$k.$updateaddress_id,$r['select'],$r['default'],array("onchange"=>"reload_edit_two_regions($updateaddress_id)"),false); ?>
<?}else{?>
    <?=$form->select('Address.RegionUpdate.'.$k,$r['select'],$r['default'],array("onchange"=>"reload_two_regions()"),false); ?>
<?}?>
<?}?>
<?
$result['type']=0;
$result['message'] = ob_get_contents();
if(isset($updateaddress_id)){
	$result['updateaddress_id']=$updateaddress_id;
}
ob_end_clean();
echo json_encode($result);
?>