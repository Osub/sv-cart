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
 * $Id: index.ctp 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
?>
<?echo $this->element('ur_here',array('cache'=>'+0 hour'))?>
<!--我的设置-->
<div id="Products_box">
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?=$SCLanguages['set'];?></b></h1>
<div id="setting">
	<div class="set-box">
	<form name="set_myconfig" action='update_config' method="POST">
	<?if(isset($my_configs) && sizeof($my_configs)>0){?>
	
	     <?foreach($my_configs as $k=>$v){?>
	           <?if($v['UserConfig']['type'] == 'radio'){?>
	           <dl>
		           <dd><?echo $v['UserConfigI18n']['name'];?>:</dd>
		           <dt>
		           	<?if(isset($v['ConfigValues']) && sizeof($v['ConfigValues'])>0){?>
		           	
			        <?foreach($v['ConfigValues'] as $key=>$val){?>
			        
			        <label for="<?=$key.$v['UserConfig']['id']?>">
			        <input onfocus="blur()" type="radio" id="<?=$key.$v['UserConfig']['id']?>" class="radio" name="code[<?echo $v['UserConfig']['id']?>]" value="<?echo $key?>" <?if($v['UserConfig']['value'] == $key){?>checked="checked"<?}?> /><?echo $val;?></label>
			        <?}?>
			        
		           <?}?>
		           <?echo $v['UserConfigI18n']['description']?></dt>
	           </dl> 
	           <?}?>
	           
	           <ul>
		           <?if($v['UserConfig']['type'] == 'select'){?>
		           <li>
		           <dd><?echo $v['UserConfigI18n']['name'];?>:</dd>
		           <dt>
		           <select name="code[<?echo $v['UserConfig']['id']?>]" />
		           
		           <?if(isset($v['ConfigValues']) && sizeof($v['ConfigValues'])>0){?>
		           
		           <?foreach($v['ConfigValues'] as $key=>$val){?>
		           <option value="<?echo $key?>" <?if($v['UserConfig']['value']==$key){?> selected="selected" <?}?> /><?echo $val?></option>
		           <?}?>
		           
		           <?}?>
		           
		           </select> <?echo $v['UserConfigI18n']['description']?>
		           </dt>
		           </li>
		           
		           <?}?>
		           
		           <?if($v['UserConfig']['type'] == 'text'){?>
		           <li>
		           <dd><?echo $v['UserConfigI18n']['name'];?>:</dd>
		           <dt><input class="text_input" size="30" name="code[<?echo $v['UserConfig']['id']?>]" <?if(!empty($v['UserConfig']['value'])){?>value="<?echo $v['UserConfig']['value'];?>"<?}else{?>value=""<?}?> /> <?echo $v['UserConfigI18n']['description']?>
		           </dt>
		           </li>
		           <?}?>
		           
	           </ul>
	           
	           
	     <?}?>
	     <br/>


	<div class="submit-btn submits">
		<p style='padding-left:108px;'>	<input type="hidden" name="uid" value="29">
			<span class="float_l"><input type="submit" value="<?=$SCLanguages['confirm']?>" /></span>
			<span class="float_l"><input type="reset" value="<?=$SCLanguages['cancel']?>" /></span></p>
	</div>		<?}?>
	</div>	</form>
</div>
</div>

<!--我的设置End-->
<?php echo $this->element('news',array('cache'=>'+0 hour'))?>