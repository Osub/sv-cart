<?php
/*****************************************************************************
 * SV-Cart �û��ȼ�
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: user_rank.php 2267 2009-06-23 09:38:35Z shenyunfeng $
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
    
     function get_rank($rank_id,$locale){
 	 	$this->set_locale($locale);
 	    $rank=$this->find("UserRank.id = $rank_id");
 	    $rank_name=$rank['UserRankI18n']['name'];
 	    return $rank_name;
 	}
    
    
//�û��ȼ���������
	function findrank(){
		$condition="";
		$cache_key = md5($this->name."_findrank");
		
		$lists_formated = cache::read($cache_key);
		if($lists_formated){
			return $lists_formated;
		}else{
			$lists=$this->findAll($condition);
			
			$lists_formated = array();
			if(is_array($lists))
				foreach($lists as $k => $v){
					    $lists_formated[$v['UserRank']['id']]['UserRank']=$v['UserRank'];
					if(is_array($v['UserRankI18n'])){
					    $lists_formated[$v['UserRank']['id']]['UserRankI18n'][]=$v['UserRankI18n'];
					}
					$lists_formated[$v['UserRank']['id']]['UserRank']['name']='';
					foreach($lists_formated[$v['UserRank']['id']]['UserRankI18n'] as $key => $val){
							         $lists_formated[$v['UserRank']['id']]['UserRank']['name'] .=$val['name'] . " | ";
						        }
				}
			cache::write($cache_key,$lists_formated);
			return $lists_formated;
		}
		
	}
    
}
?>