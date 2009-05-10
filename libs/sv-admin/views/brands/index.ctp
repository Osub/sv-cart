<?php
/*****************************************************************************
 * SV-Cart 品牌列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
?> 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>

<!--Main Start-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增品牌","add/",'',false,false);?></strong></p>

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<!--
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr></tr>
	</table>
-->
	<ul class="product_llist brands_title">
	<li class="name" >品牌名称</li>
	<li class="url">品牌网址</li>
	<li class="bewrite">品牌描述</li>
	<li class="taxis">排序</li>
	<li class="block" >是否显示</li>
	<li class="hadle">操作</li></ul>
<!--Products Cat List-->
<?if(isset($brand_list) && sizeof($brand_list)>0){?>
<?foreach($brand_list as $k=>$v){?>
	<ul class="product_llist brands_title brands_list">
	<li class="name"><cite></a><?php echo $v['Brand']['name'];?></cite></li>
	<li class="url"><span><?echo $v['Brand']['url']?></span></li>
	<li class="bewrite"><p><?php echo $v['Brand']['description'];?></p></li>
	<li class="taxis"><?php echo $v['Brand']['orderby'];?></li>
	<li class="block"><?if ($v['Brand']['status'] == 1){?><?=$html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?}elseif($v['Brand']['status'] == 0){?><?=$html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?}?></li>
	<li class="hadle"><?php echo $html->link("编辑","/brands/{$v['Brand']['id']}");?>
|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}brands/remove/{$v['Brand']['id']}')"));?></li></ul>
<?}?>
<?}?>
<!--Products Cat List End-->
<div class="pagers" style="position:relative">
    <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>

</div>

<!--Main Start End-->

</div>