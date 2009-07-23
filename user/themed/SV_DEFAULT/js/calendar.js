YAHOO.util.Event.onDOMReady(function(){
 		document.getElementById('container_cal').style.display = "block";
		document.getElementById('container_cal2').style.display = "block";
        var dialog,dialog2, calendar, calendar2;
 
        calendar = new YAHOO.widget.Calendar("cal", {
            iframe:false,          // Turn iframe off, since container has iframe support.
            hide_blank_weeks:true,  // Enable, to demonstrate how we handle changing height, using changeContent
            mindate:"1/1/1900",		//最小日期
            maxdate:"1/1/2110",		//最大日期
            navigator:true			//开启导航
        });
        
        calendar2 = new YAHOO.widget.Calendar("cal2", {
            iframe:false,          // Turn iframe off, since container has iframe support.
            hide_blank_weeks:true,  // Enable, to demonstrate how we handle changing height, using changeContent
            mindate:"1/1/1900",		//最小日期
            maxdate:"1/1/2110",		//最大日期
            navigator:true			//开启导航
        });
        
        function okHandler() {
            if (calendar.getSelectedDates().length > 0) {
 
                var selDate = calendar.getSelectedDates()[0];
 
                // Pretty Date Output, using Calendar's Locale values: Friday, 8 February 2008
                //var wStr = calendar.cfg.getProperty("WEEKDAYS_LONG")[selDate.getDay()];
                var dStr = selDate.getDate();
                var mStr = calendar.cfg.getProperty("MONTHS_LONG")[selDate.getMonth()];
                var yStr = selDate.getFullYear();
 
                YAHOO.util.Dom.get("date").value =  yStr+"-"+mStr+"-"+dStr;
            } else {
                YAHOO.util.Dom.get("date").value = "";
            }
            this.hide();
        }
        function okHandler2() {
            if (calendar2.getSelectedDates().length > 0) {
 
                var selDate = calendar2.getSelectedDates()[0];
 
                // Pretty Date Output, using Calendar's Locale values: Friday, 8 February 2008
                //var wStr = calendar.cfg.getProperty("WEEKDAYS_LONG")[selDate.getDay()];
                var dStr = selDate.getDate();
                var mStr = calendar2.cfg.getProperty("MONTHS_LONG")[selDate.getMonth()];
                var yStr = selDate.getFullYear();
 
                YAHOO.util.Dom.get("date2").value =  yStr+"-"+mStr+"-"+dStr+" ";
            } else {
                YAHOO.util.Dom.get("date2").value = "";
            }
            this.hide();
        }
        
        function cancelHandler() {
            this.hide();
        }
 
        dialog = new YAHOO.widget.Dialog("container_cal", {
            context:["show", "tl", "bl"],
            buttons:[ {text:"确定", isDefault:false, handler: okHandler}, 
                      {text:"取消", handler: cancelHandler}],
            width:"186",  // Sam Skin dialog needs to have a width defined (7*2em + 2*1em = 16em).
            draggable:true,
            close:true
        });
        calendar.render();
        dialog.render();
 
        // Using dialog.hide() instead of visible:false is a workaround for an IE6/7 container known issue with border-collapse:collapse.
        dialog.hide();
		dialog2 = new YAHOO.widget.Dialog("container_cal2", {
            context:["show2", "tl", "bl"],
            buttons:[ {text:"确定", isDefault:false, handler: okHandler2}, 
                      {text:"取消", handler: cancelHandler}],
            width:"186",  // Sam Skin dialog needs to have a width defined (7*2em + 2*1em = 16em).
            draggable:true,
            close:true
        });
        calendar2.render();
        dialog2.render();
 
        // Using dialog.hide() instead of visible:false is a workaround for an IE6/7 container known issue with border-collapse:collapse.
        dialog2.hide();
       	calendar.renderEvent.subscribe(function() {
            // Tell Dialog it's contents have changed, Currently used by container for IE6/Safari2 to sync underlay size
            dialog.fireEvent("changeContent");
        });
         calendar2.renderEvent.subscribe(function() {
            // Tell Dialog it's contents have changed, Currently used by container for IE6/Safari2 to sync underlay size
            dialog2.fireEvent("changeContent2");
        });
        YAHOO.util.Event.on("show", "click", function() {
            dialog.show();
            if (YAHOO.env.ua.opera && document.documentElement) {
                // Opera needs to force a repaint
                document.documentElement.style += "";
            } 
        });
        
        YAHOO.util.Event.on("show2", "click", function() {
            dialog2.show();
            if (YAHOO.env.ua.opera && document.documentElement) {
                // Opera needs to force a repaint
                document.documentElement.style += "";
            } 
        });
    });