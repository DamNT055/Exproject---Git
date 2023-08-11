<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
function get_input($name){
	return isset($_GET[$name]) ? $_GET[$name] : null;
}
function post_input($name){
	return isset($_POST[$name]) ? $_POST[$name] : null;
}
function auto_format_content($string = ''){
	$url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';   
	return preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $string);
}
function tele_push($message = false, $chat_id = "-334423290"){
	$apiToken = "625876161:AAG7nwEn094WJT8MGQqvT5nTSzlOucPOtZM";
	$message = ($message) ? $message : "Chào mọi người. Em là SEN của TGA đây ạ!";
	$data = [
		'chat_id' => $chat_id,
		'text' => $message,
		'parse_mode' => 'html'
	];
	$response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data) );
}
function clear_cache(){
	$url = 'https://tuyendung.mia.vn/api/clear-cache';
	$ch = curl_init($url); 
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	$result = curl_exec($ch);
	return $result;
}
function convert_name($str) {
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
	$str = preg_replace("/(\“|\”|\‘|\’|\,|\!|\&|\;|\@|\#|\%|\~|\`|\=|\_|\'|\]|\[|\}|\{|\)|\(|\+|\^)/", '-', $str);
	$str = preg_replace("/(  )/", ' ', $str);
	$str = preg_replace("/( - )/", '-', $str);
	$str = preg_replace("/( )/", '-', $str);
	return $str;
}
function fc_round_up($a){
	return round($a/1000) * 1000;
}
function api_url($url = ""){
	$str = "api.tga.com.vn/".$url;
	return "https://".str_replace("//","/",$str);
}
function json_url($url = ""){
	$str = "json.tga.com.vn/".$url;
	return "https://".str_replace("//","/",$str);
}
function getAPIs($url, $token = "DG9CexZ9sFmHxUQfd88NxRCrSJty"){
	$url = "https://api.tga.com.vn/".$url;
	$ch = curl_init($url);                                                                      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                     
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',
		'token: '.$token
	));
	$result = curl_exec($ch);
	return $result;
}
function format_timestamp($time = ""){
	if(!$time) return 0;
	$time = str_replace(" ", "",$time);
	$time = str_replace("-", "/", $time);
	$arr = explode("/", $time);
	if(count($arr) < 3) return 0;
	return strtotime("$arr[2]-$arr[1]-$arr[0]");
}
function getAPIs_sync($url, $token = "DG9CexZ9sFmHxUQfd88NxRCrSJty"){
	$url = "https://api.tga.com.vn/".$url;
	//echo $url;
	$ch = curl_init($url);                                                                      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                     
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',
		'token: '.$token
	));
	$result = curl_exec($ch);
	return $result;
}
function sendAPIs_JSON($url, $data, $token = "DG9CexZ9sFmHxUQfd88NxRCrSJty"){
	$url = "https://api.tga.com.vn/".$url;
	$ch = curl_init($url);                                                                      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',                                                                                
		'Content-Length: ' . strlen($data),
		'token: '.$token
	));
	$result = curl_exec($ch);
	return $result;
}

function send_soap($url, $data){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Content-type: text/xml;charset=\"utf-8\"",
		"Accept: text/xml",
		"Cache-Control: no-cache",
		"Pragma: no-cache",
		"Content-length: ".strlen($data),
	));
	curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec ($ch);
	curl_close ($ch);
	$xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $server_output);
	$xml = simplexml_load_string($xml);
	return json_decode(json_encode($xml), true);
}
function value($s,$from,$to){
	$s = explode($from,$s);
	$s = explode($to,$s[1]);
	return $s[0];
}
function send_url($url, $data){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data)));
	curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec ($ch);
	curl_close ($ch);
	return $server_output;
}
function get_url($url){
	$ch = curl_init($url);                                                                      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                              
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 																
	$result = curl_exec($ch);
	return $result;
}
function getTimeFormat($start = 0, $data){	
	if(intval($start) < 10 || intval($data) < 10){
		return "";
		
	}
	$gio = intval(date("G", intval($data)));
	$gio = $gio < 10 ? ("0".$gio) : $gio;
	$phut = intval(date("i", intval($data)));
	$phut = $phut < 10 ? ("0".$phut) : $phut;
	//var_dump("$gio:$phut");
	return "$gio:$phut";
}
function tax_person_incom($emp, $data, $last_time){
	$data  = (object) $data;
	$data->tax_allowance_family = rmFormatMoney($emp->allowance_family);
	$data->incom_total = rmFormatMoney($data->final_salary);

	if(rmFormatMoney($data->insurance_fine) == 0) return $data;
	$data->tax_fine = rmFormatMoney($emp->allowance_phone);
	$data->tax_able_salary = rmFormatMoney($data->final_salary) + rmFormatMoney($data->fine_advance);
	$data->tax_incom_salary = $data->tax_able_salary - 9000000 - 730000 - rmFormatMoney($emp->allowance_family);
	if($data->tax_able_salary > 9000000 && $data->tax_incom_salary > 0) {
		if($emp->end_try_day >= $last_time){
			$data->tax_incom_final = $data->tax_incom_salary * (10/100);
		}else{
			if($data->tax_incom_salary <= 5000000){
				$data->tax_incom_final = $data->tax_incom_salary * (5/100);
			}elseif($data->tax_incom_salary <= 10000000){
				$data->tax_incom_final = $data->tax_incom_salary * (10/100) - 250000;
			}elseif($data->tax_incom_salary <= 18000000){
				$data->tax_incom_final = $data->tax_incom_salary * (15/100) - 750000;
			}elseif($data->tax_incom_salary <= 32000000){
				$data->tax_incom_final = $data->tax_incom_salary * (20/100) - 1650000;
			}elseif($data->tax_incom_salary <= 52000000){
				$data->tax_incom_final = $data->tax_incom_salary * (25/100) - 1650000;
			}elseif($data->tax_incom_salary <= 80000000){
				$data->tax_incom_final = $data->tax_incom_salary * (30/100) - 3250000;
			}else{
				$data->tax_incom_final = $data->tax_incom_salary * (35/100) - 9850000;
			}
		}
	}else{
		$data->tax_incom_salary = 0;
	}
	$data->tax_incom_final = round($data->tax_incom_final);
	$data->incom_total -= $data->tax_incom_final;

	$data->allowance_family = formatMoney($data->allowance_family);
	$data->tax_able_salary = formatMoney($data->tax_able_salary);
	$data->tax_incom_salary = formatMoney($data->tax_incom_salary);
	$data->tax_incom_final = formatMoney($data->tax_incom_final);
	$data->incom_total = formatMoney($data->incom_total);
	$data->tax_fine = formatMoney($data->tax_fine);
	return $data;
}
function get_tax_person_incom(){
	
}
function strongPassword($pwd) {
	$errors = "";
    if (strlen($pwd) < 8) {
        $errors .= "<p>Mật khẩu chưa đủ 8 kí tự!</p>";
    }

    if (!preg_match("#[0-9]+#", $pwd)) {
        $errors .= "<p>Mật khẩu chưa có kí tự số!</p>";
    }

    if (!preg_match("#[a-zA-z]+#", $pwd)) {
        $errors .= "<p>Mật khẩu chưa có kí tự in thường!</p>";
	}
	
	if($errors != "") return $errors;
	return false;
}
function api_encode($data) {
	$password = "111111";
	$key = hash('sha256', $password);
	$method = 'AES-256-CBC';
	$data = serialize($data);
	$ivSize = openssl_cipher_iv_length($method);
	$iv = openssl_random_pseudo_bytes($ivSize);
	$encrypted = openssl_encrypt($data, $method, $key, OPENSSL_RAW_DATA, $iv);
	$encrypted = base64_encode($iv . $encrypted);
	return $encrypted;
}
function api_decode($data) {
	$password = "111111";
	$key = hash('sha256', $password);
	$method = 'AES-256-CBC';
	$data = base64_decode($data);
	$ivSize = openssl_cipher_iv_length($method);
	$iv = substr($data, 0, $ivSize);
	$data = openssl_decrypt(substr($data, $ivSize), $method, $key, OPENSSL_RAW_DATA, $iv);	
	return unserialize($data);
}
function getStatusNumber($data) {
	$data->level1 = isset($data->level1)?intval($data->level1):false;
	$data->level2 = isset($data->level2)?intval($data->level2):false;
	$data->level3 = isset($data->level3)?intval($data->level3):false;
	$data->cap1 = isset($data->cap1)?intval($data->cap1):false;
	$data->cap2 = isset($data->cap2)?intval($data->cap2):false;
	$data->cap3 = isset($data->cap3)?intval($data->cap3):false;
	
		if ($data->level1 < 0 || $data->level2 < 0 || $data->level3 < 0) return -1;
		if ($data->level1 != 0) {
			if ($data->level1 < 0) {
				return -1;
			} else {
				if (isset($data->cap2) && $data->cap2 != 0) {
					if ($data->level2 != 0) {
						if ($data->level2 < 0) {
							return -2;
						} else {
							if (isset($data->cap3) && $data->cap3 != 0) {
								if ($data->level3 != 0) {
									if ($data->level3 < 0) {
										return -3;
									}
									return 10;
								} else {
									return 3;
								}
							} else {
								return 10;
							}
						}
					} else {
						return 2;
					}
				} else {
					return 10;
				}
			}
		} else {
			return 1;
		}
		return 0;
}
function formatMoney($gia){
	$gia = (float) rmFormatMoney($gia);
	return number_format($gia, 0, ',', '.');
}
function rmFormatMoney($gia){
	return preg_replace("/[^0-9]/", "", $gia);
	return str_replace(array(" ","-",",",".","VND","VNĐ","vnd","vnđ","₫","�"),"",$gia);
}
function rmFormatVND($data){
	return preg_replace("/[^0-9]/", "", $data);
	return str_replace(array(" ","-","VND","VNĐ","vnd","vnđ","₫","�"),"",$data);
}

function rmFormatFloat($data){
	return str_replace(array(" ","VND","VNĐ","vnd","vnđ","₫","�"),"",$data);
}
function GetIP(){
	$ipaddress = '';
	if(isset($_SERVER['HTTP_CLIENT_IP']))
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_X_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if(isset($_SERVER['REMOTE_ADDR']))
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress ;
}
function showMes($error = true, $error_msg = "", $data = false){
	header("Content-type: application/json; charset=utf-8");
	$output = (object)array("error" => $error, "message" => $error_msg, 'data' => $data);
	echo json_encode($output, JSON_PRETTY_PRINT);
	return false;
}
function checkToken(){
	$cookie = get_cookie('userLogin1s');
	if($cookie == NULL) return 0;
	$array = api_decode($cookie);
	if(!isset($array["employeeId"])) return 0;
	if(!isset($array["time"])) return 0;
	$id = intval($array["employeeId"]);	
	if($id < 1) return 0;	
	$timeNow = time();
	$timeCookie = intval($array["time"]);
	if($timeNow > $timeCookie || $array['siteLogin'] !== DOMAIN_LOGIN){
		setcookie('userLogin1s', false, time()+60*60*4, "/", DOMAIN_LOGIN);
		unset($_COOKIE['userLogin1s']);
		setcookie('strongPass', false);
		setcookie('strongPass', false, time()+60*60*4, "/", DOMAIN_LOGIN);
		setcookie('strongPass', false, time()+60*60*4, "/", DOMAIN_LOGIN);
		unset($_COOKIE);
		redirect('');		
		return 0;
	}
	return intval($id);
	
	$time_cookie = strtotime("+1 day");
	$array['time'] = $time_cookie;
	$obj = api_encode($array);
	setcookie('userLogin1s', $obj, $time_cookie, "/", DOMAIN_LOGIN);
	//echo $cookie;die;
	return intval($id);
}

function advance_time($data = 0){
	$time = time();
	$advance = $time - $data;
	if($advance < 10) return "Vừa xong";
	if($advance < 60) return "$advance giây trước";
	if($advance < 3600){
		$advance = round($advance/60);
		return "$advance phút trước";
	}
	if($advance < 86400){
		$advance = round($advance/3600);
		return "$advance giờ trước";
	}
	$advance = round($advance/86400);
	return "$advance ngày trước";
}
function trim_text($input, $length, $ellipses = false, $strip_html = true) {
    if ($strip_html) {
        $input = strip_tags($input);
    }
    if (strlen($input) <= $length) {
        return $input;
    }
    $last_space = strrpos(substr($input, 0, $length), ' ');
    $trimmed_text = substr($input, 0, $last_space);
    if ($ellipses) {
        $trimmed_text .= '...';
    }
    return $trimmed_text;
}
function short_text($str = '', $line = 5){
	$input = strip_tags($str);
	$input = trim($input);
	$a = explode("\n", $input);
	$output = array();
	if(count($a) <= $line) return false;
	for($i=0;$i < $line && $i < count($a); $i++){
		$output[] = $a[$i];
	}
	return implode("\n", $output);
}

if (!function_exists('str_slug')) {
    function str_slug($string)
    {
        $search = array(
            '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
            '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
            '#(ì|í|ị|ỉ|ĩ)#',
            '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
            '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
            '#(ỳ|ý|ỵ|ỷ|ỹ)#',
            '#(đ)#',
            '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
            '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
            '#(Ì|Í|Ị|Ỉ|Ĩ)#',
            '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
            '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
            '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
            '#(Đ)#',
            "/[^a-zA-Z0-9\-\_]/",
        );
        $replace = array(
            'a',
            'e',
            'i',
            'o',
            'u',
            'y',
            'd',
            'A',
            'E',
            'I',
            'O',
            'U',
            'Y',
            'D',
            '-',
        );
        $string = preg_replace($search, $replace, $string);
        $string = preg_replace('/(-)+/', '-', $string);
        $string = strtolower($string);
        return $string;
    }
}

function ConverToRoman($num){ 
	$n = intval($num); 
	$res = ''; 

	//array of roman numbers
	$romanNumber_Array = array( 
	'M'  => 1000, 
	'CM' => 900, 
	'D'  => 500, 
	'CD' => 400, 
	'C'  => 100, 
	'XC' => 90, 
	'L'  => 50, 
	'XL' => 40, 
	'X'  => 10, 
	'IX' => 9, 
	'V'  => 5, 
	'IV' => 4, 
	'I'  => 1); 

	foreach ($romanNumber_Array as $roman => $number){ 
	//divide to get  matches
	$matches = intval($n / $number); 

	//assign the roman char * $matches
	$res .= str_repeat($roman, $matches); 

	//substract from the number
	$n = $n % $number; 
	} 

	// return the result
	return $res; 
} 

function get_input_time($time){
	$dateBegin = date("Y-m-d");
	$dateBeginMonth = date("Y-m-1");
	$dateEnd = date("Y-m-d");
	$dateEndHour = date("Y-m-d 24:00:00");
	if($time && $time == "thisyear"){
		$BeignLastMonth = date("Y-m-d", strtotime("$dateBegin -1 years"));
		$BeignMonthLastMonth = date("Y-m-d", strtotime("$dateBeginMonth -1 years"));
		$EndLastMonth = date("Y-m-d", strtotime("$dateEnd -1 years"));
	}else{
		$time = explode("-",$time);
		if(count($time) > 1){
			$time_begin = explode("/", $time[0]);
			$time_end = explode("/", $time[1]);
			$dateBegin = date("$time_begin[2]-$time_begin[1]-$time_begin[0]");
			$dateBeginMonth = date("$time_begin[2]-$time_begin[1]-$time_begin[0]");
			$dateEnd = date("$time_end[2]-$time_end[1]-$time_end[0]");
			$dateEndHour = date("Y-m-d 24:00:00", strtotime($dateEnd));  
		
		}
		$BeignLastMonth = date("Y-m-d", strtotime("$dateBegin -1 month"));
		$BeignMonthLastMonth = date("Y-m-1", strtotime("$dateBegin -1 month"));
		$EndLastMonth = date("Y-m-d", strtotime("$dateEnd -1 month"));
	}
	return (object) array(
		'dateBegin' => $dateBegin,
		'dateBeginMonth' => $dateBeginMonth,
		'dateEnd' => $dateEnd,
		'dateEndHour' => $dateEndHour,
		'BeignMonthLastMonth' => $BeignMonthLastMonth,
		'BeignLastMonth' => $BeignLastMonth,
		'EndLastMonth' => $EndLastMonth
	);
}
function danhngon(){
	
	$arr = array(
		"Nhất cận thị, nhị cận giang, muốn giàu sang thì… cận sếp",
		"Lương y như… tháng trước",
		"Tiền lương như \"đèn đỏ\", mỗi tháng 1 lần và tầm 1 tuần là hết!",
		"Cá không ăn muối cá ươn.\nNhân viên bật sếp lương thường không tăng.",
		"Không phải là tôi quá thông minh, chỉ là tôi chịu bỏ nhiều thời gian hơn với rắc rối",
		"Đời người thì ngắn… khoảng cách giữa hai kỳ lương thì quá dài.",
		"Khi còn trẻ phải làm những việc bạn nên làm, thì khi về già mới có thể làm những việc bạn muốn làm.",
		"Tận cùng của sự ngu dốt là đối xử quá tốt với nhiều người.",
		"Kẻ ngu thường tỏ ra nguy hiểm. \nKẻ nguy hiểm thường tỏ ra ngu.",
		"Công việc của tôi không phải là dễ dãi với mọi người. \nCông việc của tôi là khiến họ trở nên tốt đẹp hơn.",
		"Đầu lòng hai ả tố nga. \nThúy Kiều là chị, mai là thứ hai 🙁",
		"Buồn buồn ngồi chửi sếp chơi\nHôm sau mất việc buồn ơi là buồn",
		"Không có áp lực, không có kim cương",
		"Nhà xa công ty nên đi làm như đi phượt. Sáng đến công ty như là \"Sáng thức dậy ở một nơi xa\". Chiều về nhà thì giống như \"đi thật xa để trở về\" :)))",
		"Bạn phải chịu đựng áp lực. Nếu bạn không thể chịu được áp lực, bạn không thể trở thành một doanh nhân lớn hay thành đạt",
		"Mấy đời bánh đúc có xương\nMấy đời công chức có lương đủ xài?",
		"Cafe là thức uống giúp ta tỉnh táo… để không bóp cổ đồng nghiệp",
		"Mỗi ngày đi làm tới chỗ làm, chỉ mong các chị em phụ nữ xinh đẹp... xi nhan phải thì cứ rẻ phải thôi <3",
		"Làm việc 1 mình như 1 vị thần, cứ có đứa đứng cạnh nhìn là hành động như 1 thằng đần.",
		"Điều 1 sếp luôn đúng.\nĐiều 2 nếu sếp sai thì một nhân viên nào đó sai chứ không phải sếp",
		"Năng lực mạnh mẽ nhất của sếp là dừng mọi cuộc buôn chuyện chỉ bằng cách xuất hiện.",
		"Một năm chia làm 2 nửa: 1 nửa là những ngày hạnh phúc, 1 nửa là những ngày thứ hai :(",
		"Được tăng lương cũng giống như uống ly rượu, nó nâng tinh thần ta lên nhưng chỉ trong chốc lát thôi.",
		"Hãy nghĩ mình là giám đốc. Ai cần mình thì người đó gọi lại.",
		"Công sở là nơi bạn có thể thư giãn sau cuộc sống căng thẳng ở nhà.",
		"Lương khô là thức ăn được ưa chuộng vào những ngày khô lương.",
		"Thế giới cần có 1 ngày ở giữa thứ 7 và chủ nhật.",
		"Phòng làm việc là nơi bút luôn mất tích 1 cách bí ẩn, nhưng điện thoại, chìa khóa, ví tiền để quên trên bàn chả ai thèm đụng."
	);
	$random_keys=array_rand($arr,1);
	return str_replace("\n", "<br>", $arr[$random_keys]);
}