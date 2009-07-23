<?php 
/*****************************************************************************
 * SV-Cart 用户中心首页
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: home.ctp 3233 2009-07-22 11:41:02Z huangbo $
*****************************************************************************/
?>
<?php echo $javascript->link('register');?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>	<div id="Products_box">
<h1 class="headers"><span class="l">&nbsp;</span><span class="r">&nbsp;</span><b><?php echo $SCLanguages['user_center']?></b></h1>
        <div id="infos">
        	<div id="wellcom_info">
            	<h2 class="user"><?php printf($SCLanguages['welcome_back'],$user_info['User']['name'])?></h2>
                <p><?php echo $SCLanguages['last_login_time']?>：<?php echo  $user_info['User']['modified'];?></p>
        	<p><?php echo $SCLanguages['level_is']?>：<?php echo $user_rank;?>&nbsp;<?=$SCLanguages['rank_point']?>:<?=(!empty($_SESSION['User']['User']['user_point'])?$_SESSION['User']['User']['user_point']:0)?><?php echo $SCLanguages['point_unit']?></p>
                <?php if($SVConfigs['enable_members_mail_verify'] == 1){?><?php if($user_info['User']['verify_status'] != 1){?><p class="atte"><?php echo $SCLanguages['not_passed_email_approval']?>&nbsp;<a href="javascript:verify_email('<?php echo  $user_info['User']['email'];?>',<?php echo  $user_info['User']['id'];?>)"><?php echo $SCLanguages['resend_Email_for_approval']?></a></p><?php }?><?php }?>
            </div>
            <div class="affiche" style="border-left:0px;border-right:0px;">
            	<?php if(isset($SVConfigs['user_center_notice'])){?><p>*<?php echo $SCLanguages['user_center'].$SCLanguages['notices']?>* <?php echo $SVConfigs['user_center_notice'];?></p><?php }?>
            </div>
            <div id="money_info">
            	<h3 class="menber"><?php echo $SCLanguages['account'].$SCLanguages['balances']?></h3>
                <p><span class="title"><?php echo $SCLanguages['balance']?>：</span>
	  	  		<?php echo $svshow->price_format($user_info['User']['balance'],$SVConfigs['price_format']);?>
                </p>
                <?php if(isset($SVConfigs['enable_points']) && $SVConfigs['enable_points'] == 1){?>
                <p><span class="title"><?php echo $SCLanguages['point']?>：</span><?php echo $user_info['User']['point']?><?php echo $SCLanguages['point_unit']?></p>
                <?php }?>
                <?php if(isset($SVConfigs['use_coupons']) && $SVConfigs['use_coupons'] == 1){?>
                <p><span class="title"><?php echo $SCLanguages['coupon']?>：</span><?php printf($SCLanguages['total_record'],$coupon_num)?>,<?php echo $SCLanguages['value_of']?><?php echo $svshow->price_format($coupon_fee,$SVConfigs['price_format']);?></p>
                <?php }?>
                <h3 class="remind"><?php echo $SCLanguages['user_remind']?><span><?php printf($SCLanguages['submit_in_latest_30days'],$my_orders30)?></span></h3>
            
            </div>
        </div>
  </div>
<script type="text/javascript">
function verify_email(toEmail,userId){
       YAHOO.example.container.wait.show();
	   var sUrl = webroot_dir+"send_verify_email/"+toEmail+"/"+userId;
	   var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, verify_email_callback);
}
var verify_emailSuccess = function(o){
	    try{   
			var result = YAHOO.lang.JSON.parse(o.responseText);
		}catch (e){   
			alert(o.responseText);
			alert("Invalid data");
			YAHOO.example.container.wait.hide();
		} 
		createDIV("verify_email");
		if(YAHOO.example.container.verify_email)
			YAHOO.example.container.verify_email.destroy();
		document.getElementById('verify_email').innerHTML = result.content;
		document.getElementById('verify_email').style.display = '';
		YAHOO.example.container.verify_email = new YAHOO.widget.Panel("verify_email", { 
																		xy:[700,500],
																		fixedcenter:true,
																		draggable:false,
																		modal:true,
																		visible:false,
																		width:"424px",
																		zIndex:1000,
																		effect:{effect:YAHOO.widget.ContainerEffect.FADE,duration:0.5}
																	} 
															);	
															
		var close_verify_email = new YAHOO.util.KeyListener(document, { keys:27 }, 
													  { fn:YAHOO.example.container.verify_email.hide,
														scope:YAHOO.example.container.verify_email,
														correctScope:true }, "keyup" ); 
	 
		YAHOO.example.container.verify_email.cfg.queueProperty("keylisteners", close_verify_email);
		YAHOO.example.container.verify_email.render();
		YAHOO.example.container.manager.register(YAHOO.example.container.verify_email);
		YAHOO.example.container.verify_email.show();	
		YAHOO.example.container.wait.hide();
}
var verify_emailFailure = function(o){
 	alert("Failure");
};
var verify_email_callback=
{
  success:verify_emailSuccess,
  failure:verify_emailFailure,
  argument:{}
};
</script>