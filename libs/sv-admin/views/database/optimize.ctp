<?php 
/*****************************************************************************
 * SV-Cart 数据表优化
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: optimize.ctp 3673 2009-08-17 09:57:45Z huangbo $
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
<!-- start form -->
<div class="form-div" style="margin-left:25px;margin-bottom:8px;">
<?php echo $form->create('',array('action'=>'/run_optimize',"name"=>"theForm"));?>
总碎片数:<?php echo $num;?>&nbsp;
<input type="submit" value="开始进行数据表优化" class="button" />
<input type= "hidden" name= "num" value = "<?php echo $num;?>">
<?php echo $form->end();?>
</div>
<!-- end form -->
<p class="add_categories"><strong><?php echo $html->link($html->image('add.gif',array('align'=>'absmiddle'))."数据库备份","index/",'',false,false);?></strong></p>

<div class="home_main" style="padding:0 0 20px 0;min-width:970px;width:expression((documentElement.clientWidth < 970) ? '970px' : 'auto' );">
<div class="list-div" id="listDiv">
<table cellspacing='1' cellpadding='3' id='listTable'  class="list_data" >
  <tr>
    <th>数据表</th>
    <th>数据表类型</th>
    <th>记录数</th>
    <th>数据</th>
    <th>碎片</th>
    <th>字符集</th>
    <th>状态</th>
  </tr>
  <?php foreach($list as $k=>$v){ ?>
    <tr <?php if((abs($k)+2)%2!=1){?>class="tr_bgcolor"<?php }else{?>class=""<?php }?> >
      <td class="first-cell"><?php echo $v['table'];?></td>
      <td align ="left"><?php echo $v['type'];?></td>
      <td align ="right"><?php echo $v['rec_num'];?></td>
      <td align ="right"><?php echo $v['rec_size'];?></td>
      <td align ="right"><?php echo $v['rec_chip'];?></td>
      <td align ="left"><?php echo $v['charset'];?></td>
      <td align ="left"><?php echo $v['status'];?></td>
    </tr>
  <?php } ?>
</table>
</div>
</div>
<!--Main Start End-->
</div>