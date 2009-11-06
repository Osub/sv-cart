<?php 
/*****************************************************************************
 * SV-Cart 数据备份
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: restore.ctp 3949 2009-08-31 07:34:05Z huangbo $
*****************************************************************************/
?>

 
<style type="text/css">

/* 列表部分的样式*/
.list-div table {
  width: 100%;
}

.list-div th {
  line-height: 24px;
  background: url(../img/product.gif) repeat-x;
  white-space: nowrap;
}

.list-div td {
  background: #FFF;
  line-height: 22px;
}

</style>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>

<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."数据库备份","index",'',false,false);?></strong></p>
	
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' );">
<?php echo $form->create('',array('action'=>'/upload_sql',"name"=>"theForm",'enctype'=>'multipart/form-data'));?>
<div id="listDiv">
  <table  cellpadding="0" cellspacing="0" width="100%" class="list_data">
  <tr>
    <th colspan="2">恢复备份</th>
  </tr>
  <tr class="tr_bgcolor"  >
    <td>本地sql文件</td>
    <td><input type="file" name="sqlfile" size="50"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="上传并执行sql文件" class="button"></td>
  </tr>
  </table>

<?php echo $form->end();?>

<?php echo $form->create('',array('action'=>'','name'=>'file_list','onsubmit'=>"return false"));?>
<table  cellpadding="0" cellspacing="0" width="100%" class="list_data">
  <tr  class="tr_bgcolor" >
    <td colspan="6" align="center">服务器上备份文件</td>
  </tr>
  <tr>
    <th width=48 align="right"><input type="checkbox" name="chkall" onclick="checkall(this.form, 'file[]')">移除</th>
    <th>文件名</th>
    <th>时间</th>
    <th>大小</th>
    <th>卷</th>
    <th>操作</th>
  </tr>
  <?php foreach($list as $k=>$v){ ?>
  <tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
   <td><input type="checkbox" name="file[]" value="<?php echo $v['name'];?>" /></td>
   <td><?php echo $html->link("{$v['name']}","/tmp/sqldata/{$v['name']}");?></td>
   <td><?php echo $v['add_time'];?></td>
   <td><?php echo $v['file_size'];?></td>
   <td>vol:<?php echo $v['vol'];?></td>
   <td align="center"><?php echo $html->link("[导入]","/database/import/{$v['name']}");?>&nbsp;|&nbsp;
	<?php echo $html->link("[删除]","javascript:;",array("onclick"=>"layer_dialog_show('确定删除?','{$admin_webroot}database/remove/{$v['name']}')"));?></td>
  </tr>
  <?php } ?>
</table></div>
<?php if(isset($list)&&!empty($list)){?>
<input type="button" onclick="batch_action()" value="删除" /></p>
<?php } ?>
<?php echo $form->end();?>
</div>
<!--Main Start End-->
</div>
	  
<script language="JavaScript">
function checkall(frm, chk)
{
    for (i = 0; i < frm.elements.length; i++)
    {
        if (frm.elements[i].name == chk)
        {
            frm.elements[i].checked = frm.elements['chkall'].checked;
        }
    }
}

function batch_action()
{ 
	document.file_list.action=webroot_dir+"database/batch";
	document.file_list.onsubmit= "";
	document.file_list.submit();
}
</script>