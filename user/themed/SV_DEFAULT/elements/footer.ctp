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
 * $Id: footer.ctp 3271 2009-07-23 06:28:28Z huangbo $
*****************************************************************************/
?>
<?php 
$navigations_footer = $this->requestAction('commons/get_navigations/F'); 
?>
<?php if(isset($navigations_footer) && sizeof($navigations_footer)>0){?><p class="link">
<?php foreach($navigations_footer as $navigation){?><?php echo $html->link($navigation['NavigationI18n']['name'],$navigation['NavigationI18n']['url'],"",false,false);?> | 
<?php }?></p><?php }?>
<!--Footer-->
<p class="copyRight green_3"><font face="Arial">&copy;</font>2009 <?php printf($SCLanguages['copyright'],$SVConfigs['shop_name']);?></p>

<p class="pwoered green_3">
	
<?php if(isset($SVConfigs['memory_useage']) && $SVConfigs['memory_useage']=="1"){?>
	<?php echo($SCLanguages['memory']." ".$memory_useage);?>MB
	<?php } ?>
	 Gzip <?echo (isset($gzip_is_start) && $gzip_is_start == 1)?$SCLanguages['enabled']:$SCLanguages['unused'];?> 
	<?if($SVConfigs['icp_number'] !=""){?>
 	<?php echo $SVConfigs['icp_number'];?>
 	<?}?>	 	 
<?php echo $html->link(" <span class='number green_3'>Powered by SV-Cart ".$SVConfigs['version']."</span>","http://www.seevia.cn",array("target"=>"_blank"),false,false);?>
</p>
<?php echo $SVConfigs['statistic_code']?>
	<?php echo $SVConfigs['service_code']?>

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