<?php 
/*****************************************************************************
 * SV-Cart 邮件订阅管理
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 3669 2009-08-17 09:24:48Z zhengli $
*****************************************************************************/
?><?php echo $javascript->link('listtable');?>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<!--Search-->

<div class="search_box">
  	<?php echo $form->create('',array('action'=>'/','type'=>'get','name'=>"SearchForm"));?>

	<dl>
		<dt class="big_search"><input type="button" class="big" value="导出" onclick="newsletter_list_export()" /> </dt>
	</dl>
<?php echo $form->end();?>
</div>

<br />
<!--Search End-->

<!--Main Start-->
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' );height:auto!important;">
<?php echo $form->create('',array('action'=>'/',"name"=>"ProForm","type"=>"POST",'onsubmit'=>"return false"));?>
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th width="8%"><input type="checkbox" name="checkbox" value="checkbox" onclick='javascript:selectAll(this, "checkboxes")'/>编号</th>
	<th width="84%">邮件地址</th>
	<th width="8%">状态</th>
</tr>
<!--Competence List-->
<?php if(isset($newsletterlist_data) && sizeof($newsletterlist_data)>0){?>
<?php foreach( $newsletterlist_data as $k=>$v ){ ?>
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><input type="checkbox" name="checkboxes[]" value='<?php echo $v["NewsletterList"]["id"]?>' /><?php echo $v["NewsletterList"]["id"]?></td>
	<td><?php echo $v["NewsletterList"]["email"]?></td>
	<td align="center"><?php echo $systemresource_info["newsletter_list"][$v["NewsletterList"]["status"]]?></td>
</tr>
<?php } }?>
</table></div>
<!--Competence List End-->
<div class="pagers" style="position:relative">
	<?php //echo $this->element('pagers', array('cache'=>'+0 hour'));?>
<?php if(isset($newsletterlist_data) && sizeof($newsletterlist_data)>0){?>
<p class='batch'>
	<input type="button"  value="退订" onclick="diachange(this,'unsubscribe')" />
	<input type="button"  value="删除" onclick="diachange(this,'remove')" />
	<input type="button"  value="确认" onclick="diachange(this,'confirm')" />
</p>  
<?php }?>
</div>
<?php echo $form->end();?>
</div>
<!--Main Start End-->
</div>
<script type="text/javascript">
function diachange(obj,thisstatus){
	var id=document.getElementsByName('checkboxes[]');
	var j=0;
	var image="";
	for( i=0;i<=parseInt(id.length)-1;i++ ){
		if(id[i].checked){
			j++;
		}
	}
	if( j>=1 ){
		layer_dialog_show('确定'+obj.value+'?','batch_change_status("'+thisstatus+'")',5);
	}else{
		layer_dialog_show('请选择！！','',3);
	}
}
function batch_change_status(status){
    var id=document.getElementsByName('checkboxes[]');
	var i;
	var j=0;
	for( i=0;i<=parseInt(id.length)-1;i++ ){
		if(id[i].checked){
			j++;
		}
	}
	if( j<1 ){
		return false;
	}else{
		document.ProForm.action=webroot_dir+"newsletter_lists/change_status/"+status+"/";
	    document.ProForm.onsubmit= "";
	    document.ProForm.submit();
	}

}
function newsletter_list_export(){
	window.location.href = webroot_dir+"newsletter_lists/export/?status=1";
}
</script>