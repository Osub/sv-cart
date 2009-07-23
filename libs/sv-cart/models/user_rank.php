<?php
/*****************************************************************************
 * SV-Cart ��Ա�ȼ�
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: user_rank.php 2261 2009-06-22 11:06:14Z zhengli $
*****************************************************************************/
class UserRank extends AppModel
{
	var $name = 'UserRank';
	var $cacheQueries = true;
	var $cacheAction = "1 day";		
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