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
 * $Id: check.ctp 1273 2009-05-08 16:49:08Z huangbo $
*****************************************************************************/
?>
<?php echo $form->create('pages',array('action'=>'/setting_ui/','id'=>"js_check",'method'=>'post'));?>
<div class="content">
<br />
<!--Check-->
<div class="home_main">
	<div class="informations">
	<br />
	<h3 align="center" class="green">欢迎使用SV-Cart</h3>
	<div class="box">

	
<ul class="list setup" style="width:500px;margin:0 auto"> 
	<li><h3 class="green">SV-Cart系统检测</h3></li>
    <?foreach($system_info as $v){?>
    <li>
	<div class="lang"><?php echo $v[0]?></div><div class="status"><span><?php echo $v[1]?></span></div></li>
    <?php }?>
</ul>
<ul class="list setup" style="width:500px;margin:0 auto"> 
	<li><h3 class="green">APACHE功能</h3></li>
    
    <li>
    	<?if($mod_rewrite==1){?>
    	<div class="lang">mod_rewrite</div><div class="status"><span style="color:green;">开启</span></div>
    	<?}else if($mod_rewrite==2){?>
    	<div class="lang">mod_rewrite</div><div class="status"><span style="color:red;">无法确认</span></div>
    	<?}else {?>
    	<div class="lang">mod_rewrite</div><div class="status"><span style="color:red;">未开启</span></div>
    	<?}?>
	</li>
    
</ul>
<ul class="list setup" style="width:500px;margin:0 auto"> 
	<li><h3 class="green">目录权限检测</h3></li>
    <?foreach($dir_checking as $v){?>
    <li>
    <?php if ($v[1]=="可写") {?>
	<div class="lang"><?php echo $v[0]?></div><div class="status"><span style="color:green;"><?php echo $v[1]?></span></div>
	<?php }else {?>
	<div class="lang"><?php echo $v[0]?></div><div class="status"><span style="color:red;"><?php echo $v[1]?></span></div>
	<?php }?>
	</li>
    <?php }?>
</ul>
	    </div>
	</div>
<div class="agree">
	<input type="button" class="button" value="上一步：查看版权声明" onclick="pre_step();"/>
	<input type="button" class="button" value="重新检查" onclick="recheck();"/>
	<?php if($checking_result=="ERROR" || !$mod_rewrite){?><input type="submit" class="button" id="js-submit"  class="button" value="下一步：配置系统"  disabled/><?php }else{?>
	<input type="submit" class="button" id="js-submit"  class="button" value="下一步：配置系统"  />
	<?php }?>
</div>
</div>
<!--Check End-->
</div>
<input name="ucapi" type="hidden" value="" />
<input name="ucfounderpw" type="hidden" value="" />
<?php $form->end();?>
<script>
function pre_step(){
	var setting_form = document.getElementById('js_check');
	setting_form.action = webroot_dir + "pages/home";
	setting_form.submit();
}
function recheck(){
	window.location.href = webroot_dir + "pages/check";
}
</script>