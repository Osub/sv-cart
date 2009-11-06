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
 * $Id: index.ctp 4482 2009-09-24 03:35:50Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?><div id="Products_box">
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['address_book']?></b></h1>
  
  <div class="reguser_gut01 addrees_box" style="padding-bottom:0;margin-left:0;">
  <?php if(isset($this->data['user_address']) && sizeof($this->data['user_address'])>0){?>
  <p class="aleter">&nbsp;&nbsp;<?php echo $SCLanguages['preset_delivery_address'];?>。</p>
  <table width="100%" cellspacing="0" cellpadding="2">
    
    <?php foreach($this->data['user_address'] as $k=>$v){?>
    <tr bgcolor="#ffffff" height="25" class="adrees_list">
    	<td align="center" width="10%" rowspan="2">&nbsp;<?php echo $v['UserAddress']['name']?></td>
    	<td align="center" width="20%">&nbsp;<?php echo $v['UserAddress']['consignee']?></td>
    	<td align="center" width="35%">&nbsp;<?php echo $v['UserAddress']['email']?></td>
        <td align="center" width="20%"><?php echo $v['UserAddress']['telephone_all']?>/<?php echo $v['UserAddress']['mobile']?></td>
        <td align="center" width="15%">&nbsp;<?php echo $v['UserAddress']['zipcode']?></td>
         <td align="center"  class="btn_list" rowspan="2">
        <div class="margin_sid">
        <a href="javascript:show_edit(<?php echo $v['UserAddress']['id']?>)"><span><?php echo $SCLanguages['edit']?></span></a>
        <p style='height:0;line-height:0;padding:0;margin:3px 0 0;'></p>
        <a href="javascript:del_address(<?php echo $v['UserAddress']['id']?>)"><span><?php echo $SCLanguages['delete']?></span></a>
        </div>
        </td>
    </tr>
    	<td align="center" >&nbsp;<?php echo $v['UserAddress']['regions']?></td>
    	<td align="center" >&nbsp;<?php echo $v['UserAddress']['address']?></td>
    	<td align="center" >&nbsp;<?php echo $v['UserAddress']['sign_building']?></td>
        <td align="center">&nbsp;<?php echo $v['UserAddress']['best_time']?></td>
    <?php }?>
    	
    	
  </table>

    <?php }else{?>
	<br /><br />
	<div class="not">
	<br /><br /><br />
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'warning_img.gif':'warning_img.gif',array('align'=>'middle','style'=>'margin-right:15px;margin-top:-10px;'))?><strong><?php echo $SCLanguages['no_address'];?></strong>
	<br /><br /><br /><br />
	</div>
	<hr />
    <?}?>
  <?php if(isset($SVConfigs['add_address_count']) && ($count_addresses < $SVConfigs['add_address_count'])){?>
  <p class="btn_list" style="margin:10px 0 0 20px;">
  <a id="add_address" style="cursor:pointer;" class='float_l' onclick="javascript:show_add();"><span style="text-indent:0;"><b><?php echo $SCLanguages['add']?></b></span></a></p>
  <?php }?>

</div>

        
</div>
<?php echo $this->element('news', array('cache'=>array('time'=> "+0 hour",'key'=>'news'.$template_style)));?>

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
<!--  增加地址的弹出层  -->
<div id="add_address_show" style="display:none;">
<div class="hd" style='height:auto;'>
<h2 class="add-addresses">
<span class="left"><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."title_l.gif":"title_l.gif")?></span><span class="right"><?php echo $html->image(isset($img_style_url)?$img_style_url."/"."title_r.gif":"title_r.gif")?></span>
<span><?php echo $SCLanguages['add'].$SCLanguages['consignee'].$SCLanguages['information'];?></span></h2></div>
<div class="addrees_box reguser_gut01" style="margin-top:0;border-top:0;overflow:hidden;height:100%;margin-left:0;width:auto;">
  
<form action="" method="post" name="InsertAddressForm" onsubmit="return check_insert_address();">
   	<input type="hidden" name="action_type" value="insert_address">
   	<input type="hidden" name="data[UserAddress][user_id]" id="AddUserAddressUserId" value="<?=$_SESSION['User']['User']['id'];?>">
<ul>
  <li>
  <dd class="l"><?php echo $SCLanguages['address'];?><?php echo $SCLanguages['label'];?>：</dd>
  <dt style="white-space:nowrap;"><input type="text" name="data[UserAddress][name]" id="AddUserAddressName" maxLength="40" size="27" />&nbsp;<font color="red" id="add_name_msg">*</font>    </dt></li>
  <li>
  <li>
  <dd class="l"><?php echo $SCLanguages['consignee'].$SCLanguages['name']?>：</dd>
  <dt style="white-space:nowrap;"><input type="text" name="data[UserAddress][consignee]" id="AddUserAddressConsignee" maxLength="40" size="27" />&nbsp;<font color="red" id="add_consignee_msg">*</font>    </dt></li>
  <li>
<dd class="l"><?php echo $SCLanguages['email']?>：</dd>
<dt style="white-space:nowrap;"><input type="text" name="data[UserAddress][email]" id="AddUserAddressEmail" maxLength="40" size="27" />&nbsp;<font color="red" id="add_email_msg">*</font></dt></li>
  <li>
    <dd class="l"><span id="span_Uname"><?php echo $SCLanguages['region']?>：</span></dd>
    <dt style="white-space:nowrap;"><span id="regionsupdate"></span><span id="region_t_loading" style='display:none'><?php echo $html->image('regions_loader.gif',array('class'=>'vmiddle'));?></span>&nbsp;<font color="red" id="add_regions_msg">*</font> </dt>
 </li>
<script type="text/javascript">
show_two_regions("");
</script>
  <li>
    <dd class="l"><?php echo $SCLanguages['street'];?>：</dd>
    <dt class="adrees" style="width:auto;"><textarea name="data[UserAddress][address]" id="AddUserAddressAddress"  style="width:250px;overflow-y:scroll" rows="4"></textarea>&nbsp;<font color="red" id="add_address_msg">*</font>
    <p ><?php echo $SCLanguages['duplicate_fill_province_city_district'];?>。</p></dt></li>

  <li>
  <dd class="l"><?php echo $SCLanguages['marked_building']?>：</dd>
  <dt style="white-space:nowrap;"><input type="text" name="data[UserAddress][sign_building]" id="AddUserAddressSignBuilding" maxLength="40" size="27" value="" />
  </dt></li>




<li>
    <dd class="l"><?php echo $SCLanguages['post_code']?>：</dd>
    <dt style="white-space:nowrap;"><input name="data[UserAddress][zipcode]" id="AddUserAddressZipcode" onKeyUp="is_int(this);" size="27" /></dt></li>
    <li>
        <dd class="l"><span id="span_phone"><?php echo $SCLanguages['telephone']?>：</span></dd>
        <dt><input type="text" name="user_tel0" id="Addtel_0"  onKeyUp="is_int(this);" /></dt>
        <dd style="display:none;"><font color="red" id="add_tel_msg">*</font><?php echo $SCLanguages['zone_telephone_extension']?></dd></li>
  
      <li>
        <dd class="l"><span id="span_phone"><?php echo $SCLanguages['mobile']?>：</span></dd>
        <dt style="white-space:nowrap;"><input type="text" name="data[UserAddress][mobile]" id="AddUserAddressMobile" maxLength="30" onKeyUp="is_int(this);" size="27" />&nbsp;<font color="red" id="add_mobile_msg">*</font> </dt></li>

	  <li>
	  <dd class="l"><?php echo $SCLanguages['best_shipping_time']?>：</dd>
	  <dt style="white-space:nowrap;">
	<select name="data[UserAddress][best_time]" id="AddUserAddressBestTime" style="width:130px;">	
		<option value="" selected='selected'><?php echo $SCLanguages['please_choose']?></option>
		<?php 
			if(isset($information_info['best_time']) && sizeof($information_info['best_time'])>0){
				foreach($information_info['best_time'] as $k=>$v){
					if($k != ''){
					?>
				<option value="<?php echo $v?>"><?php echo $v?></option>
		<?}}}?>
	</select>		  	  
	  </dt></li>		
	  <li>
	  <dd class="l"><?php echo $SCLanguages['if_set_default']?>：</dd>
	  <dt style="white-space:nowrap;"><input type="checkbox" name="data[UserAddress][is_default]" id="add_is_default" style="width:auto" value="1" />
	  </dt></li>		  
	  	  
	  	    
</ul>

<ul id="ul_company" style="display:none;">
  <li>
    <dd class="l"><b><?php echo $SCLanguages['purchase_requirement']?>：</b></dd>
    <dt>
      <input name="buytype" id="buytype1" type="radio" size="16" value="1" /><?php echo $SCLanguages['yes']?>&nbsp;
      <input name="buytype" id="buytype2" type="radio" size="16" value="0" /><?php echo $SCLanguages['no']?><font color="red">*</font></dt>
      <dd>[<?php echo $SCLanguages['choose_if_purchase_now']?>] </dd>  
  </li>

  <li>
    <dd class="l"><b><?php echo $SCLanguages['company_name']?>：</b></dd>
    <dt>
      <input name="Comname" id="Comname" type="text" size="16" maxLength="20" />&nbsp;<font color="red">*</font></dt>
      <dd>[<?php echo $SCLanguages['leave_company_name']?>] </dd>  
  </li>
  <li>
    <dd class="l"><span id="spanzz_comaddr"><b><?php echo $SCLanguages['company_address']?>：</b></span></dd>
    <dt><input name="Comaddr" id="Text2" type="text" size="40" maxLength="80" /></dt>
    <dd>[<?php echo $SCLanguages['leave_company_address']?>]</dd>  
  </li>
  <li>
    <dd class="l"><b><?php echo $SCLanguages['company_phone']?>：</b></dd>
    <dt><input name="Comphone" id="Text3" type="text" size="16" maxLength="20" /></dt>
    <dd>[<?php echo $SCLanguages['leave_company_tel.']?>]</dd>  
  </li>
</ul>
<div class="ws_xx"></div>
<div class="add_btn big_buttons">
	<p style="padding-left:198px;">
	<span class="float_l" style="text-indent:0;"><input onfocus="blur()" type="button" name="Submit2" value="<?php echo $SCLanguages['add'];?>" onclick="javascript:add_user_address();" /></span>
	<span class="float_l" style="margin-left:4px;text-indent:0;"><input onfocus="blur()" type="button" name="Submit2" value="<?php echo $SCLanguages['cancel'];?>" onclick="javascript:address_dialog_obj.hide();" /></span>
	</p></div>
</form>

</div>
</div>
