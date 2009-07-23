<?php 
/*****************************************************************************
 * SV-Cart 后台首页
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: check.ctp 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
?>
<?php echo $form->create('tools_install',array('action'=>'/setting_ui/','id'=>"js_check",'method'=>'post'));?>
<div class="content">
<br />
<!--Check-->
<div class="home_main">
<p><?php echo $html->image("/tools/img/".$local_lang."/2_01.gif")?></p>
<div class="informations">
<div class="check">
<h3><?php echo $html->image("/tools/img/".$local_lang."/2_02.gif")?></h3>
<ul class="list setup"> 
    <?php foreach($system_info as $v){?>
    <li>
	<div class="lang"><?php echo $v[0]?></div><div class="status"><span><?php echo $v[1]?></span></div></li>
    <?php }?>
</ul>
<h3><?php echo $html->image("/tools/img/".$local_lang."/2_05.gif")?></h3>
<ul class="list setup"> 
    <li>
    	<?php if($mod_rewrite==1){?>
    	<div class="lang">mod_rewrite</div><div class="status"><span style="color:green;"><?php echo $lang['rewrite_on']?></span></div>
    	<?php }else if($mod_rewrite==2){?>
    	<div class="lang">mod_rewrite</div><div class="status"><span style="color:red;"><?php echo $lang['rewrite_unkonw']?></span></div>
    	<?php }else {?>
    	<div class="lang">mod_rewrite</div><div class="status"><span style="color:red;"><?php echo $lang['rewrite_not_on']?></span></div>
    	<?php }?>
	</li>
    
</ul>
<h3><?php echo $html->image("/tools/img/".$local_lang."/2_03.gif")?></h3>
<ul class="list setup"> 

    <?php foreach($dir_checking as $v){?>
    <li>
    <?php if ($v[1]==$lang['can_write']) {?>
	<div class="lang"><?php echo $v[0]?></div><div class="status"><span style="color:green;"><?php echo $v[1]?></span></div>
	<?php }else {?>
	<div class="lang"><?php echo $v[0]?></div><div class="status"><span style="color:red;"><?php echo $v[1]?></span></div>
	<?php }?>
	</li>
    <?php }?>
</ul>
<h3><?php echo $html->image("/tools/img/".$local_lang."/2_04.gif")?></h3>
<ul class="list setup"> 
    <li class="green"><?php echo $lang['all_are_writable']?></li>
</ul>
</div>
<p><?php echo $html->image("/tools/img/".$local_lang."/1_02.gif")?></p>
</div>
<div class="agree" style="white-space:nowrap;">
	<input type="button" class="button" value="<?php echo $lang['prev_step']?>：<?php echo $lang['check_copyright']?>" size="10" onclick="pre_step();"/>
	<input type="button" class="button setup" value="<?php echo $lang['recheck']?>" onclick="recheck();"/>
	<?php if($checking_result=="ERROR"){?>
	<input type="submit" class="button" id="js-submit"  class="button" value="<?php echo $lang['next_step'];?>：<?php echo $lang['setup_environment'];?>"  disabled/>
	<?php }else{?>
	<input type="submit" class="button" id="js-submit" value="<?php echo $lang['next_step']?>：<?php echo $lang['setup_environment']?>"  />
	<?php }?>
</div>
</div>
<!--Check End-->
</div>
<input name="ucapi" type="hidden" value="" />
<input name="ucfounderpw" type="hidden" value="" />
<?php echo $form->end();?>
<script type="text/javascript">
function pre_step(){
	var setting_form = document.getElementById('js_check');
	setting_form.action = webroot_dir + "tools/tools_installs/home";
	setting_form.submit();
}
function recheck(){
	window.location.href = webroot_dir + "tools/tools_installs/check";
}
</script>