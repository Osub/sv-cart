<p><style type="text/css">body,td { font-size:13px; }</style></p>
<h1 align="center">退货单信息</h1>
<?php foreach($all_order_info as $vall){?>
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
            <td align="right">操作时间：</td>
            <td><?php if($vall['Order']['modified']!='0000-00-00 00:00:00'){ ?><?php echo $vall['Order']['modified']?><?php } ?></td>
            <td align="right"></td>
            <td></td>
        </tr>
        <tr>
            <td>收货地址：</td>
            <td colspan="7">[<?php foreach($vall['Order']['regionname'] as $vr){ foreach($vr as $vrr){?><?php echo $vrr.'&nbsp;';?><?php }} ?>]&nbsp;<?php echo $vall['Order']['address']?>&nbsp;<!-- 收货人地址 -->
             收货人：<?php echo $vall['Order']['consignee']?>&nbsp;<!-- 收货人姓名 -->
             邮编：<?php echo $vall['Order']['zipcode']?>&nbsp;<!-- 邮政编码 -->
             联系电话：<?php echo $vall['Order']['telephone']?>&nbsp;<!-- 联系电话 -->
             手机：<?php echo $vall['Order']['mobile']?><!-- 手机号码 --></td>
        </tr>
    </tbody>
</table>
<table border="1" width="96%" style="border-color: rgb(0, 0, 0); border-collapse: collapse;">
    <tbody>
        <tr align="center">
        	<td bgcolor="#cccccc" width="5%" >序号   <!-- 序号 --></td>
            <td bgcolor="#cccccc" width="20%">商品名称   <!-- 商品名称 --></td>
            <td bgcolor="#cccccc" width="15%">货号   <!-- 商品货号 --></td>
            <td bgcolor="#cccccc" width="20%">属性  <!-- 商品属性 --></td>
            <td bgcolor="#cccccc" width="15%">单价   <!-- 商品单价 --></td>
            <td bgcolor="#cccccc" width="10%">数量   <!-- 商品数量 --></td>
            <td bgcolor="#cccccc" width="16%">小计   <!-- 价格小计 --></td>
        </tr>
        <?php foreach($vall['OrderProduct'] as $k=>$v){?>
        <tr>
        	<td>&nbsp;<?php echo $k+1;?><!-- 商品序号 --></td>
            <td>&nbsp;<?php echo $v['product_name']?><!-- 商品名称 --></td>
            <td>&nbsp;<?php echo $v['product_code']?><!-- 商品货号 --></td>
            <td>&nbsp;<!-- 商品属性 --></td>
            <td align="right">&nbsp;<?php echo $v['product_price']?><!-- 商品单价 --></td>
            <td align="right">&nbsp;<?php echo $v['product_quntity']?><!-- 商品数量 --></td>
            <td align="right">&nbsp;<?php echo $v['product_total']?><!-- 商品金额小计 --></td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="5"></td>
            <!-- 商品总金额 -->
            <td align="right" colspan="2">商品总金额：<?php echo $vall['Order']['format_subtotal']?></td>
        </tr>
    </tbody>
</table>

<table border="0" width="96%">
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
</table>
<?php } ?>