
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($links)?>
<br />
<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增链接","add/",'',false,false);?></strong></p>


<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="20%">链接名称</th>
	<th width="28%">链接地址</th>
	<th width="20%">链接LOGO</th>
	<th width="8%">显示顺序</th>
	<th width="8%">点击次数</th>
	<th width="8%">是否有效</th>
	<th width="8%">操作</th>
</tr>
<!--Products Processing List-->
<?php if(isset($links) && sizeof($links)>0){?>
<?php foreach($links as $k=>$link){?>
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><?php echo $link['LinkI18n']['name']?></td>
	<td><?php echo $link['LinkI18n']['url'];?></td>
	<td><?php echo $link['LinkI18n']['img01'];?></td>
	<td align="center"><?php echo $link['Link']['orderby'];?></td>
	<td align="center"><?php echo $link['LinkI18n']['click_stat'];?></td>
	<td align="center"><?php if($link['Link']['status'])echo $html->image('yes.gif',array('align'=>'absmiddle'));else echo$html->image('no.gif',array('align'=>'absmiddle'));?></td>
	<td align="center">
	<?php echo $html->link("编辑","/links/edit/{$link['Link']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}links/remove/{$link['Link']['id']}')"));?>
	</td>
</tr>
<?php }?><?php }?>
</table></div>
<!--Products Processing List End-->
<div class="pagers" style="position:relative;">
<?php echo $this->element('pagers',array('cache'=>'+0 hour'));?>
</div>
	
<!--Main Start End-->
</div>