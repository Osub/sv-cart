<?php
/*****************************************************************************
 * SV-Cart 字典语言
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
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