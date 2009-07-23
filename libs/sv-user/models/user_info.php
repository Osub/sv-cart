<?php
/*****************************************************************************
 * SV-Cart 用户项目
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: user_info.php 2570 2009-07-03 12:07:17Z zhengli $
*****************************************************************************/
class UserInfo extends AppModel
{
	var $name = 'UserInfo';
	var $hasOne = array('UserInfoI18n' =>   
                        array('className'    => 'UserInfoI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'user_info_id'  
                        )   
                  );
    
    
function set_locale($locale){
    	$conditions = " UserInfoI18n.locale = '".$locale."'";
    	$this->hasOne['UserInfoI18n']['conditions'] = $conditions;
        
    }

//用户等级整合数组
	function findinfoassoc($values_id){
		
		if(!empty($values_id)){
			 $condition=array("UserInfo.id"=>$values_id,
			 					"UserInfo.status" =>1 ,
			 						"UserInfo.front" =>1);
		}
		else{
			$condition="UserInfo.status = '1' and UserInfo.front = '1'";
		}
		
		$lists=$this->findAll($condition);
		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				    $lists_formated[$v['UserInfo']['id']]['UserInfo']=$v['UserInfo'];
				if(is_array($v['UserInfoI18n'])){
				    //$lists_formated[$v['UserInfo']['id']]['UserInfoI18n']=$v['UserInfoI18n'];
				     $lists_formated[$v['UserInfo']['id']]['UserInfo']['name'] = $v['UserInfoI18n']['name'];
				     $lists_formated[$v['UserInfo']['id']]['UserInfo']['user_info_values'] = $v['UserInfoI18n']['user_info_values'];
				     $lists_formated[$v['UserInfo']['id']]['UserInfo']['message'] = $v['UserInfoI18n']['message'];
				     $lists_formated[$v['UserInfo']['id']]['UserInfo']['remark'] = $v['UserInfoI18n']['remark'];
				     
				}
				//$lists_formated[$v['UserInfo']['id']]['UserInfo']['name']='';
				//foreach($lists_formated[$v['UserInfo']['id']]['UserInfoI18n'] as $key => $val){
				//		$lists_formated[$v['UserInfo']['id']]['UserInfo']['name'] .=$val['name'] . " | ";
				//}
			}
	//	pr($lists_formated);
		return $lists_formated;
	}
	
}
?>