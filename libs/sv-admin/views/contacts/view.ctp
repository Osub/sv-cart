<?php 
/*****************************************************************************
 * SV-Cart 联系我们详细
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3792 2009-08-19 11:21:35Z zhengli $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."联系列表","/contacts/",'',false,false);?></strong></p>

<!--Main Start-->

<div class="home_main">
<?php echo $form->create('email_lists',array('action'=>'/'.$this->data['Contact']['id'],'onsubmit'=>'return mailtemplates_check();'));?>
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	  <?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	  <?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	  查看详细</h1></div>
	  <div class="box">
<!--Mailtemplates_Config-->
	  <div class="shop_config menus_configs">
	  	<dl><dt style="width:105px;">公司名称: </dt>
			<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="data_mailtemplate_code" name="data[Contact][company]" value="<?php echo $this->data['Contact']['company'];?>"  readonly /></dd></dl>
	  	<dl><dt style="width:105px;">公司域名: </dt>
			<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="data_mailtemplate_code" name="data[Contact][company_url]" value="<?php echo $this->data['Contact']['company_url'];?>"  readonly/></dd></dl>
	  	<dl><dt style="width:105px;">公司行业: </dt>
			<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="data_mailtemplate_code" name="data[Contact][company_type]" value="<?php echo isset($information_info['company_type'][$this->data['Contact']['company_type']])?$information_info['company_type'][$this->data['Contact']['company_type']]:'未定义';?>" readonly/></dd></dl>
	  	<dl><dt style="width:105px;">联系人: </dt>
			<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="data_mailtemplate_code" name="data[Contact][contact_name]" value="<?php echo $this->data['Contact']['contact_name'];?>" readonly/></dd></dl>
	  	<dl><dt style="width:105px;">地址: </dt>
			<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="data_mailtemplate_code" name="data[Contact][address]" value="<?php echo $this->data['Contact']['address'];?>" readonly/></dd></dl>
	  	<dl><dt style="width:105px;">Email: </dt>
			<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="data_mailtemplate_code" name="data[Contact][email]" value="<?php echo $this->data['Contact']['email'];?>" readonly/></dd></dl>
	  	<dl><dt style="width:105px;">手机: </dt>
			<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="data_mailtemplate_code" name="data[Contact][mobile]" value="<?php echo $this->data['Contact']['mobile'];?>" readonly/></dd></dl>
	  	<dl><dt style="width:105px;">最佳联系方式: </dt>
			<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="data_mailtemplate_code" name="data[Contact][mobile]" value="<?php  if($this->data['Contact']['contact_type'] == '0'){ ?>手机<?php }?><?php  if($this->data['Contact']['contact_type'] == '1'){ ?>Email<?php }?><?php  if($this->data['Contact']['contact_type'] == '2'){ ?>手机 和 Email<?php }?>" readonly/></dd></dl>
	  	<dl><dt style="width:105px;">是否需要邮寄样本: </dt>
			<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="data_mailtemplate_code" name="data[Contact][mobile]" value="<?php  if($this->data['Contact']['is_send'] == 0){?>否<?php }?><?php  if($this->data['Contact']['is_send'] == 1){?>是<?php }?>" readonly/></dd></dl>
	  	<dl><dt style="width:105px;">QQ: </dt>
			<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="data_mailtemplate_code" name="data[Contact][qq]" value="<?php echo $this->data['Contact']['qq'];?>" readonly/></dd></dl>
	  	<dl><dt style="width:105px;">MSN: </dt>
			<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="data_mailtemplate_code" name="data[Contact][msn]" value="<?php echo $this->data['Contact']['msn'];?>" readonly/></dd></dl>
	  	<dl><dt style="width:105px;">Skype: </dt>
			<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="data_mailtemplate_code" name="data[Contact][skype]" value="<?php echo $this->data['Contact']['skype'];?>" readonly/></dd></dl>
	  	<dl><dt style="width:105px;">IP地址: </dt>
			<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="data_mailtemplate_code" name="data[Contact][ip_address]" value="<?php echo $this->data['Contact']['ip_address'];?>" readonly/></dd></dl>
	  	<dl><dt style="width:105px;">如何获知: </dt>
			<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="data_mailtemplate_code" name="data[Contact][ip_address]" value="<?php echo isset($information_info['from_type'][$this->data['Contact']['from']])?$information_info['from_type'][$this->data['Contact']['from']]:'未选择';?>" readonly/></dd></dl>
	  	<dl><dt style="width:105px;">浏览器版本: </dt>
			<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="data_mailtemplate_code" name="data[Contact][browser]" value="<?php echo $this->data['Contact']['browser'];?>" readonly/></dd></dl>
	  	<dl><dt style="width:105px;">语言: </dt>
			<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="data_mailtemplate_code" name="data[Contact][locale]" value="<?php echo $this->data['Contact']['locale'];?>" readonly/></dd></dl>
	  	<dl><dt style="width:105px;">分辨率: </dt>
			<dd><input type="text" style="width:357px;*width:180px;border:1px solid #649776" id="data_mailtemplate_code" name="data[Contact][resolution]" value="<?php echo $this->data['Contact']['resolution'];?>" readonly/></dd></dl>
	  	<dl><dt style="width:105px;">具体信息: </dt>
			<dd><textarea   readonly='true' style="width:357px;*width:180px;border:1px solid #649776"><?php echo $this->data['Contact']['content'];?></textarea></dd></dl>

	</div>
<!--Mailtemplates_Config End-->
	  </div><br />
</div>