<?php 
/*****************************************************************************
 * SV-Cart 底部文件
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: footer.ctp 4681 2009-09-28 09:16:46Z huangbo $
*****************************************************************************/
?>
<!-- 底部帮助 文章 文章分类 -->
<div class="help_foot_article">
<!--帮助中心显示开始-->
<?php if(isset($navigations_help)&&sizeof($navigations_help)>0){?>
<?php foreach($navigations_help as $k=>$v){?>
<div class="box" <?php if($k==(sizeof($navigations_help)-1)){?>style="margin-right:0;"<?php }?>>
	<h6 class="title"><?php echo $v['navigation_name'];?></h6>
	<?php if(isset($v['articles'])&&sizeof($v['articles'])>0){?>
	<ul><?php foreach($v['articles'] as $kk=>$vv){?><li><?php //echo $vv['ArticleI18n']['title'];?><?php echo $html->link($vv['ArticleI18n']['title'],"/articles/".$vv['Article']['id'],array(),false,false);?></li><?php } ?></ul>
    <?php } ?>
	</div>
<?php }} ?>
<!--帮助中心显示结束-->
</div>
<!-- 底部开始-->
	<div class="logo"><?php echo $html->image((!empty($this->data['configs']['shop_logo']))?$this->data['configs']['shop_logo']:"foot_logo.gif",array("alt"=>$this->data['languages']['free_open_independent_b2c'],"width"=>"180","height"=>"58"));?></div>
	<div class="footer_right">
	<div class="service">
	
	<?if($SVConfigs['msn'] != ""){?>
	<?$msn_res = explode(";",$SVConfigs['msn']);if(isset($msn_res) && is_array($msn_res) && sizeof($msn_res) >0){foreach($msn_res as $k=>$msn){?>
	<a href='msnim:add?contact=<?php echo $msn;?>'> <?php echo $html->image("msn.gif",array('style'=>'height:16px;','class'=>'middle','alt'=>'msn'));?></a>
	<?}}else{?>
	<a href="msnim:add?contact=<?php echo $SVConfigs['msn'];?>"> <?php echo $html->image("msn.gif",array('style'=>'height:16px;','class'=>'middle','alt'=>'msn'));?></a>
	<?}?>
	<?php if($SVConfigs['qq'] != ""  || $SVConfigs['ww'] != "" || $SVConfigs['ym'] != ""  || $SVConfigs['skype'] != "" ){?>
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'line.gif':'line.gif');?>
	<?php }?>	
	<?}?>

	<?if($SVConfigs['qq'] != ""){?>
	<?$qq_res = explode(";",$SVConfigs['qq']);if(isset($qq_res) && is_array($qq_res) && sizeof($qq_res) >0){foreach($qq_res as $k=>$qq){?>
	<a href="http://wpa.qq.com/msgrd?V=1&amp;Uin=<?=$qq?>&amp;Site=<?=$SVConfigs['shop_name']?>&amp;Menu=yes" target="_blank"><?=$html->image("qq.gif",array("alt"=>$qq."&amp;".$SVConfigs['shop_name'],"height"=>"16","class"=>"middle"))?> QQ </a> 	
	<?}}else{?>
	<a href="http://wpa.qq.com/msgrd?V=1&amp;Uin=<?=$SVConfigs['qq']?>&amp;Site=<?=$SVConfigs['shop_name']?>&amp;Menu=yes" target="_blank"><?=$html->image("qq.gif",array("alt"=>$qq."&amp;".$SVConfigs['shop_name'],"height"=>"16","class"=>"middle"))?> QQ</a>
	<?}?>
	<?php if($SVConfigs['ww'] != "" || $SVConfigs['ym'] != ""  || $SVConfigs['skype'] != "" ){?>
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'line.gif':'line.gif');?>
	<?php }?>
	<?}?>
		
	<?if($SVConfigs['ww'] != ""){?>
	<?$ww_res = explode(";",$SVConfigs['ww']);if(isset($ww_res) && is_array($ww_res) && sizeof($ww_res) >0){foreach($ww_res as $k=>$ww){?>
	<a target="_blank" href="http://amos1.taobao.com/msg.ww?v=2&amp;uid=<?php echo $ww?>&amp;s=1" ><img border="0" src="http://amos1.taobao.com/online.ww?v=2&amp;uid=<?php echo $ww?>&amp;s=1" alt="点击这里给我发消息" /></a>		
	<?}}else{?>
	<a target="_blank" href="http://amos1.taobao.com/msg.ww?v=2&amp;uid=<?=$SVConfigs['ww']?>&amp;s=1" ><img border="0" src="http://amos1.taobao.com/online.ww?v=2&amp;uid=<?=$SVConfigs['ww']?>&amp;s=1" alt="点击这里给我发消息" /></a>		
	<?}?>
	<?php if($SVConfigs['ym'] != ""  || $SVConfigs['skype'] != "" ){?>
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'line.gif':'line.gif');?>
	<?php }?>			
	<?}?>
		
		
	<?if($SVConfigs['ym'] !=""){?>
	<?$ym_res = explode(";",$SVConfigs['ym']);if(isset($ym_res) && is_array($ym_res) && sizeof($ym_res) >0){foreach($ym_res as $k=>$ym){?>
	<a href="http://edit.yahoo.com/config/send_webmesg?.target=<?php echo $ym?>&amp;.src=pg" target="_blank"><?php echo $html->image('yahoo.gif',array('alt'=>'Yahoo Messenger','border'=>'0','width'=>'18','height'=>'17'));?><?php echo $ym?></a>
	<?}}else{?>
	<a href="http://edit.yahoo.com/config/send_webmesg?.target=<?php echo $SVConfigs['ym']?>&amp;.src=pg" target="_blank"><?php echo $html->image('yahoo.gif',array('alt'=>'Yahoo Messenger','border'=>'0','width'=>'18','height'=>'17'));?><?php echo $SVConfigs['ym']?></a>
	<?}?>
	<?php if($SVConfigs['skype'] != "" ){?>
	<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'line.gif':'line.gif');?>
	<?php }?>			
	<?}?>
					
	<?if($SVConfigs['skype'] !=""){?>
	<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
	<?$skype_res = explode(";",$SVConfigs['skype']);if(isset($skype_res) && is_array($skype_res) && sizeof($skype_res) >0){foreach($skype_res as $k=>$skype){?>
	<a href="skype:<?php echo $skype;?>?call"><img src="http://mystatus.skype.com/smallclassic/<?php echo $skype;?>" style="border: none;"  alt="skype" /></a>
	<?}}else{?>
	<a href="skype:<?php echo $SVConfigs['skype'];?>?call"><img src="http://mystatus.skype.com/smallclassic/<?php echo $SVConfigs['skype'];?>" style="border: none;"  alt="skype" /></a>
	<?}?>
	<?}?>

	</div>
<?php if(isset($navigations_footer) && sizeof($navigations_footer)>0){?>
		<?php $navigations_footer_num = 0;?>
	<p class="link"><?php foreach($navigations_footer as $k => $navigation){?><?php if($navigations_footer_num !=0){?><span>|</span><?php }?>
				<?php if(substr($navigation['NavigationI18n']['url'],0,4) == 'java'){?>
				<?php echo $html->link($navigation['NavigationI18n']['name'],$navigation['NavigationI18n']['url'],array("target" =>$navigation['Navigation']['target']),false,false);?>
				<?php }else{?>
				<?php echo $html->link($navigation['NavigationI18n']['name'],$server_host.substr($cart_webroot,0,-1).$navigation['NavigationI18n']['url'],array("target" =>$navigation['Navigation']['target']),false,false);?>
				<?php }?>
				<?php $navigations_footer_num++ ;}?></p>
<?php }?>
<p class="copyRight green_3"><font face="Arial">&copy;</font>2009 <?php printf($this->data['languages']['copyright'],$this->data['configs']['shop_name']);?>  	<?if($this->data['configs']['icp_number'] !=""){?><?php echo $this->data['configs']['icp_number'];?><?}?></p>
<p class="copyRight green_3"><?php if($this->data['configs']['company_address'] != ""){ ?><?php echo $this->data['configs']['company_address'];?>&nbsp;<?php }?>
<?php if($this->data['configs']['customer_service_phone']){ ?><?php echo "Tel:".$this->data['configs']['customer_service_phone'];?>&nbsp;<?php }?>
<?php if($this->data['configs']['customer_service_email']){ ?><?php echo "E-mail:".$this->data['configs']['customer_service_email'];?>&nbsp;<?php }?>
</p>
<p class="Power green_3">
	<cake:nocache>
	<?php if(isset($this->data['configs']['memory_useage']) && $this->data['configs']['memory_useage']=="1"){?>
		<?php echo($this->data['languages']['memory']." ".$this->data['memory_useage']);?>MB
	<?php } ?>
	<?php echo $this->data['languages']['system_response_time']?> <?php echo round(getMicrotime() - $GLOBALS['TIME_START'], 4) . "s"?> <?// pr($GLOBALS['A_queriesTime']);?> 
	<?php if(Configure::read('Cache.disable')){	?>
	<?php echo $this->data['languages']['sql_response_time']?> 	<?php if(isset($queriesCnt) && isset($queriesTime)){echo "(default) ".$queriesCnt." queries took ".$queriesTime. "ms";}?>
	<?php }?>
	</cake:nocache>
	 Gzip <?echo (isset($gzip_is_start) && $gzip_is_start == 1)?$this->data['languages']['enabled']:$this->data['languages']['unused'];?> </p>
<p class="Power green_3" style="padding-bottom:4px;"><?php echo $html->link(" Powered by <span class='green_3 unline'>SV-Cart ".$this->data['configs']['version']."</span>","http://www.seevia.cn",array("target"=>"_blank"),false,false);?>
</p>
	<?php 
		if(isset($rss_id)){
		echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'rss.gif':'rss.gif'),'/products/rss/'.$rss_id,array(),false,false);
		}else{
		echo $html->link($html->image(isset($img_style_url)?$img_style_url."/".'rss.gif':'rss.gif'),'/products/rss/',array(),false,false);
		}
		?>
<?php echo $this->data['configs']['service_code']?>
<?php echo $this->data['configs']['statistic_code']?>
</div>
<!-- 底部结束 -->