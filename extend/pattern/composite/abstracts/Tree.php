<?php
namespace ext\pattern\composite\abstracts;

abstract class Tree
{
    abstract function create();//创建
    abstract function add(tree $item);//组合
    abstract function remove(tree $item);//分离
}