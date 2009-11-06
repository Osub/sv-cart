<?php 
/*****************************************************************************
 * SV-Cart 字典管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3812 2009-08-20 02:49:58Z zhengli $
*****************************************************************************/
?>
<?php echo $javascript->link('foreach_translate');?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->
<div class="search_box">
	<dl class="dictionaries">
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
			<?php if(isset($language) && count($language)>0){?>
			<dd>
			<?php echo $form->create('language_dictionaries',array('action'=>'/','name'=>'language_form','type'=>'GET'));?>

			<select id="locale" name="locale" onchange='javascript:document.language_form.submit();'>
			<option>选择语言</option>
			<?php foreach($language as $key=>$value){ ?>
			<?php if($value['Language']['name'] != ""){?>
			<?php if(isset($is_select_locale) && $is_select_locale == $value['Language']['locale']){?>
			<option value="<?php echo $value['Language']['locale'];?>" selected>
			<?php }else{?>
			<option value="<?php echo $value['Language']['locale'];?>">
			<?php }?>
			<?php echo $value['Language']['name'];?></option>
			<?php }?>
			<?php }?>
			</select>
			<?php echo $form->end();?>
			</dd>
			<?php }else{?>
			无语言选择
			<?php }?>
			<?php if(isset($is_select_locale)){?>
			<dd>
			<?php echo $form->create('language_dictionaries',array('action'=>'/','name'=>'type_form','type'=>'GET'));?>

			<input type="hidden" name="locale" value="<?php echo $is_select_locale;?>">
		 	<?php if(isset($language_type) && count($language_type)>0){?>
		 	<select id="language_type" name="language_type" onchange='javascript:check_type_form('');'>
		 	<option value="all_type">所有类型</option>
    		<?php foreach($language_type as $key=>$value){ ?>
    		<?php if($value['SystemResource']['resource_value'] != ""){?>
    		<?php if(isset($is_select_type) && $is_select_type == $value['SystemResource']['resource_value']){?>
    		<option selected>
    		<?php }else{?>
    		<option>
			<?php }?>
    		<?php echo $value['SystemResourceI18n']['name'];?></option>
    		<?php }?>
    		<?php }?>
    		</select>
    		<?php }else{?>
    		无类型选择
    		<?php }?>
		</dd>
		<dd>
		
			<select style="margin:0;" id="language_type" name="language_location" onchange='javascript: check_type_form('');'>
			<option value="all_location" <?php if(isset($_SESSION['is_select_location']) && $_SESSION['is_select_location'] == "all_location"){ echo "selected";}?>>所有位置</option>
			<option value="front"<?php if(isset($_SESSION['is_select_location']) && $_SESSION['is_select_location'] == "front"){ echo "selected";}?>>前台</option>
			<option value="back"<?php if(isset($_SESSION['is_select_location']) && $_SESSION['is_select_location'] == "back"){ echo "selected";}?>>后台</option>
			</select>
		</dd>
		<dd><input class="border_green_6" style="*margin-top:-1px;" type="text" name="keywords"  id="keywords" value="<?php if(isset($_SESSION['is_keywords'])){echo $_SESSION['is_keywords'];}?>" /></dd>
			<dt class="big_search"><input  class="search_article" type="button" onclick="javascript:check_type_form('submit');" value="查询" /><?php echo $form->end();?>
		 	<input type="button" value="导出"   class="search_article"  onclick="export_act()" />
		 	<input type="button" value="导入"   class="search_article"  onclick="import_act()" />
		</dt>
	</dl>
	<dl class="dictionaries" id="import_span" style="display:none;margin-left:185px;">
	<?php echo $form->create('language_dictionaries',array('action'=>'/import','name'=>'Import','type'=>'POST',"enctype"=>"multipart/form-data"));?>
	<dd><input class="border_green_6" style="*margin-top:-1px;"  name="file" type="file"  /></dd>
	<dt class="big_search">	<input type="submit" value="确定"   class="search_article" />
			注意：上传文件编码格式gb2312编码 （CSV文件中一次上传语言数量最好不要超过1000，CSV文件大小最好不要超过500K.）			
	</dt>		
	<?php echo $form->end();?>
	</dl>
<?php }else{?>
	<dl class="dictionaries">
			<dd></dd>
		<dt class="curement">
		 	<input type="button" value="导入"   class="search_article"  onclick="import_act()" />
		</dt>
	</dl>
	<dl class="dictionaries" id="import_span" style="display:none;margin-left:185px;">
	<?php echo $form->create('language_dictionaries',array('action'=>'/import','name'=>'Import','type'=>'POST',"enctype"=>"multipart/form-data"));?>
	<dd><input class="border_green_6" style="*margin-top:-1px;"  name="file" type="file"  /></dd>
	<dt class="curement">	<input type="submit" value="确定"   class="big" />
			注意：上传文件编码格式gb2312编码 （CSV文件中一次上传语言数量最好不要超过1000，CSV文件大小最好不要超过500K.）			
	</dt>		
	<?php echo $form->end();?>
	</dl>


<?php }?>
</div>
<br />
<?php echo $form->create('language_dictionaries',array('action'=>'/export','name'=>'Export','type'=>'POST'));?>
		<input type="hidden" name="export_locale" id="export_locale" value="<?php echo isset($is_select_locale)?$is_select_locale:'';?>" />
		<input type="hidden" name="export_type"  id="export_type" value="" />
		<input type="hidden" name="export_location"  id="export_location" value="" />
		<input type="hidden" name="export_keyword"  id="export_keyword" value="" />
		<input type="hidden" name="export"  id="export" value="export" />
<?php echo $form->end();?>
<script type="text/javascript">
function export_act(){ 
	document.getElementById('export_type').value = document.getElementById('language_type').value;
	document.getElementById('export_location').value = document.getElementById('language_location').value;
	document.getElementById('export_keyword').value = document.getElementById('keywords').value;
	document.forms['Export'].submit(); 
}		

function import_act(){
	if(document.getElementById('import_span').style.display == "none"){
	document.getElementById('import_span').style.display = "";
	}else{
	document.getElementById('import_span').style.display = "none";
	}
}


</script>
<!-- end -->
<!--Search End-->
<!--Main Start-->
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr>
	<th style="width:8%;">编号</th>
	<th style="width:17%;">名称</th>
	<th style="width:8%;">位置</th>
	<th style="width:8%;">类型</th>
	<th style="width:22%;">内容</th>
	<th style="width:28%;">描述</th>
	<th style="width:8%;">操作</th>
</tr>
	<?php if(isset($language_dictionaries) && count($language_dictionaries)>0){?>
	<?php foreach($language_dictionaries as $k=>$v){?>
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	
	<td style="width:8%;"><div id="lang_id"><?php echo $v['LanguageDictionary']['id']?></div></td>
	
	<td style="width:17%;">
		<div class="m">
		<div id="lang_name<?php echo $v['LanguageDictionary']['id']?>">
		<div id="name<?php echo $v['LanguageDictionary']['id']?>" onclick="javascript:go_input(<?php echo $v['LanguageDictionary']['id']?>,'<?php echo $v['LanguageDictionary']['name']?>','name',17);">
		<?php echo $v['LanguageDictionary']['name']?>
		</div>
		</div></div></td>
	
	<td style="width:8%;"><?php echo $v['LanguageDictionary']['location']?></td>
	
	<td id="type<?php echo $v['LanguageDictionary']['id']?>" style="width:8%;">
		<div id="lang_type<?php echo $v['LanguageDictionary']['id']?>">
		<!--div  onclick="javascript:go_input(<?php echo $v['LanguageDictionary']['id']?>,'<?php echo $v['LanguageDictionary']['type']?>','type',8);"--><?php if(isset($language_type_assoc[$v['LanguageDictionary']['type']])) echo $language_type_assoc[$v['LanguageDictionary']['type']]; else echo $v['LanguageDictionary']['type'];?><!--/div-->
		</div>
	</td>
	
	<td style="width:22%;" >
	<div  class="m">
	<div id="lang_value<?php echo $v['LanguageDictionary']['id']?>">
	<div id="value<?php echo $v['LanguageDictionary']['id']?>" onclick="javascript:go_input(<?php echo $v['LanguageDictionary']['id']?>,'<?php echo $v['LanguageDictionary']['value']?>','value',22);"><?php echo $v['LanguageDictionary']['value']?></div>
	</div>
	</div>
	</td>
	
	<td style="width:28%;">
	<div  class="m">
	<div id="lang_description<?php echo $v['LanguageDictionary']['id']?>">
	<div id="description<?php echo $v['LanguageDictionary']['id']?>" onclick="javascript:go_input(<?php echo $v['LanguageDictionary']['id']?>,'<?php echo $v['LanguageDictionary']['description']?>','description',28);"><?php echo $v['LanguageDictionary']['description']?></div>
	</div>
	</div>
	</td>
	
	<td style="width:8%;"><?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}language_dictionaries/remove/{$v['LanguageDictionary']['id']}')"),false,false);?></td>
</tr>
	<?php }?>
<?php }else{?>
<tr><td colspan=7 align="center"><span style='font-size:16px;font-weight:bold;'>
	<?php if(isset($is_select_locale)){?>
	没有相关信息
	<?php }else{?>
	请先选择语言
	<?php }?>
	</span></td>
</tr>
<?php }?>
<?php if(isset($language_dictionaries) && count($language_dictionaries)>0){?>
<div class="pagers" style="position:relative;">
<?php echo $this->element('dictionaries_pagers', array('cache'=>'+0 hour'));?>
</div><br/><br/>
<?php }?>		
</table>

<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr>
	<th>新增</th>
	<th>名称</th>
	<th>位置</th>
	<th>类型</th>
	<th>语言</th>
	<th>内容</th>
	<th>描述</th>
	<th width="8%">操作</th>
</tr>
<?php echo $form->create('language_dictionaries',array('action'=>'add','name'=>'add_form'));?>

	<?php 
	$n = 0;
	if(isset($language) && sizeof($language)>0){
	foreach($language as $key=>$value){ 
	$n++;
	?>
	<?php if($n>1){?>
	<input type="hidden" id="foreach_local_name<?php echo $n?>" value="<?php echo $value['Language']['name']?>" />
	<input type="hidden" id="foreach_local<?php echo $n?>" value="<?php echo $value['Language']['locale']?>" />
	<input type="hidden" id="foreach_local_google<?php echo $n?>" value="<?php echo $value['Language']['google_translate_code']?>" />
	<?php }?>
	<?php if($value['Language']['locale'] == $locale){
		$google_translate_code = $value['Language']['google_translate_code'];

	?>		
	<input type="hidden" id="google_translate_code" value="<?php echo $google_translate_code?>" />

	<tr>
	<td>新增</td>
	<td><input class="border_green_6" name="name" style="width:95%;margin:-5px 0"  id="add_name" value=""></td>
	<td>
	<select  id="language_location" name="location"><option value="front">前台</option><option value="back">后台</option></select></td>
	<td style="width:8%;">
	<?php if(isset($language_type) && count($language_type)>0){?>
	<select  id="language_type" name="type"><?php foreach($language_type as $key=>$value){ ?><?php if($value['SystemResource']['resource_value'] != ""){?>
    <option value="<?php echo $value['SystemResource']['resource_value'];?>"><?php echo $value['SystemResourceI18n']['name'];?></option><?php }?><?php }?>
    </select>
    <?php }else{?>
   	无类型选择
    <?php }?>
	</td>
	<td>
<?php if(isset($language) && sizeof($language)>0){?>
	<?php foreach($language as $kk=>$vv){ ?>
	<?php if($vv['Language']['name'] != ""){?>
	<?php if($locale == $vv['Language']['locale']){?>
					<?php echo $vv['Language']['name'];?>
			<?php }?>
			<?php }?>
			<?php }?><?php }?>
	</td>
	<td>
	<input class="border_green_6" name="data[LanguageDictionary][<?php echo $locale;?>][value]" id="locale_value" style="width:95%;margin:-5px 0"   value=""></td>
	<td>
	<input class="border_green_6" name="data[LanguageDictionary][<?php echo $locale;?>][description]" id="locale_description" style="width:95%;margin:-5px 0"   value=""></td>
	<td></td>
	</tr>
	<?php }else{?>
	<?php if($value['Language']['name'] != ""){?>
	<tr>
	
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td><?php echo $value['Language']['name']?></td>
	<td>
	<input class="border_green_6" name="data[LanguageDictionary][<?php echo $value['Language']['locale'];?>][value]" style="width:95%;margin:-5px 0"  id="<?php echo $value['Language']['locale'];?>value" value=""></td>

	<td>
	<input class="border_green_6" name="data[LanguageDictionary][<?php echo $value['Language']['locale'];?>][description]" style="width:95%;margin:-5px 0"  id="<?php echo $value['Language']['locale'];?>description" value=""></td>
	<td>
	<?php if(count($language) == $n){?>
	<?php echo $html->link("增加","javascript:document.add_form.submit();",'',false,false);?>|<?php echo $html->link("翻译","javascript:foreach_translate();",'',false,false);?><!--|<a href="javascript:stop_translate();">停止翻译</a-->
	<?php }?>
	</td>
	</tr>
	<?php }}}}?></table></div>
<?php echo $form->end();?>

</div>
<!--Main Start End-->
</div>
<script>
	function check_type_form(act){
		var keywords=document.getElementById('keywords').value;
		if(keywords == ""){
			if(act =="submit"){
				alert("请输入关键字!");
			}
			return;
		}else{
			 document.type_form.submit();
		}
	}
</script>