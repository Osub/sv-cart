<?php 
/*****************************************************************************
 * SV-Cart missing_action
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: missing_action.ctp 724 2009-04-17 07:59:41Z shenyunfeng $
*****************************************************************************/
?>
<?php //pr($this->name);?>
<div id="ur_here">错误信息</div>
<!--Main Start-->
<div class="home_main" >
	<div class="informations">
	<br /><br /><Br /><br /><Br /><br />
	<p><?php echo $html->image('msg.gif',array('align'=>'middle'))?> &nbsp;&nbsp;<strong>
	<?php echo $html->link("网页不存在","/",array(),false,false);?>
	</strong></p>
	<br /><br /><Br /><br /><Br /><br /><Br /><br />
	<p class="handdle"><span>
	<?php echo $html->link("返回首页","/",array(),false,false);?>
	</span></p>
	<br /><Br /><br /><Br /><br /><Br /><br />
	</div>

</div>
<!--Main Start End-->

</body>
</html>