<p><style type="text/css">body,td { font-size:13px; }</style></p>
<h1 align="center">配送单信息</h1>
<?php //pr($all_order_info); ?>
<?php foreach($all_order_info as $vall){?>
<?php if(($vall['Order']['allvirtual']==0)&&((($vall['Order']['is_cod']==1)&&($vall['Order']['status']==1)&&($vall['Order']['shipping_status']==0))||(($vall['Order']['is_cod']==0)&&($vall['Order']['payment_status']==2)&&($vall['Order']['shipping_status']==0)))){?>
<table cellpadding="1" width="100%">
    <tbody>
        <tr>
            <td width="8%">收 货 人：</td>
            <td><?php echo $vall['Order']['consignee']?><!-- 购货人姓名 --></td>
            <td align="right">下单时间：</td>
            <td><?php echo $vall['Order']['created']?><!-- 下订单时间 --></td>
            <td align="right">支付方式：</td>
            <td><?php echo $vall['Order']['payment_name']?><!-- 支付方式 --></td>
            <td align="right">订单编号：</td>
            <td><?php echo $vall['Order']['order_code']?><!-- 订单号 --></td>
        </tr>
        <tr>
            <td>付款时间：</td>
            <td><?php if($vall['Order']['payment_time']!='0000-00-00 00:00:00'){ ?><?php echo $vall['Order']['payment_time']?><?php } ?></td>
            <!-- 付款时间 -->
            <td align="right">发货时间：</td>
            <td><?php if($vall['Order']['shipping_time']!='0000-00-00 00:00:00'){ ?><?php echo $vall['Order']['shipping_time']?><?php } ?><!-- 发货时间 --></td>
            <td align="right">配送方式：</td>
            <td><?php echo $vall['Order']['shipping_name']?><!-- 配送方式 --></td>
        </tr>
        <tr>
            <td>收货地址：</td>
            <td colspan="7">[<?php foreach($vall['Order']['regionname'] as $vr){ foreach($vr as $vrr){?><?php echo $vrr.'&nbsp;';?><?php }} ?>]&nbsp;<?php echo $vall['Order']['address']?>&nbsp;<!-- 收货人地址 -->
            
             邮编：<?php echo $vall['Order']['zipcode']?>&nbsp;<!-- 邮政编码 -->
             <?php if($vall['Order']['telephone']){ ?>联系电话：<?php echo $vall['Order']['telephone']?>&nbsp;<?php } ?><!-- 联系电话 -->
             <?php if($vall['Order']['mobile']){ ?>手机：<?php echo $vall['Order']['mobile']?><?php } ?><!-- 手机号码 --></td>
        </tr>
    </tbody>
</table>
<table border="1" width="96%" style="border-color: rgb(0, 0, 0); border-collapse: collapse;">
    <tbody>
        <tr align="center">
        	<td bgcolor="#cccccc" width="5%" >序号   <!-- 序号 --></td>
        	<td bgcolor="#cccccc" width="15%">货号   <!-- 商品货号 --></td>
            <td bgcolor="#cccccc" width="20%">商品名称   <!-- 商品名称 --></td>
            <td bgcolor="#cccccc" width="20%">属性  <!-- 商品属性 --></td>
            <td bgcolor="#cccccc" width="15%">单价   <!-- 商品单价 --></td>
            <td bgcolor="#cccccc" width="10%">数量   <!-- 商品数量 --></td>
            <td bgcolor="#cccccc" width="16%">小计   <!-- 价格小计 --></td>
        </tr>
        <?php foreach($vall['OrderProduct'] as $k=>$v){?>
        <?php if($v['extension_code']!='virtual_card'){?>	
        <tr>
        	<td>&nbsp;<?php echo $k+1;?><!-- 商品序号 --></td>
        	<td>&nbsp;<?php echo $v['product_code']?><!-- 商品货号 --></td>
            <td>&nbsp;<?php echo $v['product_name']?><!-- 商品名称 --></td>
            <td>&nbsp;<?php echo $v['product_attrbute']?><!-- 商品属性 --></td>
            <td align="right">&nbsp;<?php echo $v['product_price']?><!-- 商品单价 --></td>
            <td align="right">&nbsp;<?php echo $v['product_quntity']?><!-- 商品数量 --></td>
            <td align="right">&nbsp;<?php echo $v['product_total']?><!-- 商品金额小计 --></td>
        </tr>
        <?php }} ?>
        <tr>
            <!-- 发票抬头和发票内容 -->
            <td colspan="5"></td>
            <!-- 商品总金额 -->
            <td align="right" colspan="2">商品总金额：<?php echo $vall['Order']['format_novir_subtotal']?></td>
        </tr>
    </tbody>
</table>
<table border="0" width="96%">
    <tbody>
        <tr align="right">
            <td><?php if($vall['Order']['discount']>0){?>- 折扣：<?php echo $vall['Order']['discount']?> <?php } ?>
            <?php if($vall['Order']['pack_fee']!='0.00'){?><!-- 包装名称包装费用 --> + 包装费用：<?php echo $vall['Order']['format_pack_fee']?> <?php } ?>
            <?php if($vall['Order']['card_fee']!='0.00'){?><!-- 贺卡名称以及贺卡费用 --> + 贺卡费用：<?php echo $vall['Order']['format_card_fee']?> <?php } ?>
            <?php if($vall['Order']['payment_fee']!='0.00'){?><!-- 支付手续费 --> + 支付费用：<?php echo $vall['Order']['format_payment_fee']?> <?php } ?> 
            <?php if($vall['Order']['shipping_fee']!='0.00'){?><!-- 配送费用 --> + 配送费用：<?php echo $vall['Order']['format_shipping_fee']?> <?php } ?> 
            <?php if($vall['Order']['insure_fee']!='0.00'){?><!-- 保价费用 --> + 保价费用：<?php echo $vall['Order']['format_insure_fee']?> <?php } ?> 
            <!-- 订单总金额 -->   = 订单总金额：<?php echo $vall['Order']['format_total'];?></td>
        </tr>
        <tr align="right">
            <td><!-- 如果已付了部分款项, 减去已付款金额 --> <?php if($vall['Order']['money_paid']!='0.00'){?>- 已付款金额：<?php echo $vall['Order']['format_money_paid']?> <?php } ?> 
            <!-- 如果使用了积分支付, 减去已使用的积分 -->   <?php if($vall['Order']['point_fee']!='0.00'){?>- 使用积分：<?php echo $vall['Order']['format_point_fee']?> <?php } ?> 
            <!-- 应付款金额 --> = 应付款金额：<?php echo $vall['Order']['format_should_pay'];;?></td>
        </tr>
    </tbody>
</table>
<table border="0" width="96%">
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
</table>
<?php } }?>