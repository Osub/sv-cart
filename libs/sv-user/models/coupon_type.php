<?php
/*****************************************************************************
 * SV-Cart 优惠券
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
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
    
    //数组结构调整
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