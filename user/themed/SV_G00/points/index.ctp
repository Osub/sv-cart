<?php
/*****************************************************************************
 * SV-Cart 我的积分页
 *===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: index.ctp 1273 2009-05-08 16:49:08Z huangbo $
*****************************************************************************/
?>
<?=$javascript->link('/../js/yui/calendar-min.js');?>
<?=$javascript->link('calendar');?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<div id="Products_box">
<h1><span><?=$SCLanguages['points']?></span></h1>
	<div id="infos" style="width:739px;">
        	<p class="history_detail find-btns">
        	<a class="float_r" style="margin-top:5px;"><input onfocus="blur()" class="find" type="button" onclick="javascript:points_search();" value="<?=$SCLanguages['search']?>" /></a>
			
			<span><?=$SCLanguages['time']?>: <input type="text" id="date" name="date" value="" class="text" readonly style="*margin-right:3px;" />
			<button class="Calendar" id="show" title="Show Calendar" style="*margin-top:0;">
			<?=$html->image('calendar.png',array('width'=>'18' ,'height'=>'18' ,'alt'=>'Calendar'))?></button>－<input type="text" id="date2" name="date2" value=""  class="text" readonly style="*margin-right:3px;" />
			<button class="Calendar" id="show2" title="Show Calendar" style="*margin-top:0;"><?=$html->image('calendar.png',array('width'=>'18' ,'height'=>'18' ,'alt'=>'Calendar'))?></button>
			&nbsp;&nbsp;<?=$SCLanguages['points']?>: <input class="text" type="text" name="min_points" id="min_points" value="<?echo $min_points?>" />－<input class="text" type="text" name="max_points" id="max_points" value="<?echo $max_points?>" />
			</span>
			<b><?=$SCLanguages['history_details']?></b>
			</p>
            <ul class="integral_title">
            <li class="integral" style="width:10%"><?=$SCLanguages['exchange'].$SCLanguages['points']?></li>
            <li class="time"><?=$SCLanguages['exchange'].$SCLanguages['time']?></li>
            <li class="time" ><?=$SCLanguages['order'].$SCLanguages['code']?></li>
            <li class="gift" style="width:15%"><?=$SCLanguages['operation'].$SCLanguages['type']?></li>
            <li class="handel"><?=$SCLanguages['operation']?></li></ul>
            <div class="integral_list"><?//pr($my_points);?>
    		<?if(isset($my_points) && sizeof($my_points)>0){?>
		    <?foreach($my_points as $k=>$v){?>
				<ul class="integral_title">
				<li class="integral" style="width:10%"><?echo $v['UserPointLog']['point']?><?=$SCLanguages['point_unit']?></li>
				<li class="time" ><?echo $v['UserPointLog']['created']?></li>
				<li class="time">
				<?if(isset($v['Order']['Order']['order_code'])){?>
					<?=$v['Order']['Order']['order_code']?>
				<?}else{?>
				&nbsp;
				<?}?>
					</li>
				<li class="gift" style="width:15%;text-align:center;margin-left:25px;">
				<?if ($v['UserPointLog']['log_type'] == 'B'){?>&nbsp;<?=$SCLanguages['order_generated']?><?}elseif ($v['UserPointLog']['log_type'] == 'O'){?>
					&nbsp;<?=$SCLanguages['order']?><?=$SCLanguages['use']?><?}elseif($v['UserPointLog']['log_type'] == 'R'){?>&nbsp;
						<?=$SCLanguages['register_presented']?><?}elseif($v['UserPointLog']['log_type'] == 'C'){?>&nbsp;<?=$SCLanguages['order']?><?=$SCLanguages['return']?><?}else{?>&nbsp;<?}?></li>
				
				<li class="handel">
				<?//if ($v['UserPointLog']['log_type'] == 'O'){?>
					<?if(isset($v['Order']['Order']['id'])){?>
				<?=$html->link($SCLanguages['view'].$SCLanguages['order'],"../orders/".$v['Order']['Order']['id'],array(),false,false);?>
				<?}?></li>
				</ul>
				<?}?>
				<?}?>	
					
			</div>
			<p class="last_integral"><?=$SCLanguages['current'].$SCLanguages['points']?>：<span><?echo $my_point?></span><?=$SCLanguages['point_unit']?></p>
			<br /><br />
        </div>
  </div>

<div id="pager">
	<span class="totally"><?php printf($SCLanguages['totally_records_unpaid'],$total);?></span>
    <?if(!empty($my_points)){?>
       <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
   <?}?>
</div>
  <br />
<?php echo $this->element('news', array('cache'=>'+0 hour'));?>
<?php echo $this->element('calendar', array('cache'=>'+0 hour'));?>