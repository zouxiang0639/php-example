<?php
namespace app\pattern;

class Index
{
    public function index()
    {
        echo "
                <a href='".url('Strategy/index')."'>策略模式</a><br>
                <a href='".url('Composite/index')."'>混合模式</a><br>
                ";
    }
}