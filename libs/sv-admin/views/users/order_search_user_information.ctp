<?php 
/*****************************************************************************
 * SV-Cart 订单管理列表
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 4404 2009-09-22 01:39:21Z tangyu $
*****************************************************************************/
?>
<?php echo $form->create('',array('action'=>'','name'=>"SearchForm","type"=>"get",'onsubmit'=>"return false"));?>
	<input type="hidden" name="status" value="1" />
	<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
	<tr>
	<td width="10%">会员名称：</td>
	<td><input type="text" style="border:1px solid #649776" name="user_name" id="user_name" value="<?php echo @$user_name?>"/><input type="submit"  value="搜索" onclick="search_user()"/></td>
	</tr>
	</table>
<br />
<?php echo $form->end();?>
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th>会员名</th>
	<th>邮件地址</th>
</tr>
<!--List Start-->
<?php if(isset($user_list) && sizeof($user_list)>0){?>
<?php foreach($user_list as $k=>$v){?>
<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> onclick="select_user(<?php echo $v["User"]["id"];?>,'<?php echo $v["User"]["name"];?>');">
	<td><?php echo $v["User"]["name"];?></td>
	<td><?php echo $v["User"]["email"];?></td>
</tr>
<?php }}?>
</table></div>
<!--List End-->
<div class="pagers" style="position:relative">
<?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div> 
<script type="text/javascript">
function select_user(user_id,user_name){
	window.opener.GetId('opener_select_user_id').value=user_id;
	window.close();
}
function search_user() 
{ 
document.SearchForm.action=webroot_dir+"users/order_search_user_information/";
document.SearchForm.onsubmit= "";
document.SearchForm.submit(); 
} 
</script>
