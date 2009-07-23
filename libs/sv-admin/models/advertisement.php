<?php
/*****************************************************************************
 * SV-Cart ���
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: advertisement.php 2646 2009-07-07 08:55:19Z wuchao $
*****************************************************************************/
class Advertisement extends AppModel{
	var $name = 'Advertisement';
	var $hasOne = array('AdvertisementPosition'=>
						array('className'  => 'AdvertisementPosition',
							  'conditions' => 'Advertisement.advertisement_position_id=AdvertisementPosition.id',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => ''							
						),
		               'AdvertisementI18n'=>
						array('className'  => 'AdvertisementI18n',
							  'conditions' => '',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => 'advertisement_id'							
						)
					);


	function set_locale($locale){
    	$conditions = " AdvertisementI18n.locale = '".$locale."'";
    	$this->hasOne['AdvertisementI18n']['conditions'] = $conditions;
        
    }
    
    //����ṹ����
    function localeformat($id){
		$lists=$this->findAll("Advertisement.id = '".$id."'");
		foreach($lists as $k => $v){
				 $lists_formated['Advertisement']=$v['Advertisement'];
				 $lists_formated['AdvertisementI18n'][]=$v['AdvertisementI18n'];
				 foreach($lists_formated['AdvertisementI18n'] as $key=>$val){
				 	  $lists_formated['AdvertisementI18n'][$val['locale']]=$val;
				 }
			}
		return $lists_formated;
	}


}
?>