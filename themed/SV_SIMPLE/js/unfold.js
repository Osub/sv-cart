YAHOO.namespace("example.container");

    
YAHOO.util.Event.onDOMReady(function () {
		
    var SubAction = document.getElementsByName('SubAction[]').length;
	for( var i=0;i<=SubAction-1;i++ ){
		YAHO = new YAHOO.widget.Module("SubAction"+i, { visible: false });
		YAHO.render();
		
		sho = new YAHOO.widget.Module("show"+i, { visible: true });
		sho.render();
		
		hid = new YAHOO.widget.Module("hide"+i, { visible: false });
		hid.render();

		YAHOO.util.Event.addListener("hide"+i, "click", YAHO.hide, YAHO, true);
		YAHOO.util.Event.addListener("hide"+i, "click", sho.show, sho, true);
		YAHOO.util.Event.addListener("hide"+i, "click", hid.hide, hid, true);

		YAHOO.util.Event.addListener("show"+i, "click", YAHO.show, YAHO, true);
		YAHOO.util.Event.addListener("show"+i, "click", sho.hide, sho, true);
		YAHOO.util.Event.addListener("show"+i, "click", hid.show, hid, true);
	}

    var SubAction_2 = document.getElementsByName('SubAction_2[]').length;
	//alert(SubAction_2)
	for( var ii=0;ii<=SubAction_2-1;ii++ ){

		YAHO_2 = new YAHOO.widget.Module("SubAction_2"+ii, { visible: false });
		YAHO_2.render();

		sho_2 = new YAHOO.widget.Module("show_2"+ii, { visible: true });
		sho_2.render();
		
		hid_2 = new YAHOO.widget.Module("hide_2"+ii, { visible: false });
		hid_2.render();

	

		YAHOO.util.Event.addListener("hide_2"+ii, "click", YAHO_2.hide, YAHO_2, true);
		YAHOO.util.Event.addListener("hide_2"+ii, "click", sho_2.show, sho_2, true);
		YAHOO.util.Event.addListener("hide_2"+ii, "click", hid_2.hide, hid_2, true);

		YAHOO.util.Event.addListener("show_2"+ii, "click", YAHO_2.show, YAHO_2, true);
		YAHOO.util.Event.addListener("show_2"+ii, "click", sho_2.hide, sho_2, true);
		YAHOO.util.Event.addListener("show_2"+ii, "click", hid_2.show, hid_2, true);
	}

	var menu_id = document.getElementsByName('menu_id[]').length;
	//alert(SubAction_2)
	for( var iii=0;iii<=menu_id-1;iii++ ){
		//alert("SubMenu_"+iii);
		YAHO_submenu = new YAHOO.widget.Module("SubMenu_"+iii, { visible: false });
		YAHO_submenu.render();

		menu_id_s = new YAHOO.widget.Module("menu_id_s"+iii, { visible: true });
		menu_id_s.render();
		
		menu_id_h = new YAHOO.widget.Module("menu_id_h"+iii, { visible: false });
		menu_id_h.render();

	

		YAHOO.util.Event.addListener("menu_id_h"+iii, "click", YAHO_submenu.hide, YAHO_submenu, true);
		YAHOO.util.Event.addListener("menu_id_h"+iii, "click", menu_id_s.show, menu_id_s, true);
		YAHOO.util.Event.addListener("menu_id_h"+iii, "click", menu_id_h.hide, menu_id_h, true);

		YAHOO.util.Event.addListener("menu_id_s"+iii, "click", YAHO_submenu.show, YAHO_submenu, true);
		YAHOO.util.Event.addListener("menu_id_s"+iii, "click", menu_id_s.hide, menu_id_s, true);
		YAHOO.util.Event.addListener("menu_id_s"+iii, "click", menu_id_h.show, menu_id_h, true);
	}

	helps = new YAHOO.widget.Module("helps", { visible: false });
	helps.render();
	help_text = new YAHOO.widget.Module("help_text", { visible: true });
	help_text.render();
	helpes = new YAHOO.widget.Module("helpes", { visible: true });
	helpes.render();
	YAHOO.util.Event.addListener("helpes", "click", helps.show, helps, true);
	YAHOO.util.Event.addListener("helpes", "click", helpes.hide, helpes, true);

	YAHOO.util.Event.addListener("helps", "click", helpes.show, helpes, true);
	YAHOO.util.Event.addListener("helps", "click", helps.hide, helps, true);

	YAHOO.util.Event.addListener("helps", "click", help_text.show, help_text, true);
	YAHOO.util.Event.addListener("helpes", "click", help_text.hide, help_text, true);

});