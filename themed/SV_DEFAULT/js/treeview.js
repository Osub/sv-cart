YAHOO.example.treeExample = function() {

    var tree, currentIconMode;

    function changeIconMode() {
        var newVal = parseInt(this.value);
        if (newVal != currentIconMode) {
            currentIconMode = newVal;
        }
        buildTree();
    }
    	var tempNode;
        function loadNodeData(node, fnLoadComplete)  {
            
            var path = "";   
            var leafNode = node;
            while (!leafNode.isRoot()) {       
            	path = "/"+leafNode.label+path  ;        
            	leafNode = leafNode.parent;    
            }
            //alert(path);
            var sUrl = webroot_dir+"images/treeview/?path="+path;
            var callback = {
            success: function(oResponse) {
                    YAHOO.log("XHR transaction was successful.", "info", "example");
                    var oResults = eval("(" + oResponse.responseText + ")");
                    //alert(oResponse.responseText);
                    if((oResults.message) && (oResults.message.length)) {
                        if(YAHOO.lang.isArray(oResults.message)) {
                            for (var i=0, j=oResults.message.length; i<j; i++) {
                            	tempNode = new YAHOO.widget.TextNode(oResults.message[i], node, false);
                            }
                        } else {
                             tempNode = new YAHOO.widget.TextNode(oResults.message, node, false)
                        }
                    }
                    var created_img = document.getElementById('created_img');
                    var created_img_name = document.getElementById('created_img_name');
                    created_img.innerHTML = "";
                    if(oResults.list_img){
                    	for (ii = 0; ii < oResults.list_img.length; ii++ ){
							created_img.innerHTML+="<img  src="+oResults.list_img[ii]+">"; 
						}
						test();
                    }
                    //alert(created_img.innerHTML)
                    /*if (oResults.list_img){
             			for (ii = 0; ii < oResults.list_img.length; ii++ ){
							var a = document.createElement("a");
							a.setAttribute("href",oResults.list_img[ii]);
	                 		var img = document.createElement("img");
	                     	img.setAttribute("src",oResults.list_img[ii]);
							img.setAttribute("width","10%");
							var span = document.createElement("span");
	                     	span.innerHTML = oResults.list_img_name[ii];
							created_img.appendChild(a);
	                     	a.appendChild(img);
	              			a.appendChild(span);
              			}
						//alert(created_img.innerHTML);
    				}*/
    				oResponse.argument.fnLoadComplete();
                },
                
                failure: function(oResponse) {
                    YAHOO.log("Failed to process XHR transaction.", "info", "example");
                    oResponse.argument.fnLoadComplete();
                },
                argument: {
                    "node": node,
                    "fnLoadComplete": fnLoadComplete
                },
                
                timeout: 7000
            };
            
            YAHOO.util.Connect.asyncRequest('GET', sUrl, callback);
        }

        function buildTree() {
           tree = new YAHOO.widget.TreeView("treeDiv1");
           tree.setDynamicLoad(loadNodeData, currentIconMode);
           var root = tree.getRoot();
           var sUrl = webroot_dir+"images/treeview/";
           var callbacks = {
           success: function(oResponse) {
                    YAHOO.log("XHR transaction was successful.", "info", "example");
                    var oResults = eval("(" + oResponse.responseText + ")");
           var aStates = oResults.message;
           for (var i=0, j=aStates.length; i<j; i++) {
                 tempNode = new YAHOO.widget.TextNode(aStates[i], root, false);
           }

           
           
           tree.draw();
           }
           }
           YAHOO.util.Connect.asyncRequest('GET', sUrl, callbacks);
        }


    return {
        init: function() {
            YAHOO.util.Event.on(["mode0", "mode1"], "click", changeIconMode);
            var el = document.getElementById("mode1");
            if (el && el.checked) {
                currentIconMode = parseInt(el.value);
            } else {
                currentIconMode = 0;
            }

            buildTree();
        }

    }
} ();
YAHOO.util.Event.onDOMReady(YAHOO.example.treeExample.init, YAHOO.example.treeExample,true)
