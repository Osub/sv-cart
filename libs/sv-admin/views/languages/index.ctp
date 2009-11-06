<?php 
/*****************************************************************************
 * SV-Cart 语言管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3673 2009-08-17 09:57:45Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle')).'新增语言',"add/",'',false,false);?></strong></p>
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' );height:auto!important;">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="4%">编号</th>
	<th>语言名称</th>
	<th width="8%">语言图标</th>
	<th width="8%">语言代码</th>
	<th width="8%">默认选项</th>
	<th width="8%">前台使用</th>
	<th width="8%">后台使用</th>
	<th width="8%">操作</th>
</tr>
<!--Languages List-->
<?php if(isset($languages) && sizeof($languages)>0){
   foreach($languages as $k=>$language){?>
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td align="center"><?php echo $language['Language']['id'];?></td>
	<td><?php echo $language['Language']['name']?></td>
	<td align="center"><?php if($language['Language']['img01'])echo $html->image($language['Language']['img01'])?></td>
	<td align="center"><?php if($language['Language']['map'])echo $language['Language']['locale'];?></td>
	<td align="center"><?php if($language['Language']['is_default'])echo $html->image('yes.gif');else echo $html->image('no.gif');?></td>
	<td align="center"><?php if($language['Language']['front'])echo $html->image('yes.gif');else echo $html->image('no.gif');?></td>
	<td align="center"><?php if($language['Language']['backend'])echo $html->image('yes.gif');else echo $html->image('no.gif');?></td>
	<td align="center">
	<?php echo $html->link("编辑","/languages/edit/{$language['Language']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}languages/remove/{$language['Language']['id']}')"));?>
	</td></tr>
	<?php }?><?php }?>
</table></div>
<!--Languages List End-->	
	
	

</div>
<!--Main Start End-->