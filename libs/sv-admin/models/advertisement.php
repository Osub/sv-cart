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
 * $Id: advertisement.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class Advertisement extends AppModel{
	var $name = 'Advertisement';
	var $hasOne = array('AdvertisementI18n'=>
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
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Advertisement']=$v['Advertisement'];
				 $lists_formated['AdvertisementI18n'][]=$v['AdvertisementI18n'];
				 foreach($lists_formated['AdvertisementI18n'] as $key=>$val){
				 	  $lists_formated['AdvertisementI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}


}
?>