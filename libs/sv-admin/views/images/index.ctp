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
 * $Id: index.ctp 5493 2009-11-03 10:47:49Z huangbo $
*****************************************************************************/
?>
<?php echo $javascript->link('utils');?>	
<?php echo $javascript->link('/../js/yui/treeview-min.js');?>
<?php echo $javascript->link('treeview/treeview1.js');?>
<?php echo $javascript->link('treeview/prototype.js');?>
<?php if($status!=1){?><?php echo $javascript->link('treeview/scriptaculous.js?load=effects,builder');?><?php }?>
<?php if($status!=1){?><?php echo $javascript->link('treeview/lightbox.js');?><?php }?>

<input type="hidden" value="/others" id="img_address">
<div id="msg"></div>
<div class="content">
<?php if(@!isset($this->params['url']['status'])){?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<?php }else{echo "<br /><br />";}?>
<!--Main Start-->
<style type="text/css">
/* ---------- 郑20090821 ----------------------- */
.gallery {
	list-style: none;
	margin: 0;
	padding: 0;
}
.gallery li {
	width: 186px;
	height: 153px;
	margin: 10px 10px 5px;
	float: left;
	position: relative;
}
.gallery .bg {
	width: 186px;
	height: 153px;
	position: absolute;
	top: 0;
	left: 0;
	z-index: 1;
}
.gallery img {
	border: none;
	position: absolute;
	top: 8px;
	left: 8px;
	padding:4px; border:1px #E3E3DF solid; vertical-align:middle;
width:160px;height:110px;
	z-index: 2;
}
.gallery p {
	display: block;
	padding: 4px 0 0;
	text-align: center;
	color: #333;
	width: 186px;
	position: absolute;
	bottom: 8px;
	right: 0;
	z-index: 3;
}
</style>

<br />
<!--<p class="add_categories"><?php echo $html->link("显示图片","javascript:img_is_show(this);",array("style"=>"display:none","id"=>"img_show"),false,false);?><?php echo $html->link("隐藏图片","javascript:img_is_show(this);",array("id"=>"img_hide"),false,false);?></p>-->
<div class="home_main" style="background-color: #FFFFFF;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">

<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="13.5%">菜单</th>
	<th width="86.5%">图片</th>
</tr>
<tr>
	<td id="treeDiv1" valign="top" ></td>
	<td valign="top" ><span class="gallery" id="preServerData"></span></td>
</tr>
</table>
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
<?php echo $javascript->link('swfupload/swfupload.js'); ?>
				
<?php echo $javascript->link('swfupload/swfupload.queue.js'); ?>
<?php echo $javascript->link('swfupload/fileprogress.js'); ?>
<?php echo $javascript->link('swfupload/handlers.js'); ?>
<?php echo $html->css('swfupload',"",array("rel"=>"stylesheet"));?>
<span>
<script type="text/javascript">
var swfu;
var img_addr = "";

function swfuploadimg() {
	
	if(img_addr==""){
		img_addr = "/others";
	}
	var settings = {
		flash_url : root_all+"sv-admin/js/swfupload/swfupload.swf",
		upload_url: admin_webroot+"images/upload/",	// Relative to the SWF file
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
		file_types : "*.jpg;*.jpeg;*.gif;*.png;*.bmp;*.swf",
		file_types_description : "All Files",
		file_upload_limit : 100,
		file_queue_limit : 0,
		custom_settings : {
			progressTarget : "fsUploadProgress",
			cancelButtonId : "btnCancel"
		},
		debug: false,

		// Button Settings
		button_image_url : root_all+"sv-admin/img/upload.png",	// Relative to the SWF file
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
			"PHPSESSID" : "<?php echo session_id(); ?>",
			"session_config_str" : '<?php echo $session_config_str; ?>',
			"session_operator_str" : '<?php echo $session_operator_str; ?>',
			"session_admin_config_str" : '<?php echo $session_admin_config_str; ?>',
			"session_action_list_str" : '<?php echo $session_action_list_str; ?>',
			"session_admin_locale_str" : '<?php echo $session_admin_locale_str; ?>',
			"cart_back_url":'<?php echo $cart_back_url;?>',
			"img_addr":img_addr,
			".what" : "OKAY"
		});
}
////////////////////


function dir_name(obj){
	alert(buildContextMenu.prototype.sss);
	
}

</script>
<script type="text/javascript">
var window_option_status = <?php echo $status?>;
 
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
document.onmousemove=function(e)
{
  var obj = Utils.srcElement(e);
  if (typeof(obj.onclick) == 'function' && obj.onclick.toString().indexOf('listTable.edit') != -1)
  {
    obj.title = '点击修改内容';
    obj.style.cssText = 'background: #21964D;';
    obj.onmouseout = function(e)
    {
      this.style.cssText = '';
    }
  }
  else if (typeof(obj.href) != 'undefined' && obj.href.indexOf('listTable.sort') != -1)
  {
    obj.title = '点击对列表排序';
  }
}
/* $Id: index.ctp 5493 2009-11-03 10:47:49Z huangbo $ */
var listTable = new Object;

listTable.query = "query";
listTable.filter = new Object;
listTable.url = location.href.lastIndexOf("?") == -1 ? location.href.substring((location.href.lastIndexOf("/")) + 1) : location.href.substring((location.href.lastIndexOf("/")) + 1, location.href.lastIndexOf("?"));
listTable.url += "?is_ajax=1";

/**
 * 创建一个可编辑区
 */
listTable.edit = function(obj,func,id,mydir)
{
  var tag = obj.firstChild.tagName;

  if (typeof(tag) != "undefined" && tag.toLowerCase() == "input")
  {
    return;
  }

  /* 保存原始的内容 */
  var org = obj.innerHTML;
  var val = Browser.isIE ? obj.innerText : obj.textContent;

  /* 创建一个输入框 */
  var txt = document.createElement("INPUT");
  txt.value = (val == 'N/A') ? '' : val;
  txt.style.width = (obj.offsetWidth + 12) + "px" ;

  /* 隐藏对象中的内容，并将输入框加入到对象中 */
  obj.innerHTML = "";
  obj.appendChild(txt);
  txt.focus();

  /* 编辑区输入事件处理函数 */
  txt.onkeypress = function(e)
  {
    var evt = Utils.fixEvent(e);
    var obj = Utils.srcElement(e);

    if (evt.keyCode == 13)
    {
      obj.blur();

      return false;
    }

    if (evt.keyCode == 27)
    {
      obj.parentNode.innerHTML = org;
    }
  }

  /* 编辑区失去焦点的处理函数 */
  txt.onblur = function(e){
    if (Utils.trim(txt.value).length > 0){ 
	  res = YAHOO.util.Connect.asyncRequest('POST', webroot_dir+func, null,"&new_name=" + mydir+Utils.trim(txt.value) + "&old_name=" +mydir+id);
      obj.innerHTML = Utils.trim(txt.value);
      
    }
    else{
      obj.innerHTML = org;
    }
  }
}
</script>

<div id="img_dir">
	<div id="loginout">
		<h1><b>编辑目录</b></h1>
		<div id="buyshop_box">
			<p class="login-alettr">
			目录名：<b><input type="text" id="img_dir_name" style="ime-mode:disabled;" ></b></p>
			<br />
			<p class="buy_btn mar"><?php echo $html->link("取消","javascript:big_panel.hide();");?>
			<?php echo $html->link("确定","javascript:;",array("id"=>"img_dir_comfirm"));?></p>
		</div>
		<p><?php echo $html->image("loginout-bottom.png");?></p>
	</div>
</div>
<!--upload--->
