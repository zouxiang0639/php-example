<?php

header('content-type:text/html; charset=UTF-8');

/**
 * 观察者模式
 * @author: Mac
 * @date: 2012/02/22
 */


class Paper{ /* 主题    */
    private $_observers = array();

    public function register($sub){ /*  注册观察者 */
        $this->_observers[] = $sub;
    }


    public function trigger(){  /*  外部统一访问    */
        if(!empty($this->_observers)){
            foreach($this->_observers as $observer){
                $observer->update();
            }
        }
    }
}








/**
 * 观察者要实现的接口
 */
interface Observerable{
    public function update();
}

class Subscriber implements Observerable{
    public function update(){
        echo "Callback\n";
    }
}
class Subscriber1 implements Observerable{
    public function update(){
        echo "Subscriber1\n";
    }
}

$paper = new Paper();
$paper->register(new Subscriber());
 $paper->register(new Subscriber1());
//$paper->register(new Subscriber2());
$paper->trigger();

/*$curl = curl_init();
curl_setopt($curl,CURLOPT_URL,'http://21cto.com/');
curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
curl_setopt($curl,CURLOPT_REFERER,'http://weibo.com');
curl_setopt($curl,CURLOPT_HEADER,0);
curl_setopt($curl,CURLOPT_NOBODY,0);
$output = curl_exec($curl) or die(curl_error($curl));
$gitinfo = curl_getinfo($curl);
if($output == false){
    echo curl_error($curl);
}else {
   var_dump($gitinfo);

}
curl_close($curl);*/

