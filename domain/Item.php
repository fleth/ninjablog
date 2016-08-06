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

    public function getTitle(){
        return $this->item->get("title")->value();
    }

    public function getDetailPageURL(){
        return $this->item->get("detailPageURL")->value();
    }

    public function getMediumImage(){
        return $this->item->get("mediumImage");
    }

    public function getPublicationDate(){
        return $this->item->get("publicationDate")->value();
    }

    public function toIFrame($tracking_key){
        return '<iframe src="https://rcm-fe.amazon-adsystem.com/e/cm?t='.$tracking_key.'&o=9&p=8&l=as1&asins='.$this->getAsin().'&ref=tf_til&fc1=000000&IS2=1&lt1=_blank&m=amazon&lc1=0000FF&bc1=000000&bg1=FFFFFF&f=ifr" style="width:120px;height:240px;" scrolling="no" marginwidth="0" marginheight="0" frameborder="0"></iframe>';
    }

    public function toDescription($color){
        return '
<div class="row col-xs-3 item-row" style="background-color: '.$color.';">
<div class="col-xs-3 item-image">
<a href="'.$this->getDetailPageURL().'" title="'.$this->getTitle().'">
        <img class="img-responsive center-block" style="max-height: 100px;" src="'.$this->getMediumImage()->get("url")->value().'">
</a>
</div>
<div class="col-xs-9 item-desc">
<a href="'.$this->getDetailPageURL().'" title="'.$this->getTitle().'">
<p class="lead" style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">牧場物語 3つの里の大切な友だち 公式パーフェクトガイド</p>
</a>
<br>
<span>発売日: "'.$this->getPublicationDate().'"</span>
</div>
</div>';
    }
}