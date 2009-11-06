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
 * $Id: language_dictionary.php 5080 2009-10-15 07:55:08Z huangbo $
*****************************************************************************/
class LanguageDictionary extends AppModel{
	var $name = 'LanguageDictionary';
	
	function getformatcode($locale){
		$languages = $this->findallbylocale($locale);
		$languages_formatcode =array();
		if(is_array($languages))
		foreach($languages as $v){
			$languages_formatcode[$v['LanguageDictionary']['name']]=$v['LanguageDictionary']['value'];
		}
		return $languages_formatcode;
	}
	
	function getcode($locale){
		$languages = $this->findallbylocale($locale);
		$languages_formatcode =array();
		if(is_array($languages))
		foreach($languages as $v){
			$languages_formatcode[]=$v['LanguageDictionary']['name'];
		}
		return $languages_formatcode;
	}	
}
?>