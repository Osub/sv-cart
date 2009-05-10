<?php
/*****************************************************************************
 * SV-Cart 会员等级
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: user_rank.php 1116 2009-04-28 11:04:43Z huangbo $
*****************************************************************************/
class UserRank extends AppModel
{
	var $name = 'UserRank';
	var $hasOne = array('UserRankI18n' =>   
                        array('className'    => 'UserRankI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'user_rank_id'  
                        )   
                  );
    
    
function set_locale($locale){
    	$conditions = " UserRankI18n.locale = '".$locale."'";
    	$this->hasOne['UserRankI18n']['conditions'] = $conditions;
        
    }

//用户等级整合数组
	function findrank(){
		$condition="";
		$lists=$this->findAll();
		foreach( $lists as $k=>$v ){
			$lists[$k]['UserRank']['name'] = $lists[$k]['UserRankI18n']['name'];
		}
		return $lists;
	}
	
}
?>