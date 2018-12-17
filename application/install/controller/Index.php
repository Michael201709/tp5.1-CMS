<?php

namespace app\install\controller;

use think\Controller;

/**
 * 安装控制器类
 */
require_once(APP_PATH . 'install/library/checkconfig.php');

class Index extends Controller
{
    public function initialize()
    {
        parent::initialize();
        if (file_exists(RUNTIME_PATH . 'install.lock')) {
            header("Content-type:text/html;charset=utf-8");
            die('您已安装过远丰IM，请勿重复执行安装操作！');
        }
    }
    
    public function index()
    {
        return view('index');
    }
    
    public function setup1()
    {
        return view('setup1');
    }
    
    public function setup2()
    {
        return view('setup2');
    }
    
    public function setup3()
    {
        return view('setup3');
    }
    
    public function setup4()
    {
        //生成lock文件
        $is_success = file_put_contents(RUNTIME_PATH . 'install.lock', '远丰 IM:' . date('Y-m-d H:i:s') . ' by ' . Version);
        if (!$is_success) {
            die('create install.lock file fail');
        }
        
        return view('setup4');
    }
    
    public function ajax_check_mysql()
    {
        check_mysql();
    }
    
    public function clear_cache()
    {
        //更新缓存
        $result = model('common/cache')->update_cache();
    }
    
    public function del_dir($dir)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            $str = "rmdir /s/q " . $dir;
        } else {
            $str = "rm -Rf " . $dir;
        }
    }
}