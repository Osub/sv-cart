<?php
/*****************************************************************************
 * SV-Cart 网站底部
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: footer.ctp 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
?>
<?
$navigations_footer = $this->requestAction('commons/get_navigations/F'); 
?>
<?if(isset($navigations_footer) && sizeof($navigations_footer)>0){?><p class="link">
<? foreach($navigations_footer as $navigation){?><?=$html->link($navigation['NavigationI18n']['name'],$navigation['NavigationI18n']['url'],"",false,false);?> | 
<?}?></p><?}?>
<!--Footer-->
<p class="copyRight green_3"><font face="Arial">&copy;</font>2009 <?printf($SCLanguages['copyright'],$SVConfigs['shop_name']);?></p>
<p class="pwoered green_3">
<?=$html->link(" <span class='number green_3'>Powered by SV-Cart</span>","http://www.seevia.cn",array("target"=>"_blank"),false,false);?>
</p>
<?=$SVConfigs['statistic_code']?>
<!--Footer End-->



<script language="JavaScript" type="text/javascript">
			document.onkeydown = function(evt){
				var evt = window.event?window.event:evt;
				if(evt.keyCode==13)
				{
					var UserName = document.getElementById('UserName').value;
					var UserPassword = document.getElementById('UserPassword').value;
					var UserCaptcha = document.getElementById('UserCaptcha').value;
					if(document.getElementById('UserName_page') != null){
						var UserName_page = document.getElementById('UserName_page').value;
						var UserPassword_page = document.getElementById('UserPassword_page').value;
						var UserCaptcha_page = document.getElementById('UserCaptcha_page').value;
						if(UserName_page != "" & UserPassword_page != "" && UserCaptcha_page != ""){
							user_login();
							return;
						}
					}
					if(UserName != "" & UserPassword != "" && UserCaptcha != ""){
						panel_login();
						return;
					}

				}
			}
		
</script>