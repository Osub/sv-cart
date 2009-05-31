
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
		document.getElementById('roundcorner').value = result.message.Flashe.roundcorner;
        document.getElementById('autoplaytime').value = result.message.Flashe.autoplaytime;
        document.getElementById('isheightquality').value = result.message.Flashe.isheightquality;
        document.getElementById('blendmode').value = result.message.Flashe.blendmode;
        document.getElementById('transduration').value = result.message.Flashe.transduration;
        document.getElementById('windowopen').value = result.message.Flashe.windowopen;
        document.getElementById('btnsetmargin').value = result.message.Flashe.btnsetmargin;
        document.getElementById('btndistance').value = result.message.Flashe.btndistance;
        document.getElementById('titlebgcolor').value = result.message.Flashe.titlebgcolor;
        document.getElementById('titletextcolor').value = result.message.Flashe.titletextcolor;
        document.getElementById('titlebgalpha').value = result.message.Flashe.titlebgalpha;
        document.getElementById('titlemoveduration').value = result.message.Flashe.titlemoveduration;
        document.getElementById('btnalpha').value = result.message.Flashe.btnalpha;
        document.getElementById('btntextcolor').value = result.message.Flashe.btntextcolor;
        document.getElementById('btndefaultcolor').value = result.message.Flashe.btndefaultcolor;
        document.getElementById('btnhovercolor').value = result.message.Flashe.btnhovercolor;
        document.getElementById('btnfocuscolor').value = result.message.Flashe.btnfocuscolor;
        document.getElementById('changimagemode').value = result.message.Flashe.changimagemode;
        document.getElementById('isshowbtn').value = result.message.Flashe.isshowbtn;
        document.getElementById('isshowtitle').value = result.message.Flashe.isshowtitle;
        document.getElementById('scalemode').value = result.message.Flashe.scalemode;
        document.getElementById('transform').value = result.message.Flashe.transform;
        document.getElementById('isshowabout').value = result.message.Flashe.isshowabout;
        document.getElementById('roundcorner').value = result.message.Flashe.roundcorner;
        document.getElementById('titlefont').value = result.message.Flashe.titlefont;
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