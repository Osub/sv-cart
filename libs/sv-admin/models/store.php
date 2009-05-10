<?php
/*****************************************************************************
 * SV-Cart 实体店
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: store.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class Store extends AppModel{
	var $name = 'Store';

	var $hasOne = array('StoreI18n' =>   
                        array('className'    => 'StoreI18n', 
                              'conditions'    =>  '',
                              'order'        => 'Store.id',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'store_id'  
                        )
                  );
    
    function set_locale($locale){
    	$conditions = " StoreI18n.locale = '".$locale."'";
    	$this->hasOne['StoreI18n']['conditions'] = $conditions;
        
    }
    
    //数组结构调整
    function localeformat($id){
		$lists=$this->findAll("Store.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Store']=$v['Store'];
				 $lists_formated['StoreI18n'][]=$v['StoreI18n'];
				 foreach($lists_formated['StoreI18n'] as $key=>$val){
				 	  $lists_formated['StoreI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}
}
?>