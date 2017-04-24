<?php
namespace app\pattern;

use ext\pattern\composite\unit\CreateBranch;
use ext\pattern\composite\unit\CreateLeaf;

class Composite
{
    private $html = '';
    private $nbsp = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

    public function index()
    {
        $leaf_1 = new CreateLeaf('大红树叶','大','红');
        $leaf_2 = new CreateLeaf('大绿树叶','大','绿');
        $leaf_3 = new CreateLeaf('大黄树叶','大','黄');

        $leaf_4 = new CreateLeaf('小红树叶','小','红');
        $leaf_5 = new CreateLeaf('小绿树叶','小','绿');
        $leaf_6 = new CreateLeaf('小黄树叶','小','黄');

        $branch_1 = new CreateBranch('树枝1号');
        $branch_1->add($leaf_1);
        $branch_1->add($leaf_2);
        $branch_1->add($leaf_3);

        $branch_2 = new CreateBranch('树枝2号');
        $branch_2->add($leaf_4);
        $branch_2->add($leaf_5);
        $branch_2->add($leaf_6);

        $branch_3 = new CreateBranch('树枝3号');
        $branch_3->add($leaf_4);
        $branch_3->add($leaf_1);
        $branch_3->add($leaf_6);

        $branch = new CreateBranch('树干');
        $branch->add($branch_1);
        $branch->add($branch_2);
        $branch->add($branch_3);
        $branch->remove($branch_2);

        $this->tree( $branch->create() );

        echo $this->html;
    }

    private function tree($tree, $nbsp = null)
    {
        $nbsp = $nbsp.$this->nbsp;
        foreach($tree as $k => $value){
            $this->html .= !is_int($k) ? $nbsp.$k."{<br>" : '';
            if(isset($value['size'])){
                foreach($value as $v){
                    $this->html .= $nbsp.$this->nbsp.$v.'<br>';
                }
            }else{
                $this->html .= $this->tree($value, $nbsp);
            }
            $this->html .= !is_int($k) ? "{$nbsp}}<br>" : '';
        }
    }
}