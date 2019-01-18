<?php

namespace app\index\controller;

use think\App;

class Index extends Base
{
    public function __construct(App $app = null)
    {
        parent::__construct($app);
    }
    
    public function index()
    {
        return view();
    }
}