<?php
namespace ext\pattern\composite\unit;


use ext\pattern\composite\abstracts\Tree;

class CreateLeaf extends Tree
{

    private $name;
    private $size;
    private $color;
    private $leaf = [];

    public function __construct($name, $size, $color){
        $this->name = $name;
        $this->size = $size;
        $this->color = $color;
    }

    public function create(){
        $this->leaf[$this->name] = [
            'size' => $this->size,
            'color' => $this->color
        ];
        return $this->leaf;
    }

    //由于创建叶子类不需要组合和分离的操作，我们将这两个方法投掷出错误警告。
    public function add(tree $item){
        throw new \Exception("本类不支持组合操作");
    }

    public function remove(tree $item){
        throw new \Exception("本类不支持分离操作");
    }
}