<?php

namespace infra;
require_once(__DIR__.'/autoloader.php');

use common\util\ConfigAccessor;
use domain\Item;
use domain\NinjaBlogEntry;
use domain\RankingName;

class NinjaBlogEntryPublisher {

    private $amazon_api_client;

    private $config_accessor;

    public function __construct(ConfigAccessor $config_accessor){
        $this->config_accessor = $config_accessor;
        $this->amazon_api_client = new AmazonAssociateAPIClient($config_accessor);
        $this->ninja_api_client = new NinjaAPIClient($config_accessor);
    }

    /**
     * @param RankingName $ranking_name
     * @return string
     */
    public function publishNews($ranking_name){
        $items = $this->amazon_api_client->getRecommend($ranking_name->getAsin(), "news");
        $title = $ranking_name->getName();
        $description = array_map([$this, "createDescription"], $items);
        $entry = $this->createEntry($title, $description);
        $id = $this->config_accessor->getRequired("ninja_blog_id")->value();
        return $this->ninja_api_client->addEntry($id, $entry);
    }

    /**
     * @param Item $item
     * @return mixed
     */
    private function createDescription($item){
        return $item->toIFrame($this->config_accessor->getRequired("amazon_tracking_key")->value());
    }

    private function createEntry($title, $description){
        return new NinjaBlogEntry(
            1, 0, 2,
            $description, 0, $title
        );
    }
}