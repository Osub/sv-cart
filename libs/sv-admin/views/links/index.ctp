
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));//pr($links)?>
<br />
<!--Main Start-->
<p class="add_categories"><strong><?=$html->link($html->image('add.gif',array('align'=>'absmiddle'))."新增链接","add/",'',false,false);?></strong></p>


<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">

	<ul class="product_llist friendlinks">
	<li class="linkname">链接名称</li>
	<li class="link_url">链接地址</li>
	<li class="link_logo">链接LOGO</li>
	<li class="taixs">显示顺序</li>
	<li class="click">点击次数</li>
	<li class="effective">是否有效</li>
	<li class="hadle">操作</li></ul>
<!--Products Processing List-->
<?if(isset($links) && sizeof($links)>0){?>
<?php foreach($links as $link){?>
	<ul class="product_llist friendlinks friendlinks_list">
	<li class="linkname"><span><?php echo $link['LinkI18n']['name']?></span></li>
	<li class="link_url"><span style="display:block"><?php echo $link['LinkI18n']['url'];?></span></li>
	<li class="link_logo"><?php echo $link['LinkI18n']['img01'];?></li>
	<li class="taixs"><?php echo $link['Link']['orderby'];?></li>
	<li class="click"><?php echo $link['LinkI18n']['click_stat'];?></li>
	<li class="effective"><?php if($link['Link']['status'])echo $html->image('yes.gif',array('align'=>'absmiddle'));else echo$html->image('no.gif',array('align'=>'absmiddle'));?></li>
	<li class="hadle">

	<?php echo $html->link("编辑","/links/edit/{$link['Link']['id']}");?>|<?php echo $html->link("移除","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$this->webroot}links/remove/{$link['Link']['id']}')"));?>
		</li></ul>
		
<?php }?><?}?>

<!--Products Processing List End-->
<div class="pagers" style="position:relative;">
<?=$this->element('pagers',array('cache'=>'+0 hour'));?>
</div>
	
<!--Main Start End-->
</div>