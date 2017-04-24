<?php
namespace app\pattern;

use ext\pattern\strategy\Comparator;
use ext\pattern\strategy\comparator\DateComparator;
use ext\pattern\strategy\comparator\IdComparator;

class Strategy
{

    public function __construct()
    {

       echo " <a href='".url('Strategy/testIdComparator')."'>ID排序</a>  <br>
                <a href='".url('Strategy/testDateComparator')."'>时间排序</a>  <br>";
    }

    public function index()
    {

        foreach (self::data() as $value){
            echo "ID = {$value['id']} ---------- date = {$value['date']} <br> ";
        }
    }

    public function data()
    {
        return [
            ['id' => 1, 'date' => '2014-02-09'],
            ['id' => 6, 'date' => '2014-02-08'],
            ['id' => 7, 'date' => '2014-02-07'],
            ['id' => 11, 'date' => '2014-02-6'],
            ['id' => 2, 'date' => '2014-02-05'],
            ['id' => 8, 'date' => '2014-02-04'],
            ['id' => 3, 'date' => '2014-02-03'],
            ['id' => 5, 'date' => '2014-02-02'],
            ['id' => 14, 'date' => '2014-02-01'],
            ['id' => 9, 'date' => '2014-02-10'],
        ];
    }


    //id排序
    public function testIdComparator()
    {
        $obj = new Comparator(self::data());
        $obj->setComparator(new IdComparator());
        $elements = $obj->sort();

        foreach ($elements as $value){
            echo "ID = {$value['id']} ---------- date = {$value['date']} <br> ";
        }

    }

    /**
     * @dataProvider getDateCollection
     */
    public function testDateComparator()
    {
        $obj = new Comparator(self::data());
        $obj->setComparator(new DateComparator());
        $elements = $obj->sort();

        foreach ($elements as $value){
            echo "ID = {$value['id']} ---------- date = {$value['date']} <br> ";
        }
    }
}