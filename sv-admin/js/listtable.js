/* $Id: listtable.js 14980 2008-10-22 05:01:19Z testyang $ */
var listTable = new Object;

listTable.query = "query";
listTable.filter = new Object;
listTable.url = location.href.lastIndexOf("?") == -1 ? location.href.substring((location.href.lastIndexOf("/")) + 1) : location.href.substring((location.href.lastIndexOf("/")) + 1, location.href.lastIndexOf("?"));
listTable.url += "?is_ajax=1";

/**
 * 创建一个可编辑区
 */
listTable.edit = function(obj,func,id)
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
	  res = YAHOO.util.Connect.asyncRequest('POST', webroot_dir+func, null,"&val=" + encodeURIComponent(Utils.trim(txt.value))  + "&id=" +id);
      obj.innerHTML = Utils.trim(txt.value);
      
    }
    else{
      obj.innerHTML = org;
    }
  }
}


/**
 * 切换状态
 */
listTable.toggle = function(obj, func, id)
{
  var val = (obj.src.match(/yes.gif/i)) ? 0 : 1;
	res = YAHOO.util.Connect.asyncRequest('POST', webroot_dir+func, null,"&val=" + val + "&id=" +id);
	obj.src = (val > 0) ? webroot_dir+'img/yes.gif' : webroot_dir+'img/no.gif';
}

