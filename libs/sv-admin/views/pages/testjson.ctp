<?php 
/*****************************************************************************
 * SV-Cart AJAX
 * ===========================================================================
 * ��Ȩ���� �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
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