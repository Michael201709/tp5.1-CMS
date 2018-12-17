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
    /**
     * Date:2018年12月17日17点33分
     * Notes: 一键生成基础模块和架构
     * Author:Michael Ma
     *
     * 1、其中common.php和配置文件的app.php不必要，可注释不必生成
     *  默认状态下thinkphp 核心文件夹会被忽略，请自行更新composer update执行下即可，
     *  另需要注释 thinkphp/library/think/Build.php:122 无需生成配置文件和公共文件；
     * 2、__file__ 需要指定文件格式，
     *  其余的默认创建 .php / 指定后缀的文件[.html]
     *  如有需求，请手动更改文件后缀，比如install模块下的sql里的sql文件后缀
     *
     * 3、请手动更改继承类，中间件以及验证规则类
     */
    // 生成应用公共文件 - 公共方法function文件，后期做加密文件处理
    return [
        'admin'   => [
            '__dir__'    => ['controller', 'model', 'view'],
            'controller' => ['Base', 'Index'],
            'model'      => ['Admin'],
            'view'       => ['index/index'],
        ], // 后台模块 对应子域名admin
        'api'     => [
            '__dir__'    => ['controller'],
            'controller' => ['Base', 'Index'],
        ], // 公共控制层 - 接口调用层 对应子域名api
        'common'  => [
            '__dir__'  => ['command', 'model', 'validate'],
            'command'  => ['First'], // 自定义命令行
            'model'    => ['User'], // 公共model
            'validate' => ['User'], // User公共验证规则
        ], // 公共模型层
        'facade'  => [
            '__file__' => ['User'], // 门面类 映射common下的model
        ], // 公共模型层
        'http'    => [
            '__dir__'    => ['middleware'],
            'middleware' => ['Auth'],
        ], // 中间件
        'index'   => [
            '__dir__'    => ['controller', 'model', 'view'],
            'controller' => ['Base', 'Index'],
            'model'      => ['User'],
            'view'       => ['index/index'],
        ], // 前台模块 默认模块
        'shop'    => [
            '__dir__'    => ['controller', 'model', 'view'],
            'controller' => ['Base', 'Index'],
            'model'      => ['User'],
            'view'       => ['index/index'],
        ], // 商城模块 对应子域名shop
        'wap'     => [
            '__dir__'    => ['controller', 'model', 'view'],
            'controller' => ['Base', 'Index'],
            'model'      => ['User'],
            'view'       => ['index/index'],
        ], // 移动端模块 对应子域名m
        // 其他更多的模块定义
        'install' => [
            '__dir__'    => ['controller', 'view', 'library', 'sql'],
            '__file__'   => ['common.php', 'config.php'],
            'controller' => ['Index'],
            'view'       => ['index/index'],
            'library'    => ['checkconfig'],
            'sql'        => ['install'],
        ], // 安装向导部署层 - 视图化部署安装
    ];
