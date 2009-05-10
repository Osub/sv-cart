<?php
/*****************************************************************************
 * SV-Cart 用户等级
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: user_rank.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class UserRank extends AppModel
{ 
	var $name = 'UserRank';
    var $hasOne = array('UserRankI18n'     =>array
												( 
												  'className'    => 'UserRankI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'user_rank_id'
					                        	 )
                 	   );


    
	function set_locale($locale){
    	$conditions = " UserRankI18n.locale = '".$locale."'";
    	$this->hasOne['UserRankI18n']['conditions'] = $conditions;
        
    }
}
?>