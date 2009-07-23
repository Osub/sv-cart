<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<div id="Goods_box">
    	<h1><span>我的地址簿</span></h1>
  <div id="reguser_gut01" class="addrees_box" style="padding-bottom:0;">
  <p class="aleter">您可以预设您的购物收货地址。</p>
  <table width="100%">
  	<tr bgcolor="#E9FFDF" height="25">
    	<td align="center">收货人</td>
    	<td align="center">邮箱</td>
        <td align="center">所在地区</td>
        <td align="center">街道地址</td>
        <td align="center">邮编</td>
        <td align="center">电话/手机</td>
        <td align="center" class="btn_list">操作</td>
    </tr>
    <?php foreach($this->data as $k=>$v){?>
    <tr bgcolor="#ffffff" height="25" class="adrees_list">
    	<td align="center" width=90><?php echo $v['UserAddress']['consignee']?></td>
    	<td align="center" width=120><?php echo $v['UserAddress']['email']?></td>
        <td align="center"><?php echo $v['UserAddress']['regions']?></td>
        <td align="center"><?php echo $v['UserAddress']['address']?></td>
        <td align="center"><?php echo $v['UserAddress']['zipcode']?></td>
        <td align="center"><?php echo $v['UserAddress']['telephone_all']?>/<?php echo $v['UserAddress']['mobile']?></td>
        <td align="center" class="btn_list">
        <?php echo $html->link('修 改',"javascript:show_edit_div({$v['UserAddress']['id']},'{$v['UserAddress']['regions']}')")?>
        <p style='height:0;line-height:0;padding:0;margin:0;'></p>
        <?php echo $html->link('删 除',"javascript:del_address({$v['UserAddress']['id']})")?></td>
    </tr>
    <?php }?>
  </table>
  <p style="margin:10px 0 0;">
  <a id="add_address" href="javascript:void(0)" class='bg_btns' style='margin-left:20px;'><b>新增</b></a></p>
</div>
<div id="add_address_box">
<div class="hd" style='height:auto;'>
<h2 class="add-addresses"><span>新增收货地址</span></h2></div>
<div id="reguser_gut01" class="addrees_box" style="margin-top:0;border-top:0;overflow:hidden;height:100%;">
  
<form action="" method="post" name="InsertAddressForm" onsubmit="return check_insert_address();">
   	<input type="hidden" name="action_type" value="insert_address">
   	<input type="hidden" name="data[UserAddress][user_id]" id="UserAddressUserId" value="<?php echo $user_id?>">
<ul>
  <li><span>收货人姓名：</span> <span>
    <input type="text" name="data[UserAddress][consignee]" id="UserAddressConsignee" maxLength="40" size="27" />&nbsp;<font color="red">*</font>
    </span></li>

<li><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;邮箱：</span> <span>
    <input type="text" name="data[UserAddress][email]" id="UserAddressEmail" maxLength="40" size="27" />&nbsp;<font color="red">*</font>
    </span></li>

  <li>
    <span id="span_Uname">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;区域：</span>
    <span id="regions"></span>
 </li>
<script type="text/javascript" src="/themed/SV_G00/js/regions.js"></script>
<script type="text/javascript">
show_regions("");
</script>
  <li>
    <span>&nbsp;&nbsp;&nbsp;&nbsp;街道地址：</span>
    <span class="adrees"><textarea  name="data[UserAddress][address]" id="UserAddressAddress"></textarea> <font color="red">*</font></span><span>不需要重复填写省/市/区。</span>  </li>
  <li>
    <span>&nbsp;&nbsp;&nbsp;&nbsp;邮政编码：</span>
    <span><input name="data[UserAddress][zipcode]" id="UserAddressZipcode" size="27" maxLength="18" />&nbsp;<font color="red">*</font></span></li>
    <li>
        <span id="span_phone">&nbsp;&nbsp;&nbsp;&nbsp;电话号码：</span>
         <span><input type="text" name="user_tel0" id="user_tel0" maxLength="30" size="6" />-<input type="text" name="user_tel1" id="user_tel1" maxLength="30" size="10" />-<input type="text" name="user_tel2" id="user_tel2" maxLength="30" size="6" /></span><span>（区号-电话号码-分机）</span></li>
  
      <li>
        <span id="span_phone">&nbsp;&nbsp;&nbsp;&nbsp;手机号码：</span>
        <span><input type="text" name="data[UserAddress][mobile]" id="UserAddressMobile" maxLength="30" size="27" /></span></li>
</ul>

<ul id="ul_company" style="display:none;">
  <li>
    <b>采购需求：</b></span>
    <span>
      <input name="buytype" id="buytype1" type="radio" size="16" value="1" />是&nbsp;
      <input name="buytype" id="buytype2" type="radio" size="16" value="0" />否<font color="red">*</font></span>
      <span class="z_c">[是否现在采购，请选择。] </span>  
  </li>

  <li>
    <b>单位名称：</b></span>
    <span>
      <input name="Comname" id="Comname" type="text" size="16" maxLength="20" />&nbsp;<font color="red">*</font></span>
      <span class="z_c">[请留下您公司的名称。] </span>  
  </li>
  <li>
    <span id="spanzz_comaddr"><b>单位地址：</b></span>

    <span>
      <input name="Comaddr" id="Text2" type="text" size="40" maxLength="80" /></span>
      <span class="z_c">[请留下您公司的地址。] </span>  
  </li>
  <li>
    <span><b>单位电话：</b></span>
    <span>
      <input name="Comphone" id="Text3" type="text" size="16" maxLength="20" /></span>

      <span class="z_c">[请留下您公司的电话。] </span>  
  </li>
</ul>
<div class="ws_xx"></div>
<div class="add_btn">
	<input type="image" name="Submit2" src="/themed/SV_G00/img/add_adrees.gif"/>  &nbsp;
</div>
</form>

</div>

</div>
<?php foreach($this->data as $k=>$v){?>
<div id="edit_address[<?php echo $v['UserAddress']['id']?>]" style="display:none">
<h2 class="add-addresses"><span>编辑收货地址</span></h2>
<div id="reguser_gut01" class="addrees_box" style="margin-top:0;border-top:0;overflow:hidden;height:100%;">
  
    <form action="" method="post"  name="EditAddressForm" onsubmit="return check_edit_address(<?php echo $k?>);">
      <input type="hidden" name="data[UserAddress][<?php echo $k;?>][id]" id="UserAddress<?php echo $k;?>Id" value="<?php echo $v['UserAddress']['id']?>"></>
      <input type="hidden" name="data[UserAddress][<?php echo $k;?>][user_id]" id="UserAddress<?php echo $k;?>UserId" value="<?php echo $v['UserAddress']['user_id']?>"></>
        <input type="hidden" name="action_type" value="edit_address">
<ul>
  <li><span>收货人姓名：</span> <span>
    <input type="text" name="data[UserAddress][<?php echo $k;?>][consignee]" id="UserAddress<?php echo $k;?>Consignee" maxLength="40" size="27" value="<?php echo $v['UserAddress']['consignee']?>"/>&nbsp;<font color="red">*</font>
    </span></li>
  
  <li><span>邮箱：</span> <span>
    <input type="text" name="data[UserAddress][<?php echo $k;?>][email]" id="UserAddress<?php echo $k;?>Email" maxLength="40" size="27" value="<?php echo $v['UserAddress']['email']?>"/>&nbsp;<font color="red">*</font>
    </span></li>
  
  <li>
    <span id="span_Uname">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;区域：</span>
    <span id="regions_edit<?php echo $v['UserAddress']['id']?>"></span>
 </li>
 <li>
    <span>&nbsp;&nbsp;&nbsp;&nbsp;街道地址：</span>
    <span class="adrees"><textarea name="data[UserAddress][<?php echo $k;?>][address]" id="UserAddress<?php echo $k;?>Address"><?php echo $v['UserAddress']['address']?></textarea> <font color="red">*</font></span><span>不需要重复填写省/市/区。</span>  </li>
  <li>
    <span>&nbsp;&nbsp;&nbsp;&nbsp;邮政编码：</span>
    <span><input name="data[UserAddress][<?php echo $k;?>][zipcode]" id="UserAddress<?php echo $k;?>Zipcode" size="27" maxLength="18" value="<?php echo $v['UserAddress']['zipcode']?>"/>&nbsp;<font color="red">*</font></span></li>

  
    <li>
        <span id="span_phone">&nbsp;&nbsp;&nbsp;&nbsp;电话号码：</span>
        <input type="text" name="tel_0[<?php echo $k;?>]" id="tel_0<?php echo $k;?>" maxLength="30" size="6" value="<?php echo $v['UserAddress']['telephone'][0]?>"/>-<input type="text" name="tel_1[<?php echo $k;?>]" id="tel_1<?php echo $k;?>" maxLength="30" size="10" value="<?php echo $v['UserAddress']['telephone'][1]?>"/>-<input type="text" name="tel_2[<?php echo $k;?>]" id="tel_2<?php echo $k;?>" maxLength="30" size="6" value="<?php echo $v['UserAddress']['telephone'][2]?>"/></span><span>（区号-电话号码-分机）</span></li>
  
      <li>
        <span id="span_phone">&nbsp;&nbsp;&nbsp;&nbsp;手机号码：</span>
        <span><input type="text" name="data[UserAddress][<?php echo $k;?>][mobile]" id="UserAddress<?php echo $k;?>Mobile" maxLength="30" size="27" value="<?php echo $v['UserAddress']['mobile']?>"/></span></li>
</ul>

<ul id="ul_company" style="display:none;">
  <li>
    <b>采购需求：</b></span>
    <span>
      <input name="buytype" id="buytype1" type="radio" size="16" value="1" />是&nbsp;
      <input name="buytype" id="buytype2" type="radio" size="16" value="0" />否<font color="red">*</font></span>
      <span class="z_c">[是否现在采购，请选择。] </span>  
  </li>

  <li>
    <b>单位名称：</b></span>
    <span>
      <input name="Comname" id="Comname" type="text" size="16" maxLength="20" />&nbsp;<font color="red">*</font></span>
      <span class="z_c">[请留下您公司的名称。] </span>  
  </li>
  <li>
    <span id="spanzz_comaddr"><b>单位地址：</b></span>

    <span>
      <input name="Comaddr" id="Text2" type="text" size="40" maxLength="80" /></span>
      <span class="z_c">[请留下您公司的地址。] </span>  
  </li>
  <li>
    <span><b>单位电话：</b></span>
    <span>
      <input name="Comphone" id="Text3" type="text" size="16" maxLength="20" /></span>

      <span class="z_c">[请留下您公司的电话。] </span>  
  </li>
</ul>
<div class="ws_xx"></div>
<div class="add_btn">
	<input type="image" name="Submit2" src="/themed/SV_G00/img/add_adrees.gif"  />  &nbsp;
</div>

</form>
</div>

</div>
<?php }?>

        
    </div>
<?php echo $this->element('news', array('cache'=>'+0 hour'));?>

<!--展开增加编辑框-->	
<script language="JavaScript" type="text/JavaScript">
<!-- 

function show_edit_div(AddressId,Regions){
  var EditAddress=document.getElementById('edit_address['+AddressId+']');
  if(EditAddress.style.display=="none"){
	EditAddress.style.display="block";
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
   window.location.href="/user/addresses/deladdress/"+AddressId;
}
//删除地址-------end
//编辑地址------begin
function check_edit_address(Key){
   if(document.getElementById('UserAddress'+Key+'Consignee').value == ''){
       alert("收货人姓名为空!");
       return false;
   }
   else if(document.getElementById('UserAddress'+Key+'Email').value == ''){
       alert("邮箱为空!");
       return false;
  }
  else if(document.getElementById('UserAddress'+Key+'Email').value != '' && !( /^[-_A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/.test(document.getElementById('UserAddress'+Key+'Email').value))){
       alert("邮箱格式不合法!");
       return false;
  }
   else if(document.getElementById('UserAddress'+Key+'Address').value == ''){
      alert("街道地址为空!");
      return false;
   }
   else if(document.getElementById('UserAddress'+Key+'Zipcode').value == ''){
      alert("邮政编码为空!");
      return false;
   }
   else if(document.getElementById('UserAddress'+Key+'Mobile').value == ''){
         if(document.getElementById('tel_0'+Key).value == '' || document.getElementById('tel_1'+Key).value == ''){
             alert("填写一个联系方式!");
             return false;
         }
  }
  else if(document.getElementById('UserAddress'+Key+'Mobile').value != '' && document.getElementById('UserAddress'+Key+'Mobile').value.length != 11){
         alert("手机号码不合法!");
         return false;
  }

}
//编辑地址------end
//新增地址------begin
function check_insert_address(){
  if(document.getElementById('UserAddressConsignee').value == ''){
     alert("收货人姓名为空!");
     return false;
  }
  else if(document.getElementById('UserAddressEmail').value == ''){
       alert("邮箱为空!");
       return false;
  }
  else if(document.getElementById('UserAddressEmail').value != '' && !( /^[-_A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/.test(document.getElementById('UserAddressEmail').value))){
       alert("邮箱格式不合法!");
       return false;
  }
  else if(document.getElementById('UserAddressAddress').value == ''){
     alert("街道地址为空!");
     return false;
  }
  else if(document.getElementById('UserAddressZipcode').value == ''){
     alert("邮政编码为空!");
     return false;
  }
  else if(document.getElementById('UserAddressMobile').value == ''){
         if(document.getElementById('user_tel0').value == '' || document.getElementById('user_tel1').value == ''){
             alert("填写一个联系方式!");
             return false;
         }
  }
    else if(document.getElementById('UserAddressMobile').value != '' && document.getElementById('UserAddressMobile').value.length != 11){
         alert("手机号码不合法!");
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
		var sUrl = "/user/addresses/change_region/"+RegionId+"/"+Level+"/"+Target;
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