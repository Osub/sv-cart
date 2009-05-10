
//Flash轮播
function flash_change(type_id){
	var is_none = document.getElementById('is_none');
	var flashType=document.getElementById('flashType').value;
	is_none.style.display = "block";
	if(flashType!="H"&&type_id==0){
		if(type_id == 0){
			is_none.style.display = "none";
		}
	}
	
	var sUrl = webroot_dir+"flashes/flashe/?type="+flashType+"&type_id="+type_id;
	//alert(sUrl);
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, flash_callback);
}

var flash_Success = function(o){
	//alert(o.responseText);
		try{
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			alert("Invalid data");
		}
		document.getElementById('id').value = result.message.Flashe.id;
		document.getElementById('type').value = result.message.Flashe.type;
		document.getElementById('type_id').value = result.message.Flashe.type_id;

		document.getElementById('width').value = result.message.Flashe.width;
		document.getElementById('height').value = result.message.Flashe.height;
		document.getElementById('roundCorner').value = result.message.Flashe.roundCorner;
        document.getElementById('autoPlayTime').value = result.message.Flashe.autoPlayTime;
        document.getElementById('isHeightQuality').value = result.message.Flashe.isHeightQuality;
        document.getElementById('blendMode').value = result.message.Flashe.blendMode;
        document.getElementById('transDuration').value = result.message.Flashe.transDuration;
        document.getElementById('windowOpen').value = result.message.Flashe.windowOpen;
        document.getElementById('btnSetMargin').value = result.message.Flashe.btnSetMargin;
        document.getElementById('btnDistance').value = result.message.Flashe.btnDistance;
        document.getElementById('titleBgColor').value = result.message.Flashe.titleBgColor;
        document.getElementById('titleTextColor').value = result.message.Flashe.titleTextColor;
        document.getElementById('titleBgAlpha').value = result.message.Flashe.titleBgAlpha;
        document.getElementById('titleMoveDuration').value = result.message.Flashe.titleMoveDuration;
        document.getElementById('btnAlpha').value = result.message.Flashe.btnAlpha;
        document.getElementById('btnTextColor').value = result.message.Flashe.btnTextColor;
        document.getElementById('btnDefaultColor').value = result.message.Flashe.btnDefaultColor;
        document.getElementById('btnHoverColor').value = result.message.Flashe.btnHoverColor;
        document.getElementById('btnFocusColor').value = result.message.Flashe.btnFocusColor;
        document.getElementById('changImageMode').value = result.message.Flashe.changImageMode;
        document.getElementById('isShowBtn').value = result.message.Flashe.isShowBtn;
        document.getElementById('isShowTitle').value = result.message.Flashe.isShowTitle;
        document.getElementById('scaleMode').value = result.message.Flashe.scaleMode;
        document.getElementById('transform').value = result.message.Flashe.transform;
        document.getElementById('isShowAbout').value = result.message.Flashe.isShowAbout;
        document.getElementById('roundCorner').value = result.message.Flashe.roundCorner;
        document.getElementById('titleFont').value = result.message.Flashe.titleFont;
      //  alert('sssss');
		YAHOO.example.container.wait.hide();
	}

	var flash_Failure = function(o){
		alert("error");
	}

	var flash_callback ={
		success:flash_Success,
		failure:flash_Failure,
		timeout : 10000,
		argument: {}
	};

	function close_message(){
		YAHOO.example.container.message.hide();
	}