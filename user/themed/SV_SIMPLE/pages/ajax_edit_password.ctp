<?php 
/*****************************************************************************
 * SV-Cart �����ջ���ַ���
 *===========================================================================
 * ��Ȩ���� �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *�ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 *������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 *===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: ajax_edit_password.ctp 724 2009-04-17 07:59:41Z shenyunfeng $
*****************************************************************************/
ob_start();
?>
<div id="loginout">
	<h1><b style="font-size:14px"><?php echo $SCLanguages['reset_password'];?></b></h1>
	<div style="border-left:1px solid #909592;border-right:1px solid #909592;background:#fff">
	<p class="login-alettr">
	<?php echo $html->image('icon-10.gif',array("align"=>"middle"));?>
	
	<b>
	<?php echo $result['msg']?></b></p>
		<br/>
		<p class="btns">
	<?php echo $html->link($html->image('loginout-btn_right.gif').$SCLanguages['confirm'],"/",array(),false,false);?>
		</p>
	</div>
	<p><?php echo $html->image("loginout-bottom.gif",array("align"=>"texttop"))?></p>
</div>

<?php $result['message'] = ob_get_contents();
ob_end_clean();
echo json_encode($result);
?>