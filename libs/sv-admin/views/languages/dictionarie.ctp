<?php 
/*****************************************************************************
 * SV-Cart 语言列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: dictionarie.ctp 3795 2009-08-19 11:25:53Z huangbo $
*****************************************************************************/
?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->

<div class="search_box">
<?php echo $form->create('languages',array('action'=>'dictionarie','name'=>'LanguageForm'));?>

	<dl>
	<dt style="padding-top:0;"><?php echo $html->image('serach_icon.gif',array('align'=>'left'))?></dt>
	<dd><p class="reg_time article"><input type="text" name="keywords"  id="keywords" value=""  /></p></dd>
	<dt class="small_search"><input  class="search_article" type="submit" value="查询" /> </dt>
	</dl>
<?php echo $form->end();?>
</div>
<br />
<!--Search End-->
<!--Main Start-->
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
	<ul class="product_llist procurements">
	<li class="id" style="width:8%;">编号</li>
	<li class="name" style="width:11%;">名称</li>
	<li class="locale" style="width:11%;">语言</li>
	<li class="type" style="width:11%;">类型</li>
	<li class="description" style="width:17%;">描述</li>
	<li class="value" style="width:27%;">内容</li>
	<li class="action" style="width:10%;">...</li>
	</ul>
<?php if(isset($language_dictionaries) && sizeof($language_dictionaries)>0){
	<?php foreach($language_dictionaries as $k=>$v){?>
	<ul class="product_llist procurements procurements_list">
	<div id="lang_id"><li class="id" style="width:8%;"><?php echo $v['LanguageDictionarie']['id']?></li></div>
	<div id="lang_name"><li class="name" style="width:11%;"><?php echo $v['LanguageDictionarie']['name']?></li></div>
	<div id="lang_locale<?php echo $v['LanguageDictionarie']['id']?>"><li class="locale" style="width:11%;"><div id="description<?php echo $v['LanguageDictionarie']['id']?>" onclick="javascript:go_input(<?php echo $v['LanguageDictionarie']['id']?>,'<?php echo $v['LanguageDictionarie']['locale']?>','locale',11);"><?php echo $v['LanguageDictionarie']['locale']?></div></li></div>
	<div id="lang_type<?php echo $v['LanguageDictionarie']['id']?>"><li class="type" style="width:11%; border:1px solid red;"><div id="description<?php echo $v['LanguageDictionarie']['id']?>" onclick="javascript:go_input(<?php echo $v['LanguageDictionarie']['id']?>,'<?php echo $v['LanguageDictionarie']['type']?>','type',11);"><?php echo $v['LanguageDictionarie']['type']?></div></li></div>
	<div id="lang_description<?php echo $v['LanguageDictionarie']['id']?>"><li class="description" style="width:17%;"><div id="description<?php echo $v['LanguageDictionarie']['id']?>" onclick="javascript:go_input(<?php echo $v['LanguageDictionarie']['id']?>,'<?php echo $v['LanguageDictionarie']['description']?>','description',17);"><?php echo $v['LanguageDictionarie']['description']?></div></li></div>
	<div id="lang_value<?php echo $v['LanguageDictionarie']['id']?>"><li class="value" style="width:27%;" ><div id="value<?php echo $v['LanguageDictionarie']['id']?>" onclick="javascript:go_input(<?php echo $v['LanguageDictionarie']['id']?>,'<?php echo $v['LanguageDictionarie']['value']?>','value',27);"><?php echo $v['LanguageDictionarie']['value']?></div></li></div>
	<li class="action" style="width:10%;">del</li>
	</ul>
	<?php }?><?php }?>
	<div class="pagers" style="position:relative;">
   <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
   </div>
</div>
<!--Main Start End-->
</div>