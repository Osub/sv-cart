<?php 
/*****************************************************************************
 * SV-Cart 标签管理类表
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3673 2009-08-17 09:57:45Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>


<div class="search_box">
<?php echo $form->create('tags',array('action'=>'','name'=>'ArticleForm','type'=>'get','onsubmit'=>"return false"));?>
	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">

	时间：<input type="text" name="date" class="time" id="date" readonly="readonly"  value="<?php echo @$date;?>" /><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show","class"=>"calendar"))?></button>－
	
	<input type="text" name="date2" class="time" id="date2" readonly="readonly" value="<?php echo @$date2;?>"  /><?php echo $html->image("calendar.gif",array('width'=>'18','height'=>'18','alt'=>'Calendar',"id"=>"show2","class"=>"calendar"))?></button>
	 类型: 
	    <select name="searchtype">
	    <option value="all">请选择...</option>
	    <option value="P" <?php if($searchtype == "P"){ echo "selected";}?> >商品</option>
	    <option value="A"  <?php if($searchtype == "A"){ echo "selected";}?> >文章</option>
	    </select>
	    会员名: <input type="text" name="username" value="<?php echo @$username;?>" /> 标签名: <input type="text" name="searchvalue" value="<?php echo @$searchvalue;?>" /></p></dd>
	<dt class="small_search"><input type="submit" onclick="search_article()" value="搜索" class="search_article"  /></dt>
	</dl>

</div>
<br /><br />
<!--Search End-->
	
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

<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增标签","add/",'',false,false);?></strong></p>
<!--Main Start-->
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' );">
<?php echo $form->create('',array('action'=>'/',"name"=>"ProForm","type"=>"get",'onsubmit'=>"return false"));?>
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th align="left" width="8%"><input type="checkbox" name="checkbox" value="checkbox" onclick='javascript:selectAll(this, "checkboxes")'/>编号<?php echo $html->image('sort_desc.gif',array('align'=>'absmiddle'))?></th>
	<th width="12%"><p>标签名称</p></th>
	<th width="8%">类型</th>
	<th width="12%">会员名</th>
	<th>商品名称/文章名称</th>
	<th width="8%">是否显示</th>
	<th width="8%">操作</th></tr>
<?php if(isset($tags) && sizeof($tags)){?>
<?php foreach($tags as $k=>$v){?>	
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><input type="checkbox" name="checkboxes[]" value="<?php echo $v['Tag']['id']?>" /><?php echo $v['Tag']['id']?></td>
	<td><p><?php echo $v['TagI18n']['name']?></p></td>
	<td align="center"><?php if($v['Tag']['type'] == "A"){echo"文章";}else if($v['Tag']['type'] == "P"){echo"商品";}else{echo"未定义";}?></td>
	<td align="center"><?php if(isset($v['Tag']['user_name'])){echo $v['Tag']['user_name'];}?></td>
	<td><?php if(isset($v['Tag']['type_name'])){echo $v['Tag']['type_name'];}?></td>
	<td align="center"><?php if($v['Tag']['status'] == 1){?><?php echo $html->image('yes.gif')?><?php }else{?><?php echo $html->image('no.gif')?><?php }?></td>
	<td align="center">
	<?php echo $html->link("编辑","/tags/{$v['Tag']['id']}");?>|<?php echo $html->link("删除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}tags/remove/{$v['Tag']['id']}/{$v['TagI18n']['name']}')"));?>
	</td></tr>
<?php }}?>
  </table></div>
  <div class="pagers" style="position:relative">
  <p class='batch'>
 <?php if(isset($total) && $total>0){?> 
    <select style="border:1px solid #689F7C;" name="act_type" id="act_type" >
   <option value="0">请选择...</option>
   <option value="del">放入回收站</option>
   <option value="category">转移到分类</option>
    </select> 
	<input type="button" value="确定"  onclick="operate_change()"  id="change_button"/><?php }?></p>

<?php  echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>
<?php echo $form->end();?>
</div>
<!--Main Start End-->
</div>
<script>
function operate_change(){
	var a=document.getElementById("act_type");
	if(a.value!='0'){
		for(var j=0;j<a.options.length;j++){
			if(a.options[j].selected){
				var vals = a.options[j].text ;
			}
		}
		layer_dialog_show('确定'+vals+'?','search_article()',5);
	}
}

function search_article() 
{ 
document.ArticleForm.action=webroot_dir+"tags/"; 
document.ArticleForm.onsubmit= "";
document.ArticleForm.submit(); 
} 

</script>