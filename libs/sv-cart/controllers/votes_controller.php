<?php
/*****************************************************************************
 * SV-Cart 在线调查控制
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: votes_controller.php 2699 2009-07-08 11:07:31Z huangbo $
*****************************************************************************/
class VotesController extends AppController {
	var $name = 'Votes';
    var $components = array ('Pagination','RequestHandler');
   	var $helpers = array('Pagination','Html', 'Form', 'Javascript'); 
	var $uses = array('VoteLog','Vote','VoteOption');

    function vote_already_submited(){
    	 /*   $sql = "SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('vote_log')." ".
           "WHERE ip_address = '$ip_address' AND vote_id = '$vote_id' ";
		*/
		
    	
    }
    
    function save_vote(){
    	$ip_address = $this->real_ip();
	    //pr($_POST);exit;
	    $result['type'] = 1;
	    $result['msg'] = "";
	    $vote_log = $this->VoteLog->find("VoteLog.vote_id = ".$_POST['vote_id']." and VoteLog.ip_address = '".$ip_address."'");
	    if(isset($vote_log['VoteLog'])){
	    	$result['type'] = 1;
	    	$result['msg'] = $this->languages['have_voted'];
	    }else{
	    	$add_log = array('id'=>'','user_id'=>isset($_SESSION['User']['User']['id'])?$_SESSION['User']['User']['id']:0,'vote_id'=>$_POST['vote_id'],'ip_address'=>$ip_address,'system'=>$this->get_os(),'browser'=>$this->getbrowser(),'resolution'=>$_POST['width']."*".$_POST['height'],'vote_option_id'=>$_POST['option'],'status'=>1);
	    	$this->VoteLog->save($add_log);
		    	$this->Vote->set_locale($this->locale);
		    	$vote = $this->Vote->findbyid($_POST['vote_id']);
		    	$vote['Vote']['vote_count']++;
		    	$vote_lists[$_POST['vote_id']] = $vote;
		    	$this->Vote->save($vote['Vote']);
	    	if($_POST['type'] == 1){
	    		$this->VoteOption->set_locale($this->locale);
	    		$vote_option = $this->VoteOption->findbyid($_POST['option']);
	    		$vote_option['VoteOption']['option_count']++;
	    		$this->VoteOption->save($vote_option['VoteOption']);
	    	}elseif($_POST['type'] == 0){
	    		$this->VoteOption->set_locale($this->locale);
	    		$vote_option = $this->VoteOption->findallbyid($_POST['option']);
	    		if(isset($vote_option) && sizeof($vote_option)>0){
	    			foreach($vote_option as $k=>$v){
	    				$v['VoteOption']['option_count']++;
	    				$vote_option[$k]['VoteOption']['option_count']++;
	    				$this->VoteOption->save($v['VoteOption']);
	    			}
	    		}
	    	}
			$votes = $this->Vote->find('all',array('orderby'=>'Vote.modified desc','conditions'=>array("Vote.id " =>$_POST['vote_id'],"Vote.status "=>1)));
			$vote_ids = array();
			$vote_lists = array();
			if(isset($votes) && sizeof($votes)>0){
				foreach($votes as $k=>$v){
					$vote_ids[] = $v['Vote']['id'];
				}
			}	    	
			$vote_ids = array();
			$vote_lists = array();
			if(isset($votes) && sizeof($votes)>0){
				foreach($votes as $k=>$v){
					$vote_ids[] = $v['Vote']['id'];
				}
			}	    	
			$vote_options = $this->VoteOption->find('all',array('order'=>array('VoteOption.option_count ASC'),'conditions'=>array("VoteOption.status" => 1,"VoteOption.vote_id" => $vote_ids)));
			$vote_option_lists = array();
			$vote_type = array();
			if(isset($vote_options) && sizeof($vote_options)>0){
				foreach($vote_options as $k=>$v){
					$vote_option_lists[$v['VoteOption']['vote_id']][$v['VoteOption']['id']] = $v;
					if(isset($vote_type[$v['VoteOption']['vote_id']]['all'])){
						$vote_type[$v['VoteOption']['vote_id']]['all'] += $v['VoteOption']['option_count'];
					}else{
						$vote_type[$v['VoteOption']['vote_id']]['all'] = $v['VoteOption']['option_count'];
					}
					$vote_type[$v['VoteOption']['vote_id']][$v['VoteOption']['id']] = $v['VoteOption']['option_count'];
				}
			}
			$count = 100;
			if(isset($votes) && sizeof($votes)>0){
				foreach($votes as $k=>$v){
					$vote_lists[$v['Vote']['id']] = $v;
					if(isset($vote_option_lists[$v['Vote']['id']])){
						$vote_lists[$v['Vote']['id']]['options'] = $vote_option_lists[$v['Vote']['id']];
						if(sizeof($vote_option_lists[$v['Vote']['id']])>0 ){
							foreach($vote_lists[$v['Vote']['id']]['options'] as $a=>$b){
								if($a == (sizeof($vote_lists[$v['Vote']['id']]['options']) - 1)){
								$percent = $count;
								}else{
								$percent = ($v['Vote']['vote_count'] >0 && $b['VoteOption']['option_count'])?round(($b['VoteOption']['option_count']/$v['Vote']['vote_count'])*100):0;
								$count -= $percent;
								}
								$vote_lists[$v['Vote']['id']]['options'][$a]['VoteOption']['dis'] = $percent;
							} 
						}
					}
				}
			}
			$result['msg'] = $this->languages['voting_success'];
		    $this->set('vote_list',$vote_lists);
			$result['type'] = 0;
	    }
	    $this->set('result',$result);
    }
    
	function real_ip()
	{
	    static $realip = NULL;

	    if ($realip !== NULL)
	    {
	        return $realip;
	    }

	    if (isset($_SERVER))
	    {
	        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	        {
	            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

	            /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
	            foreach ($arr AS $ip)
	            {
	                $ip = trim($ip);

	                if ($ip != 'unknown')
	                {
	                    $realip = $ip;

	                    break;
	                }
	            }
	        }
	        elseif (isset($_SERVER['HTTP_CLIENT_IP']))
	        {
	            $realip = $_SERVER['HTTP_CLIENT_IP'];
	        }
	        else
	        {
	            if (isset($_SERVER['REMOTE_ADDR']))
	            {
	                $realip = $_SERVER['REMOTE_ADDR'];
	            }
	            else
	            {
	                $realip = '0.0.0.0';
	            }
	        }
	    }
	    else
	    {
	        if (getenv('HTTP_X_FORWARDED_FOR'))
	        {
	            $realip = getenv('HTTP_X_FORWARDED_FOR');
	        }
	        elseif (getenv('HTTP_CLIENT_IP'))
	        {
	            $realip = getenv('HTTP_CLIENT_IP');
	        }
	        else
	        {
	            $realip = getenv('REMOTE_ADDR');
	        }
	    }

	    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
	    $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

	    return $realip;
	}     
    
	function getbrowser()
	{
	     global $_SERVER;

	     $agent           = $_SERVER['HTTP_USER_AGENT'];
	     $browser         = '';
	     $browser_ver     = '';
	    
	     if (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $agent, $regs))
	     {
	         $browser         = 'OmniWeb';
	         $browser_ver     = $regs[2];
	     }
	    
	     if (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $agent, $regs))
	     {
	         $browser         = 'Netscape';
	         $browser_ver     = $regs[2];
	     }
	    
	     if (preg_match('/safari\/([^\s]+)/i', $agent, $regs))
	     {
	         $browser         = 'Safari';
	         $browser_ver     = $regs[1];
	     }
	    
	     if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs))
	     {
	         $browser         = 'Internet Explorer';
	         $browser_ver     = $regs[1];
	     }
	    
	     if (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs))
	     {
	         $browser         = 'Opera';
	         $browser_ver     = $regs[1];
	     }
	    
	     if (preg_match('/NetCaptor\s([^\s|;]+)/i', $agent, $regs))
	     {
	         $browser         = '(Internet Explorer ' .$browser_ver. ') NetCaptor';
	         $browser_ver     = $regs[1];
	     }
	    
	     if (preg_match('/Maxthon/i', $agent, $regs))
	     {
	         $browser         = '(Internet Explorer ' .$browser_ver. ') Maxthon';
	         $browser_ver     = '';
	     }
	    
	     if (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs))
	     {
	         $browser         = 'FireFox';
	         $browser_ver     = $regs[1];
	     }
	    
	     if (preg_match('/Lynx\/([^\s]+)/i', $agent, $regs))
	     {
	         $browser         = 'Lynx';
	         $browser_ver     = $regs[1];
	     }
	    
	     if ($browser != '')
	     {
	        return $browser.' '.$browser_ver;
	     }
	     else
	     {
	         return 'Unknow browser';
	     }
	}

	/**
	* 获得客户端的操作系统
	*
	* @access   private
	* @return   void
	*/
	function get_os()
	{
	     $agent = $_SERVER['HTTP_USER_AGENT'];
	     $os = false;

	     if (eregi('win', $agent) && strpos($agent, '95'))
	     {
	         $os = 'Windows 95';
	     }
	     else if (eregi('win 9x', $agent) && strpos($agent, '4.90'))
	     {
	         $os = 'Windows ME';
	     }
	     else if (eregi('win', $agent) && ereg('98', $agent))
	{
	         $os = 'Windows 98';
	     }
	     else if (eregi('win', $agent) && eregi('nt 5.1', $agent))
	{
	         $os = 'Windows XP';
	     }
	     else if (eregi('win', $agent) && eregi('nt 5', $agent))
	{
	         $os = 'Windows 2000';
	     }
	     else if (eregi('win', $agent) && eregi('nt', $agent))
	{
	         $os = 'Windows NT';
	     }
	     else if (eregi('win', $agent) && ereg('32', $agent))
	{
	         $os = 'Windows 32';
	     }
	     else if (eregi('linux', $agent))
	{
	         $os = 'Linux';
	     }
	     else if (eregi('unix', $agent))
	{
	         $os = 'Unix';
	     }
	     else if (eregi('sun', $agent) && eregi('os', $agent))
	{
	         $os = 'SunOS';
	     }
	     else if (eregi('ibm', $agent) && eregi('os', $agent))
	{
	         $os = 'IBM OS/2';
	     }
	     else if (eregi('Mac', $agent) && eregi('PC', $agent))
	{
	         $os = 'Macintosh';
	     }
	     else if (eregi('PowerPC', $agent))
	{
	         $os = 'PowerPC';
	     }
	     else if (eregi('AIX', $agent))
	{
	         $os = 'AIX';
	     }
	     else if (eregi('HPUX', $agent))
	{
	         $os = 'HPUX';
	     }
	     else if (eregi('NetBSD', $agent))
	{
	         $os = 'NetBSD';
	     }
	     else if (eregi('BSD', $agent))
	{
	         $os = 'BSD';
	     }
	     else if (ereg('OSF1', $agent))
	{
	         $os = 'OSF1';
	     }
	     else if (ereg('IRIX', $agent))
	{
	         $os = 'IRIX';
	     }
	     else if (eregi('FreeBSD', $agent))
	{
	         $os = 'FreeBSD';
	     }
	     else if (eregi('teleport', $agent))
	{
	         $os = 'teleport';
	     }
	     else if (eregi('flashget', $agent))
	{
	         $os = 'flashget';
	     }
	     else if (eregi('webzip', $agent))
	{
	         $os = 'webzip';
	     }
	     else if (eregi('offline', $agent))
	{
	         $os = 'offline';
	     }
	     else
	     {
	         $os = 'Unknown';
	     }
	     return $os;
	}    
    
    
}
?>