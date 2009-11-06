<?php 
/*****************************************************************************
 * SV-Cart 商品分类管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 4433 2009-09-22 10:08:09Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<p class="add_categories">
<?php if($type == 'P'){echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增商品分类","/categories/add",array(),false,false);}?>
<?php if($type == 'A'){echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增文章分类","/categories/add/A",array(),false,false);}?>
</p>


<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<?php if($type == 'A'):?>
<div class="categories">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" id="list-table" class="list_data" >
<tr class="thead">
	<th>分类名称</th>
	<th width="80px">系统类型</th>
	<th width="80px">文章数量</th>
	<th width="50px">状态</th>
	<th width="50px">排序</th>
	<th width="200px">操作</th>
</tr>
<!--Aticle Cat-->
<?php if(isset($categories_trees) && sizeof($categories_trees)>0){?>
<?php foreach($categories_trees as $k=>$v) {?>
<tr class="0 <?php if((abs($k)+2)%2!=1){?>tr_bgcolor<?php }else{?><?php }?>" >
	<td><?php echo $html->image('menu_plus.gif',array("onclick"=>"rowClicked(this)")); ?> <?php echo $html->link("{$v['CategoryI18n']['name']}","edit/A/{$v['Category']['id']}",array(),false,false);?></td>
	<td align="center"><?php echo $systemresource_info["sub_type"][$v['Category']['sub_type']]; ?></td>
	<td align="center"><?php if(isset($categories_articles_count[$v['Category']['id']])||isset($article_count[$v['Category']['id']])){?><?php echo $html->link(@$categories_articles_count[$v['Category']['id']]+@$article_count[$v['Category']['id']],"../articles/?article_cat={$v['Category']['id']}",array(),false,false);?><?php }else{?>0<?php }?></td>
	<td align="center"><?php if($v['Category']['status']) {echo $html->image('yes.gif');}else{ echo $html->image('no.gif');}?></td>
	<td align="center"><?php echo $v['Category']['orderby'];?></td>
	<td align="center"><?php echo $html->link("查看分类文章","/articles/?article_cat={$v['Category']['id']}",array(),false,false);?> | <?php echo $html->link("编辑","/categories/edit/A/{$v['Category']['id']}",array(),false,false);?> | <?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}categories/remove/A/{$v['Category']['id']}')"),false,false);?></td>
</tr>
<!--scoend cat-->	
<?php if(isset($v['SubCategory'])&& sizeof($v['SubCategory'])>0){foreach($v['SubCategory'] as $kk=>$vv){?>	
<tr class="1" style="display:none" >
	<td>&nbsp&nbsp&nbsp<?php echo $html->image('minus.gif',array("onclick"=>"rowClicked(this)")); ?> <?php echo $html->link("{$vv['CategoryI18n']['name']}","edit/A/{$vv['Category']['id']}",array(),false,false);?></td>
	<td align="center"><?php echo $systemresource_info["sub_type"][$vv['Category']['sub_type']]; ?></td>
	<td align="center"><?php if(isset($categories_articles_count[$vv['Category']['id']])||isset($article_count[$vv['Category']['id']])){?><?php echo $html->link(@$categories_articles_count[$vv['Category']['id']]+@$article_count[$vv['Category']['id']],"../articles/?article_cat={$vv['Category']['id']}",array(),false,false);?><?php }else{?>0<?php }?></td>
	<td align="center"><?php if($vv['Category']['status']) {echo $html->image('yes.gif');}else{ echo $html->image('no.gif');}?></td>
	<td align="center"><?php echo $vv['Category']['orderby'];?></td>
	<td align="center">
	<?php echo $html->link("查看分类文章","/articles/?article_cat={$vv['Category']['id']}",array(),false,false);?> | <?php echo $html->link("编辑","/categories/edit/A/{$vv['Category']['id']}",array(),false,false);?> | <?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}categories/remove/A/{$vv['Category']['id']}')"),false,false);?></td>
</tr>
<!--three cat-->	
<?php if(isset($vv['SubCategory'])&& sizeof($vv['SubCategory'])>0){foreach($vv['SubCategory'] as $kkk=>$vvv){?>				
<tr class="2"  style="display:none" >
	<td>&nbsp&nbsp<span style="margin-left:18px;"> <?php echo $html->link("{$vvv['CategoryI18n']['name']}","edit/P/{$vvv['Category']['id']}",array(),false,false);?></td>
	<td align="center"><?php echo $systemresource_info["sub_type"][$vvv['Category']['sub_type']]; ?></td>
	<td align="center"><?php echo (isset($categories_products_count[$vvv['Category']['id']])||isset($article_count[$vvv['Category']['id']]))?@$categories_products_count[$vvv['Category']['id']]+@$article_count[$vvv['Category']['id']]:0; ?></td>
	<td align="center"><?php if($vvv['Category']['status']) {echo $html->image('yes.gif',array("id"=>"status"));}else{ echo $html->image('no.gif',array("id"=>"status"));}?></td>
	<td align="center"><?php echo $vvv['Category']['orderby'];?></td>
	<td align="center"><?php echo $html->link("查看分类文章","/articles/?article_cat={$vv['Category']['id']}",array(),false,false);?> | <?php echo $html->link("编辑","/categories/edit/A/{$vvv['Category']['id']}",array(),false,false);?> | <?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}categories/remove/A/{$vvv['Category']['id']}')"),false,false);?>
	</td>
</tr>
<?php }}}}}}?>
</table></div>
</div>
<?php endif;?>
<!--Aticle Cat End-->

<?php if($type == 'P'):?>
<!--Categories List-->
<div class="categories">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data" id="list-table" >
<tr class="thead">
	<th >分类名称</th>
	<th width="80px">商品数量</th>
	<th width="80px">状态</th>
	<th width="80px">排序</th>
	<th width="220px">操作</th>
</tr>
<!--Products Cat-->
<?php if(isset($categories_tree) && sizeof($categories_tree)>0){foreach($categories_tree as $k=>$v){?>
<tr class="0 <?php if((abs($k)+2)%2!=1){?>tr_bgcolor<?php }else{?><?php }?>">
	<td><?php echo $html->image('menu_plus.gif',array("onclick"=>"rowClicked(this)")); ?> <?php echo $html->link("{$v['CategoryI18n']['name']}","edit/P/{$v['Category']['id']}",array(),false,false);?></td>
	<td align="center"><?php if(isset($categories_products_count[$v['Category']['id']])||isset($product_count[$v['Category']['id']])){?><?php echo $html->link(@$categories_products_count[$v['Category']['id']]+@$product_count[$v['Category']['id']],"../products/?category_id={$v['Category']['id']}",array(),false,false);?><?php }else{?>0<?php }?></td>
	<td align="center"><?php if($v['Category']['status']) {echo $html->image('yes.gif');}else{ echo $html->image('no.gif');}?></td>
	<td align="center"><?php echo $v['Category']['orderby'];?></td>
	<td align="center"><?php echo $html->link("查看商品","/products/?category_id={$v['Category']['id']}",array("target"=>"_blank"),false,false);?> | <?php echo $html->link("转移商品","move_to/{$v['Category']['id']}",array(),false,false);?> | <?php echo $html->link("编辑","/categories/edit/P/{$v['Category']['id']}",array(),false,false);?> | <?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}categories/remove/P/{$v['Category']['id']}')"),false,false);?></td>
</tr>
<!--scoend cat-->	
<?php if(isset($v['SubCategory']) && sizeof($v['SubCategory'])>0){foreach($v['SubCategory'] as $kk=>$vv){?>	
<tr class="1" style="display:none" >
	<td>&nbsp&nbsp&nbsp<?php echo $html->image('minus.gif',array("onclick"=>"rowClicked(this)")); ?> <?php echo $html->link("{$vv['CategoryI18n']['name']}","edit/P/{$vv['Category']['id']}",array(),false,false);?></td>
	<td align="center"><?php if(isset($categories_products_count[$vv['Category']['id']])||isset($product_count[$vv['Category']['id']])){?><?php echo $html->link(@$categories_products_count[$vv['Category']['id']]+@$product_count[$vv['Category']['id']],"../products/?category_id={$vv['Category']['id']}",array(),false,false);?><?php }else{?>0<?php }?></td>
	<td align="center"><?php if($vv['Category']['status']) {echo $html->image('yes.gif');}else{ echo $html->image('no.gif');}?></td>
	<td align="center"><?php echo $vv['Category']['orderby'];?></td>
	<td align="center"><?php echo $html->link("查看商品","/products/?category_id={$vv['Category']['id']}",array("target"=>"_blank"),false,false);?> | <?php echo $html->link("转移商品","move_to/{$vv['Category']['id']}",array(),false,false);?> | <?php echo $html->link("编辑","/categories/edit/P/{$vv['Category']['id']}",array(),false,false);?> | <?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}categories/remove/P/{$vv['Category']['id']}')"),false,false);?></td>
</tr>
<!--three cat-->	
<?php if(isset($vv['SubCategory']) && sizeof($vv['SubCategory'])>0){foreach($vv['SubCategory'] as $kkk=>$vvv){?>				
<tr class="2" style="display:none" >
	<td>&nbsp&nbsp<span style="margin-left:18px;"> <?php echo $html->link("{$vvv['CategoryI18n']['name']}","edit/P/{$vvv['Category']['id']}",array(),false,false);?></span></td>
	<td align="center"><?php echo (isset($categories_products_count[$vvv['Category']['id']])||isset($product_count[$vvv['Category']['id']]))?@$categories_products_count[$vvv['Category']['id']]+@$product_count[$vvv['Category']['id']]:0; ?></td>
	<td align="center"><?php if($vvv['Category']['status']) {echo $html->image('yes.gif',array("id"=>"status"));}else{ echo $html->image('no.gif',array("id"=>"status"));}?></td>
	<td align="center"><?php echo $vvv['Category']['orderby'];?></td>
	<td align="center"><?php echo $html->link("查看商品","/products/?category_id={$vvv['Category']['id']}",array("target"=>"_blank"),false,false);?> | <?php echo $html->link("转移商品","move_to/{$vvv['Category']['id']}",array(),false,false);?> | <?php echo $html->link("编辑","/categories/edit/P/{$vvv['Category']['id']}",array(),false,false);?> | <?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}categories/remove/P/{$vvv['Category']['id']}')"),false,false);?></td>
</tr>
<?php }}}}}}?>	
</table></div>
<!--scoend cat End-->
<!--Products Cat End-->
	    </div>
<!--Categories List End-->
<?php endif;?>
	    </div>
<!--Main Start End-->
</div>
	
<script type="text/javascript">
/**
 * 折叠菜单列表
 */
function rowClicked(obj){
	if(obj.src.indexOf("minus.gif") != -1){	
		obj.src = admin_webroot+"img/menu_plus.gif";
	}
	else{
		obj.src = admin_webroot+"img/minus.gif";
	}
	obj = obj.parentNode.parentNode;
  	var tbl = document.getElementById("list-table");
  	var lvl = parseInt(obj.className);
  	var fnd = false;
  	for (i = 0; i < tbl.rows.length; i++){
		var row = tbl.rows[i];
		if (tbl.rows[i] == obj){
			fnd = true;
		}
		else{
			if (fnd == true){
				var cur = parseInt(row.className);
				if (cur > lvl){
					row.style.display = (row.style.display != 'none') ? 'none' : (BrowserisIE()) ? 'block' : 'table-row';
				}
				else{
					fnd = false;
					break;
				}
			}
		}
  	}

	
}
function BrowserisIE(){
	if(navigator.userAgent.search("Opera")>-1){
		return false;
	}
	if(navigator.userAgent.indexOf("Mozilla/5.")>-1){
        return false;
    }
    if(navigator.userAgent.search("MSIE")>0){
        return true;
    }
}
</script>