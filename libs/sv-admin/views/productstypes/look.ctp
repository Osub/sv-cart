<?php 
/*****************************************************************************
 * SV-Cart  查看商品类型
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: look.ctp 2520 2009-07-02 02:01:40Z zhengli $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($coupons);?>

<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle')).'新增属性','/productstypes/lookadd/'.$id,'',false,false)?> </strong></p>
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">	
	<th>编号</th>
	<th>属性名称</th>
	<th>商品类型</th>
	<th>属性值的录入方式</th>
	<th>可选值列表</th>
	<th>排序</th>
	<th>操作</th></tr>
<!--Menberleves List-->
<?php if(isset($attribute) && sizeof($attribute)>0){?>
<?php foreach( $attribute as $k=>$v ){ ?>
	<tr>
	<td align="center"><span> <strong><?php echo $v['ProductTypeAttribute']["id"]?></strong></span></td>
	<td align="center"><?php echo $v['ProductTypeAttributeI18n']["name"]?></td>
	<td align="center"><?php echo $v['ProductTypeAttribute']["typename"]?></td>
	<td align="center"><span><?php if($v['ProductTypeAttribute']["attr_input_type"]==0){ echo "手工录入";}?><?php if($v['ProductTypeAttribute']["attr_input_type"]==1){ echo "从列表中选择";}?><?php if($v['ProductTypeAttribute']["attr_input_type"]==2){ echo "多行文本框";}?></span></td>
	<td align="center"><?php if($v['ProductTypeAttribute']["attr_type"]==0){ echo "不可选";}?><?php if($v['ProductTypeAttribute']["attr_type"]==1){ echo "可选";}?></td>
	<td align="center"><?php echo $v['ProductTypeAttribute']["orderby"]?></td>
	<td align="center">
	<?php echo $html->link('编辑','/productstypes/lookedit/'.$v['ProductTypeAttribute']['id']."/".$id,'',false,false);?> |
	<?php echo $html->link('删除',"javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}productstypes/lookremove/{$v['ProductTypeAttribute']['id']}/{$id}')"));?>

</td></tr>
<?php }}?>
	</table>

<!--Menberleves List End-->	
<div class="pagers" style="position:relative">
<?php // echo $this->element('pagers',array('cache'=>'+0 hour'));?>
</div>
</div>
<!--Main Start End-->
</div>