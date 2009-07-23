<?php 
/*****************************************************************************
 * SV-Cart 商品回收站列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 2761 2009-07-10 09:06:59Z shenyunfeng $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>

<!--Main Start-->
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' );">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="150px">操作日期</th>
	<th width="90px">操作员</th>
	<th>操作记录</th>
</tr>
<!--Messgaes List-->
    <?php foreach($log_array as $v){?>
<tr>
	<td align="center" width="150px"><?php echo $v[0]; ?></td>
	<td align="center" width="90px"><?php echo $v[1]; ?></td>
	<td><?php echo $v[2]; ?></td>
</tr>
    <?php } ?>
</table>
<!--Messgaes List End-->	
</div>
<!--Main Start End-->
</div>