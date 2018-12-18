<?php
namespace app\index\controller;

class Index extends Base
{
    public function index()
    {
        dump(get_http_s());
        die();
    }
}
