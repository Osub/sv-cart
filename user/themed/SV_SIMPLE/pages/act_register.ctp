<?php 
/*****************************************************************************
 * SV-Cart 注册成功
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: done.ctp 2722 2009-07-09 07:57:02Z shenyunfeng $
*****************************************************************************/
?>
<!--Main Start-->
<div class="tips">
<?php if(isset($fail)){?>
	<h4><?php echo $SCLanguages['register'].$SCLanguages['failed']?></h4>
<?}else{?>
	<h4><?php echo $SCLanguages['register'].$SCLanguages['successfully']?></h4>
<?php }?>

<p>
	<?php echo $error_msg;?>
</p>
	
<p>
	<?php if(isset($_SESSION['back_url'])){?>
	<?php echo $html->link($SCLanguages['return'].$SCLanguages['previous'].$SCLanguages['page'],$_SESSION['back_url'],array(),false,false);?>
	<?php unset($_SESSION['back_url']);?>
	<?php }else{?>
	<?php echo $html->link($error_msg,$server_host.$user_webroot."register/",array(),false,false);?>		
	<?php }?>
</p>
</div>
<!--Main Start End-->
