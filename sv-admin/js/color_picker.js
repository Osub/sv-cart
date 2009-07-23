  YAHOO.util.Event.onContentReady("button-container", function () {
        function onButtonOption() {
            var oColorPicker = new YAHOO.widget.ColorPicker(oColorPickerMenu.body.id, {
                                    showcontrols: false,
                                    images: {
                                        PICKER_THUMB: root_all+"sv-admin/img/picker_thumb.png",
                                        HUE_THUMB: root_all+"sv-admin/img/hue_thumb.png"
                                    }
                                });

            oColorPicker.on("rgbChange", function (p_oEvent) {
				
                var sColor = "#" + this.get("hex");
                document.getElementById('product_style_color').value=sColor;
                font_color_picker(sColor);
                oButton.set("value", sColor);
                YAHOO.util.Dom.setStyle("current-color", "backgroundColor", sColor);
                YAHOO.util.Dom.get("current-color").innerHTML = "Current color is " + sColor;
            
            });
            
            this.unsubscribe("option", onButtonOption);
        
        }


        var oColorPickerMenu = new YAHOO.widget.Menu("color-picker-menu");
        var oButton = new YAHOO.widget.Button({ 
                                            type: "split", 
                                            id: "color-picker-button", 
                                            label: "<em id=\"current-color\">Current color is #FFFFFF.</em>", 
                                            menu: oColorPickerMenu, 
                                            container: "button-container" });
        
        
        oButton.on("appendTo", function () {
	
			oColorPickerMenu.setBody("&#32dddd;");
	
			oColorPickerMenu.body.id = "color-picker-container";
	
	
	
			oColorPickerMenu.render(this.get("container"));
        
        });
        
        
        
        oButton.on("option", onButtonOption);
        

		
        oButton.on("click", function () {
        	document.getElementById('product_style_color').value=this.get("value");
        	//YAHOO.util.Dom.setStyle("photo", "backgroundColor", this.get("value"));
        	
        });
    
    });