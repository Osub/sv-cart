<?php
/*****************************************************************************
 * SV-Cart 文章
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: template.php 2699 2009-07-08 11:07:31Z huangbo $
*****************************************************************************/
class Template extends AppModel
{
	var $name = 'Template';
	var $cacheQueries = true;
	var $cacheAction = "1 day";
	
	function find_template($sql){
		$cache_key = md5($this->name.'_'.$sql);
		
		$template = cache::read($cache_key);	
		if($template){
			return $template;
		}else{
		$template =  $this->findAll($sql);
		cache::write($cache_key,$template);
		return $template;
		}
	}
	
	
}
?>