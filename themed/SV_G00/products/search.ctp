<?php
/*****************************************************************************
 * SV-Cart 搜索
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: search.ctp 786 2009-04-18 15:38:32Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
	<div id="Editinfo_title"><h1><b><?php echo $SCLanguages['search_result'];?></b></h1></div>
<?if ($products){?>
<?php echo $this->element('category_products', array('cache'=>'+0 hour'));?>
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
<?}else{?>
<!--无搜索结果-->
    <div id="noproducts"><p>
	 	<?=$html->image('warning_img.gif',array("align"=>"middle"));?>
    &nbsp;<?=$SCLanguages['not_find_product'];?></p></div>
  <!--无搜索结果End--> 
<?}?>
