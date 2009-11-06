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
 * $Id: footer.ctp 3518 2009-08-07 08:11:25Z shenyunfeng $
*****************************************************************************/
?>
<!-- 底部帮助 文章 文章分类 -->
<div class="height_10">&nbsp;</div>
<div class="help_foot_article">
<!--帮助中心显示开始-->
<?php if(isset($navigations_help)&&sizeof($navigations_help)>0){?>

<?php foreach($navigations_help as $k=>$v){?>
<div class="box">
	<p class="title"><?php echo $v['navigation_name'];?></p>
	<?php if(isset($v['articles'])&&sizeof($v['articles'])>0){?>
	<ul>
	<?php foreach($v['articles'] as $kk=>$vv){?>
	<li><?php //echo $vv['ArticleI18n']['title'];?><?php echo $html->link($vv['ArticleI18n']['title'],"/articles/".$vv['Article']['id'],array(),false,false);?></li>
	<?php } ?>
	</ul>
    <?php } ?>
	</div>
<?php }} ?>
<!--帮助中心显示结束-->
</div> 

<div id="logo"><?php echo $html->image((!empty($this->data['configs']['shop_logo']))?$this->data['configs']['shop_logo']:"logo.gif",array("alt"=>"SV-Cart","width"=>"192","height"=>"58"));?></div>

<?php if(isset($navigations_footer) && sizeof($navigations_footer)>0){?><p class="link">
<?php foreach($navigations_footer as $navigation){?><?php echo $html->link($navigation['NavigationI18n']['name'],$navigation['NavigationI18n']['url'],array("target" =>$navigation['Navigation']['target']),false,false);?> | 
<?php }?></p><?php }?>
<!--Footer-->
<p class="copyRight green_3"><font face="Arial">&copy;</font>2009 <?php printf($SCLanguages['copyright'],$SVConfigs['shop_name']);?> 	<?if($SVConfigs['icp_number'] !=""){?><?php echo $SVConfigs['icp_number'];?><?}?></p>

<p class="pwoered green_3">
	
	<cake:nocache>
	<?php if(isset($this->data['configs']['memory_useage']) && $this->data['configs']['memory_useage']=="1"){?>
		<?php echo($this->data['languages']['memory']." ".$this->data['memory_useage']);?>MB
	<?php } ?>
	<?php echo $this->data['languages']['system_response_time']?> <?php echo round(getMicrotime() - $GLOBALS['TIME_START'], 4) . "s"?> <?// pr($GLOBALS['A_queriesTime']);?> 
		
	<?php if(Configure::read('Cache.disable')){	?>
	<?php echo $this->data['languages']['sql_response_time']?> 	<?php if(isset($queriesCnt) && isset($queriesTime)){echo "(default) ".$queriesCnt." queries took ".$queriesTime. "ms";}?>
	<?php }?>	
	
	
	</cake:nocache>


	 Gzip <?echo (isset($gzip_is_start) && $gzip_is_start == 1)?$SCLanguages['enabled']:$SCLanguages['unused'];?> 
	 	 <br />
<?php echo $html->link(" <span class='number green_3'>Powered by SV-Cart ".$SVConfigs['version']."</span>","http://www.seevia.cn",array("target"=>"_blank"),false,false);?>
<br />
	<?php 	echo $html->link($html->image('rss.gif'),$server_host.$cart_webroot.'products/rss/',array(),false,false);?>	
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