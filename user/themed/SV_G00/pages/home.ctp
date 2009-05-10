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
 * $Id: home.ctp 1283 2009-05-10 13:48:29Z huangbo $
*****************************************************************************/
?>
<?=$javascript->link('register');?>
	<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
	<div id="Products_box">
    	<h1><span><?=$SCLanguages['user_center']?> </span></h1>
        <div id="infos" style="width:739px;">
        	<div id="wellcom_info">
            	<h2 class="user"><?printf($SCLanguages['welcome_back'],$user_info['User']['name'])?></h2>
                <p><?=$SCLanguages['last_login_time']?>：<?= $user_info['User']['modified'];?></p>
        	<p><?=$SCLanguages['level_is']?>：<?echo $user_rank;?></p>
                <?if($SVConfigs['enable_members_mail_verify'] == 1){?><?if($user_info['User']['verify_status'] != 1){?><p class="atte"><?=$SCLanguages['not_passed_email_approval']?>&nbsp;<a href="javascript:verify_email('<?= $user_info['User']['email'];?>',<?= $user_info['User']['id'];?>)"><?=$SCLanguages['resend_Email_for_approval']?></a></p><?}?><?}?>
            </div>
            <div class="affiche">
            	<?if(isset($SVConfigs['user_center_notice'])){?><p>*<?=$SCLanguages['user_center'].$SCLanguages['notices']?>* <?echo $SVConfigs['user_center_notice'];?></p><?}?>
            </div>
            <div id="money_info">
            	<h3 class="menber"><?=$SCLanguages['account'].$SCLanguages['balances']?></h3>
                <p><span class="title"><?=$SCLanguages['balance']?>：</span>
	  	  		<?=$svshow->price_format($user_info['User']['balance'],$SVConfigs['price_format']);?>
                </p>
                <p><span class="title"><?=$SCLanguages['point']?>：</span><?echo $user_info['User']['point']?><?=$SCLanguages['point_unit']?></p>
                <p><span class="title"><?=$SCLanguages['coupon']?>：</span><? printf($SCLanguages['total_record'],$coupon_num)?>,<?=$SCLanguages['value_of']?><?=$svshow->price_format($coupon_fee,$SVConfigs['price_format']);?></p>
                
                <h3 class="remind"><?=$SCLanguages['user_remind']?><span><?php printf($SCLanguages['submit_in_latest_30days'],$my_orders30)?></span></h3>
            
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