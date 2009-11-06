<?php 
/*****************************************************************************
 * SV-Cart 待处理冲值
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: search.ctp 3795 2009-08-19 11:25:53Z huangbo $
*****************************************************************************/
?> 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>

<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."充值管理","/user_accounts/",'',false,false);?></strong></p>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' ); ">
<div id="listDiv">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th>会员名称</th>
	<th width="12%">操作日期</th>
	<th width="8%">金额</th>
	<th width="15%">支付方式</th>
	<th width="25%">备注</th>
	<th width="8%">操作</td></tr>
<!--Products Processing List-->
<?php if(isset($UserAccount_list) && sizeof($UserAccount_list)>0){?>
<?php foreach( $UserAccount_list as $k=>$v ){ ?>
	<tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
	<td><span><?php echo $v['UserAccount']['name']?></span></td>
	<td align="center"><?php echo $v['UserAccount']['created']?></td>
	<td align="center"><span><?php echo $v['UserAccount']['amount']?></span></td>
	<td align="center"><?php echo $v['UserAccount']['payment_name']?></td>
	<td align="center"><span><?php if( $v['UserAccount']['status']==1 ){ echo "已确认"; }else{ echo "待处理";}?></span></td>
	<td align="center"><?php echo $html->link("确认","/balances/search_verify/{$v['UserAccount']['id']}",'',false,false);?>|<?php echo $html->link("取消","/balances/search_cancel/{$v['UserAccount']['id']}",'',false,false);?></td></tr>

<?php }?><?php }?>
</table></div>
<!--Products Processing List End-->
<div class="pagers" style="position:relative">
 <?php if(isset($UserAccount_list) && sizeof($UserAccount_list)>0){?> <p class='batch'><input type="button" class="search_article" value="导出"  onclick=export_act()  /></p><?php }?>
<input type="hidden" id="url" <?php   if(isset($ex_page)){  ?> value="/balances/search/uncheck?page=<?php echo $ex_page;?>&export=export"<?php }else{ ?> value="/balances/search/uncheck?export=export"<?php } ?>/>

    <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
</div>

</div>
<!--Main Start End-->
</div>
<script type="text/javascript">
function export_act(){ 
	var url=document.getElementById("url").value;
	window.location.href=webroot_dir+url;
}
</script>