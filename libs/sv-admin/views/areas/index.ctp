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
 * $Id: index.ctp 3673 2009-08-17 09:57:45Z huangbo $
*****************************************************************************/
?> 
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start--> 
<?php if(isset($pid) && $pid != 0){?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."上一级","javascript:history.go(-1);",'',false,false);?></strong></p>
<?php }?>
<div class="home_main">



<!--Areas List-->
	<div class="order_stat properies">
	  <div class="title">

<?php echo $html->link($html->image('btn_left.gif',array('class'=>'left')).$html->image('btn_right.gif',array('class'=>'right'))."新增区域","javascript:showPanel2();",array("class"=>"add_main"),false,false);?>
<h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  <?php echo $num_name?></h1></div>
	  <div class="box">
	<table  cellpadding="0" cellspacing="0" width="100%" >
	  <?php if(isset($area_list) && sizeof($area_list)>0){?>	
<?php $j=1;foreach($area_list as $k=>$v){?>
	<?php if($j==1){?><tr><?php }?><td align="right">
		<?php if($v['RegionI18n']['name'] == '未命名'){}else{?>
		<?php echo $v['RegionI18n']['name']?>
		<?php }?>
		<span style="margin:0 3px;"><?php echo $html->image('line_.gif',array('align'=>'absmiddle'))?></span>
		</td><td><span class="handle"><?php echo $html->link("管理","/areas/index/{$v['Region']['id']}",'',false,false);?>&nbsp&nbsp<?php echo $html->link("编辑","javascript:edit({$v['RegionI18n']['region_id']},{$pid})",'',false,false);?>&nbsp&nbsp<?php echo $html->link("删除","/areas/remove/{$v['Region']['id']}",'',false,false);?></span></div>
	</td><?php $j++;if($j==8){?></tr><?php $j=1;}?>
<?php }}?>
	</table>
	  </div>
	</div>
<!--Areas List End-->

</div>
	<?php //pr($languages)?>
	
<div id="img_dir" style="display:none">
<?php echo $form->create('areas',array('action'=>'add','name'=>'','id'=>''));?>
	
	<div id="loginout" >
		<h1><b>编辑地区</b></h1>
		<div id="buyshop_box">
		<br />
		<p>
		<?php if(isset($languages) && sizeof($languages)>0){
		
		foreach ($area_languages as $k => $v){?>
			<input id="" name="data[RegionI18n][<?php echo $k;?>][locale]" type="hidden" value="<?php echo  $v['Language']['locale'];?>">
		<?php }}?>
		</p>
		<div class="keyword" style="float:right">
			<dl>
			<dd><b>排序：</b></dd><dt><input type="text" name="orderby" id="orderby" value="" ></dt>
			<dd><b>简写：</b></dd><dt><input type="text" name="abbreviated" id="abbreviated" value="" ></dt>
			</dl>
			</div>
		<?php if(is_array($languages)){?>
			<div class="keyword">
			<?php foreach ($area_languages as $k => $v){?>
			<dl>
			<input type="hidden" name="data[RegionI18n][<?php echo $k;?>][id]" id="RegionI18n_id_<?php echo $v['Language']['locale'];?>" />
			<dd><b><?php echo $v['Language']['name']?></b></dd>
			<dt><input id="regionI18n_name_id_<?php echo $v['Language']['locale'];?>" name="data[RegionI18n][<?php echo $k;?>][name]" type="text" maxlength="100" class="text_input"  value=""></dt>
			</dl>
			
		<?php }?>
		</div>
		<p class="clear">&nbsp;</p>
		<p class="height_5">&nbsp;</p>	
		<?php }?>
			<p align="center">
			<input type="hidden" name="region_id" id="region_id" />
			<input type="hidden" name="r_id" id="r_id" />
			<input type="hidden" name="parent_id" value="<?php echo $pid;?>" />
			<input type="submit" value="确定"/>
			<input type="button" value="取消" onclick="big_panel.hide()"/>
			</p>
		<p class="height_5">&nbsp;</p>	
		</div>
		<p><?php echo $html->image("loginout-bottom.png");?></p>
	</div><?php echo $form->end();?>

</div>
<!--Main Start End-->	

<script>
	var local_arr = Array();
<?php foreach ($area_languages as $k => $v){?>
	local_arr[<?php echo $k?>] = "<?php echo $v['Language']['locale']?>";
<?php }?>

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
	document.getElementById("region_id").value = "";
	for( var i=0;i<local_arr.length;i++ ){
		document.getElementById("RegionI18n_id_"+local_arr[i]).value = "";
	}
	big_panel.show();
}

function edit(region_id,pid){
	
	var sUrl = webroot_dir+"areas/edit/"+region_id;
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, edit_record_callback);
	big_panel.show();document.getElementById("r_id").value = region_id;
}

	var edit_record_Success = function(o){
	
		
		eval('result='+o.responseText); 
		for(var i=0;i<=result.length-1;i++){
			document.getElementById("regionI18n_name_id_"+result[i].locale).value = result[i].name;
			document.getElementById("RegionI18n_id_"+result[i].locale).value = result[i].id;
			document.getElementById("orderby").value = result[i].orderby;
			document.getElementById("abbreviated").value = result[i].abbreviated;
			document.getElementById("region_id").value = result[i].region_id;
			
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
