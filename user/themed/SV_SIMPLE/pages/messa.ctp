<?php 
/*****************************************************************************
 * SV-Cart 会员登录
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: login.ctp 987 2009-04-24 08:08:24Z shenyunfeng $
*****************************************************************************/
?>
<div class="tips">
	<h4><strong>注册成功</strong></h4>
	<p>恭喜您注册成功，点击进入您的控制面板</p>
	<p>点击继续</p>
</div>
	
<div class="tips">
	<h4><strong>信息反馈</strong></h4>
	<p>对不起，您尚未登录，请先执行登录操作</p>
	<p>前往登录</p>
</div>
    	<fieldset>
			<legend class="font_yellow"><?php echo $SCLanguages['member'].$SCLanguages['login']?></legend>
			<?php echo $form->create('pages',array('action'=>'login','name'=>'user_login_no_ajax','type'=>'POST'));?>
			<dl class="password">
				<dt><?php echo $SCLanguages['username']?></dt><dd><input type="text" name="data[User][name]" id="UserName_page" tabindex="1"/></dd>
			</dl>
			<dl class="password">
				<dt><?php echo $SCLanguages['password']?></dt><dd><input type="password" name="data[User][password]" id="UserPassword_page" tabindex="2"/></dd>
	        </dl>	
			<dl id="error_message_area" style="margin-bottom:0;display:none;">
				<dt></dt><dd class="vidata" id="error_msg"></dd>
			</dl>
			
			<div class="submit_form">
			<?php if(isset($SVConfigs['use_ajax']) && $SVConfigs['use_ajax'] == 0){?>
				<span class="button float_left"><a href="javascript:user_login_no_ajax()"><?php echo $SCLanguages['confirm'];?></a></span>
			<?php }else{?>
				<span class="button float_left"><a href="javascript:user_login()"><?php echo $SCLanguages['confirm'];?></a></span>
			<?php }?>
				<span class="button float_left"><a href="../register/"><?php echo $SCLanguages['register'];?></a></span>
			</div>
			<p class="forget">忘记密码|<?php echo $html->link($SCLanguages['forget_password']."?","forget_password/",array("tabindex"=>"5"),false,false);?>
			</p>
			<?php echo $form->end();?>
			
		</fieldset>
		<div class="banner">
			<p><?php echo $html->image('login-banner.gif')?></p>
		</div>
</div>
