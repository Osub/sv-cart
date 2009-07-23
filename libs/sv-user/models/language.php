<?php
/*****************************************************************************
 * SV-Cart 语言
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: language.php 2304 2009-06-26 07:00:53Z zhengli $
*****************************************************************************/
class Language extends AppModel
{
	var $name = 'Language';
	
	function findalllang(){
		 if($this->cacheFind($this->name,'findalllang',array('front'=>'1'))){
		 	$language = $this->cacheFind($this->name,'findalllang',array('front'=>'1'));
		 }else{
		 	$language = $this->findAll("Language.front = '1' ");
			$this->cacheSave($this->name,'findalllang',array('front'=>'1'),$language);
		 }
		 return $language;
	}
	
	
}
?>