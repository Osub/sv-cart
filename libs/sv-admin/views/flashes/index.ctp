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
 * $Id: index.ctp 1327 2009-05-11 11:01:20Z huangbo $
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

<?=$javascript->link('flashes');?>
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
	<dt style="padding-top:0;"><?=$html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article">
		类型:
		<select name="flashtype" id='flashType' onchange='typechange();'>
<? if(isset($flashtypes) && sizeof($flashtypes)>0){
		 foreach($flashtypes as $k => $v){?>
			<option value="<?php echo $k;?>" <?php if($k==$type)echo "selected";?>><?php echo $v;?></option>
		<?php }}?>		
		</select>
			<span id="selects"></span>
		

		<select style="width:80px;" name="language">
			<option value=''>全部语言</option>
<? if(isset($languages) && sizeof($languages)>0){
		foreach($languages as $k => $v){?>
			<option value="<?php echo $v['Language']['locale'];?>" <?php if($v['Language']['locale']==$language)echo "selected";?>><?php echo $v['Language']['name'];?></option>
		<?php }}?>
		</select>
		</p></dd>
	<dt class="small_search"><input type="submit" value="搜索"  class="search_article" />  &nbsp &nbsp&nbsp &nbsp&nbsp&nbsp &nbsp&nbsp &nbsp&nbsp注：flash设置留空为默认值</dt></dl>
<? echo $form->end();?>
<?php echo $form->create('Flashe',array('action'=>'./'));?>
		<table id="is_none" style="display:none;" cellpadding='0' cellspacing='0' border='0' width='100%' class='table'>
			<tr valign="middle">
					<td class='paddings'>width：</td>
					<td><input type="text" id="width" name="data[Flashe][width]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>height ：</td>
					<td><input type="text" id="height" name="data[Flashe][height]"  style="width:125px;border:1px solid #649776"  /></td>
					
			
			<tr valign="middle">
				<td class='paddings'>
					<input type="hidden" name="data[Flashe][id]" id="id">
					<input type="hidden" name="data[Flashe][type]"  id="type">
					<input type="hidden" name="data[Flashe][type_id]"  id="type_id">
					roundCorner：</td>
				<td><input type="text" id="roundCorner" name="data[Flashe][roundCorner]"  style="width:125px;border:1px solid #649776"  /></td>
				<td class='paddings'>autoPlayTime：</td>
				<td><input type="text" id="autoPlayTime" name="data[Flashe][autoPlayTime]"  style="width:125px;border:1px solid #649776"  /></td>
				<td class='paddings'>isHeightQuality：</td>
				<td><input type="text" id="isHeightQuality" name="data[Flashe][isHeightQuality]"  style="width:125px;border:1px solid #649776"  /></td>
				<td class='paddings'>blendMode：</td>
				<td><input type="text" id="blendMode" name="data[Flashe][blendMode]"  style="width:125px;border:1px solid #649776"  /></td>
			</tr>
				<tr valign="middle">
					<td class='paddings'>transDuration：</td>
					<td><input type="text" id="transDuration" name="data[Flashe][transDuration]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>windowOpen：</td>
					<td><input type="text" id="windowOpen" name="data[Flashe][windowOpen]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>btnSetMargin：</td>
					<td><input type="text" id="btnSetMargin" name="data[Flashe][btnSetMargin]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>btnDistance：</td>
					<td><input type="text"id="btnDistance" name="data[Flashe][btnDistance]"  style="width:125px;border:1px solid #649776"  /></td>
				</tr>
				<tr>
					<td valign="middle" class='paddings'>titleBgColor：</td>
					<td><input type="text" id="titleBgColor" name="data[Flashe][titleBgColor]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings' valign="middle">titleTextColor：</td>
					<td><input type="text" id="titleTextColor" name="data[Flashe][titleTextColor]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings' valign="middle">titleBgAlpha：</td>
					<td><input type="text" id="titleBgAlpha" name="data[Flashe][titleBgAlpha]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings' valign="middle">titleMoveDuration：</td>
					<td><input type="text" id="titleMoveDuration" name="data[Flashe][titleMoveDuration]"  style="width:125px;border:1px solid #649776"  /></td>
				</tr>
				<tr valign="middle">
					<td class='paddings'>btnAlpha：</td>
					<td><input type="text" id="btnAlpha" name="data[Flashe][btnAlpha]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>btnTextColor：</td>
					<td><input type="text" id="btnTextColor" name="data[Flashe][btnTextColor]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>btnDefaultColor：</td>
					<td><input type="text" id="btnDefaultColor" name="data[Flashe][btnDefaultColor]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>btnHoverColor：</td>
					<td><input type="text" id="btnHoverColor" name="data[Flashe][btnHoverColor]"  style="width:125px;border:1px solid #649776"  /></td>
				</tr>
				<tr valign="middle">
					<td class='paddings'>btnFocusColor：</td>
					<td><input type="text" id="btnFocusColor" name="data[Flashe][btnFocusColor]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>changImageMode：</td>
					<td><input type="text" id="changImageMode" name="data[Flashe][changImageMode]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>isShowBtn：</td>
					<td><input type="text" id="isShowBtn" name="data[Flashe][isShowBtn]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>isShowTitle：</td>
					<td><input type="text" id="isShowTitle" name="data[Flashe][isShowTitle]"  style="width:125px;border:1px solid #649776"  /></td>
				</tr>
				<tr valign="middle">
					<td class='paddings'>scaleMode：</td>
					<td><input type="text" id="scaleMode" name="data[Flashe][scaleMode]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>transform：</td>
					<td><input type="text" id="transform" name="data[Flashe][transform]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>isShowAbout：</td>
					<td><input type="text" id="isShowAbout" name="data[Flashe][isShowAbout]"  style="width:125px;border:1px solid #649776"  /></td>
					<td class='paddings'>titleFont：</td>
					<td><input type="text" id="titleFont" name="data[Flashe][titleFont]"  style="width:125px;border:1px solid #649776"  /></td>
				</tr>
				
				<tr>
					<td colspan='8' valign='bottom' align='center' height='35'><input class="search_article" type="submit" value="提交" /></td
				></tr>
</table>
<? echo $form->end();?>
</div>
<br />
<!--Search End-->
<!--Main Start-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."添加图片","add/",'',false,false);?></strong></p>

<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
	<ul class="product_llist flashes">
	<li class="type">类型</li>
	<li class="lang">语言</li>
	<li class="url" style='text-align:left'><span style='margin-left:5px;'>轮播图片链接</span></li>
	<li class="taixs">排序</li>
	<li class="in_effect">是否有效</li>
	<li class="hadle">操作</li></ul>
<!--User List-->
<?php if(isset($flashes) && sizeof($flashes)>0){foreach($flashes as $flash){?>
	<ul class="product_llist flashes flashes_list">
	<li class="type"><?=$flash['Flash']['typename'];?></li>
	<li class="lang"><?=$flash['FlashImage']['locale'];?></li>
	<li class="url"><p><?=$html->link("{$flash['FlashImage']['image']}","{$flash['FlashImage']['image']}",'',false,false);?></p></li>
	<li class="taixs"><?=$flash['FlashImage']['orderby']?></li>
	<li class="in_effect"><?php if($flash['FlashImage']['status']) echo $html->image('yes.gif');else echo $html->image('no.gif');?></li>
	<li class="hadle">
	<?php echo $html->link("编辑","/flashes/edit/{$flash['FlashImage']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}flashes/remove/{$flash['FlashImage']['id']}')"));?>
		</li></ul>
<?php }?>
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
<? if(isset($b) && sizeof($b)>0){
		 foreach($b as $k => $v){?>
			<option value="<?php echo $k;?>" <?php if($k==$typeid)echo "selected";?>><?php echo $v;?></option>
		<?php }}?>
		</select>
</span>	<span id="select2">
					<select  name="pctypeid" id='pcTypeId' onchange='flash_change(this.options[this.options.selectedIndex].value);' >
			<option value='0'>全部页面</option>
<? if(isset($pc) && sizeof($pc)>0){
		 foreach($pc as $k => $v){?>
			<option value="<?php echo $k;?>" <?php if($k==$typeid)echo "selected";?>><?php echo $v;?></option>
		<?php }}?>
		</select>
	</span>			<span id="select3">			
		<select  name="actypeid" id='acTypeId' onchange='flash_change(this.options[this.options.selectedIndex].value);' >
			<option value='0'>全部页面</option>
<? if(isset($ac) && sizeof($ac)>0){
		 foreach($ac as $k => $v){?>
			<option value="<?php echo $k;?>" <?php if($k==$typeid)echo "selected";?>><?php echo $v;?></option>
		<?php }}?>
		</select>
</span>
</span>
<script type='text/javascript'>typechange();</script>