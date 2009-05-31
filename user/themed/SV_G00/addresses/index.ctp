<?php
/*****************************************************************************
 * SV-Cart 我的地址簿
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<div id="Products_box">
    	<h1 class="headers"><span class="l"></span><span class="r"></span><b><?echo $SCLanguages['address_book']?></b></h1>
  <div id="reguser_gut01" class="addrees_box" style="padding-bottom:0;margin-left:0;">
  <p class="aleter"><?=$SCLanguages['preset_delivery_address'];?>。</p>
  <table width="100%" cellspacing="0" cellpadding="2">
    <?if(isset($this->data) && sizeof($this->data)>0){?>
    
    <?foreach($this->data as $k=>$v){?>
    <tr bgcolor="#ffffff" height="25" class="adrees_list">
    	<td align="center" width="10%" rowspan="2"><?echo $v['UserAddress']['name']?></td>
    	<td align="center" width="20%"><?echo $v['UserAddress']['consignee']?></td>
    	<td align="center" width="35%">&nbsp;<?echo $v['UserAddress']['email']?></td>
        <td align="center" width="20%"><?echo $v['UserAddress']['telephone_all']?>/<?echo $v['UserAddress']['mobile']?></td>
        <td align="center" width="15%">&nbsp;<?echo $v['UserAddress']['zipcode']?></td>
         <td align="center"  class="btn_list" rowspan="2">
        <div class="margin_sid">
        <a href="javascript:show_edit(<?=$v['UserAddress']['id']?>)"><span><?echo $SCLanguages['edit']?></span></a>
        <p style='height:0;line-height:0;padding:0;margin:3px 0 0;'></p>
        <a href="javascript:del_address(<?=$v['UserAddress']['id']?>)"><span><?echo $SCLanguages['delete']?></span></a>
        </div>
        </td>
    </tr>
    	<td align="center" ><?echo $v['UserAddress']['regions']?></td>
    	<td align="center" ><?echo $v['UserAddress']['address']?></td>
    	<td align="center" >&nbsp;<?echo $v['UserAddress']['sign_building']?></td>
        <td align="center">&nbsp;<?echo $v['UserAddress']['best_time']?></td>
    <?}?>
    	
    <?}?>
    	
  </table>
  <?if(isset($SVConfigs['add_address_count']) && ($count_addresses < $SVConfigs['add_address_count'])){?>
  <p class="btn_list" style="margin:10px 0 0 20px;">
  <a id="add_address" style="cursor:pointer;" class='float_l' onclick="javascript:show_add();"><span style="text-indent:0;"><b><?echo $SCLanguages['add']?></b></span></a></p>
  <?}?>
</div>

        
</div>
<?php echo $this->element('news', array('cache'=>'+0 hour'));?>

<!--展开增加编辑框-->	
<script type="text/JavaScript">
<!-- 

function show_edit_div(AddressId,Regions){
var posX;
var posY;  
  var EditAddress=document.getElementById('edit_address['+AddressId+']');
  if(EditAddress.style.display=="none"){
	EditAddress.style.display="block";
	EditAddress.style.top=(document.documentElement.scrollTop+(document.documentElement.clientHeight-EditAddress.offsetHeight)/2)+"px";
	EditAddress.style.left=(document.documentElement.scrollLeft+(document.documentElement.clientWidth-EditAddress.offsetWidth)/2)+"px";
document.getElementById("title").onmousedown=function(e)
{
  if(!e) e = window.event; //alert("reerr")//如果是IE
  posX = e.clientX - parseInt(EditAddress.style.left);
  posY = e.clientY - parseInt(EditAddress.style.top);
  document.onmousemove = mousemove;  
}
document.onmouseup = function()
{
  document.onmousemove = null;
}
function mousemove(ev)
{
  if(ev==null) ev = window.event;//如果是IE
  EditAddress.style.left = (ev.clientX - posX) + "px";
  EditAddress.style.top = (ev.clientY - posY) + "px";
}
	}
	else{
	EditAddress.style.display="none";
	}
	edit_regions(AddressId,Regions);

}
-->
</script>
<!--增加编辑框-->

<script>
//删除地址-----begin
function del_address(AddressId){
   window.location.href=webroot_dir+"addresses/deladdress/"+AddressId;
}
//删除地址-------end
//编辑地址------begin
function check_edit_address(Key){
alert("1");
   if(document.getElementById('UserAddress'+Key+'Consignee').value == ''){
       alert(consignee_name_not_empty);
       return false;
   }
   else if(document.getElementById('UserAddress'+Key+'Email').value == ''){
       alert(invalid_email);
       return false;
  }
  else if(document.getElementById('UserAddress'+Key+'Email').value != '' && !( /^[-_A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/.test(document.getElementById('UserAddress'+Key+'Email').value))){
       alert(invalid_email);
       return false;
  }
   else if(document.getElementById('UserAddress'+Key+'Address').value == ''){
      alert(address_detail_not_empty);
      return false;
   }
   else if(document.getElementById('UserAddress'+Key+'Zipcode').value == ''){
      alert(zip_code_not_empty);
      return false;
   }
   else if(document.getElementById('UserAddress'+Key+'Mobile').value == ''){
         if(document.getElementById('tel_0'+Key).value == '' || document.getElementById('tel_1'+Key).value == ''){
             alert(fill_one_contact);
             return false;
         }
  }
  else if(document.getElementById('UserAddress'+Key+'Mobile').value != '' && document.getElementById('UserAddress'+Key+'Mobile').value.length != 11){
         alert(invalid_mobile_number);
         return false;
  }
  alert("2");

}
//编辑地址------end
//新增地址------begin
function check_insert_address(){

  if(document.getElementById('UserAddressConsignee').value == ''){
     alert(consignee_name_not_empty);
     return false;
  }
  else if(document.getElementById('UserAddressEmail').value == ''){
       alert(invalid_email);
       return false;
  }
  else if(document.getElementById('UserAddressEmail').value != '' && !( /^[-_A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/.test(document.getElementById('UserAddressEmail').value))){
       alert(invalid_email);
       return false;
  }  
  else if(document.getElementById('UserAddressAddress').value == ''){
     alert(address_detail_not_empty);
     return false;
  }
  else if(document.getElementById('UserAddressZipcode').value == ''){
     alert(zip_code_not_empty);
     return false;
  }
  else if(document.getElementById('UserAddressMobile').value == ''){
         if(document.getElementById('user_tel0').value == '' || document.getElementById('user_tel1').value == ''){
             alert(fill_one_contact);
             return false;
         }
  }
    else if(document.getElementById('UserAddressMobile').value != '' && document.getElementById('UserAddressMobile').value.length != 11){
         alert(invalid_mobile_number);
         return false;
  }

}
//新增地址------end
</script>
<script>
//取得省市下级-----begin
function show_lower(RegionId,Level,Target){

        YAHOO.example.container.manager.hideAll();
		YAHOO.example.container.wait.show();
		var sUrl = webroot_dir+"addresses/change_region/"+RegionId+"/"+Level+"/"+Target;
		var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, change_region_callback);
}
	var change_region_Success = function(o){
		try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);   
		}catch (e){   
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		} 
	 
		var sel = document.getElementById(result.targets);
		if (result.regions)
        {
          for (i = 0; i < result.regions.length; i ++ )
            {
              var opt = document.createElement("OPTION");
                  opt.value = result.regions[i]['RegionI18n'].region_id;
                  opt.text  = result.regions[i]['RegionI18n'].name;
                  sel.options.add(opt);
            }
        }
		YAHOO.example.container.wait.hide();
	}

	var change_region_Failure = function(result){
		YAHOO.example.container.wait.hide();
	}

	var change_region_callback ={
		success:change_region_Success,
		failure:change_region_Failure,
		timeout : 3000,
		argument: {}
	};
//取得省市下级-----end
</script>