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
 * $Id: index.ctp 3261 2009-07-23 05:38:53Z huangbo $
*****************************************************************************/
?>
<?php echo $javascript->link('calendar');?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour'));?>
<div id="Products_box">
<h1 class="headers"><span class="l"></span><span class="r"></span><b><?php echo $SCLanguages['points']?></b></h1>
	<div id="infos">
        	<p class="history_detail find-btns">
        	<a class="float_r" style="margin-top:5px;"><input onfocus="blur()" class="find" type="button" onclick="javascript:points_search();" value="<?php echo $SCLanguages['search']?>" /></a>
			
			<span><?php echo $SCLanguages['time']?>: <input type="text" id="date" name="date" value="" class="text" readonly style="*margin-right:3px;" /><button class="calendar" id="show" title="Show Calendar" style="*margin-top:0;">
			<?php echo $html->image(isset($img_style_url)?$img_style_url."/".'calendar.png':'calendar.png',array('width'=>'18' ,'height'=>'18' ,'alt'=>'Calendar'))?></button>－<input type="text" id="date2" name="date2" value=""  class="text" readonly style="*margin-right:3px;" /><button class="calendar" id="show2" title="Show Calendar" style="*margin-top:0;"><?php echo $html->image(isset($img_style_url)?$img_style_url."/".'calendar.png':'calendar.png',array('width'=>'18' ,'height'=>'18' ,'alt'=>'Calendar'))?></button>
			&nbsp;&nbsp;<?php echo $SCLanguages['points']?>: <input class="text" type="text" name="min_points" id="min_points" value="<?php echo $min_points?>" />－<input class="text" type="text" name="max_points" id="max_points" value="<?php echo $max_points?>" />
			</span>
			<b><?php echo $SCLanguages['history_details']?></b>
			</p>
            <ul class="integral_title">
            <li class="time" style="width:23%"><strong><?php echo $SCLanguages['exchange'].$SCLanguages['time']?></strong></li>
            <li class="integral" style="width:23%"><strong><?php echo $SCLanguages['exchange'].$SCLanguages['points']?></strong></li>
            <li class="gift"style="width:23%"><strong><?php echo $SCLanguages['operation'].$SCLanguages['type']?></strong></li>
            <li class="handel" style="width:22%"><strong><?php echo $SCLanguages['remark']?></strong></li></ul>
            <div class="integral_list">
    		<?php if(isset($my_points) && sizeof($my_points)>0){?>
		    <?php foreach($my_points as $k=>$v){?>
				<ul class="integral_title" >
				<li class="time" style="width:23%"><?php echo $v['UserPointLog']['created']?></li>
				<li class="integral" style="width:23%"><?php echo $v['UserPointLog']['point']?><?php echo $SCLanguages['point_unit']?></li>
				<li class="gift" style="width:23%;margin-left:25px;">
				<?php if ($v['UserPointLog']['log_type'] == 'B'){?>
				<?php echo $systemresource_info['point_log_type']['B']?>
				<?php }elseif ($v['UserPointLog']['log_type'] == 'O'){?>
				<?php echo $systemresource_info['point_log_type']['O']?>
				<?php }elseif($v['UserPointLog']['log_type'] == 'R'){?>
				<?php echo $systemresource_info['point_log_type']['R']?>
				<?php }elseif($v['UserPointLog']['log_type'] == 'C'){?>
				<?php echo $SCLanguages['order']?><?php echo $SCLanguages['return']?><?php }else{?>&nbsp;<?php }?></li>
				
				<li class="handel"   style="width:22%">
				<?php //if ($v['UserPointLog']['log_type'] == 'O'){?>
				<?php if(isset($v['Order']['Order']['id'])){?>
				<?php echo $SCLanguages['order_code']?>:<?php echo $html->link("<span>".$v['Order']['Order']['order_code']."</span>","../orders/".$v['Order']['Order']['id'],array('style'=>'text-decoration:underline;',"target"=>"_blank"),false,false);?>
				<?php }?></li>
				</ul>
				<?php }?>
				<?php }?>	
	<!-- 小计 -->				
			<ul class="integral_title" style="padding:10px 0 0 32px;">
	        <?php echo $SCLanguages['order_generated']?>: <?php echo $b_point?> <?php echo $SCLanguages['point_unit']?>&nbsp;&nbsp;&nbsp;&nbsp;
	        <?php echo $SCLanguages['register_presented']?>: <?php echo $r_point?> <?php echo $SCLanguages['point_unit']?>&nbsp;&nbsp;&nbsp;&nbsp;
	        <?php echo $SCLanguages['order']?><?php echo $SCLanguages['use']?>: <?php echo $o_point?> <?php echo $SCLanguages['point_unit']?>&nbsp;&nbsp;&nbsp;&nbsp;
	        <?php echo $SCLanguages['order']?><?php echo $SCLanguages['return']?>: <?php echo $c_point?> <?php echo $SCLanguages['point_unit']?>
			</ul>		
	<!-- 小计 -->
	<p class="last_integral" align="right"><?php echo $SCLanguages['current'].$SCLanguages['point']?>：<span><?php echo $my_point?></span><?php echo $SCLanguages['point_unit']?>
				&nbsp;&nbsp;<?=$SCLanguages['rank_point']?>:<span><?=(!empty($user_point)?$user_point:0)?></span><?php echo $SCLanguages['point_unit']?>
				
			</p>
			</div>
			
        </div>
  </div>

<div id="pager">
	<span class="totally"><?php printf($SCLanguages['totally_records_unpaid'],$total);?></span>
    <?php if(!empty($my_points)){?>
       <?php echo $this->element('pagers', array('cache'=>'+0 hour'));?>
   <?php }?>
</div>
  <br />
<?php echo $this->element('news', array('cache'=>array('time'=> "+24 hour",'key'=>'news'.$template_style)));?>
<?php echo $this->element('calendar', array('cache'=>'+0 hour'));?>