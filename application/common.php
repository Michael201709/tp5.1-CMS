<?php
/**
 * Created by PhpStorm.
 * Author: Michael Ma
 * Date: 2018年12月17日
 * Time: 23:23:16
 */
// include __DIR__ . '/helpers.php';
// if (mt_rand(0, 5) == 1) {
//     $lic = __DIR__ . '/../licence/licence.lic';
//     $pem = __DIR__ . '/../licence/public.pem';
//     $rows['domain'] = $_SERVER['HTTP_HOST'] ? :$_SERVER['SERVER_NAME'];
//     $flag = false;
//     if (file_exists($lic) && file_exists($pem)) {
//         $lic_maker = new Licence_Maker();
//         $check = $lic_maker->check(file_get_contents($lic), file_get_contents($pem), $rows);
//         if (!$check) {
//             $flag = false;
//         } else {
//             $flag = true;
//         }
//     }
//     if ($flag != true) {
//         $url = 'https://license.yuanfeng.cn?domain=' . $rows['domain'] . '&app=im';
//         $d = file_get_contents($url);
//         if ($d && strpos($d, '#OK#') !== false) {
//             $flag = true;
//         }
//     }
//     if (!$flag) {
//         header("Content-type: text/html; charset=utf-8");
//         echo '版权所有，请联系管理员！';
//         exit;
//     }
// }
/**
 *
 * Notes: 判断http[s]协议,拼接'://'
 * Author: Michael Ma
 *
 * @return string
 */
function get_http_s()
{
    return 'http' . (((isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1)) || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') || (isset($_SERVER['HTTP_X_CLIENT_SCHEME']) && $_SERVER['HTTP_X_CLIENT_SCHEME'] == 'https') || (isset($_SERVER['HTTP_VIA']) && ($_SERVER['HTTP_VIA'] && strpos(strtolower($_SERVER['HTTP_VIA']), 'baidu-cdn-') !== false))) ? 's':'') . '://';
}

/**
 *
 * Notes:获取主域名
 *
 * @return string
 */
function get_domain()
{
    return request()->rootDomain();
}

/**
 *
 * Notes:获取接口/子域地址，拼接'/'
 * Author: Michael Ma
 *
 * @param string $domain
 *
 * @return string
 */
function get_api_url($domain = '')
{
    return get_http_s() . ($domain ? :'www') . '.' . get_domain() . '/';
}



/*****************以下为参考的公共方法************************/
/**
 * 当前主题资源所在URL
 *
 * @param  [type] $str [description]
 *
 * @return [type]      [description]
 */
function static_url($str = null)
{
    if ($str) {
        $name = "." . $str;
    }
    
    return theme_url('static') . $name;
}

/**
 * 加载API请求
 * 配置如下
 * $res['shopCartRead']  = [
 *    'url'=>'api/shopcart/index',
 *
 * ];
 *
 * 调用
 * api_load([
 *    'name'=>'shopCartRead',
 *    'js'=>[
 *          '1.js'
 *    ],
 *    'css'=>[
 *          '1.css'
 *    ],
 *   'call'=>"
 *      $('.toolbar .cart .count').html(res.cartNum)
 *    "
 * ]);
 *
 * return $res;
 *
 * @param  [type] $name [请在configs/api.php配置]
 *
 * @return [type]       [description]
 */
function api_load($arr = [])
{
    $name = $arr['name'];
    $call = $arr['call'];
    $js = $arr['js'];
    $css = $arr['css'];
    //从配置中读取
    if (strpos($name, '/') === false) {
        $res = config("api." . $name);
        $url = $res['url'];
        $js = $arr['js'];
        $css = $arr['css'];
        if ($js && is_array($js)) {
            foreach ($js as $j0) {
                SObjs('jsFs', $j0);
            }
        }
        if ($css && is_array($css)) {
            foreach ($css as $j0) {
                SObjs('cssFs', $j0);
            }
        }
        if (!$url) {
            return;
        }
        SObjs("scripts", "
            $.get('" . host() . '/' . $url . "',function(res){
                " . $call . "
            },'json')
        ");
    }
}

function is_ajax()
{
    return request()->isAjax();
}

/**
 * 输出页面JS CSS等
 *
 * @return [type] [description]
 */
function html_header()
{
    $js = SObjs("cssFs");
    if ($js) {
        foreach ($js as $vs) {
            foreach ($vs as $j0) {
                $sp .= "<link type=\"text/css\" rel=\"stylesheet\" href='" . $j0 . "'>\n";
            }
        }
    }
    
    return $sp;
}

function html_footer()
{
    $js = SObjs("jsFs");
    if ($js) {
        foreach ($js as $vs) {
            foreach ($vs as $j0) {
                $sp .= "<script type=\"text/javascript\" src='" . $j0 . "'></script>\n";
            }
        }
    }
    $js = SObjs("scripts");
    if ($js) {
        $sp .= "\n<script>\n$(function(){\n";
        foreach ($js as $j) {
            $sp .= $j;
        }
        $sp .= "\n})\n</script>\n";
    }
    
    return $sp;
}

/**
 * 输出JSON
 *
 * @param  [type] $array [description]
 *
 * @return [type]        [description]
 */
function return_json($array)
{
    $callback = $_GET['callback'];
    if ($callback) {
        return jsonp($array);
    }
    
    return json($array);
}

class Controller extends think\Controller
{
    //检测是否登录
    public $_check_login = false;
    //登录地址
    public $_login_url = 'index/login/index';
    public $_cookie_id = 'id';
    public $_cookie_name = 'user';
    
    /**
     * 设置主题
     *
     * @param [type] $name [description]
     */
    public function setTheme($name)
    {
        config('template.theme', $name);
    }
    
    protected function initialize()
    {
        /**
         * 非AJAX请求时，加载主题下的function.moduleName.php
         */
        if (!request()->isAjax()) {
            $fs = theme_path() . '/function.' . reqArr()['m'] . '.php';
            $fs1 = theme_path(false) . '/function.php';
            if (is_file($fs)) {
                include $fs;
            }
            if (is_file($fs1)) {
                include $fs1;
            }
        }
        $this->init();
    }
    
    /**
     * 设置登录COOKIE
     *
     * @param  [type] $user [description]
     *
     * @return [type]       [description]
     */
    public function setCookie($arr = [])
    {
        cookie($this->_cookie_id, $arr['id'], 0);
        cookie($this->_cookie_name, $arr['user'], 0);
    }
    
    public function clearCookie()
    {
        cookie($this->_cookie_id, null);
        cookie($this->_cookie_name, null);
    }
    
    public function init()
    {
        //使用视图过滤，需要在渲染的时候使用　$this->fetch()
        $this->view->filter(function($content) {
            $content = preg_replace_callback('|.*</head>|', function() {
                return html_header() . "\n</head>";
            }, trim($content));
            $content = preg_replace_callback('|.*</body>|', function() {
                return html_footer() . "\n</body>";
            }, trim($content));
            
            return $content;
        });
        if ($this->_check_login === true) {
            if (!cookie($this->_cookie_id)) {
                $this->redirect(url($this->_login_url), $params, $delay, lang('请先登录'));
                exit;
            }
        }
    }
    
    /**
     * JSON格式化，并自动判断JSONP格式
     *
     * @param  [type] $array [description]
     *
     * @return [type]        [description]
     */
    public function json($array)
    {
        echo return_json($array);
        exit;
    }
    
    /**
     * 判断是否是AJAX请求
     *
     * @return boolean [description]
     */
    public function isAjax()
    {
        return request()->isAjax();
    }
}

/**
 * 接口处理
 */
class ApiController extends Controller
{
    public $data;
    
    public function response($data)
    {
        $callback = $_GET['callback'];
        if ($callback) {
            die($callback . "(" . json_encode($data) . ")");
            exit;
        }
        die(json_encode($data));
        exit;
    }
}

/**
 * 单个对象保存
 *
 * @param [type] $name  [description]
 * @param [type] $value [description]
 */
function SObj($name, $value = null)
{
    static $_obj;
    if (!$value) {
        return $_obj[$name];
    }
    $_obj[$name] = $value;
}

/**
 * 多对象保存
 *
 * @param [type] $name  [description]
 * @param [type] $value [description]
 */
function SObjs($name, $value = null)
{
    static $_obj;
    if (!$value) {
        return $_obj[$name];
    }
    $_obj[$name][] = $value;
}

// 应用公共文件
function error_header($msg = 'Not Found')
{
    header('HTTP/1.1 404 ' . $msg);
}

/**
 * 返回当前请求的 module controller actino
 *
 * @return [type] [description]
 */
function reqArr($key = null)
{
    static $data;
    if (!$data) {
        $data['m'] = strtolower(request()->module());
        $data['c'] = strtolower(request()->controller());
        $data['a'] = strtolower(request()->action());
    }
    if ($key) {
        return $data[$key];
    }
    
    return $data;
}

/**
 * 返回当前URL 带HTTP[s]
 *
 * @param  string $url [description]
 *
 * @return [type]      [description]
 */
function host($url = '')
{
    return get_http_s() . request()->host() . '/' . $url;
}

/**
 * 主题名
 *
 * @return [type] [description]
 */
function theme_name()
{
    return config('template.theme');
}

/**
 * 当前主题URL
 *
 * @return [type] [description]
 */
function theme_url($ext = null)
{
    $str = $ext ? '/' . $ext:null;
    
    return host() . '/themes/' . config('template.theme') . $str;
}

/**
 * 当前主题路径
 *
 * @return [type] [description]
 */
function theme_path($flag = true)
{
    $path = realpath(Env::get('app_path') . '../public/themes');
    if ($flag === true) {
        $path .= '/' . config('template.theme');
    }
    
    return $path;
}

/**
 * 选中菜单
 */
function activeMenu($url)
{
    if (strpos(reqArr('m') . '/' . reqArr('c'), $url) !== false) {
        return true;
    }
    
    return false;
}

/**
 *
 * Notes:简易加密解密的AES方式
 * 建议$ostr的长度位32位字符串
 *
 * @param        $ostr
 * @param        $securekey
 * @param string $type
 *
 * @return string
 */
function aes($ostr, $securekey, $type = 'encrypt')
{
    if ($ostr == '') {
        return '';
    }
    $key = $securekey;
    $iv = @strrev($securekey);
    $td = @mcrypt_module_open('rijndael-256', '', 'ofb', '');
    @mcrypt_generic_init($td, $key, $iv);
    $str = '';
    switch ($type) {
        case 'encrypt':
            $str = @base64_encode(@mcrypt_generic($td, $ostr));
            break;
        case 'decrypt':
            $str = @mdecrypt_generic($td, @base64_decode($ostr));
            break;
    }
    @mcrypt_generic_deinit($td);
    
    return $str;
}

/*------------------------------------------------------------------
 * 加密解密,主要提供 给URL请求使用。在URL请求是
 * ras_encode() 自动 URLENCODE
 * 1、compser安装phpseclib composer require phpseclib/phpseclib
 * 2、入口文件 require __DIR__ . '/vendor/autoload.php';
 * 3、直接new(tp直接new就好用~)
 * -----------------------------------------------------------------
 */
function create_rsa_key()
{
    $rsa = new phpseclib\Crypt\RSA();
    $key = $rsa->createKey();
    $data['privatekey'] = $key['privatekey'];
    $data['publickey'] = $key['publickey'];
    
    return $data;
}

/**
 * 加密
 * ras_encode(['t'=>'test'],$publickey))
 */
function ras_encode($plaintext = [], $publickey, $urlencode = true)
{
    $rsa = new phpseclib\Crypt\RSA();
    $plaintext['time'] = time() + 60;
    $rsa->loadKey($publickey);
    $ciphertext = $rsa->encrypt(json_encode($plaintext));
    $res = base64_encode($ciphertext);
    if ($urlencode) {
        $res = urlencode($res);
    }
    
    return $res;
}

/**
 * 解密
 */
function ras_decode($decrypttext, $privatekey)
{
    $rsa = new phpseclib\Crypt\RSA();
    $rsa->loadKey($privatekey);
    $res = json_decode($rsa->decrypt(base64_decode($decrypttext)));
    if ($res->time >= time()) {
        return $res;
    } else {
        Log::error('RSA 过期');
    }
}

/**
 * 加密
 *
 */
function aes_encode($plaintext = [], $key, $urlencode = false)
{
    $rsa = new phpseclib\Crypt\AES();
    $rsa->setKey($key);
    $plaintext['time'] = time() + 60;
    $ciphertext = $rsa->encrypt(json_encode($plaintext));
    $res = base64_encode($ciphertext);
    if ($urlencode) {
        $res = urlencode($res);
    }
    
    return $res;
}

/**
 * 解密
 */
function aes_decode($decrypttext, $key, $checkTime = true)
{
    $rsa = new phpseclib\Crypt\AES();
    $rsa->setKey($key);
    $res = json_decode($rsa->decrypt(base64_decode($decrypttext)));
    if ($checkTime) {
        if ($res->time >= time()) {
            return $res;
        }
        {
            Log::error('RSA 过期');
        }
    } else {
        return $res;
    }
}

/**
 * 数组 转 对象
 *
 * @param array $arr 数组
 *
 * @return object
 */
function array_to_object($arr)
{
    if (gettype($arr) != 'array') {
        return;
    }
    foreach ($arr as $k => $v) {
        if (gettype($v) == 'array' || getType($v) == 'object') {
            $arr[$k] = (object)array_to_object($v);
        }
    }
    
    return (object)$arr;
}

/**
 * 对象 转 数组
 *
 * @param object $obj 对象
 *
 * @return array
 */
function object_to_array($obj)
{
    $obj = (array)$obj;
    foreach ($obj as $k => $v) {
        if (gettype($v) == 'resource') {
            return;
        }
        if (gettype($v) == 'object' || gettype($v) == 'array') {
            $obj[$k] = (array)object_to_array($v);
        }
    }
    
    return $obj;
}

/**
 * 随机字符
 *
 * @param number $length  长度
 * @param string $type    类型
 * @param number $convert 转换大小写
 *
 * @return string
 */
function random($length = 6, $type = 'string', $convert = 0)
{
    $config = [
        'number' => '1234567890',
        'letter' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'string' => 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789',
        'all'    => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
    ];
    if (!isset($config[$type])) {
        $type = 'string';
    }
    $string = $config[$type];
    $code = '';
    $strlen = strlen($string) - 1;
    for ($i = 0; $i < $length; $i++) {
        $code .= $string{mt_rand(0, $strlen)};
    }
    if (!empty($convert)) {
        $code = ($convert > 0) ? strtoupper($code):strtolower($code);
    }
    
    return $code;
}

// exit();
// class Licence_Maker
// {
//     private $keydir = NULL;
//     private $data = [];
//     private $output = NULL;
//
//     /**
//      *  生成licence
//      *
//      * @access public
//      *
//      * @return bool  res;
//      */
//     public function createLicence($data = ['expires' => '2014-04-14 00:00:00', 'ip' => '202.107.0.1'], $private_key_path, $licence_path = NULL)
//     {
//         $data_str = serialize($data);
//         $pri = file_get_contents($private_key_path);
//         openssl_private_encrypt($data_str, $out, $pri);
//         $b = base64_encode($out);
//         file_put_contents($licence_path, $b);
//
//         return $b;
//     }
//
//     public function getData($licence_data, $public_key_data)
//     {
//         $licence = base64_decode($licence_data);
//         $ret = openssl_public_decrypt($licence, $data, $public_key_data);
//         $data = unserialize($data);
//
//         return $data;
//     }
//
//     public function check($licence_data, $public_key_data, $evn_row = [])
//     {
//         $licence = base64_decode($licence_data);
//         $ret = openssl_public_decrypt($licence, $data, $public_key_data);
//         $data = unserialize($data);
//
//         return $this->checkDate($data, $evn_row);
//     }
//
//     public function checkDate($data, $evn_row = [])
//     {
//         $expires = $data['expires'];
//         $domain = $data['licence_domain'];
//         $d = $evn_row['domain'];
//         if (strpos($domain, ',') !== FALSE) {
//             $arr = explode(',', $domain);
//             foreach ($arr as $v) {
//                 $new_domain[] = trim($v);
//             }
//         } else {
//             $new_domain[] = $domain;
//         }
//         if ($new_domain && in_array($d, $new_domain)) {
//             return TRUE;
//         } else {
//             return FALSE;
//         }
//         /*if ($expires > time()
//         )
//         {
//             return true;
//         }
//
//         return false;*/
//     }
//
//     //client
//     public function checkLicence()
//     {
//         $url = '';
//         $arr_param = [];
//         $data = get_url($url, $arr_param = []);
//         if (200 == $data['status']) {
//             return TRUE;
//         } else {
//             return FALSE;
//         }
//     }
// }
//
// $php_version = (float)phpversion();
// $php_version = str_replace('.', '', $php_version);
// $load_licese_file = __DIR__ . '/common_' . $php_version . '.php';
// if (!file_exists($load_licese_file)) {
//     header("Content-type: text/html; charset=utf-8");
//     exit("请确认当前PHP版本，仅支持7.1，7.2版本需要扩展ioncube，其他为zendloader");
// }
// include $load_licese_file;