<?php 
/*****************************************************************************
 * SV-Cart 广告代码粘贴
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<html>
<head>
<title>广告代码 - Powered by Seevia</title>
</head>
<body>
<span>广告代码</span>
<textarea name='ad_content' id='ad_content' rows="3" cols="30"></textarea>
<input type="button" value="执行代码" onclick="operator_code()">
</body>
</html>
<script>
function operator_code()
{
	var code = document.getElementById('ad_content').value;
	var aa = code.split("\"");
	if(aa!="")
	{
	   window.location.href = aa[3];
	}
	//document.write(code);
}
</script>