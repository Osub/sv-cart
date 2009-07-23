<?php 
/*****************************************************************************
 * SV-Cart 帮助中心
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: help.ctp 2550 2009-07-03 06:35:49Z tangyu $
*****************************************************************************/
?>
<?php $navigations_help = $this->requestAction('commons/get_navigations/H'); 
if($navigations_help){?>
<div class="category_box brand_box">
<!--HelpCenter-->
<h3><span class="l"></span><span class="r"></span><?php echo $SCLanguages['help_center']?></h3>
<div class="box">
	<div class="category Help">
		<ul>
		<?php if(isset($navigations_help) && sizeof($navigations_help)>0 ){?>
		<?php foreach($navigations_help as $key=>$helps){ ?>
			<li><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'ico_28.gif':'ico_28.gif',array("alt"=>"SV-Cart"));?><?php echo $html->link($helps['NavigationI18n']['name']." <font face='宋体'>&gt;&gt;</font>","/../".$helps['NavigationI18n']['url'],"",false,false);?>
		</li>
		<?php }?>
		<?php }?>
		</ul>
	</div>
</div>
<p><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'category_ulbt.gif':'category_ulbt.gif',array("alt"=>""));?></p>
</div>
<!--HelpCenter End-->
<?php }?>
