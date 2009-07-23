<?php
/*****************************************************************************
 * SV-Cart 外部链接
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: link.php 725 2009-04-17 08:00:21Z huangbo $
*****************************************************************************/
class Link extends AppModel{
	var $name = 'Link';

	var $hasOne = array('LinkI18n' =>   
                        array('className'    => 'LinkI18n', 
                              'conditions'    =>  '',
                              'order'        => 'Link.id',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'link_id'  
                        )
                  );
    
    function set_locale($locale){
    	$conditions = " LinkI18n.locale = '".$locale."'";
    	$this->hasOne['LinkI18n']['conditions'] = $conditions;
        
    }
    
    //数组结构调整
    function localeformat($id){
		$lists=$this->findAll("Link.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Link']=$v['Link'];
				 $lists_formated['LinkI18n'][]=$v['LinkI18n'];
				 foreach($lists_formated['LinkI18n'] as $key=>$val){
				 	  $lists_formated['LinkI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}

}
?>