<?php 
/*****************************************************************************
 * SV-Cart 资源库管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 2787 2009-07-13 06:31:25Z zhaojingna $
*****************************************************************************/
?>

 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'/','name'=>"SearchForm","type"=>"get"));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif')?></dt>
	<dd><p class="reg_time">资源分类：
		<?php if(!empty($top_src)){?>
			<select class="all" name="src_id" id="src_id">
				<option value="0">所有一级资源</option>
				<?php if(isset($top_src) && sizeof($top_src)>0){?><?php foreach($top_src as $first_k=>$first_v){?>
				<option value="<?php echo $first_v['InformationResource']['id'];?>" <?php if(isset($src_id) && $src_id == $first_v['InformationResource']['id']){?>selected<?php }?>><?php echo $first_v['InformationResourceI18n']['name'];?></option>
				<?php }}?>
			</select>
		<?php }?>
		</p>
	</dd>
	<dt class="big_search"><input type="submit" class="search_article" value="搜索" /></dt>
    </dl>
</div>
<br />
<?php echo $form->end();?>
<!--Search End-->

<!--Main Start-->
<p class="add_categories"><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增资源","/information_resources/add",array(),false,false);?></p>
<?php echo $form->create('system_resource',array('action'=>'','name'=>"InformationResourceForm","type"=>"get","onsubmit"=>"return false"));?>
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data" id="list-table" >
<tr class="thead">
		<th width="40%">资源分类</th>
		<th width="18%">资源代码</th>
		<th width="18%">资源值</th>
		<th width="8%">是否可用</th>
		<th width="8%">排序</th>
		<th width="8%">操作</th>
</tr>
<?php if(isset($resource) && sizeof($resource)>0){?>
<?php foreach($resource as $k => $v){?>
<tr class="0 <?php if((abs($k)+2)%2!=1){?>tr_bgcolor<?php }else{?><?php }?> " >
	<td><?php echo $html->image('menu_plus.gif',array("onclick"=>"rowClicked(this)")); ?> <?php echo $v['InformationResourceI18n']['name'];?></td>
	<td><?php echo $v['InformationResource']['code']?></td>
	<td><?php echo $v['InformationResource']['information_value']?></td>
	<td align="center"><?php if(!empty($v['InformationResource']['status'])&&$v['InformationResource']['status'])echo $html->image('yes.gif'); else echo $html->image('no.gif');?></td>
	<td align="center"><?php echo $v['InformationResource']['orderby']?></td>
	<td align="center"><?php echo $html->link("编辑","/information_resources/edit/{$v['InformationResource']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}information_resources/remove/".$v['InformationResource']['id']."')"));?></td>
</tr>
<!--second menu-->
	<?php if(isset($v['SubMenu']) && !empty($v['SubMenu'])>0){foreach($v['SubMenu'] as $kk=>$vv){?>
<tr class="1" style="display:none" >
	<td	class="next_cat"> &nbsp<?php echo $html->link($vv['InformationResourceI18n']['name'],"edit/{$vv['InformationResource']['id']}",array(),false,false);?></td>
	<td><?php echo $vv['InformationResource']['code']?></td>
	<td><?php echo $vv['InformationResource']['information_value']?></td>
	<td align="center"><?php if(!empty($vv['InformationResource']['status'])&&$vv['InformationResource']['status'])echo $html->image('yes.gif'); else echo $html->image('no.gif');?></td>
	<td align="center"><?php echo $vv['InformationResource']['orderby']?></td>
	<td align="center"><?php echo $html->link("编辑","/information_resources/edit/{$vv['InformationResource']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}information_resources/remove/".$vv['InformationResource']['id']."')"));?></td>
</tr>
<?php }}?>
<!--second menu End-->	

<?php }}?></table></div>
<div class="pagers" style="position:relative">
 <?php echo $form->end();?>
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div></div>
<!--Main Start End-->
</div>
<script type="text/javascript">
/**
 * 折叠菜单列表
 */
function rowClicked(obj){
	if(obj.src.indexOf("minus.gif") != -1){	
		obj.src = server_host+"/sv-admin/img/menu_plus.gif";
	}
	else{
		obj.src = server_host+"/sv-admin/img/minus.gif";
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