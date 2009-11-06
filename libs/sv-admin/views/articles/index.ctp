<?php 
/*****************************************************************************
 * SV-Cart 文章管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 4580 2009-09-25 10:28:48Z huangbo $
*****************************************************************************/
?>
<p class="none"><span id="show3">&nbsp;eee</span><span id="show4">&nbsp;</span></p> 
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
	<!--时间控件层start-->
	<div id="container_cal" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal2" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal2"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal3" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal3"></div><div style="clear:both;"></div></div>
	</div>
	<div id="container_cal4" class="calender_2">
		<div class="hd">日历</div>
		<div class="bd"><div id="cal4"></div><div style="clear:both;"></div></div>
	</div>
<!--end-->
<!--Search-->
<div class="search_box">
<?php echo $form->create('',array('action'=>'','name'=>'ArticleForm','type'=>'get','onsubmit'=>"return false"));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">

	 <select class="all" name="article_cat" id="article_cat" >
	<option value="0">所有分类</option>
<?php if(isset($categories_tree) && sizeof($categories_tree)>0){?><?php foreach($categories_tree as $first_k=>$first_v){?>
<option value="<?php echo $first_v['Category']['id'];?>" <?php if($article_cats == $first_v['Category']['id'] ){echo "selected";}?> ><?php echo $first_v['CategoryI18n']['name'];?></option>
<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
<option value="<?php echo $second_v['Category']['id'];?>" <?php if($article_cats == $second_v['Category']['id'] ){echo "selected";}?> >|--<?php echo $second_v['CategoryI18n']['name'];?></option>
<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
<option value="<?php echo $third_v['Category']['id'];?>" <?php if($article_cats == $third_v['Category']['id'] ){echo "selected";}?> >|----<?php echo $third_v['CategoryI18n']['name'];?></option>
<?php }}}}}}?>
	</select>
&nbsp;&nbsp;
		<select name="article_cat_type">
			<option value="">文章类型</option>
		<?php foreach( $systemresource_info["sub_type"] as $k=>$v ){?>
			<option value="<?php echo $k;?>" <?php if("$article_cat_type" == "$k"){echo "selected";}?>><?php echo $v;?></option>
		<?php }?>
		</select>
&nbsp;&nbsp;
	文章标题：<input type="text"  name="title" style="border:1px solid #649776" value="<?php echo @$titles?>"/>&nbsp;&nbsp;
	发布时间：<input type="text" name="start_time" style="border:1px solid #649776" id="date" readonly="readonly"value="<?php echo @$start_time?>" /><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?></button>－
	<input type="text" name="end_time" style="border:1px solid #649776" id="date2" readonly="readonly" value="<?php echo @$end_time?>" /><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?></button></p></dd>
	<dt class="small_search"><input type="submit" onclick="search_article()" value="搜索" class="search_article"  /></dt>
	</dl>
</div>
<br />
<!--Search End-->
	


<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增文章","add/",'',false,false);?></strong></p>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<table   class="list_data" width="100%" style="padding-left: 30px; border-collapse: collapse;border:1px solid #C4D9A5;" border="1"  cellpadding="0" cellspacing="0">
<tr><td width="12%" valign="top" style="border:1px solid #C4D9A5;">
<table id="list-table"  class="list_data" width="100%" >
<tr class="thead">
<?php if(isset($categories_tree) && sizeof($categories_tree)>0){?>
<?php foreach($categories_tree as $k=>$v) {?>
<tr class="0">
	<td><?php echo $html->image('minus.gif',array("onclick"=>"rowClicked(this)")); ?> <?php echo $html->link("{$v['CategoryI18n']['name']}","/articles/?article_cat={$v['Category']['id']}",array(),false,false);?></td>
</tr>
<!--scoend cat-->	
<?php if(isset($v['SubCategory'])&& sizeof($v['SubCategory'])>0){foreach($v['SubCategory'] as $kk=>$vv){?>	
<tr class="1"  >
	<td>&nbsp&nbsp&nbsp<?php echo $html->image('minus.gif',array("onclick"=>"rowClicked(this)")); ?> <?php echo $html->link("{$vv['CategoryI18n']['name']}","/articles/?article_cat={$vv['Category']['id']}",array(),false,false);?></td>
</tr>
<!--three cat-->
<?php if(isset($vv['SubCategory'])&& sizeof($vv['SubCategory'])>0){foreach($vv['SubCategory'] as $kkk=>$vvv){?>				
<tr class="2" >
	<td>&nbsp&nbsp<span style="margin-left:18px;"> <?php echo $html->link("{$vvv['CategoryI18n']['name']}","/articles/?article_cat={$vvv['Category']['id']}",array(),false,false);?></td>
</tr>
<?php }}}}}}?>

</table>
</td><td width="88%" valign="top" style="border:1px solid #C4D9A5;">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th  align="left" width="6%"><label><input type="checkbox" name="chkall" value="checkbox" onclick="checkAll(this.form, this);" /><!--selectAll(this,'checkbox');-->编号<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></label></th>
	<th>文章标题</th>
	<th width="6%">重要性</th>
	<th width="7%">文章分类</th>
	<th width="7%">文章类型</th>
	<th width="7%">有效</th>
	<th width="7%">首页显示</th>
	<th width="7%">推荐</th>
	<th width="4%">排序</th>
	<th width="13%">添加日期</th>
	<th width="10%">操作</th></tr>
<!--Article List-->

<?php if(isset($article) && sizeof($article)>0){?>
<?php foreach($article as $k=>$v ){?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><label><input type="checkbox" name="checkbox[]" value="<?php echo $v['Article']['id']?>" /><?php echo $v['Article']['id']?></label></td>
	<td><span><?php echo $html->link("{$v['ArticleI18n']['title']}",$server_host.$cart_webroot."articles/{$v['Article']['id']}",'',false,false);?></span></td>
	<td align="center"><?php if( $v['Article']['importance'] == 1){?><?php echo "置顶";?><?php }else{ echo "普通"; }?></td>

	<td align="center"><span><?php echo $v['Article']['category']?></span></td>
	<td align="center"><?php echo @$systemresource_info["sub_type"][$v['Article']['type']]?></td>
	<td align="center"><?php if( $v['Article']['status'] == 1){?><?php echo $html->image('yes.gif')?><?php }else{ echo $html->image('no.gif'); }?></td>
	<td align="center"><?php if( $v['Article']['front'] == 1){?><?php echo $html->image('yes.gif')?><?php }else{ echo $html->image('no.gif'); }?></td>
	<td align="center"><?php if( $v['Article']['recommand'] == 1){?><?php echo $html->image('yes.gif')?><?php }else{ echo $html->image('no.gif'); }?></td>
	<td align="center"><?php echo $v['Article']['orderby']?></td>

	<td align="center"><?php echo $v['Article']['modified']?></td>	
	<td align="center">

	<?php echo $html->link("查看",$server_host.$cart_webroot."articles/{$v['Article']['id']}",array("target"=>"_blank"));?>|<?php echo $html->link("编辑","edit/{$v['Article']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}articles/remove/{$v['Article']['id']}')"));?>
	</td></tr>

<?php } ?>	
<?php }?>
</table></div>
</td></tr></table>
<div class="pagers" style="position:relative;">
<?php if(isset($article) && sizeof($article)>0){?>
<p class='batch'>    
	<select style="border:1px solid #689F7C ;" name="act_type" id="act_type" onchange="operate_change(this)">
    <option value="0">请选择...</option>
    <option value="delete">删除</option>
    <option value="sub_type">转移系统类型</option>
    <option value="a_category">转移文章分类</option>
    <option value="a_status">有效</option>
    <option value="a_f_status">首页显示</option>
    <option value="a_c_status">推荐</option>
    </select> 
	 <select style="border:1px solid #689F7C ;display:none" name="article_cat_o" id="article_cat_o" >
	<option value="0">所有分类</option>
	<?php if(isset($categories_tree) && sizeof($categories_tree)>0){?><?php foreach($categories_tree as $first_k=>$first_v){?>
	<option value="<?php echo $first_v['Category']['id'];?>" ><?php echo $first_v['CategoryI18n']['name'];?></option>
	<?php if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?php foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
	<option value="<?php echo $second_v['Category']['id'];?>"  >|--<?php echo $second_v['CategoryI18n']['name'];?></option>
	<?php if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?php foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
	<option value="<?php echo $third_v['Category']['id'];?>" >|----<?php echo $third_v['CategoryI18n']['name'];?></option>
	<?php }}}}}}?>
	</select>
	<select style="border:1px solid #689F7C ;display:none" name="sub_type" id="sub_type" >
		<?php foreach($systemresource_info["sub_type"] as $k=>$v){?>
			<option value="<?php echo $k;?>"><?php echo $v;?></option>
		<?php }?>
	</select>
	<select style="border:1px solid #689F7C ;display:none" name="is_yes_no" id="is_yes_no" >
		<option value="1">是</option>
		<option value="0">否</option>
	</select>
		
<input type="button" onclick="diachange()" value="确定" /></p><?php }?>
		<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div><?php echo $form->end();?>
</div>

<script>
function operate_change(obj){
	if(obj.value=="delete"){
		document.getElementById("sub_type").style.display="none";
		document.getElementById("article_cat_o").style.display="none";
		document.getElementById("is_yes_no").style.display="none";
	}
	if(obj.value=="sub_type"){
		document.getElementById("article_cat_o").style.display="none";
		document.getElementById("sub_type").style.display="inline";
		document.getElementById("is_yes_no").style.display="none";
	}
	if(obj.value=="a_category"){
		document.getElementById("sub_type").style.display="none";
		document.getElementById("article_cat_o").style.display="inline";
		document.getElementById("is_yes_no").style.display="none";
	}
	if(obj.value=="a_status"||obj.value=="a_f_status"||obj.value=="a_c_status"){
		document.getElementById("sub_type").style.display="none";
		document.getElementById("article_cat_o").style.display="none";
		document.getElementById("is_yes_no").style.display="inline";
	}
	
	if(obj.value=="0"){
		document.getElementById("sub_type").style.display="none";
		document.getElementById("is_yes_no").style.display="none";
		document.getElementById("article_cat_o").style.display="none";
	}
}


function diachange(){
	var a=document.getElementById("act_type");
	if(a.value!='0'){
		for(var j=0;j<a.options.length;j++){
			if(a.options[j].selected){
				var vals = a.options[j].text ;
			}
		}
		var id=document.getElementsByName('checkbox[]');
		var i;
		var j=0;
		var image="";
		for( i=0;i<=parseInt(id.length)-1;i++ ){
			if(id[i].checked){
				j++;
			}
		}
		if( j>=1 ){
			layer_dialog_show('确定'+vals+'?','batch_action()',5);
		}else{
			layer_dialog_show('请选择！！','batch_action()',3);
		}
	}

	}

function batch_action() 
{ 
document.ArticleForm.action=webroot_dir+"articles/batch"; 
document.ArticleForm.onsubmit= "";
document.ArticleForm.submit(); 
} 
function search_article() 
{ 
document.ArticleForm.action=webroot_dir+"articles/"; 
document.ArticleForm.onsubmit= "";
document.ArticleForm.submit(); 
} 


</script>
<script type="text/javascript">
/**
 * 折叠菜单列表
 */
function rowClicked(obj){
	
	if(obj.src.indexOf("minus.gif") != -1){	
		obj.src = "/sv-admin/img/menu_plus.gif";
	}
	else{
		obj.src = "/sv-admin/img/minus.gif";
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