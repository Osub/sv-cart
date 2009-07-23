function selectAll(obj, chk)
{
  if (chk == null)
  {
    chk = 'checkboxes';
  }
  var elems = obj.form.getElementsByTagName("INPUT");
  for (var i=0; i < elems.length; i++)
  {
    if (elems[i].name == chk || elems[i].name == chk + "[]")
    {
      elems[i].checked = obj.checked;
    }
  }
}


/*******************************************************************
leo 2009-1-5

使用说明
list:checkbox的VALUE集合
obj:this
chk:要选中的name复选框

frm: this.form
checkbox: this
**************************************************** ***************/
//操作员分批全选
function check(list, obj,chk)
{
  var frm = obj.form;

    for (i = 0; i < frm.elements.length; i++)
    {
      if (frm.elements[i].name == chk+"[]")
      {
          var regx = new RegExp(frm.elements[i].value + "(?!_)", "i");

          if (list.search(regx) > -1) frm.elements[i].checked = obj.checked;
      }
    }
}
//操作员复选框全部选取
function checkAll(frm, checkbox){
	for(i = 0; i < frm.elements.length; i++){
		if( frm.elements[i].type == "checkbox" ){
			frm.elements[i].checked = checkbox.checked;
		}
	}
}




//赠品（特惠品）商品
function special_preference(){
	var sp_obj = document.getElementById('special_preference');
	var good_obj = document.getElementById('source_select1');
}

/********************/



