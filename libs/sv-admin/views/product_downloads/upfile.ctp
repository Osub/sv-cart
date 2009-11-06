<?php 
/*****************************************************************************
 * SV-Cart 上传下载商品
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: upfile.ctp 3507 2009-08-06 10:52:06Z tangyu $
*****************************************************************************/
?>


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


<input type="hidden" value="/temp" id="img_address"/>
<div class="home_main" style="background-color: #FFFFFF;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">

	<ul class="product_llist departments_headers" style="background-color: #FFFFFF;"><li class="hadle">文件</li></ul>
	<ul class="product_llist departments_headers departments_list" style='height:100%;'>

		<li class="hadle" style="width:85.5%;"><ul class="hotGroup">
		<span id="preServerData"></span>
			
	</ul></li>
	</ul>

<br />
</div>
<!--upload--->

<br />
<div class="home_main" style="background-color: #FFFFFF;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
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
<?php echo $javascript->link('swfupload/swfupload.js'); ?>
<?php echo $javascript->link('swfupload/swfupload.swfobject.js'); ?>
<?php echo $javascript->link('swfupload/swfupload.queue.js'); ?>
<?php echo $javascript->link('swfupload/fileprogress.js'); ?>
<?php echo $javascript->link('swfupload/handlers.js'); ?>
<?php echo $html->css('swfupload',"",array("rel"=>"stylesheet"));?>
<span>
<script type="text/javascript">
var swfu;
var img_addr = "";
swfuploadimg();
function swfuploadimg() {
	if(img_addr==""){
		img_addr = "/temp";
	}
	var settings = {
		flash_url : root_all+"sv-admin/js/swfupload/swfupload.swf",
		upload_url: admin_webroot+"product_downloads/upload/",	// Relative to the SWF file
		post_params: {
			"PHPSESSID" : "<?php echo session_id(); ?>",
			"session_config_str" : '<?php echo $session_config_str; ?>',
			"session_operator_str" : '<?php echo $session_operator_str; ?>',
			"session_admin_config_str" : '<?php echo $session_admin_config_str; ?>',
			"session_action_list_str" : '<?php echo $session_action_list_str; ?>',
			"session_admin_locale_str" : '<?php echo $session_admin_locale_str; ?>',
			"cart_back_url":'<?php echo $cart_back_url;?>',
			"img_addr":img_addr,
			".what" : "OKAY"
		},
		file_size_limit : "100 MB",
		file_types : "*.tar.gz;*.tar.bz2",
		file_types_description : "All Files",
		file_upload_limit : 100,
		file_queue_limit : 0,
		custom_settings : {
			progressTarget : "fsUploadProgress",
			cancelButtonId : "btnCancel"
		},
		debug: false,

		// Button Settings
		button_image_url :root_all+"sv-admin/img/upload.png",	// Relative to the SWF file
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




function file_back(img_obj){
			var src_arr = img_obj.name.split("/");
			var j=0;
			var src_str = "";
			for(var i=1;i<=src_arr.length-1;i++){
				src_str+="/"+src_arr[i];
				j++;
			}
			window.opener.GetId('file_src').value = ".."+src_str;
			window.close();
}

//删除图片
var image_src;
var img_src;
function remove_file(result){
	var img_hide_show		= document.getElementsByName('img_hide_show[]');
	image_src			= document.getElementById('img_address').value;
	img_src= result.value;
	var arr = img_src.split('/');
	layer_dialog();
	layer_dialog_show("确定删除文件"+arr[arr.length-1]+"?","remove_img_confirm()",5);

}
function remove_img_confirm(){
	YAHOO.example.container.wait.show();
	var sUrls = webroot_dir+"product_downloads/remove_file/?img_src="+img_src;
	YAHOO.util.Connect.asyncRequest('POST', sUrls, load_show_remove_img_callback);//AJAX删除图片
}
//图片加载回传
var load_show_remove_img_Success = function(oResponse){
		var urlimg = webroot_dir+"product_downloads/treeview/?path="+image_src;
        YAHOO.util.Connect.asyncRequest('POST', urlimg, load_show_img_callback);//重载图片
        YAHOO.example.container.wait.hide();
	}

	var load_show_remove_img_Failure = function(o){
		alert("异步请求失败");
	} //

	var load_show_remove_img_callback ={
		success:load_show_remove_img_Success,
		failure:load_show_remove_img_Failure,
		timeout : 10000,
		argument: {}
	};
	
//图片加载回传
var load_show_img_Success = function(oResponse){
		var oResults = eval("("+oResponse.responseText+")");
	            var created_img = document.getElementById('preServerData');
	            created_img.innerHTML = "";
	            if(oResults.show_img_str){
	            	created_img.innerHTML = oResults.show_img_str;
	            }
        YAHOO.example.container.wait.hide();
	}

	var load_show_img_Failure = function(o){
		alert("异步请求失败");
	}

	var load_show_img_callback ={
		success:load_show_img_Success,
		failure:load_show_img_Failure,
		timeout : 10000,
		argument: {}
	};
//图片加载end	
	
	
</script>


