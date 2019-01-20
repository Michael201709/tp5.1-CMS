<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
Route::domain('admin', 'admin');
Route::domain('api', 'api');
Route::domain('install', 'install');
Route::domain('shop', 'shop');
Route::domain('m', 'wap');
Route::rule('info', 'index/index/info'); // 静态地址路由
return [
];
