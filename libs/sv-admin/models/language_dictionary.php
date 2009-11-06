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