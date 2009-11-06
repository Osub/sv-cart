<?php
/*****************************************************************************
 * SV-Cart 图片批量处理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: votes_controller.php 3179 2009-07-22 05:09:18Z zhengli $
*****************************************************************************/
class ProductImageBatchsController extends AppController {

	var $name = 'ProductImageBatchs';
    var $components=array('Pagination','RequestHandler');
    var $helpers=array('Pagination','Html','Form','Javascript');
    var $uses=array("Product","ProductGallery");
    
    function index($product_code_value="all",$keywords_value="all",$all_up_img=""){
        $this->pageTitle="商品图片批量处理-商品图片批量处理"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'产品管理','url'=>'');
        $this->navigations[]=array('name' => '商品图片批量处理','url' => '');
        $this->navigations[]=array('name' => '下载图片到服务器','url' => '');
    	$this->set('navigations',$this->navigations);
        $this->Product->hasMany = array();
		$this->Product->hasOne = array('ProductI18n'=>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 )
                 	   ); //

		$condition = "";
		$condition["and"]["img_thumb like"] = "%http://%";
        if(isset($keywords_value) && $keywords_value!='all'){
            $keywords=$keywords_value;
            $condition["and"]["or"]["Product.code like"] = "%$keywords%";
            $condition["and"]["or"]["ProductI18n.name like"] = "%$keywords%";
            $condition["and"]["or"]["ProductI18n.description like"] = "%$keywords%";
            $condition["and"]["or"]["Product.id like"] = "%$keywords%";
        }
        if(isset($product_code_value) && $product_code_value!='all'){
        	$condition["and"]["or"]["Product.code like"] = "%$product_code_value%";
		} 
	 	$fields[]="Product.id";
        $fields[]="Product.code";
        $fields[]="ProductI18n.name"; 
        $fields[]="Product.img_thumb"; 
        $this->Product->set_locale($this->locale);
        
        $total=$this->Product->findCount($condition,0);
        $sortClass='Product';
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=Array($rownum,$page);
        $options=Array();
        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
    	$product_data = $this->Product->find("all",array("conditions"=>$condition,"fields"=>$fields,"limit"=>$rownum,"page"=>$page));
    	
    	
    	$this->set( "product_data",$product_data );
    	$this->set( "product_code",$product_code_value=="all"?"":$product_code_value );
    	$this->set( "keywords",$keywords_value=="all"?"":$keywords_value );
    	$this->set( "status_update",$keywords_value=="all"?"":$keywords_value );
    	$this->set( "all_up_img",$all_up_img=="all"?"all":$all_up_img );
    }
    function this_img_update($product_code_value="all",$keywords_value="all",$all_up_img=""){
        $this->pageTitle="商品图片批量处理-商品图片批量处理"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'产品管理','url'=>'');
        $this->navigations[]=array('name' => '商品图片批量处理','url' => '');
        $this->navigations[]=array('name' => '缩略图重新生成','url' => '');
    	$this->set('navigations',$this->navigations);
        $this->Product->hasMany = array();
		$this->Product->hasOne = array('ProductI18n'=>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 )
                 	   ); //

		$condition = "";
		$condition["and"]["img_thumb not like"] = "%http://%";
        if(isset($keywords_value) && $keywords_value!='all'){
            $keywords=$keywords_value;
            $condition["and"]["or"]["Product.code like"] = "%$keywords%";
            $condition["and"]["or"]["ProductI18n.name like"] = "%$keywords%";
            $condition["and"]["or"]["ProductI18n.description like"] = "%$keywords%";
            $condition["and"]["or"]["Product.id like"] = "%$keywords%";
        }
        if(isset($product_code_value) && $product_code_value!='all'){
        	$condition["and"]["or"]["Product.code like"] = "%$product_code_value%";
		} 
	 	$fields[]="Product.id";
        $fields[]="Product.code";
        $fields[]="ProductI18n.name"; 
        $fields[]="Product.img_thumb"; 
        $this->Product->set_locale($this->locale);
        
        $total=$this->Product->findCount($condition,0);
        $sortClass='Product';
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=Array($rownum,$page);
        $options=Array();
        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
    	$product_data = $this->Product->find("all",array("conditions"=>$condition,"fields"=>$fields,"limit"=>$rownum,"page"=>$page));
    	
    	$this->set( "product_data",$product_data );
    	$this->set( "pagetotal",ceil($total/$rownum) );
    	$this->set( "thispage",$page);
    	$this->set( "product_code",$product_code_value=="all"?"":$product_code_value );
    	$this->set( "keywords",$keywords_value=="all"?"":$keywords_value );
    	$this->set( "status_update",$keywords_value=="all"?"":$keywords_value );
    	$this->set( "all_up_img",$all_up_img=="all"?"all":$all_up_img );

    }
    function update_img($product_id_str=""){
    	set_time_limit(36000000);
        $this->Product->hasOne = array();
		$this->Product->hasMany = array();
		$condition = "";
		$condition["img_thumb like"] = "%http://%";
		if($product_id_str!=""){
			$product_id_arr = explode("-",$product_id_str);
			$condition["product_id"] = $product_id_arr;
		}
		$fields[]="id";
		$fields[]="product_id";
		$fields[]="img_thumb";
		$this->ProductGallery->hasMany=array();
        $this->Product->hasOne = array();
		$this->Product->hasMany = array();
		$product_gallery_data = $this->ProductGallery->find("all",array("conditions"=>$condition,"fields"=>$fields));
		foreach( $product_gallery_data as $k=>$v ){
			$condition = "";
			$condition["id"] = $v["ProductGallery"]["product_id"];
			$fields="";
			$fields[]="img_thumb";
			$fields[]="code";
			$product_code_info = $this->Product->find("first",array("conditions"=>$condition,"fields"=>$fields));
			$v["ProductGallery"]["code"] = $product_code_info["Product"]["code"];
			if(empty($product_code_info)){
				//商品不存在时删除图片
				$this->ProductGallery->del($v["ProductGallery"]["id"]);
				continue;
			}
			else{
				
			}

			//判断图片是否存在||
			if(!$fp=@fopen($v["ProductGallery"]["img_thumb"],"r")){
				//文件不存在时
				$this->ProductGallery->del($v["ProductGallery"]["id"]);
				continue;
			}
			else{
				
				
			}
			//缩略图地址
			$thumb = "../img/products/".$v["ProductGallery"]["code"]."/";
			//原图地址
			$img_original= "../img/products/".$v["ProductGallery"]["code"]."/original/";
			//详细图 中图地址
			$img_detail= "../img/products/".$v["ProductGallery"]["code"]."/detail/";
			
			//创建相应目录
			if(!is_dir($thumb)){
				mkdir($thumb, 0777);
				@chmod($thumb, 0777);
			}
			if(!is_dir($img_original)){
				mkdir($img_original, 0777);
				@chmod($img_original, 0777);
			}
			if(!is_dir($img_detail)){
				mkdir($img_detail, 0777);
				@chmod($img_detail, 0777);
			}
			//列表缩略图宽度
			$thumbl_image_width = $this->configs['thumbl_image_width'];
			//列表缩略图高度
			$thumb_image_height = $this->configs['thumb_image_height'];
			//中图宽度
			$image_width = $this->configs['image_width'];
			//中图高度
			$image_height = $this->configs['image_height'];
			//是否加水印
			$is_watermark = $this->configs['is_watermark'];
			//取水印位置$this->configs
			$watermark_location = $this->configs['watermark_location'];
			//取水印文件
			$watermark_file = $this->configs['watermark_file'];
		 	$WaterMark_img_address = substr($_SERVER["DOCUMENT_ROOT"],0, -1).trim($watermark_file);//水印文件
			//取水印透明度
			$watermark_transparency = $this->configs['watermark_transparency'];
			
			
			//开始抓图
			$ext=strrchr($v["ProductGallery"]["img_thumb"],".");
			$md5_name = substr(md5($_SESSION['Operator_Info']['Operator']['id']),-3).substr(md5(time()),-3).substr(time(),-3);
			$img_thumb_watermark_name=$md5_name.$ext;
			$img_original = "../img/products/".$v["ProductGallery"]["code"]."/original/".$img_thumb_watermark_name;//保存原图地址
			$filename = $this->GrabImage($v["ProductGallery"]["img_thumb"],$img_original);//返回保存在本地的图片名称
			$imgname_arr = explode(".",$img_thumb_watermark_name);
			//商品缩略图
			$image_name	= $this->make_thumb($img_original,$thumbl_image_width,$thumb_image_height,"#FFFFFF",$img_thumb_watermark_name,$thumb,"");
	 		$image_name	= $this->make_thumb($img_original,$image_width,$image_height,"#FFFFFF",$img_thumb_watermark_name,$img_detail,"");
			//水印
			if( $is_watermark == 1){
				$this->imageWaterMark($img_detail.$image_name,$watermark_location,$WaterMark_img_address,$watermark_transparency);
				$this->imageWaterMark($img_original,$watermark_location,$WaterMark_img_address,$watermark_transparency);
				$this->imageWaterMark($thumb.$image_name,$watermark_location,$WaterMark_img_address,$watermark_transparency);
			}
			
			$update_gallery_img = array(
				"id" => $v["ProductGallery"]["id"],
				"img_thumb" => "/img/products/".$v["ProductGallery"]["code"]."/".$img_thumb_watermark_name,
				"img_detail" => "/img/products/".$v["ProductGallery"]["code"]."/detail/".$img_thumb_watermark_name,
				"img_original" => "/img/products/".$v["ProductGallery"]["code"]."/original/".$img_thumb_watermark_name,
			);
			$this->ProductGallery->save(array("ProductGallery"=>$update_gallery_img));
			//更新默认商品图
			$img_thumb_explode_addr=explode("http://",$product_code_info["Product"]["img_thumb"]);  
			if((count($img_thumb_explode_addr)>1)){
				$update_img = array(
					"id" => $v["ProductGallery"]["product_id"],
					"img_thumb" => "/img/products/".$v["ProductGallery"]["code"]."/".$img_thumb_watermark_name,
					"img_detail" => "/img/products/".$v["ProductGallery"]["code"]."/detail/".$img_thumb_watermark_name,
					"img_original" => "/img/products/".$v["ProductGallery"]["code"]."/original/".$img_thumb_watermark_name,
				);
				$this->Product->save(array("Product"=>$update_img));
			}
		}
        Configure::write('debug',0);
        $result['msg']="商品图片批量更新到服务器";
        die(json_encode($result));
	}
    function this_update_img_thumb($product_id_str=""){
    	set_time_limit(36000000);
        $this->Product->hasOne = array();
		$this->Product->hasMany = array();
		$condition = "";
		$condition["img_thumb not like"] = "%http://%";
		if($product_id_str!=""){
			$product_id_arr = explode("-",$product_id_str);
			$condition["product_id"] = $product_id_arr;
		}
		$fields[]="id";
		$fields[]="product_id";
		$fields[]="img_thumb";
		$fields[]="img_detail";
		$fields[]="img_original";
		$this->ProductGallery->hasMany=array();
        $this->Product->hasOne = array();
		$this->Product->hasMany = array();
		$product_gallery_data = $this->ProductGallery->find("all",array("conditions"=>$condition,"fields"=>$fields));
		
		foreach( $product_gallery_data as $k=>$v ){
			$condition = "";
			$condition["id"] = $v["ProductGallery"]["product_id"];
			$fields="";
			$fields[]="img_thumb";
			$fields[]="code";
			$product_code_info = $this->Product->find("first",array("conditions"=>$condition,"fields"=>$fields));
			$v["ProductGallery"]["code"] = $product_code_info["Product"]["code"];
			//缩略图地址
			$thumb = "../img/products/".$v["ProductGallery"]["code"]."/";
			//原图地址
			$img_original= "../img/products/".$v["ProductGallery"]["code"]."/original/";
			//详细图 中图地址
			$img_detail= "../img/products/".$v["ProductGallery"]["code"]."/detail/";
			
			//创建相应目录
			if(!is_dir($thumb)){
				mkdir($thumb, 0777);
				@chmod($thumb, 0777);
			}
			if(!is_dir($img_original)){
				mkdir($img_original, 0777);
				@chmod($img_original, 0777);
			}
			if(!is_dir($img_detail)){
				mkdir($img_detail, 0777);
				@chmod($img_detail, 0777);
			}
			//列表缩略图宽度
			$thumbl_image_width = $this->configs['thumbl_image_width'];
			//列表缩略图高度
			$thumb_image_height = $this->configs['thumb_image_height'];
			//中图宽度
			$image_width = $this->configs['image_width'];
			//中图高度
			$image_height = $this->configs['image_height'];
			//是否加水印
			$is_watermark = $this->configs['is_watermark'];
			//取水印位置$this->configs
			$watermark_location = $this->configs['watermark_location'];
			//取水印文件
			$watermark_file = $this->configs['watermark_file'];
		 	$WaterMark_img_address = substr($_SERVER["DOCUMENT_ROOT"],0, -1).trim($watermark_file);//水印文件
			//取水印透明度
			$watermark_transparency = $this->configs['watermark_transparency'];
			
			
			//开始抓图
			$ext=strrchr($v["ProductGallery"]["img_thumb"],".");
			$md5_name = substr(md5($_SESSION['Operator_Info']['Operator']['id']),-3).substr(md5(time()),-3).substr(time(),-3);
			$img_thumb_watermark_name=$md5_name.$ext;
			$img_original = "../img/products/".$v["ProductGallery"]["code"]."/original/".$img_thumb_watermark_name;//保存原图地址
			$file = $v["ProductGallery"]["img_original"];
			if(file_exists("..".$file)){
				copy("..".$file, $img_original);
			}else{
				
				$this->ProductGallery->del($v["ProductGallery"]["id"]);
				continue;
			}
			$imgname_arr = explode(".",$img_thumb_watermark_name);
			//商品缩略图
			$image_name	= $this->make_thumb($img_original,$thumbl_image_width,$thumb_image_height,"#FFFFFF",$img_thumb_watermark_name,$thumb,"");
	 		$image_name	= $this->make_thumb($img_original,$image_width,$image_height,"#FFFFFF",$img_thumb_watermark_name,$img_detail,"");
			//水印
			if( $is_watermark == 1){
				$this->imageWaterMark($img_detail.$image_name,$watermark_location,$WaterMark_img_address,$watermark_transparency);
				$this->imageWaterMark($img_original,$watermark_location,$WaterMark_img_address,$watermark_transparency);
				$this->imageWaterMark($thumb.$image_name,$watermark_location,$WaterMark_img_address,$watermark_transparency);
			}
			
			$update_gallery_img = array(
				"id" => $v["ProductGallery"]["id"],
				"img_thumb" => "/img/products/".$v["ProductGallery"]["code"]."/".$img_thumb_watermark_name,
				"img_detail" => "/img/products/".$v["ProductGallery"]["code"]."/detail/".$img_thumb_watermark_name,
				"img_original" => "/img/products/".$v["ProductGallery"]["code"]."/original/".$img_thumb_watermark_name,
			);
			$this->ProductGallery->save(array("ProductGallery"=>$update_gallery_img));
			//更新默认商品图

				$update_img = array(
					"id" => $v["ProductGallery"]["product_id"],
					"img_thumb" => "/img/products/".$v["ProductGallery"]["code"]."/".$img_thumb_watermark_name,
					"img_detail" => "/img/products/".$v["ProductGallery"]["code"]."/detail/".$img_thumb_watermark_name,
					"img_original" => "/img/products/".$v["ProductGallery"]["code"]."/original/".$img_thumb_watermark_name,
				);
				$this->Product->save(array("Product"=>$update_img));
		
		}
        Configure::write('debug',0);
        $result['msg']="商品图片批量更新到服务器";
        die(json_encode($result));
	}

	//取外网图片
	function GrabImage($url,$filename="") {
		if($url==""):return false;endif;
		if($filename=="") {
			$ext=strrchr($url,".");
			$filename=substr(md5($_SESSION['Operator_Info']['Operator']['id']),-3).substr(md5(time()),-3).substr(date("dMYHis"),-3).$ext;
		}
		ob_start();
		readfile($url);
		$img = ob_get_contents();
		ob_end_clean();
		$size = strlen($img);
		$fp2=@fopen($filename, "a");
		fwrite($fp2,$img);
		fclose($fp2);
		return $filename;
	}
	/**
	* 创建图片的缩略图
	*
	* @param   string      $img    原始图片的路径
	* @param   int         $thumb_width  缩略图宽度
	* @param   int         $thumb_height 缩略图高度
	* @param   int         $filename 	 图片名..
	* @param   strint      $dir         指定生成图片的目录名
	* @return  mix         如果成功返回缩略图的路径，失败则返回false
	*/
	function make_thumb($img, $thumb_width = 0, $thumb_height = 0, $bgcolor='#FFFFFF',$filename,$dir,$imgname){
		//echo $filename;
		/* 检查缩略图宽度和高度是否合法 */
		if ($thumb_width == 0 && $thumb_height == 0){
			return false;
		}
		/* 检查原始文件是否存在及获得原始文件的信息 */
		$org_info = @getimagesize($img);
		if (!$org_info){
			return false;
		}
		
		$img_org = $this->img_resource($img, $org_info[2]);
		/* 原始图片以及缩略图的尺寸比例 */
		$scale_org = $org_info[0] / $org_info[1];
		/* 处理只有缩略图宽和高有一个为0的情况，这时背景和缩略图一样大 */
		if ($thumb_width == 0){
			$thumb_width = $thumb_height * $scale_org;
		}
		if ($thumb_height == 0){
			$thumb_height = $thumb_width / $scale_org;
		}

		/* 创建缩略图的标志符 */
		$img_thumb  = @imagecreatetruecolor($thumb_width, $thumb_height);//真彩

		/* 背景颜色 */
		if (empty($bgcolor)){
			$bgcolor = $bgcolor;
		}
		$bgcolor = trim($bgcolor,"#");
		sscanf($bgcolor, "%2x%2x%2x", $red, $green, $blue);
		$clr = imagecolorallocate($img_thumb, $red, $green, $blue);
		imagefilledrectangle($img_thumb, 0, 0, $thumb_width, $thumb_height, $clr);
		if ($org_info[0] / $thumb_width > $org_info[1] / $thumb_height){
			$lessen_width  = $thumb_width;
			$lessen_height  = $thumb_width / $scale_org;
		}else{
			/* 原始图片比较高，则以高度为准 */
			$lessen_width  = $thumb_height * $scale_org;
			$lessen_height = $thumb_height;
		}
		$dst_x = ($thumb_width  - $lessen_width)  / 2;
		$dst_y = ($thumb_height - $lessen_height) / 2;
		
		/* 将原始图片进行缩放处理 */
		imagecopyresampled($img_thumb, $img_org, $dst_x, $dst_y, 0, 0, $lessen_width, $lessen_height, $org_info[0], $org_info[1]);

		
		/* 生成文件 */
		if (function_exists('imagejpeg')){
			$filename .= ".".$imgname;
			imagejpeg($img_thumb, $dir . $filename,90);
		}elseif (function_exists('imagegif')){
			$filename .= ".".imgname;
			imagegif($img_thumb, $dir . $filename,90);
		}elseif (function_exists('imagepng')){
			$filename .= ".".$imgname;
			imagepng($img_thumb, $dir . $filename,90);
		}else{
			return false;
		}
		imagedestroy($img_thumb);
		imagedestroy($img_org);

		//确认文件是否生成
		if (file_exists($dir . $filename)){
			return  $filename;
		}else{
			return false;
		}
	}
	/*
	* 参数：
	*       $groundImage     	要加水印的图片
	*       $waterPos        	水印位置		0为随机位置；
	*                       	1为顶端居左，	2为顶端居中，	3为顶端居右；
	*                       	4为中部居左，	5为中部居中，	6为中部居右；
	*                       	7为底端居左，	8为底端居中，	9为底端居右；
	*       $waterImage      	图片水印
	*		$watermark_alpha	图片水印透明度
	*       $waterText       	文字水印
	*       $fontSize        	文字大小
	*       $textColor       	文字颜色
	*       $fontfile        	windows字体文件
	*       $xOffset         	水平偏移量，即在默认水印坐标值基础上加上这个值，默认为0，如果给水印留
	*                       	出水平方向上的边距，可以设置这个值,如：2 则表示在默认的基础上向右移2个单位,-2 表示向左移两单位
	*       $yOffset         	垂直偏移量，即在默认水印坐标值基础上加上这个值，默认为0，如果给水印留
	*                       	出垂直方向上的边距，可以设置这个值,如：2 则表示在默认的基础上向下移2个单位,-2 表示向上移两单位
	* 返回值：
	*        0   水印成功
	*        1   水印图片格式不支持
	*        2   要水印的背景图片不存在
	*        3   需要加水印的图片的长度或宽度比水印图片或文字区域还小，无法生成水印
	*        4   字体文件不存在
	*        5   水印文字颜色格式不正确
	*        6   水印背景图片格式目前不支持
	*/
	function imageWaterMark($groundImage,$waterPos=0,$waterImage="",$watermark_alpha=50,$fontSize=44,$textColor="#6AD267",$waterText="", $fontfile='../vendors/securimage/elephant.ttf',$xOffset=0,$yOffset=0){
	
		$isWaterImage = FALSE;
		//读取水印文件
		if(!empty($waterImage) && file_exists($waterImage)){
			$isWaterImage = TRUE;
			$water_info = getimagesize($waterImage);
			$water_w     = $water_info[0];//取得水印图片的宽
			$water_h     = $water_info[1];//取得水印图片的高
			
			switch($water_info[2]){    //取得水印图片的格式  
	            case 1:$water_im = imagecreatefromgif($waterImage);break;
	            case 2:$water_im = imagecreatefromjpeg($waterImage);break;
	            case 3:$water_im = imagecreatefrompng($waterImage);break;
	            default:return 1;
	        }
	    }

	     //读取背景图片
		if(!empty($groundImage) && file_exists($groundImage)){
	        $ground_info  = getimagesize($groundImage);
	        $ground_w     = $ground_info[0];//取得背景图片的宽
	        $ground_h     = $ground_info[1];//取得背景图片的高

	        switch($ground_info[2]){    //取得背景图片的格式  
	             case 1:$ground_im = imagecreatefromgif($groundImage);break;
	             case 2:$ground_im = imagecreatefromjpeg($groundImage);break;
	             case 3:$ground_im = imagecreatefrompng($groundImage);break;
	             default:return 1;
	         }
	     }else{
			return 2;
	     }

	     //水印位置
		if($isWaterImage){ //图片水印  
	         $w = $water_w;
	         $h = $water_h;
	         $label = "图片的";
		}else{  
	     	//文字水印
	     	
			if(!file_exists($fontfile))return 4;
				$temp 	= imagettfbbox($fontSize,0,$fontfile,$waterText);//取得使用 TrueType 字体的文本的范围
				$w 		= $temp[2] - $temp[6];
				$h 		= $temp[3] - $temp[7];
				unset($temp);
	     }
	     if( ($ground_w < $w) || ($ground_h < $h) ){
	         return 3;
	     }
	     switch($waterPos) {
	         case 0://随机
	             $posX = rand(0,($ground_w - $w));
	             $posY = rand(0,($ground_h - $h));
	             break;
	         case 1://1为顶端居左
	             $posX = 0;
	             $posY = 0;
	             break;
	         case 2://2为顶端居中
	             $posX = ($ground_w - $w) / 2;
	             $posY = 0;
	             break;
	         case 3://3为顶端居右
	             $posX = $ground_w - $w;
	             $posY = 0;
	             break;
	         case 4://4为中部居左
	             $posX = 0;
	             $posY = ($ground_h - $h) / 2;
	             break;
	         case 5://5为中部居中
	             $posX = ($ground_w - $w) / 2;
	             $posY = ($ground_h - $h) / 2;
	             break;
	         case 6://6为中部居右
	             $posX = $ground_w - $w;
	             $posY = ($ground_h - $h) / 2;
	             break;
	         case 7://7为底端居左
	             $posX = 0;
	             $posY = $ground_h - $h;
	             break;
	         case 8://8为底端居中
	             $posX = ($ground_w - $w) / 2;
	             $posY = $ground_h - $h;
	             break;
	         case 9://9为底端居右
	             $posX = $ground_w - $w;
	             $posY = $ground_h - $h;
	             break;
	         default://随机
	             $posX = rand(0,($ground_w - $w));
	             $posY = rand(0,($ground_h - $h));
	             break;     
	     }

	     //设定图像的混色模式
	     imagealphablending($ground_im, true);
	     if($isWaterImage) { //图片水印
	         imagecopymerge($ground_im, $water_im, $posX + $xOffset, $posY + $yOffset, 0, 0, $water_w,$water_h, $watermark_alpha);//拷贝水印到目标文件         
	     }else{//文字水印
			if( !empty($textColor) && (strlen($textColor)==7) ) {
				$R = hexdec(substr($textColor,1,2));
				$G = hexdec(substr($textColor,3,2));
				$B = hexdec(substr($textColor,5));
	         }else{
				return 5;
	         }
	         imagettftext ( $ground_im, $fontSize, 0, $posX + $xOffset, $posY + $h + $yOffset, imagecolorallocate($ground_im, $R, $G, $B), $fontfile, $waterText);
	     }

	     //生成水印后的图片
	     
	     @unlink($groundImage);
	     switch($ground_info[2]) {//取得背景图片的格式
			case 1:imagegif($ground_im,$groundImage);break;
			case 2:imagejpeg($ground_im,$groundImage);break;
			case 3:imagepng($ground_im,$groundImage);break;
			default: return 6;
	     }

	     //释放内存
	     if(isset($water_info)) unset($water_info);
	     if(isset($water_im)) imagedestroy($water_im);
	     unset($ground_info);
	     imagedestroy($ground_im);
	     return 0;
	}
	/**
	* 根据来源文件的文件类型创建一个图像操作的标识符
	*
	* @param   string      $img_file   图片文件的路径
	* @param   string      $mime_type  图片文件的文件类型
	* @return  resource    如果成功则返回图像操作标志符，反之则返回错误代码
	*/
	function img_resource($img_file, $mime_type){
		switch ($mime_type){
			
			case 1:
			case 'image/gif':
			$res = imagecreatefromgif($img_file);
			break;
			
			case 2:
			case 'image/pjpeg':
			case 'image/jpeg':
			$res = imagecreatefromjpeg($img_file);
			break;

			case 3:
			case 'image/x-png':
			case 'image/png':
			$res = imagecreatefrompng($img_file);
			break;

			default:
			return false;
		}
		return $res;
	}
}
?>