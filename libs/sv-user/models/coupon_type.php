<?php
/*****************************************************************************
 * SV-Cart �Ż�ȯ
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: coupon_type.php 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
class CouponType extends AppModel{
	var $name = 'CouponType';
//	var $cacheQueries = true;
//	var $cacheAction = "1 day";
	var $hasOne = array('CouponTypeI18n' =>   
                        array('className'    => 'CouponTypeI18n', 
                              'conditions'    =>  '',
                              'order'        => 'CouponType.id',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'coupon_type_id'  
                        )
                  );
    
   function set_locale($locale){
    	$conditions = " CouponTypeI18n.locale = '".$locale."'";
    	$this->hasOne['CouponTypeI18n']['conditions'] = $conditions;
        
    }
    
    //����ṹ����
    function localeformat($id){
		$lists=$this->findAll("CouponType.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['CouponType']=$v['CouponType'];
				 $lists_formated['CouponTypeI18n'][]=$v['CouponTypeI18n'];
				 foreach($lists_formated['CouponTypeI18n'] as $key=>$val){
				 	  $lists_formated['CouponTypeI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}
	
//	function coupon_types($locale){
		
//	}

}
?>