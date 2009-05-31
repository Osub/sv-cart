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
 * $Id: language_dictionary.php 1670 2009-05-25 00:47:18Z huangbo $
*****************************************************************************/
class LanguageDictionary extends AppModel{
	var $name = 'LanguageDictionary'; 
	var $cacheQueries = true;
	
	
	function getformatcode($locale){
		
		$cache_key = md5($this->name."_".$locale."_");
		
		$languages_formatcode = cache::read($cache_key);
		if ($languages_formatcode){
			return $languages_formatcode;
		}else{
			$languages = $this->findallbylocale($locale);
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