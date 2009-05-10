<?php
/*****************************************************************************
 * SV-Cart 更新订单
 * ===========================================================================
 * 版权所有 上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn [^]
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: upload_products_file.ctp 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
?>
<?php echo $this->element('ur_here', array('cache'=>'+0 hour','navigations'=>$navigations));?>
<?php echo $form->create('products',array('action'=>'/batch_add_products/','name'=>"theForm","enctype"=>"multipart/form-data"));?>

<table align='center' >
<tr>
<td>商品分类：</td><td><select id="category_id" name="category_id">
		<option value="0">所有分类</option>
		<?if(isset($categories_tree) && sizeof($categories_tree)>0){?><?foreach($categories_tree as $first_k=>$first_v){?>
<option value="<?=$first_v['Category']['id'];?>" ><?=$first_v['CategoryI18n']['name'];?></option>
<?if(isset($first_v['SubCategory']) && sizeof($first_v['SubCategory'])>0){?><?foreach($first_v['SubCategory'] as $second_k=>$second_v){?>
<option value="<?=$second_v['Category']['id'];?>">&nbsp;&nbsp;<?=$second_v['CategoryI18n']['name'];?></option>
<?if(isset($second_v['SubCategory']) && sizeof($second_v['SubCategory'])>0){?><?foreach($second_v['SubCategory'] as $third_k=>$third_v){?>
<option value="<?=$third_v['Category']['id'];?>">&nbsp;&nbsp;&nbsp;&nbsp;<?=$third_v['CategoryI18n']['name'];?></option>
<?}}}}}}?>
		</select> </td>
</tr>
<tr><td>上传批量csv文件：</td><td><input name="file" size="40" type="file"><td></tr>
<tr><td></td><td>注意：上传文件编码格式gb2312编码<br/>（CSV文件中一次上传商品数量最好不要超过1000，CSV文件大小最好不要超过500K.）<td></tr>
<tr><td></td><td><strong><?=$html->link("下载批量csv文件","/products/download",'',false,false);?></strong></td></tr>
<tr><td colspan="2" align='center'>
<input name="submit" id="submit" value=" 确定 " class="button" type="submit">
</td></tr>
</table>
<?php $form->end();?>