<?php

namespace infra;
require_once(__DIR__.'/autoloader.php');

use common\http\HttpClient;
use common\util\ArrayAccessor;
use common\util\ConfigAccessor;
use domain\Item;
use domain\RankingName;

class AmazonAssociateAPIClient {
use HttpClient;

    private $config_accessor;

    public function __construct(ConfigAccessor $config_accessor){
        $this->config_accessor = $config_accessor;
    }

    public function getRankingNames(){
        $path = "/itemset/names";
        $url = $this->getBaseUrl() . $path;

        $results = json_decode($this->httpGet($url)->getBody()->__toString(), true);

        $names = [];
        foreach($results as $result){
            $name = new ArrayAccessor($result);
            $names[] = new RankingName(
                $name->get("id")->value(),
                $name->get("name")->value()
            );
        }

        return $names;
    }

    public function getRecommend($item_set_id, $ranking_type){
        $path = "/items/ranking/recommend";
        $url = $this->getBaseUrl() . $path . "/$item_set_id/$ranking_type";

        $results = json_decode($this->httpGet($url)->getBody()->__toString(), true);

        $items = [];
        foreach($results as $result){
            $items[] = new Item($result);
        }

        return $items;
    }

    private function getBaseUrl(){
        return $this->config_accessor->getRequired("amazon_associate_api_url")->value();
    }

}