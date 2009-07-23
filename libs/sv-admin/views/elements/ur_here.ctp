<?php 
/*****************************************************************************
 * SV-Cart 位置导航
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: ur_here.ctp 2485 2009-06-30 11:33:00Z huangbo $
*****************************************************************************/
?>
<div id="ur_here">当前位置：
<?php 
if(isset($navigations) && sizeof($navigations)>0){
	foreach($navigations as $v){
	 	if(!isset($v['url']) || $v['url']==''){
				echo $v['name'].' -> ';
	 	}else{
	 	 echo $html->link($v['name'],$v['url']).' -> ';
		}
	}
}else{
	echo '首页';
}
?>
</div>