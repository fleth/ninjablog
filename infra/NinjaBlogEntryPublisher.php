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
        $descriptions = [];
        foreach($items as $item){
            $color = (count($descriptions) % 2 == 0) ? "#FAFAFA" : "#FFFFFF";
            $descriptions[] = $this->createDescription($item, $color);
        }
        $description = '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>'
            .implode("", $descriptions).implode("", $descriptions);
        $entry = $this->createEntry($title, $description);
        $id = $this->config_accessor->getRequired("ninja_blog_id")->value();
        return $this->ninja_api_client->addEntry($id, $entry);
    }

    /**
     * @param Item $item
     * @param $color
     * @return mixed
     */
    private function createDescription($item, $color){
        return $item->toDescription($color);
    }

    private function createEntry($title, $description){
        return new NinjaBlogEntry(
            2, 0, 2,
            $description, 0, $title
        );
    }
}