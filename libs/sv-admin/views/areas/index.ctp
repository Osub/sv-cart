<?php
/*****************************************************************************
 * SV-Cart 地区设置
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1250 2009-05-07 13:59:20Z huangbo $
*****************************************************************************/
?> 
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start-->

<div class="home_main">



<!--Areas List-->
	<div class="order_stat properies">
	  <div class="title">
	  <?if(isset($pid) && $pid != 0){?>
<?=$html->link($html->image('btn_left.gif',array('class'=>'left')).$html->image('btn_right.gif',array('class'=>'right'))."上一级","javascript:history.go(-1);",array("class"=>"add_main"),false,false);?>

	  
	  <?}?>
<?=$html->link($html->image('btn_left.gif',array('class'=>'left')).$html->image('btn_right.gif',array('class'=>'right'))."新增区域","javascript:showPanel2();",array("class"=>"add_main"),false,false);?>
<h1>
	  <?=$html->image('tab_left.gif',array('class'=>'left'))?>
	  <?=$html->image('tab_right.gif',array('class'=>'right'))?>
	  <?=$num_name?></h1></div>
	  <div class="box">
	  <?if(isset($area_list) && sizeof($area_list)>0){?>	
<?foreach($area_list as $k=>$v){?>
		<div class="language_manages" style="margin-right:15px;float:left;display:inline;"><span><?=$html->image('zh_cn.gif',array('align'=>'absmiddle'))?>
		<?if($v['RegionI18n']['name'] == '未命名'){?>
		<!--    <input name="region_name" id="region_name" value="未命名" onblur="javascript:edit_region_name(this.value);" size="5"/>
		    <input name="regioni18n_id" id="regioni18n_id" value="<?echo $v['RegionI18n']['id'];?>" type="hidden"/>
		--><?}else{?>
		     <?echo $v['RegionI18n']['name']?>
		<?}?>
		</a></span>
		<span style="margin:0 3px;"><?=$html->image('line_.gif',array('align'=>'absmiddle'))?></span>
		<span class="handle"><?=$html->link("管理","/areas/index/{$v['Region']['id']}",'',false,false);?>&nbsp&nbsp<?=$html->link("编辑","javascript:edit({$v['RegionI18n']['region_id']},{$pid})",'',false,false);?>&nbsp&nbsp<?=$html->link("删除","/areas/remove/{$v['Region']['id']}",'',false,false);?></span></div>
<?}?><?}?>
	  </div>
	</div>
<!--Areas List End-->

</div>
	<?//pr($languages)?>
	
<div id="img_dir" style="display:none">
<?php echo $form->create('areas',array('action'=>'add','name'=>'','id'=>''));?>
	
	<div id="loginout" >
		<h1><b>编辑地区</b></h1>
		<div id="buyshop_box">
		<br />
		<p>
		<? if(isset($languages) && sizeof($languages)>0){
		
		foreach ($languages as $k => $v){?>
			<input id="" name="data[RegionI18n][<?=$k;?>][locale]" type="hidden" value="<?= $v['Language']['locale'];?>">
		<?}}?>
		</p>
		<? if(is_array($languages)){
			foreach ($languages as $k => $v){?>
			<div class="keyword">
			<input type="hidden" name="data[RegionI18n][<?=$k;?>][id]" id="RegionI18n_id_<?=$v['Language']['locale'];?>" />
			<dd><b><?=$v['Language']['name']?></b></dd>
			<dt><input id="RegionI18n_name_<?=$v['Language']['locale'];?>" name="data[RegionI18n][<?=$k;?>][name]" type="text" maxlength="100"  value=""></dt>
			</div>
		<?}}?>
		
			<input type="hidden" name="r_id" id="r_id" />
			<input type="hidden" name="parent_id" value="<?echo $pid;?>" />
			<p align="center">
			<input type="submit" value="确定">
			<input type="button" value="取消" onclick="big_panel.hide()">
			</p>
		</div>
		<p><?=$html->image("loginout-bottom.gif");?></p>
	</div><? echo $form->end();?>

</div>
<!--Main Start End-->	

<script>

window.onload = function(){
	document.getElementById('img_dir').style.display="block";
	initPage2();
}
function initPage2(){
	tabView = new YAHOO.widget.TabView('contextPane'); 
	big_panel = new YAHOO.widget.Panel("img_dir", 
								{
									visible:false,
									draggable:false,
									modal:true,
									style:"margin 0 auto",
									fixedcenter: true
								} 
							); 
			big_panel.render();
		}
function showPanel2(){
	big_panel.show();
}

function edit(region_id,pid){
	
	var sUrl = webroot_dir+"areas/edit/"+region_id;
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, edit_record_callback);
	big_panel.show();document.getElementById("r_id").value = region_id;
}

	var edit_record_Success = function(o){
		//alert(o.responseText);
		eval('result='+o.responseText); 
		for(var i=0;i<=result.length-1;i++){
			document.getElementById("RegionI18n_name_"+result[i].locale).value = result[i].name;
			document.getElementById("RegionI18n_id_"+result[i].locale).value = result[i].id;
			
			
		}
		//window.location.reload();
	}
	
	var edit_record_Failure = function(o){
		alert("error");
	}

	var edit_record_callback ={
		success:edit_record_Success,
		failure:edit_record_Failure,
		timeout : 10000,
		argument: {}
	};
			
				
				
  function show_add_region(){
          	send_style=document.getElementById('new_region');
	           if(send_style.style.display=="none"){
		              send_style.style.display="block";
	            }
	           else{
		              send_style.style.display="none";
	           }
  }

</script>
