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
 * $Id: index.ctp 2520 2009-07-02 02:01:40Z zhengli $
*****************************************************************************/
?> 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>

<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('class'=>'vmiddle'))."新增品牌","add/",'',false,false);?></strong></p>

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<!--
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr></tr>
	</table>
-->
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th>品牌名称</th>
	<th>品牌网址</th>
	<th>品牌描述</th>
	<th>排序</th>
	<th>是否显示</th>
	<th>操作</th></tr>
<!--Products Cat List-->
<?php if(isset($brand_list) && sizeof($brand_list)>0){?>
<?php foreach($brand_list as $k=>$v){?>
	<tr>
	<td><cite></a><?php echo $v['Brand']['name'];?></cite></td>
	<td><span><?php echo $v['Brand']['url']?></span></td>
	<td><p><?php echo $v['Brand']['description'];?></p></td>
	<td align="center"><?php echo $v['Brand']['orderby'];?></td>
	<td align="center"><?php if ($v['Brand']['status'] == 1){?><?php echo $html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?php }elseif($v['Brand']['status'] == 0){?><?php echo $html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?php }?></td>
	<td align="center"><?php echo $html->link("编辑","/brands/{$v['Brand']['id']}");?>
|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}brands/remove/{$v['Brand']['id']}')"));?></td></tr>
<?php }?>
<?php }?></table>
<!--Products Cat List End-->
<div class="pagers" style="position:relative">
    <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>

</div>

<!--Main Start End-->

</div>