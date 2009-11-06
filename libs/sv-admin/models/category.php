<?php
/*****************************************************************************
 * SV-Cart 分类
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: category.php 5382 2009-10-23 03:59:18Z huangbo $
 *****************************************************************************/
class Category extends AppModel{
    var $name='Category';
    var $hasOne=array('CategoryI18n' => array('className' => 'CategoryI18n',
        'order' => '','dependent' => true,'foreignKey' => 'category_id'
    ));
    var $categories_parent_format=array();
    var $cat_navigate_format=array();
    var $all_subcat=array();
    var $allinfo=array();

    function set_locale($locale){
        $conditions=" CategoryI18n.locale = '".$locale."'";
        $this->hasOne['CategoryI18n']['conditions']=$conditions;
    }

    function tree_p($type='P',$category_id=0,$locale=''){
            $this->categories_parent_format=array();
            $this->cat_navigate_format=array();
            $this->all_subcat=array();
            $this->allinfo=array();
            $lists=$this->findall("status ='1' AND type='".$type."' ",'','orderby asc');
            $lists=$this->find('all',array('order' => 'orderby asc','fields' => array('Category.id','Category.parent_id'),'conditions' => array("status ='1' AND type='".$type."' ")));

            $lists_formated=array();
            if(is_array($lists)){
                foreach($lists as $k => $v){
                    $lists_formated[$v['Category']['id']]=$v;
                }
                $this->allinfo['assoc']=$lists_formated;
                foreach($lists as $k => $v){
                    $this->categories_parent_format[$v['Category']['parent_id']][]=$v;
                }
                $this->allinfo['tree']=$this->subcat_get(0);
                $this->allinfo['subids']=$this->all_subcat;

                return $this->allinfo;
			}
    }

    function tree($type,$locale,$id="all"){
	        $this->categories_parent_format=array();
	        $this->cat_navigate_format=array();
	        $this->all_subcat=array();
	        $this->allinfo=array();
	        $this->set_locale($locale);
	        $conditions['type =']=$type;
	        if($id!="all"){
	            $conditions['Category.id !=']=$id;
	        }
	        $categories=$this->find("all",array("conditions"=>$conditions,"fields"=>array("Category.id,Category.parent_id,Category.orderby,Category.sub_type,Category.status,CategoryI18n.name"))); 
	        //pr($categories);
	        if(is_array($categories))
	        foreach($categories as $k => $v){
	            $this->categories_parent_format[$v['Category']['parent_id']][]=$v;
	        }
	        return $this->subcat_get(0);
    }


    function subcat_get($category_id){
        $subcat=array();
        if(isset($this->categories_parent_format[$category_id]) && is_array($this->categories_parent_format[$category_id]))
        //判断parent_id = 0 的数据
        foreach($this->categories_parent_format[$category_id]as $k => $v){
            $category=$v; //parent_id 为 0 的数据
            if(isset($this->categories_parent_format[$v['Category']['id']]) && is_array($this->categories_parent_format[$v['Category']['id']])){
                $category['SubCategory']=$this->subcat_get($v['Category']['id']);
            }

            $subcat[$k]=$category;
            //	pr($subcat); //parent_id 为 0 的数据

            $this->all_subcat[$v['Category']['id']][]=$v['Category']['id'];

            if(isset($this->all_subcat[$v['Category']['parent_id']])){
                $this->all_subcat[$v['Category']['parent_id']]=array_merge($this->all_subcat[$v['Category']['parent_id']],$this->all_subcat[$v['Category']['id']]);
            }
            else{
                $this->all_subcat[$v['Category']['parent_id']]=$this->all_subcat[$v['Category']['id']];
            }

            //	pr($this->all_subcat);  ??
        }
        return $subcat;
    }


    function localeformat($id){
        $lists=$this->find("all",array("conditions"=>array("Category.id"=>$id)));
        //	pr($lists);
        foreach($lists as $k => $v){
            $lists_formated['Category']=$v['Category'];
            $lists_formated['CategoryI18n'][]=$v['CategoryI18n'];
            foreach($lists_formated['CategoryI18n']as $key => $val){
                $lists_formated['CategoryI18n'][$val['locale']]=$val;
            }
        }
        //	pr($lists_formated);
        return $lists_formated;
    }



    function findAssocs($type){

        $conditions=" type='".$type."'";
        $categories=$this->find("all",array("conditions"=>$conditions,"fields"=>array("Category.id,Category.parent_id,CategoryI18n.name")));
        if(is_array($categories)){
            $data=array();
            foreach($categories as $k => $v){
                $categoryname='';
                if(is_array($v['CategoryI18n'])){
                    $categoryname=$v['CategoryI18n']['name'];

                }
                $data[$v['Category']['id']]=$categoryname;
            }
        }
        return $data;
    }
    function findAssoc($type){
        $data="";
        $conditions=" type='".$type."'";
        $categories=$this->find("all",array("conditions"=>$conditions,"fields"=>array("Category.id,Category.parent_id,CategoryI18n.name")));

        if(is_array($categories)){
            foreach($categories as $k => $v){
                $categoryname='';
                if(is_array($v['CategoryI18n'])){
                    //pr($v['CategoryI18n']);
                    //foreach( $v['CategoryI18n'] as $kci => $vci){
                    $categoryname=$v['CategoryI18n']['name'];

                    //}
                }
				$str = $v['Category']['parent_id']>0?"|----":"|--";
                $data[$v['Category']['id']]=$str.$categoryname;
                for($i=0;$i <= $v['Category']['parent_id']-1;$i++){
                    $data[$v['Category']['id']]=$data[$v['Category']['id']];
                }
            }
        }
        return $data;
    }
    function getbrandformat(){
        $condition=" Category.type = 'A'";
        $lists=$this->find("all",array("conditions"=>$condition,"fields"=>array("Category.id,Category.parent_id,CategoryI18n.name")));
        $lists_formated=array();
        if(is_array($lists))
        foreach($lists as $k => $v){
            $this->categories_parent_format[$v['Category']['parent_id']][]=$v;
        }
        return $this->subcat_get(0);
    }



	//leo20090929
	function get_categories_tree($type,$locale){
	        $this->categories_parent_format=array();
	        $this->set_locale($locale);
	        $condition['type =']=$type;
	        $categories=$this->find("all",array("conditions"=>$condition,"fields"=>array("Category.id,Category.parent_id,CategoryI18n.name")));
	        if(is_array($categories))
	        foreach($categories as $k => $v){
	            $this->categories_parent_format[$v['Category']['parent_id']][]=$v;
	        }
	        return $this->subcat_get(0);
	}
}

?>