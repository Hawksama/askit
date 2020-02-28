<?php
error_reporting(0);

include 'config.php';

if(!isset($_GET['glang']) or !isset($_GET['gurl']))
    exit;

$glang = $_GET['glang'];

// pick a server based on hostname
$server_id = intval(substr(md5(preg_replace('/^www\./', '', $_SERVER['HTTP_HOST'])), 0, 5), 16) % count($servers);
$server = $servers[$server_id];

$page_url = '/'.$_GET['gurl'];

$page_url_segments = explode('/', $page_url);
foreach($page_url_segments as $i => $segment) {
    $page_url_segments[$i] = rawurlencode($segment);
}
$page_url = implode('/', $page_url_segments);

$get_params = $_GET;
if(isset($get_params['glang']))
    unset($get_params['glang']);
if(isset($get_params['gurl']))
    unset($get_params['gurl']);

if(count($get_params)) {
    $page_url .= '?' . http_build_query($get_params);
}

$main_lang = isset($data['default_language']) ? $data['default_language'] : $main_lang;

if($glang == $main_lang) {
    $page_url = preg_replace('/^[\/]+/', '/', $page_url);

    header('Location: ' . $page_url, true, 301);
    exit;
}

$page_url = $server.'.tdn.gtranslate.net' . $page_url;

$protocol = ((isset($_SERVER['HTTPS']) and ($_SERVER['HTTPS'] == 'on' or $_SERVER['HTTPS'] == 1)) or (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) and  $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https' : 'http';
$page_url = $protocol . '://' . $page_url;

if(!in_array(strtolower($glang), array('en','ar','bg','zh-cn','zh-tw','hr','cs','da','nl','fi','fr','de','el','hi','it','ja','ko','no','pl','pt','ro','ru','es','sv','ca','tl','iw','id','lv','lt','sr','sk','sl','uk','vi','sq','et','gl','hu','mt','th','tr','fa','af','ms','sw','ga','cy','be','is','mk','yi','hy','az','eu','ka','ht','ur','bn','bs','ceb','eo','gu','ha','hmn','ig','jw','kn','km','lo','la','mi','mr','mn','ne','pa','so','ta','te','yo','zu','my','ny','kk','mg','ml','si','st','su','tg','uz','am','co','haw','ku','ky','lb','ps','sm','gd','sn','sd','fy','xh')))
    exit;

if(!function_exists("getallheaders")) {
  //Adapted from http://www.php.net/manual/en/function.getallheaders.php#99814
  function getallheaders() {
    $result = array();
    foreach($_SERVER as $key => $value) {
      if (substr($key, 0, 5) == "HTTP_") {
        $key = str_replace(" ", "-", ucwords(strtolower(str_replace("_", " ", substr($key, 5)))));
        $result[$key] = $value;
      } else if ($key == "CONTENT_TYPE") {
        $result["Content-Type"] = $value;
      }
    }
    return $result;
  }
}

$request_headers = getallheaders();

if(isset($request_headers['X-GT-Lang']) or isset($request_headers['X-Gt-Lang']) or isset($request_headers['x-gt-lang'])) {
    echo 'Please remove DNS cname records for GTranslate!';
    exit;
}

$host = $glang . '.' . preg_replace('/^www\./', '', $_SERVER['HTTP_HOST']);
$request_headers['Host'] = $host;
if(isset($request_headers['HOST'])) unset($request_headers['HOST']);
if(isset($request_headers['host'])) unset($request_headers['host']);

if(!function_exists('gzdecode'))
    $request_headers['Accept-Encoding'] = '';
else
    $request_headers['Accept-Encoding'] = 'gzip';

if(isset($request_headers['accept-encoding'])) unset($request_headers['accept-encoding']);

if(isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
    $request_headers['Authorization'] = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
    if(isset($request_headers['authorization'])) unset($request_headers['authorization']);
}
//print_r($request_headers);
//exit;

if(isset($request_headers['content-type'])) {
    $request_headers['Content-Type'] = $request_headers['content-type'];
    unset($request_headers['content-type']);
}

if(isset($request_headers['Content-Type']) and strpos($request_headers['Content-Type'], 'multipart/form-data;') !== false) {
    //$request_headers['Content-Type'] = 'multipart/form-data'; // remove boundary
    $request_headers['Content-Type'] = 'application/x-www-form-urlencoded';
    $is_multipart = true;
    $request_headers['Content-Length'] = '';

    if(isset($request_headers['content-length']))
        unset($request_headers['content-length']);
}

$headers = array();
foreach($request_headers as $key => $val) {
    // remove cloudflare CF headers: CF-IPCountry, CF-Ray, etc...
    if(preg_match('/^CF-/i', $key))
        continue;
    else
        $headers[] = $key . ': ' . $val;
}

// add real visitor IP header
if(isset($_SERVER['HTTP_CLIENT_IP']) and !empty($_SERVER['HTTP_CLIENT_IP']))
    $viewer_ip_address = $_SERVER['HTTP_CLIENT_IP'];
if(isset($_SERVER['HTTP_CF_CONNECTING_IP']) and !empty($_SERVER['HTTP_CF_CONNECTING_IP']))
    $viewer_ip_address = $_SERVER['HTTP_CF_CONNECTING_IP'];
if(isset($_SERVER['HTTP_X_SUCURI_CLIENTIP']) and !empty($_SERVER['HTTP_X_SUCURI_CLIENTIP']))
    $viewer_ip_address = $_SERVER['HTTP_X_SUCURI_CLIENTIP'];
if(!isset($viewer_ip_address))
    $viewer_ip_address = $_SERVER['REMOTE_ADDR'];

$headers[] = 'X-GT-Viewer-IP: ' . $viewer_ip_address;

// add X-Forwarded-For
if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) and !empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    $headers[] = 'X-GT-Forwarded-For: ' . $_SERVER['HTTP_X_FORWARDED_FOR'];

//print_r($headers);
//exit;

if(!function_exists('curl_init')) {
    if(function_exists('http_response_code'))
        http_response_code(500);

    echo 'PHP Curl library is required';
    exit;
}

