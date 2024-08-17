<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//PERMISSION
if (!function_exists('getDatabyUser')) {
	function getDatabyUser($and = 1){
		//if(IS_ADMIN != 1){
			if($and == 1){
				return " AND uid = '".session("uid")."'";
			}else{
				return " uid = '".session("uid")."'";
			}
		//}
	}
}	

if(!function_exists('permission')){
	function permission($admin = false){
		if(IS_ADMIN != 1 && $admin == true){
			$now = strtotime(date("Y-m-d", strtotime(NOW)));
			$expiration_date = strtotime(EXPRIATION_DATE);
			if($now <= $expiration_date){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
	}
}

if(!function_exists('permission_view') ){
	function permission_view($admin = true){
		if(!permission($admin)){
			redirect(PATH."dashboard");
		}
	}
}

if(!function_exists('permission_list')){
	function permission_list($permission, $feature){
		$package = json_decode($permission);
		if(!empty($package)){
			if(isset($package->$feature) && $package->$feature == 1){
				return '<i class="fa col-light-green fa-check-circle-o" aria-hidden="true"></i>';
			}else{
				return '<i class="fa col-red fa-times-circle-o" aria-hidden="true"></i>';
			}
		}else{
			return '<i class="fa col-red fa-times-circle-o" aria-hidden="true"></i>';
		}
	}
}

if(!function_exists('check_FFMPEG')){
	function check_FFMPEG(){
	    @exec('ffmpeg -version 2>&1', $output, $returnvalue);
        if ($returnvalue === 0) {
            return 'ffmpeg';
        }
        @exec('avconv -version 2>&1', $output, $returnvalue);
        if ($returnvalue === 0) {
            return 'avconv';
        }

        return false;
	}
}

if(!function_exists('createDateRangeArray')){
	function createDateRangeArray($strDateFrom,$strDateTo)
	{
	    $aryRange=array();

	    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2), substr($strDateFrom,8,2),substr($strDateFrom,0,4));
	    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2), substr($strDateTo,8,2),substr($strDateTo,0,4));

	    if ($iDateTo>=$iDateFrom)
	    {
	        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
	        while ($iDateFrom<$iDateTo)
	        {
	            $iDateFrom+=86400; // add 24 hours
	            array_push($aryRange,date('Y-m-d',$iDateFrom));
	        }
	    }
	    return $aryRange;
	}
}

if(!function_exists('getListLang')){
	function getListLang(){
		$list_lang = scandir(APPPATH."../lang/");
		unset($list_lang[0]);
		unset($list_lang[1]);
		$data_lang = array();
		foreach ($list_lang as $lang) {
			$arr_lang = explode(".", $lang);
			if(count($arr_lang) == 2 && strlen($arr_lang[0]) == 2 && $arr_lang[1] == "xml"){
				$data_lang[] = $arr_lang[0];
			}
		}
		return $data_lang;
	}
}

if(!function_exists('setLang')){
	function setLang(){
		$list_lang = scandir(APPPATH."../lang/");
		unset($list_lang[0]);
		unset($list_lang[1]);
		$data_lang = array();
		$data_lang = array();
		foreach ($list_lang as $lang) {
			$arr_lang = explode(".", $lang);
			if(count($arr_lang) == 2 && strlen($arr_lang[0]) == 2 && $arr_lang[1] == "xml"){
				if($arr_lang[0] == get('l')){
					set_session("lang", get('l'));
					redirect(PATH);		
				}
			}
		}
	}
}

if(!function_exists('compare_day')){
	function compare_day($day1,$day2,$type = "min")
	{
	    if($day1 != ""){
	    	$day1 = strtotime(date("Y-m-d", strtotime($day1)));
		    $day2 = strtotime(date("Y-m-d", strtotime($day2)));
		    if($type == "min"){
		    	if($day1 > $day2){
			    	return true;
			    }else{
			    	return false;
			    }
		    }else{
		    	if($day1 < $day2){
			    	return true;
			    }else{
			    	return false;
			    }
		    }
	    }else{
	    	return true;
	    }
	}
}

if(!function_exists('status_post')){
	function status_post($type){
		switch ($type) {
			case 1:
				$result = '<span class="label bg-light-blue">'.l('Processing').'</span>';
				break;

			case 2:
				$result = '<span class="label bg-light-orange">'.l('Queue').'</span>';
				break;

			case 4:
				$result = '<span class="label bg-red">'.l('Failure').'</span>';
				break;

			case 5:
				$result = '<span class="label bg-purple">'.l('Repeat').'</span>';
				break;

			default:
				$result = '<span class="label bg-light-green">'.l('Complete').'</span>';
				break;

		}

		return $result;
	}
}

function listIt($path) {
	$items = scandir($path);
	$list = array();
	foreach($items as $item) {
	    // Ignore the . and .. folders
	    if($item != "." AND $item != "..") {
	        if (is_file($path . $item)) {
	            if(strpos($path . $item,  ".php") != false){
	            	require($path . $item);
	            }
	        } else {
	            listIt($path . $item . "/");
	        }
	    }
  	}

  	return false;
}

function Delete($path)
{
    if (is_dir($path) === true)
    {
        $files = array_diff(scandir($path), array('.', '..'));

        foreach ($files as $file)
        {
            Delete(realpath($path) . '/' . $file);
        }

        return rmdir($path);
    }

    else if (is_file($path) === true)
    {
        return unlink($path);
    }

    return false;
}

class Spintax
{
    public function process( $text )
    {
        return preg_replace_callback(
            '/\{(((?>[^\{\}]+)|(?R))*)\}/x',
            array( $this, 'replace' ),
            $text
        );
    }

    public function replace( $text )
    {
        $text = $this -> process( $text[1] );
        $parts = explode( '|', $text );
        return $parts[ array_rand( $parts ) ];
    }
}

if (!function_exists('l')) {
	function l($slug = ""){
		$CI =& get_instance();
		$lang = $CI->session->userdata("lang");
		$xml = simplexml_load_file(APPPATH."../lang/".LANGUAGE.".xml") or simplexml_load_file(APPPATH."../lang/en.xml");
		$text = $slug;
		foreach ($xml->lang as $key => $row) {
			if(xml_attribute($row,"slug") == $slug){
				$text = html_entity_decode(ucfirst($row->text));
			}
		}
		return $text;
	}
}

if (!function_exists('xml_attribute')) {
	function xml_attribute($object, $attribute)
	{
	    if(isset($object[$attribute]))
	        return (string) $object[$attribute];
	}
}

if(!function_exists('cn')){
	function cn($slug = ""){
		$CI =& get_instance();
		return PATH.$CI->router->fetch_class()."/".$slug;
	}
}

if(!function_exists('ms')){
	function ms($array){
		print_r(json_encode($array));
		exit(0);
	}
}

if(!function_exists('url')){
	function url($slug){
		return PATH.$slug;		
	}
}

if (!function_exists('deleteDir')) {
	function deleteDir($path){
		return is_file($path) ? @unlink($path) : array_map(__FUNCTION__, glob($path.'/*')) == @rmdir($path);
	}
}

if (!function_exists('convert_vi_to_en')) {
	function convert_vi_to_en($str) {
	  $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
	  $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
	  $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
	  $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
	  $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
	  $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
	  $str = preg_replace("/(đ)/", 'd', $str);
	  $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
	  $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
	  $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
	  $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
	  $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
	  $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
	  $str = preg_replace("/(Đ)/", 'D', $str);
	  //$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
	  return $str;
	}
}

if (!function_exists('clean')) {
	function clean($string) {
		$string = str_replace("~", "", $string);	   
		$string = str_replace("@", "", $string);	   
		$string = str_replace("#", "", $string);	   
		$string = str_replace("$", "", $string);	   
		$string = str_replace("%", "", $string);	   
		$string = str_replace("^", "", $string);	   
		$string = str_replace("&", "", $string);	   
		$string = str_replace("*", "", $string);	   
		$string = str_replace("(", "", $string);	   
		$string = str_replace(")", "", $string);	   
		$string = str_replace("{", "", $string);	   
		$string = str_replace("}", "", $string);	   
		$string = str_replace("|", "", $string);	   
		$string = str_replace("\\", "", $string);	   
		$string = str_replace(":", "", $string);	   
		$string = str_replace("\"", "", $string);	   
		$string = str_replace("'", "", $string);	   
		$string = str_replace("<", "", $string);	   
		$string = str_replace(">", "", $string);	   
		$string = str_replace(",", "", $string);	   
		$string = str_replace(".", "", $string);	   
		$string = str_replace("/", "", $string);	   
		$string = str_replace("?", "", $string);	   
		$string = str_replace("`", "", $string);	   
		return $string;
	}
}

if (!function_exists('format_number')) {
	function format_number($number = ""){
		return number_format($number, 0, ',',',');
	}
}

if (!function_exists('pr')) {
    function pr($data, $type = 0) {
        print '<pre>';
        print_r($data);
        print '</pre>';
        if ($type != 0) {
            exit();
        }
    }
}

if ( ! function_exists('CutText')){
	function CutText($text, $n=80) 
	{ 
		// string is shorter than n, return as is
		if (strlen($text) <= $n) {
			return $text;}
		$text= substr($text, 0, $n);
		if ($text[$n-1] == ' ') {
			return trim($text)."...";
		}
		$x  = explode(" ", $text);
		$sz = sizeof($x);
		if ($sz <= 1)   {
			return $text."...";}
		$x[$sz-1] = '';
		return trim(implode(" ", $x))."...";
	}
}

if ( ! function_exists('theme_color')){
	function theme_color() {
	  	$theme_color = array(
	  		"red" => "Red",
	  		"pink" => "Pink",
	  		"purple" => "Purple",
	  		"deep-purple" => "Deep purple",
	  		"blue" => "Blue",
	  		"light-blue" => "Light blue",
	  		"teal" => "Teal",
	  		"green" => "Green",
	  		"light-green" => "Light green",
	  		"amber" => "Amber",
	  		"orange" => "Orange",
	  		"deep-orange" => "Deep orange",
	  		"brown" => "Brown",
	  		"grey" => "Grey",
	  		"blue-grey" => "Blue grey",
	  		"black" => "Black",

	  	);
	  	return $theme_color;
	}
}

if ( ! function_exists('tz_list')){
	function tz_list() {
	  	$zones_array = array();
	  	$timestamp = time();
	  	foreach(timezone_identifiers_list() as $key => $zone) {
	   		date_default_timezone_set($zone);
	   		$zones_array[$key]['zone'] = $zone;
	    	$zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
	  	}
	  	return $zones_array;
	}
}

if (!function_exists('filter_input_xss')){
	function filter_input_xss($input){
        if($input)
		  $input= htmlspecialchars($input, ENT_QUOTES);
		return $input;
	}
}

if (!function_exists('segment')){
	function segment($index){
		$CI = &get_instance();
        return $CI->uri->segment($index);
	}
}

if (!function_exists('post')){
	function post($input,$check=true){
		$CI = &get_instance();
        if($check){
		  return $CI->input->post($input);
        }else{
            return $CI->input->post($input);
        }
	}
}

if (!function_exists('get')){
	function get($input){
		$CI = &get_instance();
		return $CI->input->get($input);
	}
}

if (!function_exists('session')){
	function session($input){
		$CI = &get_instance();
		return $CI->session->userdata($input);
	}
}

if (!function_exists('set_session')){
	function set_session($name,$input){
		$CI = &get_instance();
		return $CI->session->set_userdata($name,$input);
	}
}

if (!function_exists('unset_session')){
	function unset_session($name){
		$CI = &get_instance();
		return $CI->session->unset_userdata($name);
	}
}

if (!function_exists('array_flatten')) {
	function array_flatten($data) { 
	  	$it =  new RecursiveIteratorIterator(new RecursiveArrayIterator($data));
		$l = iterator_to_array($it, false);
	  	return $l;
	} 
}
?>