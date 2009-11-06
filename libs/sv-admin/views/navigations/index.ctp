<?php 
/*****************************************************************************
 * SV-Cart  添加导航栏
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3949 2009-08-31 07:34:05Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<?php //pr($navigations);
	?>
<div class="search_box">
<?php echo $form->create('',array('action'=>'/','name'=>'NavigationForm','type'=>'get'));?>

	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd>
		<select name="controller" id="controller">
		  <option value="">系统参数</option>
		<?php if(isset($controllers) && sizeof($controllers)>0){?>

		<?php foreach($controllers as $k=>$v){?>
		  <option value="<?php echo $k; ?>" <?php if($k==$controller)echo 'selected'; ?>><?php echo $v; ?></option>
		<?php }}?>
		</select>	
		<select name="type" id="type">
		  <option value="">位置</option>
		    <?php if(isset($types) && sizeof($types)>0){?>

		<?php foreach($types as $k=>$v){?>
		  <option value="<?php echo $k; ?>" <?php if($k==$type)echo 'selected'; ?>><?php echo $v; ?></option>
		<?php }}?>
		</select>
		关键字：<input type="text" class="name" name="navigation_name"/>&nbsp;&nbsp;
	</dd>
	<dt class="small_search"><input type="submit"  value="搜索"  class="search_article" /></dt>
	</dl>

</div><br></br>
<!--Main Start-->
<p class="add_categories"><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."添加导航","/navigations/add",array(),false,false);?></p>
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data" id="list-table">
<tr class="thead">
	<th width="60%">名称</th>
	<th width="8%">显示</th>
	<th width="8%">新窗口</th>
	<th width="8%">排序</th>
	<th width="8%">位置</th>
	<th width="8%">操作</th>
</tr>
<!--Navigation List-->
<?php if(isset($navigations2) && sizeof($navigations2)>0){?>
	<?php  foreach($navigations2 as $k=>$navigation){ ?>
<tr class="0 <?php if((abs($k)+2)%2!=1){?>tr_bgcolor<?php }else{?><?php }?>" >
	<td><?php echo $html->image('menu_plus.gif',array("onclick"=>"rowClicked(this)")); ?>&nbsp;<?php echo $html->link($navigation['NavigationI18n']['name'],$navigation['NavigationI18n']['url'],'',false,false);?></td>
	<td align="center"><?php if($navigation['Navigation']['status']){echo $html->image('yes.gif');} else {echo $html->image('no.gif');}?></td>
	<td align="center"><?php if($navigation['Navigation']['target']=='_blank'){echo $html->image('yes.gif');} else {echo $html->image('no.gif');}?></td>
	<td align="center"><?php echo $navigation['Navigation']['orderby'];?></td>
	<td align="center"><?php echo $systemresource_info["navigation_type"][$navigation['Navigation']['type']];?></td>
	<td align="center">
	<?php echo $html->link("编辑","/navigations/edit/{$navigation['Navigation']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}navigations/remove/{$navigation['Navigation']['id']}')"));?>
	</td>
</tr>
<?php if(!empty($navigation['SubMenu']) && sizeof($navigation['SubMenu'])>0)foreach($navigation['SubMenu'] as $kk=>$vv){?>
<tr class="1" style="display:none" >
	<td>&nbsp;&nbsp;&nbsp;<?php echo $html->link($vv['NavigationI18n']['name'],$vv['NavigationI18n']['url'],'',false,false);?></td>
	<td align="center"><?php if($vv['Navigation']['status']){echo $html->image('yes.gif');} else {echo $html->image('no.gif');}?></td>
	<td align="center"><?php if($vv['Navigation']['target']=='_blank'){echo $html->image('yes.gif');} else {echo $html->image('no.gif');}?></td>
	<td align="center"><?php echo $vv['Navigation']['orderby'];?></td>
	<td align="center"><?php echo $systemresource_info["navigation_type"][$navigation['Navigation']['type']];?></td>
	<td align="center">
	<?php echo $html->link("编辑","/navigations/edit/{$vv['Navigation']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}navigations/remove/{$vv['Navigation']['id']}')"));?>
	</td>
</tr>	
<!--second menu End-->	
<?php }?>
<?php }}?></table></div>


		
<!--User List End-->
<div class="pagers" style="position:relative">	
<?php //echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>

</div>

<!--Main Start End-->
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