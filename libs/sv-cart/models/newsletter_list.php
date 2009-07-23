<?php
/*****************************************************************************
 * SV-Cart 邮件
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: newsletter_list.php 1402 2009-05-15 09:31:53Z shenyunfeng $
*****************************************************************************/
class NewsletterList extends AppModel
{
	var $name = 'NewsletterList';
		//检查email是否重用
	function check_unique_email($email,$id=0){
		if($id==0)
			$condition = " NewsletterList.email='$email' and NewsletterList.status = '1'";
		else
			$condition = " NewsletterList.id <> $id and NewsletterList.email='$email'";
		$data=$this->findCount($condition);

		return $data;

	}
	function check_unique_email_by_email($email,$id=0){
		if($id==0)
			$condition = " NewsletterList.email='$email'";
		else
			$condition = " NewsletterList.id <> $id and NewsletterList.email='$email'";
		$data=$this->findCount($condition);

		return $data;

	}
}
?>