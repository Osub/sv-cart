<?php
/*****************************************************************************
 * SV-Cart 后台通用方法
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: commons_controller.php 2918 2009-07-16 03:26:36Z shenyunfeng $
 *****************************************************************************/
class CommonsController extends AppController{
    var $name='Commons';
    var $components=array('Email'); // Added
    var $uses=array("MailTemplate","Topic","TopicProduct",'Operator','Operator_action','Operator_menu','Region','ProductType','ProductRelation','Product','ProductArticle','Article');
    //$languages = $this->requestAction('commons/get_languages_front/');
    function operator_action(){
        //获取菜单
        $this->Operator_action->set_locale($this->locale);
        $operator_action=$this->Operator_action->tree($_SESSION['Operator_Info']['Operator']['role_id']);
        return $operator_action;
    }
    function operator_menus(){
        //获取菜单
        $this->Operator_menu->set_locale($this->locale);
        $Operator_menus=$this->Operator_menu->tree();
        //pr($Operator_menus);
        $sub_actions_id1=explode(';',$_SESSION['Action_List']);
        if($sub_actions_id1[0]!='all'){
            //得到所有属于此操作员的action的id集合
            $sub_actions_id2=array();
            $condition=array("Operator_action.id" => $sub_actions_id1," Operator_action.parent_id != '0' and Operator_action.status = '1'");
            $actions_list=$this->Operator_action->findAll($condition);
            $Operator_real_menus=array();
            foreach($Operator_menus as $k => $v){
                $res[$k]['Operator_menu']=$v['Operator_menu'];
                if(isset($v['SubMenu']) && is_array($v['SubMenu'])){
                    foreach($v['SubMenu']as $key => $val){
                        foreach($actions_list as $action_code){
                            //echo "---------";
                            //echo $action_code['Operator_action']['code'];
                            if($val['Operator_menu']['operator_action_code']==$action_code['Operator_action']['code']){
                                $res[$k]['SubMenu'][$key]['Operator_menu']=$val['Operator_menu'];
                            }
                        }
                    }
                }
            }
            if(isset($res) && is_array($res))
            foreach($res as $menu_key => $menu){
                if(isset($menu['SubMenu'])){
                    $Operator_real_menus[$menu_key]=$menu;
                }
            }
        }
        else{
            $Operator_real_menus=$Operator_menus;
            //pr($Operator_real_menus);
        }
        //	pr($Operator_real_menus);
        return $Operator_real_menus;
    }
    /**
     * 获得用户的真实IP地址
     *
     * @access  public
     * @return  string
     */
    function real_ip(){
        static $realip=NULL;
        if($realip!==NULL){
            return $realip;
        }
        if(isset($_SERVER)){
            if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $arr=explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
                /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
                foreach($arr AS $ip){
                    $ip=trim($ip);
                    if($ip!='unknown'){
                        $realip=$ip;
                        break;
                    }
                }
            }
            elseif(isset($_SERVER['HTTP_CLIENT_IP'])){
                $realip=$_SERVER['HTTP_CLIENT_IP'];
            }
            else{
                if(isset($_SERVER['REMOTE_ADDR'])){
                    $realip=$_SERVER['REMOTE_ADDR'];
                }
                else{
                    $realip='0.0.0.0';
                }
            }
        }
        else{
            if(getenv('HTTP_X_FORWARDED_FOR')){
                $realip=getenv('HTTP_X_FORWARDED_FOR');
            }
            elseif(getenv('HTTP_CLIENT_IP')){
                $realip=getenv('HTTP_CLIENT_IP');
            }
            else{
                $realip=getenv('REMOTE_ADDR');
            }
        }
        preg_match("/[\d\.]{7,15}/",$realip,$onlineip);
        $realip=!empty($onlineip[0]) ? $onlineip[0]: '0.0.0.0';
        return $realip;
    }
    //生日格式函数
    function html_select_date($field_order,$prefix,$start_year,$end_year,$display_months,$display_days,$month_format,$day_value_format,$times='0000-00-00'){
        $pre=$prefix;
        if(isset($times)){
            if(intval($times) > 10000){
                $times=gmdate('Y-m-d',$times+8*3600);
            }
            $t=explode('-',$times);
            $year=strval($t[0]);
            $month=strval($t[1]);
            $day=strval($t[2]);
        }
        $now=gmdate('Y',time());
        if(isset($start_year)){
            if(abs($start_year)==$start_year){
                $startyear=$start_year;
            }
            else{
                $startyear=$start_year+$now;
            }
        }
        else{
            $startyear=$now-3;
        }
        if(isset($end_year)){
            if(strlen(abs($end_year))==strlen($end_year)){
                $endyear=$end_year;
            }
            else{
                $endyear=$end_year+$now;
            }
        }
        else{
            $endyear=$now+3;
        }
        $out="<select name=\"birthdayYear\" id=\"birthdayYear\">";
        for($i=$startyear;$i <= $endyear;$i++){
            $out .= $i==$year ? "<option value=\"$i\" selected>$i</option>" : "<option value=\"$i\">$i</option>";
        }
        if($display_months!='false'){
            $out .= "</select>&nbsp;<select name=\"birthdayMonth\" id=\"birthdayMonth\">";
            for($i=1;$i <= 12;$i++){
                $out .= $i==$month ? "<option value=\"$i\" selected>".str_pad($i,2,'0',STR_PAD_LEFT)."</option>": "<option value=\"$i\">".str_pad($i,2,'0',STR_PAD_LEFT)."</option>";
            }
        }
        if($display_days!='false'){
            $out .= "</select>&nbsp;<select name=\"birthdayDay\" id=\"birthdayDay\">";
            for($i=1;$i <= 31;$i++){
                $out .= $i==$day ? "<option value=\"$i\" selected>".str_pad($i,2,'0',STR_PAD_LEFT)."</option>": "<option value=\"$i\">".str_pad($i,2,'0',STR_PAD_LEFT)."</option>";
            }
        }
        return $out.'</select>';
    }
    function change_region($region_id,$level,$target){
        $low_region=$this->Region->findAll("Region.parent_id = '".$region_id."'");
        $this->set('level',$level);
        $this->set('targets',$target);
        $this->set('low_region',$low_region);
        $this->set('province_list',$this->get_regions(1));
        //显示的页面
        $this->layout='ajax';
    }
    function get_regions($level=0){
        $this->Region->set_locale($this->locale);
        $regions_list=$this->Region->findAll("level = '".$level."'");
        return $regions_list;
    }
    //商品类型列表
    function product_type_list($selected=0){
        $condition="";
        $lists=$this->ProductType->findAll($condition);
        $lists_formated=array();
        if(is_array($lists))
        foreach($lists as $k => $v){
            $lists_formated[$k]['ProductType']['name']='';
            foreach($v['ProductTypeI18n']as $key => $val){
                if($val['locale']==$this->locale){
                    $lists_formated[$k]['ProductType']['name']=$val['name'];
                }
                $lists_formated[$k]['ProductType']['id']=$val['type_id'];
            }
        }
        $lst="";
        foreach($lists_formated as $k => $v){
            $lst .= "<option value=".$v['ProductType']['id']."";
            $lst .= ($selected==$v['ProductType']['id']) ? ' selected="true"' : '';
            $lst .= '>'.htmlspecialchars($v['ProductType']['name']).'</option>';
        }
        return $lst;
    }
    /**
     * 取得通用属性和某分类的属性，以及某商品的属性值
     * @param   int     $cat_id     分类编号
     * @param   int     $products_id   商品编号
     * @return  array   规格与属性列表
     */
    function build_attr_html($cat_id,$product_id=0){
        $attr=$this->requestAction("/attributes/get_attr_list/".$cat_id."/".$product_id."");
        $html='<table  width="100%" id="attrTable">';
        //pr($attr);
        $spec=0;
        foreach($attr AS $key => $val){
            $html .= "<tr><td style='width:120px;'>";
            if($val['ProductTypeAttribute']['attr_type']=="1"){
                $html .= ($spec!=$val['ProductTypeAttribute']['id']) ? "<a href='javascript:;' onclick='addSpec(this)'>[+]</a>": "<a href='javascript:;' onclick='removeSpec(this)'>[-]</a>";
                $spec=$val['ProductTypeAttribute']['id'];
            }
            $html .= $val['ProductTypeAttributeI18n']['name']."</td><td><input  type='hidden' name='attr_id_list[]' value=".$val['ProductTypeAttribute']['id']." />";
            if($val['ProductTypeAttribute']['attr_input_type']=="0"){
                $html .= '<input style="width:355px;height:60px;border:1px solid #649776;overflow-y:scroll" name="attr_value_list[]" type="text" value="'.$val['ProductAttribute']['product_type_attribute_value'].'"  /> ';
            }
            elseif($val['ProductTypeAttribute']['attr_input_type']=="2"){
                $html .= '<textarea style="width:355px;height:60px;border:1px solid #649776;overflow-y:scroll" name="attr_value_list[]" >'.$val['ProductAttribute']['product_type_attribute_value'].'</textarea>';
            }
            else{
                $html .= '<select name="attr_value_list[]" style="width:355px;">';
                $html .= '<option value="">请选择</option>';
                //pr($val);
                if(isset($val['ProductTypeAttribute']['attr_value'])){
                    $attr_values=explode("\n",$val['ProductTypeAttribute']['attr_value']);
                    //  pr($attr_values);
                    foreach($attr_values AS $opt){
                        $opt=trim($opt);
                        $html .= ($val['ProductAttribute']['product_type_attribute_value']!=$opt) ? '<option value="'.$opt.'">'.$opt.'</option>': '<option value="'.$opt.'" selected="selected">'.$opt.'</option>';
                    }
                }
                $html .= '</select> ';
            }
            $html .= "<span style='display:none'>";
            $html .= ($val['ProductTypeAttribute']['attr_type']=="1") ? '属性价格<input style="border:1px solid #649776;overflow-y:scroll" type="text" name="attr_price_list[]" value="'.$val['ProductAttribute']['product_type_attribute_price'].'" size="2" maxlength="10" />': ' <input type="hidden" name="attr_price_list[]" value="0" />';
            $html .= '</span>';
            $html .= '</td></tr>';
        }
        $html .= '</table>';
        return $html;
    }
    //取得商品关联商品
    function get_linked_products($product_id){
        $product_relations=$this->ProductRelation->findAll("ProductRelation.product_id = '".$product_id."'","","ProductRelation.orderby desc");
        $res=$this->Product->find("all");
        foreach($res as $k => $v){
            $products[$v['Product']['id']]=$v;
        }
        foreach($product_relations as $k => $v){
            if(is_array(@$products[$v['ProductRelation']['related_product_id']])){
                $product_relations[$k]['Product']=$products[$v['ProductRelation']['related_product_id']]['Product'];
                $product_relations[$k]['Product']['name']='';
                if(isset($products[$v['ProductRelation']['related_product_id']]['ProductI18n']) && is_array($products[$v['ProductRelation']['related_product_id']]['ProductI18n'])){
                    $product_relations[$k]['Product']['name']=$products[$v['ProductRelation']['related_product_id']]['ProductI18n']['name'];
                }
                $product_relations[$k]['ProductI18n']=$products[$v['ProductRelation']['related_product_id']]['ProductI18n'];
            }
            $linked_type=$v['ProductRelation']['is_double']==0 ? '单项关联' : '双向关联';
            $product_relations[$k]['ProductI18n']['name']=@$product_relations[$k]['ProductI18n']['name']." -- [$linked_type]";
            $product_relations[$k]['Product']['name']=@$product_relations[$k]['Product']['name']." -- [$linked_type]";
        }
        return $product_relations;
    }
    //取得专题关联商品
    function get_linked_topic_products($topic_id){
        $this->Product->set_locale($this->locale);
        if(!empty($topic_id)){
            $wh["TopicProduct.topic_id"]=$topic_id;
        }
        $topic_products=$this->TopicProduct->findAll($wh,"","TopicProduct.orderby desc");
        $res=$this->Product->findAll();
        foreach($res as $k => $v){
            $products[$v['Product']['id']]=$v;
        }
        foreach($topic_products as $k => $v){
            if(is_array($products[$v['TopicProduct']['product_id']])){
                $topic_products[$k]['Product']=$products[$v['TopicProduct']['product_id']]['Product'];
                $topic_products[$k]['Product']['name']='';
                if(isset($products[$v['TopicProduct']['product_id']]['ProductI18n']) && is_array($products[$v['TopicProduct']['product_id']]['ProductI18n'])){
                    $topic_products[$k]['Product']['name']=$products[$v['TopicProduct']['product_id']]['ProductI18n']['name'];
                    $topic_products[$k]['Product']['name']=$products[$v['TopicProduct']['product_id']]['Product']['code']."  ".$topic_products[$k]['Product']['name'];
                }
                $topic_products[$k]['ProductI18n']=$products[$v['TopicProduct']['product_id']]['ProductI18n'];
            }
            //$linked_type = $v['TopicProduct']['is_double'] == 0 ? '单项关联' : '双向关联';
            $topic_products[$k]['ProductI18n']['name']=$topic_products[$k]['ProductI18n']['name'];
        }
        //	pr($topic_products);
        return $topic_products;
    }
    //取得商品关联商品文章
    function get_products_articles($product_id){
        $this->Article->set_locale($this->locale);
        $product_articles=$this->ProductArticle->findAll("ProductArticle.product_id = '".$product_id."'","","ProductArticle.orderby desc");
        $res=$this->Article->findAll();
        foreach($res as $k => $v){
            $articles[$v['Article']['id']]['Article']=$v['Article'];
            $articles[$v['Article']['id']]['ArticleI18n']=$v['ArticleI18n'];
        }
        //pr($articles);
        foreach($product_articles as $k => $v){
            $product_articles[$k]['Article']['title']='';
            if(isset($articles[$v['ProductArticle']['article_id']]) && is_array($articles[$v['ProductArticle']['article_id']])){
                $product_articles[$k]['Article']=$articles[$v['ProductArticle']['article_id']]['Article'];
                $product_articles[$k]['ArticleI18n']=$articles[$v['ProductArticle']['article_id']]['ArticleI18n'];
                $linked_type=$v['ProductArticle']['is_double']==0 ? '单项关联' : '双向关联';
                $product_articles[$k]['Article']['title']=$product_articles[$k]['ArticleI18n']['title']." -- [$linked_type]";
            }
            else{
                $product_articles[$k]['Article']['title']='';
            }
        }
        //	pr($product_articles);
        return $product_articles;
    }
    //取得文章关联商品
    function get_articles_products($article_id){
        //$this->ProductArticle->set_locale($this->locale);
        $this->Product->set_locale($this->locale);
        $product_articles=$this->ProductArticle->findAll("ProductArticle.article_id = '".$article_id."'","","ProductArticle.orderby desc");
        $res=$this->Product->findAll();
        foreach($res as $k => $v){
            $products[$v['Product']['id']]['Product']=$v['Product'];
            $products[$v['Product']['id']]['ProductI18n']=$v['ProductI18n'];
            $products[$v['Product']['id']]['Product']['name']=$products[$v['Product']['id']]['ProductI18n']['name'];
        }
        foreach($product_articles as $k => $v){
            $product_articles[$k]['Product']['name']='';
            if(isset($products[$v['ProductArticle']['product_id']]) && is_array($products[$v['ProductArticle']['product_id']])){
                $product_articles[$k]['Product']=$products[$v['ProductArticle']['product_id']]['Product'];
                $product_articles[$k]['ProductI18n']=$products[$v['ProductArticle']['product_id']]['ProductI18n'];
                $linked_type=$v['ProductArticle']['is_double']==0 ? '单项关联' : '双向关联';
                $product_articles[$k]['ProductI18n']['name']=$product_articles[$k]['ProductI18n']['name']." -- [$linked_type]";
            }
            else{
                $product_articles[$k]['Product']['name']='';
            }
        }
        //pr($product_articles);
        return $product_articles;
    }
    /*********发送邮件   ***********/
    function send_email($to_email,$template,$fromName,$subject){
        $this->MailTemplate->set_locale($this->locale);
        $template=$this->MailTemplate->find("code = '$template' and status = '1'");
        $this->Email->sendAs='html';
        $this->Email->is_ssl=$this->configs['smtp_ssl'];
		$this->Email->is_mail_smtp=$this->configs['mail_service'];
        $this->Email->smtp_port=$this->configs['smtp_port'];
        $this->Email->smtpHostNames="".$this->configs['smtp_host']."";
        $this->Email->smtpUserName="".$this->configs['smtp_user']."";
        $this->Email->smtpPassword="".$this->configs['smtp_pass']."";
        $this->Email->fromName=$fromName;
        eval("\$subject = \"$subject\";");
        $this->Email->subject="=?utf-8?B?".base64_encode($subject)."?=";
        $this->Email->from="".$this->configs['smtp_user']."";
        /* 商店网址 */
        $shop_url=$this->server_host.$this->cart_webroot;
        $template_str=$template['MailTemplateI18n']['html_body'];
        eval("\$template_str = \"$template_str\";");
        $this->Email->html_body=$template_str;
        $text_body=$template['MailTemplateI18n']['text_body'];
        eval("\$text_body = \"$text_body\";");
        $this->Email->text_body=$text_body;
        $this->Email->to="".$to_email."";
        $this->Email->send();
        return true;
    }
    /**
     * 加密函数
     * @param   string  $str    加密前的字符串
     * @param   string  $key    密钥
     * @return  string  加密后的字符串
     */
    function encrypt($str,$key=AUTH_KEY){
        $coded='';
        $keylength=strlen($key);
        for($i=0,$count=strlen($str);$i < $count;$i += $keylength){
            $coded .= substr($str,$i,$keylength) ^ $key;
        }
        return str_replace('=','',base64_encode($coded));
    }
    /**
     * 解密函数
     * @param   string  $str    加密后的字符串
     * @param   string  $key    密钥
     * @return  string  加密前的字符串
     */
    function decrypt($str,$key=AUTH_KEY){
        $coded='';
        $keylength=strlen($key);
        $str=base64_decode($str);
        for($i=0,$count=strlen($str);$i < $count;$i += $keylength){
            $coded .= substr($str,$i,$keylength) ^ $key;
        }
        return $coded;
    }
}
?>