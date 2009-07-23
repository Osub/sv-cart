<?php
/*****************************************************************************
 * SV-Cart �ֵ�����
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: language_dictionary.php 2952 2009-07-16 09:56:25Z huangbo $
*****************************************************************************/
class LanguageDictionary extends AppModel{
	var $name = 'LanguageDictionary'; 
	
	
	
	function getformatcode($locale){
		
		$cache_key = md5($this->name."_".$locale."_");
		
		$languages_formatcode = cache::read($cache_key);
		if ($languages_formatcode){
			return $languages_formatcode;
		}else{
	//		$languages = $this->findallbylocale($locale);
			$languages = $this->find('all',array('fields'=>array('LanguageDictionary.name','LanguageDictionary.value'),'conditions'=>array('locale'=>$locale)));
			$languages_formatcode =array();
			if(is_array($languages))
			foreach($languages as $v){
				$languages_formatcode[$v['LanguageDictionary']['name']]=$v['LanguageDictionary']['value'];
			}
			cache::write($cache_key,$languages_formatcode);
			return $languages_formatcode;
		}
		
	}

}
?>