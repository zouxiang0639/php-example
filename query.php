<?php
include 'QueryList.class.php';

class querys{
    public $url;
    public function document(){

    }
}
?>

<?php
header("Content-type:text/html;charset=utf-8");

phpQuery::newDocumentFile('http://www.thinkphp.cn/topic/index.html');
$artlist = pq(".ext-list li");
echo '<pre>';

foreach($artlist as $li){
   echo pq($li)->find('.hd a:eq(1)')->html()."<br/>";
   echo pq($li)->find('.hd a:eq(1)')->attr('href')."<br/>";
}


?>