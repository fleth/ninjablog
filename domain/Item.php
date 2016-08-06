<?php

namespace domain;
require_once(__DIR__.'/autoloader.php');

use common\util\ArrayAccessor;

class Item {

    private $item;

    public function __construct($array){
        $this->item = new ArrayAccessor($array);
    }

    public function getAsin(){
        return $this->item->get("asin")->value();
    }

    public function toIFrame($tracking_key){
        return '<iframe src="https://rcm-fe.amazon-adsystem.com/e/cm?t='.$tracking_key.'&o=9&p=8&l=as1&asins='.$this->getAsin().'&ref=tf_til&fc1=000000&IS2=1&lt1=_blank&m=amazon&lc1=0000FF&bc1=000000&bg1=FFFFFF&f=ifr" style="width:120px;height:240px;" scrolling="no" marginwidth="0" marginheight="0" frameborder="0"></iframe>';
    }
}