<?php
namespace app\index\controller;

use think\App;
use think\Controller;

class Base extends Controller
{
    /**
     * Base constructor.
     * Notes: 构造函数
     *
     * @param \think\App|null $app
     */
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        echo getDays();
    }
}