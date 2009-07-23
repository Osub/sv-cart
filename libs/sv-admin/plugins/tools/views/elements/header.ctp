<?php 
/*****************************************************************************
 * SV-Cart 头部
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: header.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<div id="header">
	<div class="box">
		
		<div class="logo">
		<span class="select_lang">
		<input type="radio" class="radio" checked="checked" name="lang_radio" onclick="choose_lang(this.value);" value="chi" <?php if($local_lang=='chi') echo "checked"?>/>中&nbsp;&nbsp;&nbsp;&nbsp;文
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="radio eng_radio" type="radio" name="lang_radio" onclick="choose_lang(this.value);" value="eng" <?php if($local_lang=='eng') echo "checked"?>/>English</span>
	<?php echo $html->image('/tools/img/'.$local_lang.'/logo.gif')?></div>
	</div>
	<div class="box_2">
		<p align="center" class="logo"><?php echo $html->image('/tools/img/'.$local_lang.'/1_05.gif')?></p>
	</div>
</div>
<script type="text/javascript">
function choose_lang(value){
	if('<?php echo $local_lang?>'==value)
		return false;
	window.location.href = "?lang="+value;
}
</script>