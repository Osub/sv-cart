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
 * $Id: index.ctp 3949 2009-08-31 07:34:05Z huangbo $
*****************************************************************************/
?>

 
<style type="text/css">

/* 列表部分的样式*/
.list-div table {
  width: 100%;
}

.list-div th {
  line-height: 24px;

  white-space: nowrap;
}

.list-div td {

  line-height: 22px;
}

</style>
<div class="content">
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>

<!--Main Start-->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."恢复备份","restore/",'',false,false);?>&nbsp&nbsp<?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."数据库优化","optimize",'',false,false);?></strong></p>
	
<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' );">
<?php echo $form->create('',array('action'=>'/dumpsql/',"name"=>"theForm"));?>
<div class="list-div" id="listDiv">
<table cellspacing='1' cellpadding='3' class="list_data" >
  <tr>
    <th colspan="2">备份类型</th>
  </tr>
  <tr class="tr_bgcolor" >
    <td><input type="radio" name="type" value="full" class="radio" onclick="findobj('showtables').style.display='none'">全部备份</td>
    <td>备份数据库所有表</td>
  </tr>
  <tr>
    <td><input type="radio" name="type" value="stand" class="radio" checked="checked" onclick="findobj('showtables').style.display='none'">标准备份(推荐)</td>
    <td>备份常用的数据表</td>
  </tr>
  <tr class="tr_bgcolor"  >
    <td><input type="radio" name="type" value="min" class="radio" onclick="findobj('showtables').style.display='none'">最小备份</td>
    <td>仅包括商品表，订单表，用户表</td>
  </tr>
  <tr >
    <td><input type="radio" name="type" value="custom" class="radio" onclick="findobj('showtables').style.display=''">自定义备份</td>
    <td>根据自行选择备份数据表</td>
  </tr>
  <tbody id="showtables" style="display:none">
  <tr>
    <td colspan="2">
      <table>
        <tr>
          <td colspan="4"><input name="chkall" onclick="checkall(this.form, 'customtables[]')" type="checkbox"><b>全选</b></td>
        </tr>
        <tr>
        <?php foreach($tables as $k=>$v){ ?>
           <?php if(($k>0)&&($k%4==0)){?>
          </tr><tr>
          <?php } ?>
          <td><input name="customtables[]" value="<?php echo $v;?>"  type="checkbox" <?php if(in_array($v,$operatormenu)){?>checked<?php }?>><?php echo $v;?></td>
        <?php } ?>
        </tr>
      </table>
    </td>
  </tr>
  </tbody>
</table>

<table cellspacing='1' cellpadding='3' class="list_data" >
  <tr>
    <th colspan="2" >其他选项</th>
  </tr>
  <tr class="tr_bgcolor" >
    <td>使用扩展插入(Extended Insert)方式</td>
    <td><input type="radio" name="ext_insert" class="radio" value='1'>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="ext_insert" class="radio" value='0' checked="checked">否</td>
  </tr>
  <tr>
    <td>分卷备份 - 文件长度限制(kb)</td>
    <td><input type="text" name="vol_size" value="<?php echo $vol_size;?>" readonly></td>
  </tr>
  <tr class="tr_bgcolor" >
    <td>备份文件名</td>
    <td><input type="text" name="sql_file_name" value="<?php echo $sql_name;?>"></td>
  </tr>
</table>
<p>&nbsp;</p>
<center><input type="submit" value="开始备份" class="button" /></center>
</div>	 
<?php echo $form->end();?>
</div>
<!--Main Start End-->
</div>

<script>
function findobj(str)
{
    return document.getElementById(str);
}

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

function radioClicked(n)
{
    if (n > 0)
    {
        document.forms['theForm'].elements["vol_size"].disabled = false;
        var str = document.forms['theForm'].elements["sql_name"].value ;
        document.forms['theForm'].elements["sql_name"].value = str.slice(0, -4) + '.zip' ;
    }
    else
    {
        document.forms['theForm'].elements["vol_size"].disabled = true;
        var str = document.forms['theForm'].elements["sql_name"].value ;
        document.forms['theForm'].elements["sql_name"].value = str.slice(0, -4) + '.sql' ;
    }
}

/**
 * 切换显示表前缀
 * @param bool display 是否显示
 */
function toggleTablePre(display)
{
    var disp = display ? '' : 'none';
    for (var i = 1; i <= 9; i++)
    {
        document.getElementById('pre_' + i).style.display = disp;
    }
}
</script>