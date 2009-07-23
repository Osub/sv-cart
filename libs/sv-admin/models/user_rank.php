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
 * $Id: user_rank.php 1095 2009-04-28 05:21:30Z zhengli $
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

//�û��ȼ���������
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