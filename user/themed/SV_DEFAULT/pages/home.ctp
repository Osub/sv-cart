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
 * $Id: home.ctp 3949 2009-08-31 07:34:05Z huangbo $
*****************************************************************************/
?>
<?php echo $javascript->link('register');?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>	<div id="Products_box">
<h1 class="headers"><span class="l">&nbsp;</span><span class="r">&nbsp;</span><b><?php echo $SCLanguages['user_center']?></b></h1>
        <div class="infos">
    	<div class="member_infos">
        	<div id="wellcom_info">
            <h2 class="user"><?php printf($SCLanguages['welcome_back'],$user_info['User']['name'])?></h2>
            <p><?php echo $SCLanguages['last_login_time']?>：<?php echo  $user_info['User']['modified'];?></p>
        	<p><?php echo $SCLanguages['level_is']?>：<?php echo $user_rank;?>&nbsp;<?=$SCLanguages['rank_point']?>:<?=(!empty($_SESSION['User']['User']['user_point'])?$_SESSION['User']['User']['user_point']:0)?><?php echo $SCLanguages['point_unit']?></p>
            <?php if($SVConfigs['enable_members_mail_verify'] == 1){?>
    		<?php if($user_info['User']['verify_status'] != 1){?>
    		
    		<p class="atte"><?php echo $SCLanguages['not_passed_email_approval']?>&nbsp;<a href="javascript:verify_email('<?php echo  $user_info['User']['email'];?>',<?php echo  $user_info['User']['id'];?>)"><?php echo $SCLanguages['resend_Email_for_approval']?></a></p><?php }?><?php }?>
            </div>
<!--资金-->
            <div id="money_info">
           	<h3 class="menber"><?php echo $SCLanguages['account'].$SCLanguages['balances']?></h3>
           	
            <ul>
            <li class="lang"><?php echo $SCLanguages['balance']?>：</li>
	  	  	<li><?//php echo $svshow->price_format($user_info['User']['balance'],$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
			<?php echo $svshow->price_format($user_info['User']['balance']*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
			<?php echo $svshow->price_format($user_info['User']['balance'],$this->data['configs']['price_format']);?>	
			<?php }?> 
			</li>   					  	  		
            </ul>
            <?php if(isset($SVConfigs['enable_points']) && $SVConfigs['enable_points'] == 1){?>
            <ul>
            	<li class="lang"><?php echo $SCLanguages['point']?>：</li>
            	<li><?php echo $user_info['User']['point']?><?php echo $SCLanguages['point_unit']?></li>
            </ul>
            <?php }?>
            <?php if(isset($SVConfigs['use_coupons']) && $SVConfigs['use_coupons'] == 1){?>
            <ul>
            <li class="lang"><?php echo $SCLanguages['coupon']?>：</li>
            <li><?php printf($SCLanguages['total_record'],$coupon_num)?>,<?php echo $SCLanguages['value_of']?>
            <?//php echo $svshow->price_format($coupon_fee,$SVConfigs['price_format']);?>
			<?php if(isset($this->data['configs']['currencies_setting']) && $this->data['configs']['currencies_setting'] == 1 && $session->check('currencies') && $session->check('Config.locale') && isset($this->data['currencies'][$session->read('currencies')])){?>
			<?php echo $svshow->price_format($coupon_fee*$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['rate'],$this->data['currencies'][$session->read('currencies')][$session->read('Config.locale')]['Currency']['format']);?>	
			<?php }else{?>
			<?php echo $svshow->price_format($coupon_fee,$this->data['configs']['price_format']);?>	
			<?php }?> 
			</li>                 
            </ul>
            <?php }?>
            <ul class="remind">
            	<li class="lang"><strong><?php echo $SCLanguages['user_remind']?></strong></li>
            	<li><?php printf($SCLanguages['submit_in_latest_30days'],$my_orders30)?></li>
            </ul>
            </div>
<!--资金END-->
          </div>
            <div class="affiche" style="border-left:0px;border-right:0px;">
            <?php if(isset($SVConfigs['user_center_notice'])){?><p>*<?php echo $SCLanguages['user_center'].$SCLanguages['notices']?>* <?php echo $SVConfigs['user_center_notice'];?></p><?php }?>
            </div>
        <div class="height_25">&nbsp;</div>
        <div class="member_infos">
            <!-- 我的最新订单 -->
			<div class="box new_order">
				<h5><?php echo $SCLanguages['latest'].$SCLanguages['order'];?></h5>
			   	<?php if(isset($new_orders) && sizeof($new_orders)>0){?>
	        	<?php foreach($new_orders as $k=>$v){?>
	        	<ul>
	        	<li class="lang"><?php echo $html->link($v['Order']['order_code'],'/orders/'.$v['Order']['id'],array('target'=>'_blank'),false,false)?></li>
	            <li><?php echo $systemresource_info['order_status'][$v['Order']['status']];?> <?php echo $systemresource_info['payment_status'][$v['Order']['payment_status']];?> <?php echo $systemresource_info['shipping_status'][$v['Order']['shipping_status']];?>
	        	</li>
	        	</ul>
	        	<?php }?>
	        	<?php }?>
            </div>
            <!-- 我的最新订单 END -->
            	
            	<!-- 我的最新评论 -->
				<div class="box">
					<h5><?php echo $SCLanguages['latest'].$SCLanguages['comments'];?></h5>
				   	<?php if(isset($new_comments) && sizeof($new_comments)>0){?>
	            	<?php foreach($new_comments as $k=>$v){?>
	            	<ul>
	            	<?php if($v['Comment']['type'] == 'P'){?>
	            	<li class="lang">
	            	<?php if(isset($products_list[$v['Comment']['type_id']])){?>
	            	<?php echo $html->link($products_list[$v['Comment']['type_id']]['ProductI18n']['name'],$server_host.$cart_webroot.'products/'.$v['Comment']['type_id'],array('target'=>'_blank'),false,false);?>
	            	<?php }?>
	            	<p class="comment_img">
					<?php if($v['Comment']['rank'] == '1'){?>1
						<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'one.gif':'one.gif')?>
					<?php }elseif($v['Comment']['rank'] == '2'){?>
						<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'two.gif':'two.gif')?>
					<?php }elseif($v['Comment']['rank'] == '3'){?>
						<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'three.gif':'three.gif')?>
					<?php }elseif($v['Comment']['rank'] == '4'){?>
						<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'four.gif':'four.gif')?>
					<?php }elseif($v['Comment']['rank'] == '5'){?>
						<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'five.gif':'five.gif')?>				
					<?php }?>
	            	</p>
	            	</li>
	            	<li><?php echo $v['Comment']['content'];?>
	            		<div class="reply">
	            		<?php if(isset($v['Reply']) && sizeof($v['Reply'])>0){?>
	            		<?php echo $SCLanguages['reply'];?>：
	            			<?php foreach($v['Reply'] as $kk=>$vv){?>
	            				<?php echo $vv['Comment']['content']?><br/>
	            			<?php }?>
	            		<?php }?>
	            		</div>
	            	</li>
	            	<?php }?>
	            	<?php if($v['Comment']['type'] == 'A'){?>
	            		<?php if(isset($articles_list[$v['Comment']['type_id']])){?>
	            		<li class="lang"><?php echo $html->link($articles_list[$v['Comment']['type_id']]['ArticleI18n']['title'],$server_host.$cart_webroot.'articles/'.$v['Comment']['type_id'],array('target'=>'_blank'),false,false);?></li>
	            		<?php }?>	            				
	            		<li><?php echo $v['Comment']['content'];?></li>
	            	<?php }?>	            				
	            		</ul>
	            		<?php }?>
	            	<?php }?>
            	</div>
            	<!-- 我的最新评论 END -->            	
				<!-- 我的最新留言 -->
				<div class="box">
					
					<h5><?php echo $SCLanguages['latest'].$SCLanguages['message'];?></h5>
				   	<?php if(isset($new_messages) && sizeof($new_messages)>0){?>
	            	<?php foreach($new_messages as $k=>$v){?>
	            	<ul>
	            	<li class="lang"><?if($v['UserMessage']['type'] == "P" && isset($v['Product'])){?>
	            	<?php echo $html->link($v['Product']['ProductI18n']['name'],$server_host.$cart_webroot.'products/'.$v['Product']['Product']['id'],array(),false,false)?>:
	            		<?}elseif($v['UserMessage']['type'] == "O" && isset($v['Order'])){?>
								<?php echo $html->link($v['Order']['Order']['order_code'],'/orders/'.$v['Order']['Order']['id'],array(),false,false)?>:
	            		<?}else{?>
	            				<?php echo $systemresource_info['msg_type'][$v['UserMessage']['msg_type']];?>
	            		<?}?>
	            		</li>
	            		<li><?php echo $v['UserMessage']['msg_title']?></li>
	            		<li class="reply">
	            		<?php if(isset($v['Reply']) && sizeof($v['Reply'])>0){?>
	            			<?php echo $SCLanguages['reply'];?>：
	            			<?php foreach($v['Reply'] as $kk=>$vv){?>
	            			<?php echo $vv['UserMessage']['msg_title']?>
	            			<?php }?>
	            		<?php }?>	            					
	            		</li>
	            		</ul>
	            		<?php }?>
	            	<?php }?>
            	</div>
            	<!-- 我的最新留言 END --> 
        </div>	
        <div class="height_25">&nbsp;</div>
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