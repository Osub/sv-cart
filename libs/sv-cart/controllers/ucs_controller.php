<?php
class UcsController extends AppController{
    var $name='Ucs';
    var $helpers=array();
    var $uses=array("User");
    var $db='';
    var $tablepre='';
    var $appdir='';

    function index(){
    	$integrate_config = unserialize($this->configs["integrate_config"]);
    	
		define('ROOT_PATH', str_replace('api', '', str_replace('\\', '/', dirname(__FILE__))));
		define('UC_CONNECT', "mysql");
		define('UC_DBHOST', $integrate_config["db_host"]);
		define('UC_DBUSER', $integrate_config["db_user"]);
		define('UC_DBPW', $integrate_config["db_pass"]);
		define('UC_DBNAME', $integrate_config["db_name"]);
		define('UC_DBCHARSET', $integrate_config["db_charset"]);
		define('UC_DBTABLEPRE', $integrate_config["db_pre"]);
		define('UC_DBCONNECT', '0');
		define('UC_KEY', $integrate_config["uc_key"]);
		define('UC_API', $integrate_config["uc_url"]);
		define('UC_CHARSET', "utf-8");
		define('UC_IP', 1);
		define('UC_APPID', 1);
		define('UC_PPP', '20');


		define('UC_CLIENT_VERSION', '1.5.0');  //note UCenter �汾��ʶ
		define('UC_CLIENT_RELEASE', '20081031');

		define('API_DELETEUSER', 1);    //note �û�ɾ�� API �ӿڿ���
		define('API_RENAMEUSER', 1);    //note �û����� API �ӿڿ���
		define('API_GETTAG', 1);        //note ��ȡ��ǩ API �ӿڿ���
		define('API_SYNLOGIN', 1);      //note ͬ����¼ API �ӿڿ���
		define('API_UPDATEPW', 1);      //note �����û����� ����
		define('API_UPDATEBADWORDS', 1);//note ���¹ؼ����б� ����
		define('API_UPDATEHOSTS', 1);   //note ���������������� ����
		define('API_UPDATEAPPS', 1);    //note ����Ӧ���б� ����
		define('API_UPDATECLIENT', 1);  //note ���¿ͻ��˻��� ����
		define('API_UPDATECREDIT', 1);  //note �����û����� ����
		define('API_GETCREDITSETTINGS', 1);  //note �� UCenter �ṩ�������� ����
		define('API_GETCREDIT', 1);     //note ��ȡ�û���ĳ����� ����
		define('API_UPDATECREDITSETTINGS', 1);  //note ����Ӧ�û������� ����

		define('API_RETURN_SUCCEED', '1');
		define('API_RETURN_FAILED', '-1');
		define('API_RETURN_FORBIDDEN', '-2');

		define('IN_ECS', TRUE);

        Configure::write('debug',0);

        $_DCACHE=$get=$post=array();

        $code=$_GET['code'];
        parse_str($this->myauthcode($code,'DECODE',UC_KEY),$get);

        if(in_array($get['action'],array('test','deleteuser','renameuser','gettag','synlogin','synlogout','updatepw','updatebadwords','updatehosts','updateapps','updateclient','updatecredit','getcreditsettings','updatecreditsettings'))){

            exit($this->$get['action']($get,$post));
        }
        else{
            exit(API_RETURN_FAILED);
        }



    }
    /**
     *  uc�Դ�����3
     *
     * @access  public
     * @param   string  $string
     *
     * @return  string  $string
     */
    function mystripslashes($string){
        if(is_array($string)){
            foreach($string as $key => $val){
                $string[$key]=$this->mystripslashes($val);
            }
        }
        else{
            $string=stripslashes($string);
        }
        return $string;
    }

    function _serialize($arr,$htmlon=0){
        if(!function_exists('xml_serialize')){
            include(ROOT_PATH.'uc_client/lib/xml.class.php');
        }
        return xml_serialize($arr,$htmlon);
    }

    function uc_note(){
        $this->appdir=ROOT_PATH;
        //$this->db = $GLOBALS['db'];
    }

    function test($get,$post){
        return API_RETURN_SUCCEED;
    }


    function gettag($get,$post){
        $name=$get['id'];
        if(!API_GETTAG){
            return API_RETURN_FORBIDDEN;
        }
        $tags=fetch_tag($name);
        $return=array($name,$tags);
        include_once(ROOT_PATH.'uc_client/client.php');
        return uc_serialize($return,1);
    }

    function synlogin($get,$post){
        $uid=intval($get['uid']);
        $username=$get['username'];
        if(!API_SYNLOGIN){
            return API_RETURN_FORBIDDEN;
        }
        header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
        $this->set_login($uid,$username);
    }

    function synlogout($get,$post){
        if(!API_SYNLOGOUT){
            return API_RETURN_FORBIDDEN;
        }

        header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
        set_cookie();
        set_session();
    }

    function updatepw($get,$post){
        if(!API_UPDATEPW){
            return API_RETURN_FORBIDDEN;
        }
        $username=$get['username'];
#$password = md5($get['password']);
        $newpw=md5(time().rand(100000,999999));
        //$this->db->query("UPDATE " . $GLOBALS['ecs']->table('users') . " SET password='$newpw' WHERE user_name='$username'");
        return API_RETURN_SUCCEED;
    }

    function updatebadwords($get,$post){
        if(!API_UPDATEBADWORDS){
            return API_RETURN_FORBIDDEN;
        }
        $cachefile=$this->appdir.'./uc_client/data/cache/badwords.php';
        $fp=fopen($cachefile,'w');
        $data=array();
        if(is_array($post)){
            foreach($post as $k => $v){
                $data['findpattern'][$k]=$v['findpattern'];
                $data['replace'][$k]=$v['replacement'];
            }
        }
        $s="<?php\r\n";
        $s .= '$_CACHE[\'badwords\'] = '.var_export($data,TRUE).";\r\n";
        fwrite($fp,$s);
        fclose($fp);
        return API_RETURN_SUCCEED;
    }

    function updatehosts($get,$post){
        if(!API_UPDATEHOSTS){
            return API_RETURN_FORBIDDEN;
        }
        $cachefile=$this->appdir.'./uc_client/data/cache/hosts.php';
        $fp=fopen($cachefile,'w');
        $s="<?php\r\n";
        $s .= '$_CACHE[\'hosts\'] = '.var_export($post,TRUE).";\r\n";
        fwrite($fp,$s);
        fclose($fp);
        return API_RETURN_SUCCEED;
    }

    function updateapps($get,$post){
        if(!API_UPDATEAPPS){
            return API_RETURN_FORBIDDEN;
        }
        $UC_API=$post['UC_API'];

        $cachefile=$this->appdir.'./uc_client/data/cache/apps.php';
        $fp=fopen($cachefile,'w');
        $s="<?php\r\n";
        $s .= '$_CACHE[\'apps\'] = '.var_export($post,TRUE).";\r\n";
        fwrite($fp,$s);
        fclose($fp);
#clear_cache_files();
        return API_RETURN_SUCCEED;
    }

    function updateclient($get,$post){
        if(!API_UPDATECLIENT){
            return API_RETURN_FORBIDDEN;
        }
        $cachefile=$this->appdir.'./uc_client/data/cache/settings.php';
        $fp=fopen($cachefile,'w');
        $s="<?php\r\n";
        $s .= '$_CACHE[\'settings\'] = '.var_export($post,TRUE).";\r\n";
        fwrite($fp,$s);
        fclose($fp);
        return API_RETURN_SUCCEED;
    }

    function updatecredit($get,$post){
        if(!API_UPDATECREDIT){
            return API_RETURN_FORBIDDEN;
        }
        $cfg=unserialize($GLOBALS['_CFG']['integrate_config']);
        $credit=intval($get['credit']);
        $amount=intval($get['amount']);
        $uid=intval($get['uid']);
        $points=array(0 => 'rank_points',1 => 'pay_points');
        //$sql = "UPDATE " . $GLOBALS['ecs']-> table('users') . " SET {$points[$credit]} = {$points[$credit]} + '$amount' WHERE user_id = $uid";
        //$this->db->query($sql);
        //if ($this->db->affected_rows() <= 0)
        //{
        return API_RETURN_FAILED;
        // }
        //$sql = "INSERT INTO " . $GLOBALS['ecs']->table('account_log') . "(user_id, {$points[$credit]}, change_time, change_desc, change_type)" .
        // " VALUES ('$uid', '$amount', '". gmtime() ."', '" . $cfg['uc_lang']['exchange'] . "', '99')";
        // $this->db->query($sql);
        return API_RETURN_SUCCEED;
    }

    function getcredit($get,$post){
        if(!API_GETCREDIT){
            return API_RETURN_FORBIDDEN;
        }

        /*$uid = intval($get['uid']);
        $credit = intval($get['credit']);
        return $credit >= 1 && $credit <= 8 ? $this->db->result_first("SELECT extcredits$credit FROM ".$this->tablepre."members WHERE uid='$uid'") : 0;*/
    }

    function getcreditsettings($get,$post){
        if(!API_GETCREDITSETTINGS){
            return API_RETURN_FORBIDDEN;
        }
        $cfg=unserialize($GLOBALS['_CFG']['integrate_config']);
        $credits=$cfg['uc_lang']['credits'];
        include_once(ROOT_PATH.'uc_client/client.php');
        return uc_serialize($credits);
    }

    function updatecreditsettings($get,$post){
        if(!API_UPDATECREDITSETTINGS){
            return API_RETURN_FORBIDDEN;
        }

        $outextcredits=array();
        foreach($get['credit']as $appid => $credititems){
            if($appid==UC_APPID){
                foreach($credititems as $value){
                    $outextcredits[]=array('appiddesc' => $value['appiddesc'],'creditdesc' => $value['creditdesc'],'creditsrc' => $value['creditsrc'],'title' => $value['title'],'unit' => $value['unit'],'ratio' => $value['ratio']);
                }
            }
        }
        // $this->db->query("UPDATE " . $GLOBALS['ecs']->table("shop_config") . " SET value='".serialize($outextcredits)."' WHERE code='points_rule'");
        return API_RETURN_SUCCEED;
    }

    /**
     *  uc�Դ�����2
     *
     * @access  public
     *
     * @return  string  $string
     */
    function myauthcode($string,$operation='DECODE',$key='',$expiry=0){
        $ckey_length=4;
        $key=md5($key ? $key : UC_KEY);
        $keya=md5(substr($key,0,16));
        $keyb=md5(substr($key,16,16));
        $keyc=$ckey_length ? ($operation=='DECODE' ? substr($string,0,$ckey_length): substr(md5(microtime()),-$ckey_length)): '';

        $cryptkey=$keya.md5($keya.$keyc);
        $key_length=strlen($cryptkey);

        $string=$operation=='DECODE' ? base64_decode(substr($string,$ckey_length)): sprintf('%010d',$expiry ? $expiry+time(): 0).substr(md5($string.$keyb),0,16).$string;
        $string_length=strlen($string);

        $result='';
        $box=range(0,255);

        $rndkey=array();
        for($i=0;$i <= 255;$i++){
            $rndkey[$i]=ord($cryptkey[$i%$key_length]);
        }

        for($j=$i=0;$i < 256;$i++){
            $j=($j+$box[$i]+$rndkey[$i])%256;
            $tmp=$box[$i];
            $box[$i]=$box[$j];
            $box[$j]=$tmp;
        }

        for($a=$j=$i=0;$i < $string_length;$i++){
            $a=($a+1)%256;
            $j=($j+$box[$a])%256;
            $tmp=$box[$a];
            $box[$a]=$box[$j];
            $box[$j]=$tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a]+$box[$j])%256]));
        }

        if($operation=='DECODE'){
            if((substr($result,0,10)==0 || substr($result,0,10)-time() > 0) && substr($result,10,16)==substr(md5(substr($result,26).$keyb),0,16)){
                return substr($result,26);
            }
            else{
                return '';
            }
        }
        else{
            return $keyc.str_replace('=','',base64_encode($result));
        }
    }
    /**
     * �����û���½
     *
     * @access  public
     * @param int $uid
     * @return void
     */
    function set_login($user_id='',$user_name=''){
        if(empty($user_id)){
            return ;
        }
        else{
            $row=$this->User->findById($user_id);
            if($row){

                $_SESSION['User']=$row;
            }
            else{

            }
        }
    }

}



?>