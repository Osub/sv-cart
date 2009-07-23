<?php 
/*****************************************************************************
 * SV-Cart 商店设置向导
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: ucenter.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Main Start-->
<br />
<div class="home_main" id="guides_1">
<div class="order_stat athe_infos configvalues">
	<div class="title"><h1>
	<?php echo $html->image('tab_left.gif',array('class'=>'left'))?>
	<?php echo $html->image('tab_right.gif',array('class'=>'right'))?>
	设置会员数据整合插件</h1></div>
	<div class="box">
	<div class="shop_config menus_configs guides" style="width:500px;">
	<br />
	
	<dl><dt style="width:140px;">UCenter 的 URL: </dt>
	<dd><input type="text" style="width:300px;*width:180px;border:1px solid #649776"  /></dd></dl>
	<dl><dt style="width:140px;">UCenter 创始人密码: </dt>
	<dd><input type="text" style="width:300px;*width:180px;border:1px solid #649776" /></dd></dl>
	<input type="hidden" value="ucenter">


	</div>
	</div>
	<p class="submit_btn"><input type="button" value="确定" onclick="save_uc_config()" /><input type="reset" value="重置"  /></p>
	</div>
</div>

