<?php

namespace ext\pattern\composite\unit;


use ext\pattern\composite\abstracts\Tree;

class CreateBranch extends Tree{

    private $name;
    private $branch = array();
    private $items = array();//树枝可能被安插叶子，该变量用于存放叶子对象

    public function __construct($name){
        $this->name = $name;
    }

    public function create(){
        foreach($this->items as $item){
            $arr = $item->create();
            $this->branch[$this->name][] = $arr;
        }

        if(empty($this->branch)){
            $this->branch[$this->name] = array();
        }
        return $this->branch;
    }

    public function add(tree $item){
        if(in_array($item, $this->items, true)){
            return;
        }
        $this->items[] = $item;
    }

    public function remove(tree $item){
        $this->items = array_udiff($this->items, array($item), function($a, $b){
            return ($a === $b) ? 0 : 1 ;
        });
    }

}