<?php

namespace app\admin\controller;

use think\App;

class Index extends Base
{
    /**
     * Index constructor.
     *  构造函数
     *
     * @param \think\App|null $app
     */
    public function __construct(App $app = null)
    {
        parent::__construct($app);
    }
    
    /**
     *
     * Notes: 渲染后台主页
     * Author: Michael Ma
     *
     */
    public function index()
    {
        return view();
    }
    
    /**
     *
     * Notes: 渲染后台控制台页
     * Author: Michael Ma
     *
     * @return \think\response\View
     */
    public function console()
    {
        return view();
    }
}
