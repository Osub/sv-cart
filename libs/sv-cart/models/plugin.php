<?php
/*****************************************************************************
 * SV-Cart 插件
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: plugin.php 2952 2009-07-16 09:56:25Z huangbo $
*****************************************************************************/
class Plugin extends AppModel
{
	var $name = 'Plugin';

	function find_union(){
		$cache_key = md5($this->name);
		
		$plugin = cache::read($cache_key);	
		if($plugin){
			return $plugin;
		}else{
			
			$plugin_arr = $this->cache_find('all',array('conditions'=>array('Plugin.status'=>1,'Plugin.code'=>'union')),$this->name);
			$plugin = array();
			if(isset($plugin_arr[0])){
				$plugin = $plugin_arr[0];
			}
			cache::write($cache_key,$plugin);
			return $plugin;
		}
	}
	
	function find_union_admin(){
		$plugin_arr = $this->cache_find('all',array('conditions'=>array('Plugin.status'=>1,'Plugin.code'=>'union_admin')),$this->name);
		$plugin = array();
		if(isset($plugin_arr[0])){
			$plugin = $plugin_arr[0];
		}
		return $plugin;
	}
}
?>