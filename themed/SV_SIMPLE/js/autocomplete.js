	function ajax_init(){
			YAHOO.example.ACJson = new function(){
		    this.oACDS = new YAHOO.widget.DS_XHR(webroot_dir+"products/search_autocomplete/", ["ResultSet.Result","name"]);
		    this.oACDS.queryMatchContains = true;
		    this.oACDS.scriptQueryAppend = "output=json&results=100"; // Needed for YWS

		    // Instantiate AutoComplete
		    this.oAutoComp = new YAHOO.widget.AutoComplete("ysearchinput_search","ysearchcontainer_search", this.oACDS);
		    this.oAutoComp.useShadow = true;
		    this.oAutoComp.queryDelay = 2;   
		    
		    this.oAutoComp.formatResult = function(oResultItem, sQuery) {
		        return  "" + oResultItem[1].code + "  " + oResultItem[1].name + " &nbsp;&nbsp;<img src='"+oResultItem[1].img+"' width='"+search_autocomplete_image_width+"' height='"+search_autocomplete_image_height+"' />";
		    };
		    this.oAutoComp.doBeforeExpandContainer = function(oTextbox, oContainer, sQuery, aResults) {
		        var pos = YAHOO.util.Dom.getXY(oTextbox);
		        pos[1] += YAHOO.util.Dom.get(oTextbox).offsetHeight + 2;
		        YAHOO.util.Dom.setXY(oContainer,pos);
		        return true;
		    };

		    // Stub for form validation
		    this.validateForm = function() {
		        // Validation code goes here
		        return true;
		    };
		}
	}
	YAHOO.util.Event.onDOMReady(ajax_init);
	
	function advanced_search(){
	var keywords=document.getElementById('ysearchinput_search').value;

    if(keywords == ''){
		    var keywords = 'all';
    }
	var type='SAD';
	var category_id=document.getElementById('category_id_search').value;
	var brand_id=document.getElementById('brand_id_search').value;
	var min_price=document.getElementById('min_price_search').value;
	var max_price=document.getElementById('max_price_search').value;
	var ss = webroot_dir+"products/advancedsearch/"+type+"/"+keywords+"/"+category_id+"/"+brand_id+"/"+min_price+"/"+max_price;
	window.location.href=webroot_dir+"products/advancedsearch/"+type+"/"+keywords+"/"+category_id+"/"+brand_id+"/"+min_price+"/"+max_price;
}