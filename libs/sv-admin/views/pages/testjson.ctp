<?php 
/*****************************************************************************
 * SV-Cart AJAX
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: testjson.ctp 2485 2009-06-30 11:33:00Z huangbo $
*****************************************************************************/
?>
	<div id="demo">
    <input type="button" id="demo_btn" value="Get Messages">

    <div id="demo_msg"></div>
</div>
<script type="text/javascript">
YAHOO.util.Event.on('demo_btn','click',function (e) {
    // Get the div element in which to report messages from the server
    var msg_section = YAHOO.util.Dom.get('demo_msg');
    msg_section.innerHTML = '';

    // Define the callbacks for the asyncRequest
    var callbacks = {

        success : function (o) {

            // Process the JSON data returned from the server
            var messages = [];
            var aa='{"type":"0","message":"aafa"}';
            try {
                messages = YAHOO.lang.JSON.parse(o.responseText);
                
            }
            catch (x) {
            	if(o.responseText+'' == '{"type":"0","message":"aafa"}'){
            		alert("OK");
            	}else{
            	alert("-"+o.responseText+"--");
            	alert(o.responseText.charAt(1));
            	alert(aa.charAt(1));
            	}
                alert("JSON Parse failed!");
                return;
            }

 			alert(messages.type);
        },

        failure : function (o) {
            if (!YAHOO.util.Connect.isCallInProgress(o)) {
                alert("Async call failed!");
            }
        },

        timeout : 3000
    }
    YAHOO.util.Connect.asyncRequest('POST',webroot_dir+"orders/json/", callbacks);
});
</script>