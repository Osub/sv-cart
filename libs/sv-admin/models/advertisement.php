<?php
/*****************************************************************************
 * SV-Cart 广告
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: advertisement.php 1608 2009-05-21 02:50:04Z huangbo $
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
    
    //数组结构调整
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