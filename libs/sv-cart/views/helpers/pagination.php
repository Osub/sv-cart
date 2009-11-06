<?php  
/*****************************************************************************
 * SV-Cart 分页
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: pagination.php 4078 2009-09-04 11:42:15Z huangbo $
*****************************************************************************/
class PaginationHelper extends Helper  
{ 
    var $ajaxLinkOptions = array(); 
    var $style = 'html'; 
    var $paramStyle = 'get'; 
    var $_pageDetails = Array(); 
    var $helpers = Array("Html","Ajax"); 
    function setPaging($paging) 
    { 
        if (empty($paging)) {return false;} 
        $this->_pageDetails = $paging; 
        $this->_pageDetails['previousPage'] = ($paging['page']>1) ? $this->_pageDetails['page']-1 : ''; 
        $this->_pageDetails['nextPage'] = ($paging['page'] < $this->_pageDetails['pageCount']) ? $this->_pageDetails['page']+1 : ''; 

        $this->url = $this->_pageDetails['url']; 
         
        $getParams = $this->params['url']; 
        unset($getParams['url']); 
        $this->getParams = $getParams; 
         
        $this->showLimits = $this->_pageDetails['showLimits']; 
        $this->style = isset($this->_pageDetails['style'])?$this->_pageDetails['style']:$this->style; 
         
        if (($this->_pageDetails['maxPages'] % 2)==0) // need odd number of page links 
        { 
            $this->_pageDetails['maxPages'] = $this->_pageDetails['maxPages']-1; 
        } 
         
        $this->maxPages = $this->_pageDetails['maxPages']; 
        $this->pageSpan = ($this->_pageDetails['maxPages']-1)/2; 
         
           return true; 
    } 
     
    function resultsPerPage($t="Results per page: ", $separator=" ",$escapeTitle=true) 
    { 
        if (empty($this->_pageDetails)) { return false; } 
        $pageDetails = $this->_pageDetails; 
        if ( !empty($pageDetails['pageCount']) ) 
        { 
            if(is_array($pageDetails['resultsPerPage'])) 
            { 
                $OriginalValue = $pageDetails['show']; 
                $t .= $separator; 
                foreach($pageDetails['resultsPerPage'] as $value) 
                { 
                    if($OriginalValue == $value) 
                    { 
                        $t .= '<strong>'.$value.'</strong>'.$separator; 
                    } 
                    else 
                    { 
                        $pageDetails['show'] = $value; 
                        $t .= $this->_generateLink($value,1,$escapeTitle,$pageDetails).$separator; 
                    } 
                } 
            } 
            return $t; 
        } 
        return false; 
    } 

    function resultsPerPageSelect($t="Results per page: ") 
    { 
        if (empty($this->_pageDetails)) { return false; } 
        if ( !empty($this->_pageDetails['pageCount']) ) 
        { 
            $Options = Array(); 
            if(is_array($this->_pageDetails['resultsPerPage'])) 
            { 
                foreach($this->_pageDetails['resultsPerPage'] as $value) 
                { 
                    $Options[$value] = $value; 
                } 
            } 
            return $t.$this->Html->selectTag("pagination/show", $Options, $this->_pageDetails['show'], NULL, NULL,FALSE); 
        } 
        return false; 
    } 

    function result($t="Results: ",$of=" of ",$inbetween="-") 
    { 
        if (empty($this->_pageDetails)) { return false; } 
        if ( !empty($this->_pageDetails['pageCount']) ) 
        { 
            if($this->_pageDetails['pageCount'] > 1) 
            { 
                $start_row = (($this->_pageDetails['page']-1)*$this->_pageDetails['show'])+1; 
                $end_row = min ((($this->_pageDetails['page'])*$this->_pageDetails['show']),($this->_pageDetails['total'])); 
                $t = $t.$start_row.$inbetween.$end_row.$of.$this->_pageDetails['total']; 
            } 
            else 
            { 
                $t .= $this->_pageDetails['total']; 
            } 
            return $t; 
        } 
        return false; 
    } 

    function pageNumbers($separator=null,$escapeTitle=true,$spacerLower="...",$spacerUpper="...") 
    { 
        if (empty($this->_pageDetails) || $this->_pageDetails['pageCount'] == 1) { return " 1 "; } 
        $total = $this->_pageDetails['pageCount']; 
        $max = $this->maxPages; 
        $span = $this->pageSpan; 
        if ($total<$max) 
        { 
            $upperLimit = min($total,($span*2+1)); 
            $lowerLimit = 1; 
        } 
        elseif ($this->_pageDetails['page']<($span+1)) 
        { 
            $lowerLimit = 1; 
            $upperLimit = min($total,($span*2+1)); 
        } 
        elseif ($this->_pageDetails['page']>($total-$span)) 
        { 
            $upperLimit = $total; 
            $lowerLimit = max(1,$total-$span*2); 
        } 
        else 
        { 
            $upperLimit = min ($total,$this->_pageDetails['page']+$span); 
            $lowerLimit = max (1,($this->_pageDetails['page']-$span)); 
        } 
         
        $t = array(); 
        if (($lowerLimit<>1)AND($this->showLimits)) 
        { 
            $lowerLimit = $lowerLimit+1; 
            $t[] = $this->_generateLink(1,1,$escapeTitle); 
            if ($spacerLower) 
            { 
                $t[] = $spacerLower; 
            } 
        } 
        if (($upperLimit<>$total)AND($this->showLimits)) 
        { 
            $dottedUpperLimit = true; 
        } 
        else 
        { 
            $dottedUpperLimit = false; 
        } 
        if (($upperLimit<>$total)AND($this->showLimits)) 
        { 
            $upperLimit = $upperLimit-1; 
        } 
        for ($i = $lowerLimit; $i <= $upperLimit; $i++) 
        { 
             if($i == $this->_pageDetails['page']) 
             { 
                $text = '<strong>'.$i.'</strong>'; 
             } 
             else 
             { 
                $text = $this->_generateLink($i,$i,$escapeTitle); 
             } 
             $t[] = $text; 
        } 
        if ($dottedUpperLimit) 
        { 
            if ($spacerUpper) 
            { 
                $t[] = $spacerUpper; 
            } 
            $t[] = $this->_generateLink($this->_pageDetails['pageCount'],$this->_pageDetails['pageCount'],$escapeTitle); 
        } 
        $t = implode($separator, $t); 
        return $t; 
    } 

    function prevPage($text='prev',$escapeTitle=true) 
    { 
        if (empty($this->_pageDetails)) { return false; } 
        if ( !empty($this->_pageDetails['previousPage']) ) 
        { 
            return $this->_generateLink($text,$this->_pageDetails['previousPage'],$escapeTitle); 
        } 
        return $text; 
    } 
     
    function nextPage($text='next',$escapeTitle=true) 
    { 
        if (empty($this->_pageDetails)) { return false; } 
        if (!empty($this->_pageDetails['nextPage'])) 
        { 
            return $this->_generateLink($text,$this->_pageDetails['nextPage'],$escapeTitle); 
        } 
        return $text; 
    } 

    function firstPage($text='first',$escapeTitle=true) 
    { 
        if (empty($this->_pageDetails)) { return false; } 
        if ($this->_pageDetails['page']<>1) 
        { 
            return $this->_generateLink($text,1,$escapeTitle); 
        } 
        else 
        { 
            return false; 
        } 
    } 

    function lastPage($text='last',$escapeTitle=true) 
    { 
        if (empty($this->_pageDetails)) { return false; } 
        if ($this->_pageDetails['page']<>$this->_pageDetails['pageCount']) 
        { 
            return $this->_generateLink($text,$this->_pageDetails['pageCount'],$escapeTitle); 
        } 
        else 
        { 
            return false; 
        } 
    } 

    function sortBy ($value, $title=NULL, $Model=NULL,$escapeTitle=true,$upText=" ^",$downText=" v")  
    { 
        if (empty($this->_pageDetails)) { return false; } 
        $title = $title?$title:ucfirst($value); 
        $value = strtolower($value); 
        $Model = $Model?$Model:$this->_pageDetails['Defaults']['sortByClass']; 

        $OriginalSort = $this->_pageDetails['sortBy']; 
        $OriginalModel = $this->_pageDetails['sortByClass']; 
        $OriginalDirection = $this->_pageDetails['direction']; 

        if (($value==$OriginalSort)&&($Model==$OriginalModel))  
        { 
            if (up($OriginalDirection)=="DESC")  
            { 
                $this->_pageDetails['direction'] = "ASC"; 
                $title .= $upText; 
            }  
            else  
            { 
                $this->_pageDetails['direction'] = "DESC"; 
                $title .= $downText; 
            } 
        } 
        else 
        { 
            if ($Model)  
            { 
                $this->_pageDetails['sortByClass'] = $Model; 
                //echo "page details model class set to ".$this->_pageDetails['sortByClass']."<br>"; 
            } 
            else 
            { 
                $this->_pageDetails['sortByClass'] = NULL; 
            } 
            $this->_pageDetails['sortBy'] = $value; 
        } 
        $link = $this->_generateLink ($title,1,$escapeTitle); 
        $this->_pageDetails['sortBy'] = $OriginalSort; 
        $this->_pageDetails['sortByClass'] = $OriginalModel; 
        $this->_pageDetails['direction'] = $OriginalDirection; 
        return $link; 
    } 

    function sortBySelect($sortFields, $t="Sort By: ",$upText=" ^",$downText=" v") 
    { 
        if (empty($this->_pageDetails)) { return false; } 
        if ( !empty($this->_pageDetails['pageCount']) ) 
        { 
            $OriginalValue = $this->_pageDetails['sortBy']."::".$this->_pageDetails['direction']."::".$this->_pageDetails['sortByClass']; 
            if(is_array($sortFields)) 
            { 
                foreach($sortFields as $value) 
                { 
                    $Vals = Array(); 
                    $Vals = explode("::",$value); 
                    if (isset($Vals[2])) 
                    { 
                        $DisplayVal = $Vals[2]." "; 
                    } 
                    else 
                    { 
                        $DisplayVal = ""; 
                    } 
                    $DisplayVal .= $Vals[0]; 
                    if (up($Vals[1])=="ASC") 
                    { 
                        $DisplayVal .= $downText; 
                    } 
                    else 
                    { 
                        $DisplayVal .= $upText;                         
                    } 
                    $Options[$value] = $DisplayVal; 
                } 
                return $t.$this->Html->selectTag("pagination/sortByComposite", $Options, $OriginalValue, NULL, NULL,FALSE); 
            } 
        } 
        return false; 
    } 
     
    function _generateLink ($title,$page=NULL,$escapeTitle,$pageDetails = NULL)  
    { 
        $pageDetails = $pageDetails?$pageDetails:$this->_pageDetails; 
        $url = $this->_generateUrl($page,$pageDetails); 
        $AjaxDivUpdate = $pageDetails['ajaxDivUpdate']; 
        if ($this->style=="ajax") 
        { 
            $options = am($this->ajaxLinkOptions, 
                            array( 
                                "update" => $pageDetails['ajaxDivUpdate'] 
                                ) 
                            ); 
            if (isset($pageDetails['ajaxFormId'])) 
            { 
                $id = 'link' . intval(rand()); 
                $return = $this->Html->link( 
                                $title, 
                                $url, 
                                array('id' => $id, 'onclick'=>" return false;"), 
                                NULL, 
                                $escapeTitle 
                                    ); 
                $options['with'] = "Form.serialize('{$this->_pageDetails['ajaxFormId']}')"; 
                $options['url'] = $url; 
                $return .= $this->Ajax->Javascript->event("'$id'", "click", $this->Ajax->remoteFunction($options)); 
                return $return; 
            } 
            else 
            { 
                return $this->Ajax->link( 
                                $title, 
                                $url, 
                                $options, 
                                NULL, 
                                NULL, 
                                $escapeTitle 
                                    ); 
            } 
        } 
        else 
        { 
            return $this->Html->link( 
                            $title, 
                            $url, 
                            NULL, 
                            NULL, 
                            $escapeTitle 
                                ); 
        } 
    } 

    function _generateUrl ($page=NULL,$pageDetails=NULL)  
    { 
   		
        $pageDetails = $pageDetails?$pageDetails:$this->_pageDetails; 
        $getParams = $this->getParams; // Import any other pre-existing get parameters 
        if ($this->_pageDetails['paramStyle']=="pretty") 
        { 
            $pageParams=$pageDetails['importParams']; 
        } 
        $pageParams['show'] = $pageDetails['show']; 
        $pageParams['sortBy'] = $pageDetails['sortBy']; 
        $pageParams['direction'] = $pageDetails['direction']; 
        $pageParams['page'] = $page?$page:$pageDetails['page']; 
        if (isset($pageDetails['sortByClass'])) 
        { 
            $pageParams['sortByClass'] = $pageDetails['sortByClass']; 
        } 
        $getString = Array(); 
        $prettyString = Array(); 
        if ($pageDetails['paramStyle']=="get") 
        { 
            $getParams = am($getParams,$pageParams); 
        } 
        else 
        { 
            foreach($pageParams as $key => $value) 
            { 
                if (isset($pageDetails['Defaults'][$key])) 
                { 
                    if (up($pageDetails['Defaults'][$key])<>up($value)) 
                    { 
                        $prettyString[] = "$key{$pageDetails['paramSeperator']}$value"; 
                    } 
                } 
                else 
                { 
                    $prettyString[] = "$key{$pageDetails['paramSeperator']}$value"; 
                }             
            } 
        } 
        $page_value = '1';
        foreach($getParams as $key => $value) 
        { 
            if ($pageDetails['paramStyle']=="get") 
            { 
                if (isset($pageDetails['Defaults'][$key])) 
                { 
                    if (up($pageDetails['Defaults'][$key])<>up($value)) 
                    { 
                        $getString[] = "$key=$value"; 
                        if($key == "page"){
                        	$page_value = $value;
                        }
                    } 
                } 
                else 
                { 
                    $getString[] = "$key=$value"; 
                    if($key == "page"){
                      	$page_value = $value;
                    }                    
                } 
            } 
            else 
            { 
                $getString[] = "$key=$value"; 
                if($key == "page"){
                   	$page_value = $value;
                }                
            }             
        } 
        $url = $this->url; 
        if ($prettyString) 
        { 
            $prettyString = implode ("/", $prettyString); 
            $url .= $prettyString; 
        } 
        if ($getString) 
        { 
            $getString = implode ("&", $getString); 
            $url .= "?".$getString; 
        } 
        
        if($this->params['controller'] == 'category_articles'){
        	$display_mode_url = "/category_articles/".$this->data['to_page_id']."/".$page_value;
        }elseif($this->params['controller'] == 'articles' && $this->params['action'] == 'search'){
			$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$this->data['to_page_id']."/".$page_value."/";
        }elseif($this->params['controller'] == 'articles' && $this->params['action'] == 'category'){
			$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$this->data['to_page_id']."/".$this->data['this_locale']."/".$page_value."/";
        }elseif($this->params['controller'] == 'products' && $this->params['action'] == 'user_gallery'){
        	$display_mode_url = "/products/user_gallery/".$page_value;
        }elseif($this->params['controller'] == 'comments'){
        	$display_mode_url = "/comments/index/".$page_value;
        }elseif($this->params['controller'] == 'topics'){
        	$display_mode_url = "/topics/index/".$page_value."/".$this->data['orderby']."/".$this->data['rownum'];
        }elseif($this->params['controller'] == 'promotions'){
        	$display_mode_url = "/promotions/index/".$page_value."/".$this->data['orderby']."/".$this->data['rownum'];
        }elseif($this->params['controller'] == 'exchanges'){
        	$display_mode_url = "/exchanges/".$page_value."/".$this->data['orderby']."/".$this->data['rownum']."/".$this->data['showtype'];
        }elseif($this->params['controller'] == 'products'){
        	$display_mode_url = "/products/advancedsearch/SAD/".$this->data['to_page_id']."/".$this->data['pagination_category']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$page_value."/".$this->data['orderby']."/".$this->data['rownum']."/".$this->data['showtype'];
        }elseif($this->params['controller'] == 'categories'){
			if($this->data['configs']['use_sku'] == 1){
				if(isset($this->data['parent'])){ 
					$display_mode_url="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_parent']."/".$this->data['page_category_name']."/".$page_value."/".$this->data['orderby']."/".$this->data['rownum']."/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/";
				}else{
					$display_mode_url="/".$this->params['controller']."/".$this->data['to_page_id']."/".$this->data['page_category_name']."/0/".$page_value."/".$this->data['orderby']."/".$this->data['rownum']."/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/";
				}
			}else{
				$display_mode_url="/".$this->params['controller']."/".$this->data['to_page_id']."/0/0/".$page_value."/".$this->data['orderby']."/".$this->data['rownum']."/".$this->data['showtype']."/".$this->data['pagination_brand']."/".$this->data['price_min']."/".$this->data['price_max']."/".$this->data['page_filters']."/";
			}
		}else{
			$display_mode_url="/".$this->params['controller']."/".$this->params['action']."/".$this->data['to_page_id']."/".$page_value."/".$this->data['orderby']."/".$this->data['rownum']."/".$this->data['showtype']."/";
	    }           
	    
        $url = $display_mode_url;        
        
   //     pr($display_mode_url."--");
        
        return $url; 
    } 
} 
?>