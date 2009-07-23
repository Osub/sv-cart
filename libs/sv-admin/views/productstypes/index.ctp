<?php 
/*****************************************************************************
 * SV-Cart  商品类型管理列表
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
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle')).'新增商品类型','/productstypes/add',array(),false,false);?></strong></p>
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th>商品类型名称</th><th>属性分组</th><th>属性数</th><th>状态</th><th>操作</th></tr>
<!--Products Cat List-->
<?php if(isset($productstype) && sizeof($productstype)>0){?>
<?php foreach($productstype as $producttype){?>
	<tr>
	<td><cite><?php echo $html->link($producttype['ProductType']['name'],'look/'.$producttype['ProductType']['id'],'',false,false);?></cite></td>
	<td><?php echo $producttype['ProductType']['group_code']?></td>
	<td align="center"><?php echo $producttype['ProductType']['num']?></td>
	<td align="center"><?php if($producttype['ProductType']['status'])echo $html->image('yes.gif',array('align'=>'absmiddle'));else echo $html->image('no.gif',array('align'=>'absmiddle')) ?></td>
	<td align="center"><?php echo $html->link('属性列表','look/'.$producttype['ProductType']['id'],'',false,false);?>|<?php echo $html->link('编辑','edit/'.$producttype['ProductType']['id'],'',false,false);?>|<?php echo $html->link('移除','remove/'.$producttype['ProductType']['id'],'',false,false);?></td></tr>
<?php }}?>
</table>

<!--Products Cat List End-->

</div>
	
<!--Main Start End-->
</div>