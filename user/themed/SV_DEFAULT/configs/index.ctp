<?php 
/*****************************************************************************
 * SV-Cart 我的设置
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3391 2009-07-29 10:42:51Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?><!--我的设置-->
<div id="Products_box">
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['set'];?></b></h1>
<div id="setting">
	<div class="set-box">
	<form name="set_myconfig" action='update_config' method="POST">
	<?php if(isset($my_configs) && sizeof($my_configs)>0){?>
	
	     <?php foreach($my_configs as $k=>$v){?>
	           <?php if($v['UserConfig']['type'] == 'radio'){?>
	           <dl>
		           <dd><?php echo $v['UserConfigI18n']['name'];?>:</dd>
		           <dt>
		           	<?php if(isset($v['ConfigValues']) && sizeof($v['ConfigValues'])>0){?>
		           	
			        <?php foreach($v['ConfigValues'] as $key=>$val){?>
			        
			        <label for="<?php echo $key.$v['UserConfig']['id']?>">
			        <input onfocus="blur()" type="radio" id="<?php echo $key.$v['UserConfig']['id']?>" class="radio" name="code[<?php echo $v['UserConfig']['id']?>]" value="<?php echo $key?>" <?php if($v['UserConfig']['value'] == $key){?>checked="checked"<?php }?> /><?php echo $val;?></label>
			        <?php }?>
			        
		           <?php }?>
		           <?php echo $v['UserConfigI18n']['description']?></dt>
	           </dl> 
	           <?php }?>
	           
	           <ul>
		           <?php if($v['UserConfig']['type'] == 'select'){?>
		           <li>
		           <dd><?php echo $v['UserConfigI18n']['name'];?>:</dd>
		           <dt>
		           <select name="code[<?php echo $v['UserConfig']['id']?>]" />
		           
		           <?php if(isset($v['ConfigValues']) && sizeof($v['ConfigValues'])>0){?>
		           
		           <?php foreach($v['ConfigValues'] as $key=>$val){?>
		           <option value="<?php echo $key?>" <?php if($v['UserConfig']['value']==$key){?> selected="selected" <?php }?> /><?php echo $val?></option>
		           <?php }?>
		           
		           <?php }?>
		           
		           </select> <?php echo $v['UserConfigI18n']['description']?>
		           </dt>
		           </li>
		           
		           <?php }?>
		           
		           <?php if($v['UserConfig']['type'] == 'text'){?>
		           <li>
		           <dd><?php echo $v['UserConfigI18n']['name'];?>:</dd>
		           <dt><input class="text_input" size="30" name="code[<?php echo $v['UserConfig']['id']?>]" <?php if(!empty($v['UserConfig']['value'])){?>value="<?php echo $v['UserConfig']['value'];?>"<?php }else{?>value=""<?php }?> /> <?php echo $v['UserConfigI18n']['description']?>
		           </dt>
		           </li>
		           <?php }?>
		           
	           </ul>
	           
	           
	     <?php }?>
	     <br/>


	<div class="submit-btn submits">
		<p style='padding-left:108px;'>	<input type="hidden" name="uid" value="29">
			<span class="float_l"><input type="submit" value="<?php echo $SCLanguages['confirm']?>" /></span>
			<span class="float_l"><input type="reset" value="<?php echo $SCLanguages['cancel']?>" /></span></p>
	</div>		<?php }?>
	</div>	</form>
</div>
</div>

<!--我的设置End-->
<?php echo $this->element('news', array('cache'=>array('time'=> "+0 hour",'key'=>'news'.$template_style)));?>
