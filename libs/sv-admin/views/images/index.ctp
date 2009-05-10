<?php
/*****************************************************************************
 * SV-Cart 图片管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1028 2009-04-24 12:23:26Z huangbo $
*****************************************************************************/
?>
<?=$javascript->link('/../js/yui/treeview-min.js');?>
<?=$javascript->link('treeview/treeview1.js');?>
<?=$javascript->link('treeview/prototype.js');?>
<?if($status!=1){?><?=$javascript->link('treeview/scriptaculous.js?load=effects,builder');?><?}?>
<?if($status!=1){?><?=$javascript->link('treeview/lightbox.js');?><?}?>
<?=$javascript->link('/../js/yui/treeview-min.js');?>
<input type="hidden" value="/others" id="img_address">
<div id="msg"></div>
<div class="content">
<?if(@!isset($this->params['url']['status'])){?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<?}else{echo "<br /><br />";}?>
<!--Main Start-->
<style>

td{font-family:verdana;font-size:11px;color:000000}
.bold{font:900}
<!--
.box{ 
		
		*display: block;
		*font-size: 85px;
		*font-family:Arial;
}
.box img{ padding:4px; border:1px #E3E3DF solid; vertical-align:middle;
width:120px;height:100px;
}
-->
</style>


<p class="add_categories"><?=$html->link("显示图片","javascript:img_is_show(this);",array("style"=>"display:none","id"=>"img_show"),false,false);?><?=$html->link("隐藏图片","javascript:img_is_show(this);",array("id"=>"img_hide"),false,false);?></p>
<div class="home_main" style="width:96%;background-color: #FFFFFF;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">


	<ul class="product_llist departments_headers" style="background-color: #FFFFFF;"><li class="name"><span>菜单</span></li><li class="hadle">图片</li></ul>
	<ul class="product_llist departments_headers departments_list" style='height:100%;'>
		<li class="name" style="overflow:auto;line-height:14pt;letter-spacing:0.2em; HEIGHT:400px;TEXT-ALIGN:left"><strong ><div id="treeDiv1" style="overflow:auto;width:140px;line-height:14pt;letter-spacing:0.2em; " ></div></strong></li>
		<li class="hadle" style="width:85.5%;"><ul class="hotGroup">
		<span id="preServerData"></span>
			
	</ul></li>
	</ul>

<br />
</div>
<!--upload--->

<br />
<div class="home_main" style="width:96%;background-color: #FFFFFF;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<br />&nbsp&nbsp&nbsp<br />
	<div id="content" style="margin:0;padding:0 10px;">
			
			<div id="divSWFUploadUI">
				<div class="fieldset  flash" id="fsUploadProgress">
				<span class="legend">Upload Queue</span>
				</div>
				<p id="divStatus" style='margin-left:5px;'>0 Files Uploaded</p>
				<p style='margin-left:5px;padding-top:5px;'>
					<span id="spanButtonPlaceholder"></span>
					<input id="btnCancel" type="button" value="Cancel All Uploads" disabled="disabled" style="margin-left: 2px; height: 22px; font-size: 8pt;" />
					<br />
				</p>
			</div>
			<noscript style="background-color: #FFFF66; border-top: solid 4px #FF9966; border-bottom: solid 4px #FF9966; margin: 10px 25px; padding: 10px 15px;">
				We're sorry.  SWFUpload could not load.  You must have JavaScript enabled to enjoy SWFUpload.
			</noscript>
			<div id="divLoadingContent" class="content" style="background-color: #FFFF66; border-top: solid 4px #FF9966; border-bottom: solid 4px #FF9966; margin: 10px 25px; padding: 10px 15px; display: none;">
				SWFUpload is loading. Please wait a moment...
			</div>
			<div id="divLongLoading" class="content" style="background-color: #FFFF66; border-top: solid 4px #FF9966; border-bottom: solid 4px #FF9966; margin: 10px 25px; padding: 10px 15px; display: none;">
				SWFUpload is taking a long time to load or the load has failed.  Please make sure that the Flash Plugin is enabled and that a working version of the Adobe Flash Player is installed.
			</div>
			<div id="divAlternateContent" class="content" style="background-color: #FFFF66; border-top: solid 4px #FF9966; border-bottom: solid 4px #FF9966; margin: 10px 25px; padding: 10px 15px; display: none;">
				We're sorry.  SWFUpload could not load.  You may need to install or upgrade Flash Player.
				Visit the Adobe website to get the Flash Player.
			</div>
	</div>
</div>
</div>
<!--upload--->
<?=$javascript->link('swfupload/swfupload.js'); ?>
<?=$javascript->link('swfupload/swfupload.swfobject.js'); ?>
<?=$javascript->link('swfupload/swfupload.queue.js'); ?>
<?=$javascript->link('swfupload/fileprogress.js'); ?>
<?=$javascript->link('swfupload/handlers.js'); ?>
<?=$html->css('swfupload',"",array("rel"=>"stylesheet"));?>
<span>
<script type="text/javascript">
var swfu;
var img_addr = "";

function swfuploadimg() {
	//alert(img_addr);
	if(img_addr==""){
		img_addr = "/others";
	}
	var settings = {
		flash_url : webroot_dir+"js/swfupload/swfupload.swf",
		upload_url: webroot_dir+"images/upload/",	// Relative to the SWF file
		post_params: {
			"PHPSESSID" : "<?=session_id(); ?>",
			"session_operator_str" : '<?=$session_operator_str; ?>',
			"Admin_Config" : '<?=$Admin_Config; ?>',
			"Action_List" : '<?=$Action_List; ?>',
			"Admin_Locale" : '<?=$Admin_Locale; ?>',
			"Operator" : '<?=$Operator; ?>',
			"cart_back_url":'<?=$cart_back_url;?>',
			"img_addr":img_addr,
			".what" : "OKAY"
		},
		file_size_limit : "100 MB",
		file_types : "*.*",
		file_types_description : "All Files",
		file_upload_limit : 100,
		file_queue_limit : 0,
		custom_settings : {
			progressTarget : "fsUploadProgress",
			cancelButtonId : "btnCancel"
		},
		debug: false,

		// Button Settings
		button_image_url : webroot_dir+"img/upload.png",	// Relative to the SWF file
		button_placeholder_id : "spanButtonPlaceholder",
		button_width: 61,
		button_height: 22,

		// The event handler functions are defined in handlers.js
		swfupload_loaded_handler : swfUploadLoaded,
		file_queued_handler : fileQueued,
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,
		queue_complete_handler : queueComplete,	// Queue plugin event
		
		// SWFObject settings
		minimum_flash_version : "9.0.28",
		swfupload_pre_load_handler : swfUploadPreLoad,
		swfupload_load_failed_handler : swfUploadLoadFailed
	};

	swfu = new SWFUpload(settings);
}
window.onload = function(){
	if(img_addr==""){
		img_addr = "/others";
	}
	initPage2();
}
function swf_upload_addr(){
	swfu.setPostParams({
			"PHPSESSID" : "<?=session_id(); ?>",
			"session_operator_str" : '<?=$session_operator_str; ?>',
			"Admin_Config" : '<?=$Admin_Config; ?>',
			"Action_List" : '<?=$Action_List; ?>',
			"Admin_Locale" : '<?=$Admin_Locale; ?>',
			"Operator" : '<?=$Operator; ?>',
			"cart_back_url":'<?=$cart_back_url;?>',
			"img_addr":img_addr,
			"HELLO-WORLD" : "Here I Am",
			".what" : "OKAY"
		});
		
	
}
////////////////////


function dir_name(obj){
	alert(buildContextMenu.prototype.sss);
	
}

</script>
<script type="text/javascript">
var window_option_status = <?=$status?>;
 
var assign_dir = "";
if(window_option_status != ""){
	assign_dir = window.opener.document.getElementById('assign_dir').value;
}
if( assign_dir == "all" ){
	assign_dir = "";
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
</script>

<div id="img_dir">
	<div id="loginout">
		<h1><b>编辑目录</b></h1>
		<div id="buyshop_box">
			<p class="login-alettr">
			目录名：<b><input type="text" id="img_dir_name" style="ime-mode:disabled;" ></b></p>
			<br />
			<p class="buy_btn mar"><?=$html->link("取消","javascript:big_panel.hide();");?>
			<?=$html->link("确定","javascript:;",array("id"=>"img_dir_comfirm"));?></p>
		</div>
		<p><?=$html->image("loginout-bottom.gif");?></p>
	</div>
</div>
<!--upload--->
