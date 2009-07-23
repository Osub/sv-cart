<?php 
/*****************************************************************************
 * SV-Cart Flashes管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 2504 2009-07-01 08:24:22Z huangbo $
*****************************************************************************/
?>
<style type='text/css'>
table.table td{
	padding:2px 0;
}
table.table td.paddings{
	padding-left:5px;
}
</style>

<?php echo $javascript->link('flashes');?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Search-->
<div class="search_box">
<script type='text/javascript'>

function typechange(){
	var	selects = document.getElementById('selects');
	var	select1 = document.getElementById('select1');
	var	select2 = document.getElementById('select2');
	var select3 = document.getElementById('select3');
	var type = document.getElementById('flashType');
	var is_none = document.getElementById('is_none');
	
	//alert(type.value);
	switch(type.value){
		case 'B':selects.innerHTML = select1.innerHTML;is_none.style.display = "none";flash_change(document.getElementById('bTypeId').value);break;
		case 'PC':selects.innerHTML = select2.innerHTML;is_none.style.display = "none";flash_change(document.getElementById('pcTypeId').value);break;
		case 'AC':selects.innerHTML = select3.innerHTML;is_none.style.display = "none";flash_change(document.getElementById('acTypeId').value);break;
		default:selects.innerHTML = "";is_none.style.display = "block";flash_change(0);
	}
	
}
</script>
<?php echo $form->create('',array('action'=>'./','name'=>'FlashForm','onload'=>'typechange()','type'=>'get'));?>

	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">
		类型:
		<select name="flashtype" id='flashType' onchange='typechange();'>
<?php if(isset($flashtypes) && sizeof($flashtypes)>0){
		 foreach($flashtypes as $k => $v){?>
			<option value="<?php echo $k;?>" <?php if($k==$type)echo "selected";?>><?php echo $v;?></option>
		<?php }}?>		
		</select>
			<span id="selects"></span>
		

		<select style="width:80px;" name="language">
			<option value=''>全部语言</option>
<?php if(isset($languages) && sizeof($languages)>0){
		foreach($languages as $k => $v){?>
			<option value="<?php echo $v['Language']['locale'];?>" <?php if($v['Language']['locale']==$language)echo "selected";?>><?php echo $v['Language']['name'];?></option>
		<?php }}?>
		</select>
		</p></dd>
	<dt class="small_search"><input type="submit" value="搜索"  class="search_article" /></dt>
		</dl>
<?php echo $form->end();?>
</div>
<div class="height_5">&nbsp;</div>
<div class="search_box">
<?php echo $form->create('Flashe',array('action'=>'./'));?>
		<table id="is_none" style="display:none;" cellpadding='0' cellspacing='0' border='0' width='100%' class='table'>
			<tr>
			<td colspan="8" class='paddings' height="25">注：flash设置留空为默认值</td>
			</tr>
			<tr valign="middle">
					<td class='paddings'>width：</td>
					<td><input type="text" id="width" name="data[Flashe][width]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>height ：</td>
					<td><input type="text" id="height" name="data[Flashe][height]"  style="width:125px;border:1px solid #649776"  /></td>
			</tr>
			<tr valign="middle">
				<td class='paddings'>
				<input type="hidden" name="data[Flashe][id]" id="id">
				<input type="hidden" name="data[Flashe][type]"  id="type">
				<input type="hidden" name="data[Flashe][type_id]"  id="type_id">
				roundcorner：</td>
				<td><input type="text" id="roundcorner" name="data[Flashe][roundcorner]"  style="width:125px;border:1px solid #649776"  /></td>
				<td class='paddings'>autoplaytime：</td>
				<td><input type="text" id="autoplaytime" name="data[Flashe][autoplaytime]"  style="width:125px;border:1px solid #649776"  /></td>
				<td class='paddings'>isheightquality：</td>
				<td><input type="text" id="isheightquality" name="data[Flashe][isheightquality]"  style="width:125px;border:1px solid #649776"  /></td>
				<td class='paddings'>blendmode：</td>
				<td><input type="text" id="blendmode" name="data[Flashe][blendmode]"  style="width:125px;border:1px solid #649776"  /></td>
			</tr>
				<tr valign="middle">
					<td class='paddings'>transduration：</td>
					<td><input type="text" id="transduration" name="data[Flashe][transduration]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>windowopen：</td>
					<td><input type="text" id="windowopen" name="data[Flashe][windowopen]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>btnsetmargin：</td>
					<td><input type="text" id="btnsetmargin" name="data[Flashe][btnsetmargin]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>btndistance：</td>
					<td><input type="text"id="btndistance" name="data[Flashe][btndistance]"  style="width:125px;border:1px solid #649776"  /></td>
				</tr>
				<tr>
					<td valign="middle" class='paddings'>titlebgcolor：</td>
					<td><input type="text" id="titlebgcolor" name="data[Flashe][titlebgcolor]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings' valign="middle">titletextcolor：</td>
					<td><input type="text" id="titletextcolor" name="data[Flashe][titletextcolor]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings' valign="middle">titlebgalpha：</td>
					<td><input type="text" id="titlebgalpha" name="data[Flashe][titlebgalpha]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings' valign="middle">titlemoveduration：</td>
					<td><input type="text" id="titlemoveduration" name="data[Flashe][titlemoveduration]"  style="width:125px;border:1px solid #649776"  /></td>
				</tr>
				<tr valign="middle">
					<td class='paddings'>btnalpha：</td>
					<td><input type="text" id="btnalpha" name="data[Flashe][btnalpha]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>btntextcolor：</td>
					<td><input type="text" id="btntextcolor" name="data[Flashe][btntextcolor]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>btndefaultcolor：</td>
					<td><input type="text" id="btndefaultcolor" name="data[Flashe][btndefaultcolor]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>btnhovercolor：</td>
					<td><input type="text" id="btnhovercolor" name="data[Flashe][btnhovercolor]"  style="width:125px;border:1px solid #649776"  /></td>
				</tr>
				<tr valign="middle">
					<td class='paddings'>btnfocuscolor：</td>
					<td><input type="text" id="btnfocuscolor" name="data[Flashe][btnfocuscolor]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>changimagemode：</td>
					<td><input type="text" id="changimagemode" name="data[Flashe][changimagemode]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>isshowbtn：</td>
					<td><input type="text" id="isshowbtn" name="data[Flashe][isshowbtn]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>isshowtitle：</td>
					<td><input type="text" id="isshowtitle" name="data[Flashe][isshowtitle]"  style="width:125px;border:1px solid #649776"  /></td>
				</tr>
				<tr valign="middle">
					<td class='paddings'>scalemode：</td>
					<td><input type="text" id="scalemode" name="data[Flashe][scalemode]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>transform：</td>
					<td><input type="text" id="transform" name="data[Flashe][transform]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>isshowabout：</td>
					<td><input type="text" id="isshowabout" name="data[Flashe][isshowabout]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>titlefont：</td>
					<td><input type="text" id="titlefont" name="data[Flashe][titlefont]"  style="width:125px;border:1px solid #649776"  /></td>
				</tr>
				
				<tr>
					<td colspan='8' valign='bottom' align='center' height='35'><input class="search_article" type="submit" value="提交" /></td
				></tr>
</table>
<?php echo $form->end();?>
</div>
<br />
<!--Search End-->
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."添加图片","add/",'',false,false);?></strong></p>

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
					
	<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
	<tr class="thead">
		<th>类型</th>
		<th>语言</th>
		<th>轮播图片链接</th>
		<th>排序</th>
		<th>是否有效</th>
		<th class="no_border">操作</th>
	</tr>
<!--User List-->
<?php if(isset($flashes) && sizeof($flashes)>0){foreach($flashes as $flash){?>
	<tr>
		<td align="center"><?php echo $flash['Flash']['typename'];?></td>
		<td align="center"><?php echo $flash['FlashImage']['locale'];?></td>
		<td><?php echo $html->link("{$flash['FlashImage']['image']}","{$flash['FlashImage']['image']}",'',false,false);?></td>
		<td align="center"><?php echo $flash['FlashImage']['orderby']?></td>
		<td align="center"><?php if($flash['FlashImage']['status']) echo $html->image('yes.gif');else echo $html->image('no.gif');?></td>
		<td align="center">
		<?php echo $html->link("编辑","/flashes/edit/{$flash['FlashImage']['id']}");?> |
		<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}flashes/remove/{$flash['FlashImage']['id']}')"));?>
		</td>
	</tr>
<?php }?>
	</table>

<!--User List End-->	

<div class="pagers" style="position:relative">
<?php echo $this->element('pagers',array('cache'=>"+0 hour"));?>
</div>
<?php }else echo "找不到您要的Flash";?>
</div>
	
<!--Main Start End-->
</div>
	<span style="display:none">
	<span id="select1">
	<select  name="btypeid" id='bTypeId' onchange='flash_change(this.options[this.options.selectedIndex].value);'   >
			<option value='0'>全部页面</option>
<?php if(isset($b) && sizeof($b)>0){
		 foreach($b as $k => $v){?>
			<option value="<?php echo $k;?>" <?php if($k==$typeid)echo "selected";?>><?php echo $v;?></option>
		<?php }}?>
		</select>
</span>	<span id="select2">
					<select  name="pctypeid" id='pcTypeId' onchange='flash_change(this.options[this.options.selectedIndex].value);' >
			<option value='0'>全部页面</option>
<?php if(isset($pc) && sizeof($pc)>0){
		 foreach($pc as $k => $v){?>
			<option value="<?php echo $k;?>" <?php if($k==$typeid)echo "selected";?>><?php echo $v;?></option>
		<?php }}?>
		</select>
	</span>			<span id="select3">			
		<select  name="actypeid" id='acTypeId' onchange='flash_change(this.options[this.options.selectedIndex].value);' >
			<option value='0'>全部页面</option>
<?php if(isset($ac) && sizeof($ac)>0){
		 foreach($ac as $k => $v){?>
			<option value="<?php echo $k;?>" <?php if($k==$typeid)echo "selected";?>><?php echo $v;?></option>
		<?php }}?>
		</select>
</span>
</span>
<script type='text/javascript'>typechange();</script>