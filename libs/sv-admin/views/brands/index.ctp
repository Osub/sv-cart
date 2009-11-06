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
 * $Id: index.ctp 5199 2009-10-20 07:08:27Z huangbo $
*****************************************************************************/
?> 
<?php echo $javascript->link('listtable');?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('brands',array('action'=>'/','name'=>'ArticleForm','type'=>'get'));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd>品牌名称：<input type="text" name="brand_name"  value="<?php echo @$brand_name;?>" style="border:1px solid #649776" />
	    关键字：<input type="text" name="keyword_value"  value="<?php echo @$keyword_value;?>" style="border:1px solid #649776" />
		<select  name="category_id" style="width:100px">
			<option value="0">所有分类</option>
			<?php if(isset($product_cat) && sizeof($product_cat)>0){?><?php foreach($product_cat as $first_k=>$first_v){?>
			<option value="<?php echo $first_v['Category']['id'];?>" <?php if($category_id == $first_v['Category']['id']){?>selected<?php }?> ><?php echo $first_v['CategoryI18n']['name'];?></option>
			<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
			<option value="<?php echo $second_v['Category']['id'];?>" <?php if($category_id == $second_v['Category']['id']){?>selected<?php }?>>&nbsp;&nbsp;<?php echo $second_v['CategoryI18n']['name'];?></option>
			<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
			<option value="<?php echo $third_v['Category']['id'];?>" <?php if($category_id == $third_v['Category']['id']){?>selected<?php }?> >&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $third_v['CategoryI18n']['name'];?></option>
			<?php }}}}}}?>
		</select>
	</dd>
	<dt class="small_search"><input type="submit" onclick="search_article()" value="搜索" class="search_article"  /></dt>
	</dl>
</div>
<br />
<!--Search End-->
<?php echo $form->end();?>
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('class'=>'vmiddle'))."新增品牌","add/",'',false,false);?></strong></p>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">

<div id="listDiv"><?php echo $form->create('',array('action'=>'/',"name"=>"ProForm","type"=>"POST"));?>
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="20%"><input type="checkbox" name="checkbox" value="checkbox" onclick='javascript:selectAll(this, "checkboxes")'/>品牌名称</th>
	<th width="52%">品牌网址</th>
	<th width="8%">排序</th>
	<th width="8%">是否显示</th>
	<th width="12%">操作</th></tr>
<!--Products Cat List-->
<?php if(isset($brand_list) && sizeof($brand_list)>0){?>
<?php foreach($brand_list as $k=>$v){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><input type="checkbox" name="checkboxes[]" value="<?php echo $v['Brand']['id']?>" /><?php echo $v['BrandI18n']['name'];?></td>
	<td><span><?php echo $v['Brand']['url']?></span></td>
	<td align="center"><?php echo $v['Brand']['orderby'];?></td>
	<td align="center"><?php if ($v['Brand']['status'] == 1){?><?php echo $html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?php }elseif($v['Brand']['status'] == 0){?><?php echo $html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?php }?></td>
	<td align="center"><?php echo $html->link("查看商品","/products/?brand_id={$v['Brand']['id']}",array("target"=>"_blank"));?> | <?php echo $html->link("编辑","/brands/{$v['Brand']['id']}");?>
| <?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}brands/remove/{$v['Brand']['id']}')"));?></td></tr>
<?php }?>
<?php }?>
</table><?php echo $form->end();?></div>
<!--Products Cat List End-->
<div class="pagers" style="position:relative">
 <p class='batch'>
	<input type="button" value="删除" onclick="batch_select()" />
</p>
    <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>

</div>

<!--Main Start End-->

</div>
<script type="text/javascript">
function batch_select(){
	layer_dialog();
	layer_dialog_show("确定删除选中的品牌?","batch_action()",5);

}
function batch_action(){ 
	document.ProForm.action=webroot_dir+"brands/batch";
	document.ProForm.onsubmit= "";
	document.ProForm.submit(); 
}
</script>