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
 * $Id: search.ctp 2520 2009-07-02 02:01:40Z zhengli $
*****************************************************************************/
?> 
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>

<!--Main Start-->
<br />
<div class="home_main" style="width:96%;padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : '96%' ); ">
<table cellpadding="0" cellspacing="0" width="100%" class="list_data">
<tr class="thead">
	<th>会员名称</th>
	<th>操作日期</th>
	<th>金额</th>
	<th>支付方式</th>
	<th>备注</th>
	<th>操作</td></tr>
<!--Products Processing List-->
<?php if(isset($UserAccount_list) && sizeof($UserAccount_list)>0){?>
<?php foreach( $UserAccount_list as $k=>$v ){ ?>
	<tr>
	<td><span><?php echo $v['UserAccount']['name']?></span></td>
	<td align="center"><?php echo $v['UserAccount']['created']?></td>
	<td align="center"><span><?php echo $v['UserAccount']['amount']?></span></td>
	<td align="center"><?php echo $v['UserAccount']['payment_name']?></td>
	<td align="center"><span><?php if( $v['UserAccount']['status']==1 ){ echo "已确认"; }else{ echo "待处理";}?></span></td>
	<td align="center"><?php echo $html->link("确认","/balances/search_verify/{$v['UserAccount']['id']}",'',false,false);?>|<?php echo $html->link("取消","/balances/search_cancel/{$v['UserAccount']['id']}",'',false,false);?></td></tr>

<?php }?><?php }?>
</table>
<!--Products Processing List End-->
<div class="pagers" style="position:relative">
 <?php if(isset($UserAccount_list) && sizeof($UserAccount_list)>0){?> <p class='batch'><input type="button" value="导出"  onclick=export_act()  /></p><?php }?>
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