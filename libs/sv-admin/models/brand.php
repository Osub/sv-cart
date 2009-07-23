<?php
/*****************************************************************************
 * SV-Cart Ʒ��
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: brand.php 725 2009-04-17 08:00:21Z huangbo $
*****************************************************************************/
class Brand extends AppModel
{
	var $name = 'Brand';

	var $hasOne = array('BrandI18n' =>   
                        array('className'    => 'BrandI18n', 
                              'conditions'    =>  '',
                              'order'        => '',
                              'dependent'    =>  true,
                              'foreignKey'   => 'brand_id'
                        )
                  );
    
    	function set_locale($locale){
    	$conditions = " BrandI18n.locale = '".$locale."'";
    	$this->hasOne['BrandI18n']['conditions'] = $conditions;
        
    }
  /*  function localeformat($id){
		$info=$this->findbyid($id);
		if(is_array($info['BrandI18n']))
			foreach($info['BrandI18n'] as $k => $v){
				$info['BrandI18n'][$v['locale']]=$v;
			}
		return $info;
	}*/
	
	//Ʒ������ṹ����
    function localeformat($id){
		$lists=$this->findAll("Brand.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Brand']=$v['Brand'];
				 $lists_formated['BrandI18n'][]=$v['BrandI18n'];
				 foreach($lists_formated['BrandI18n'] as $key=>$val){
				 	  $lists_formated['BrandI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}
	
	
	function getbrandformat(){
		$condition="";
		$lists=$this->findAll($condition);
		//pr($lists);
		//$lists_formated = array();
	/*	if(is_array($lists))
			foreach($lists as $k => $v){
				 $lists_formated[$v['Brand']['id']]['Brand']=$v['Brand'];
				 $lists_formated[$v['Brand']['id']]['BrandI18n'][]=$v['BrandI18n'];
				 $lists_formated[$v['Brand']['id']]['Brand']['name']='';
				 foreach($lists_formated[$v['Brand']['id']]['BrandI18n'] as $key=>$val){
				 	  $lists_formated[$v['Brand']['id']]['Brand']['name'] .=$val['name']."|";
				 }
			}*/

		return $lists;
	}


}
?>