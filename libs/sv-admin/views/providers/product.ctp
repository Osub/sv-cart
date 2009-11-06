<?php 
/*****************************************************************************
 * SV-Cart  供应商管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3500 2009-08-06 05:20:48Z zhangshisong $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('providers',array('action'=>'product','name'=>'searchtrash','type'=>"get"));?>
	<dl>
	<dt><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p>

	供应商关键字：<input type="text" style="width:105px;" name="providerkeywords" id="providerkeywords" value="<?php echo @$providerkeywords?>"/>
	商品关键字：<input type="text" style="width:105px;" name="productkeywords" id="productkeywords" value="<?php echo @$productkeywords?>"/>


	
	</p></dd>
	<dt class="big_search"><input type="submit" class="search_article"  value="搜索" /></dt>
	</dl><?php echo $form->end();?>
</div>
<br />
<!--Search End-->
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增供应商商品","product_add/",'',false,false);?></strong></p>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="15%">供应商名称</th>
	<th>商品名称</th>
	<th width="8%">供货价</th>
	<th width="8%">最小进货量</th>
	<th width="8%">排序</th>
	<th width="8%">是否有效</th>
	<th width="8%">操作</th>
</tr>
<!--Competence List-->
<?php if(isset($ProviderProduct_list) && sizeof($ProviderProduct_list)>0){?>
<?php foreach( $ProviderProduct_list as $k=>$v ){?>	
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><?php echo $v['Provider']['name']?></td>
	<td><?php echo $v['ProductI18n']['name']?></td>
	<td><?php echo $v['providerProduct']['price']?></td>
	<td align="center"><?php echo $v['providerProduct']['min_buy']?></td>
	<td align="center"><?php echo $v['providerProduct']['orderby']?></td>
	<td align="center"><?php if ($v['providerProduct']['status'] == 1){?><?php echo $html->image('yes.gif',array('align'=>'absmiddle','onclick'=>'')) ?><?php }elseif($v['providerProduct']['status'] == 0){?><?php echo $html->image('no.gif',array('align'=>'absmiddle','onclick'=>''))?><?php }?></li>
	<td align="center">
	<?php echo $html->link("编辑","/providers/product_edit/{$v['providerProduct']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}providers/product_remove/{$v['providerProduct']['id']}')"));?>
	</td>
</tr>
<?php }} ?>
</table></div>

<!--Competence List End-->	

<br />
</div>
<!--Main Start End-->
</div>