<?php

namespace infra;
require_once(__DIR__.'/autoloader.php');

use common\redis\RedisConfigFactory;
use common\redis\RedisSetAccessor;
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
        $redis_config = RedisConfigFactory::create($config_accessor, 0);
        $this->redis_set_accessor = new RedisSetAccessor($redis_config);
    }

    /**
     * @param RankingName $ranking_name
     * @return string
     */
    public function publishNews($ranking_name){
        $redis_key = $this->createNewsRedisKey($ranking_name);
        $items = $this->amazon_api_client->getRecommend($ranking_name->getId(), "news");
        $ids = $this->redis_set_accessor->member($redis_key);
        $title = $this->createNewsTitle($ranking_name);
        $descriptions = [];
        /** @var Item $item */
        foreach($items as $item){
            if(in_array($item->getAsin(), $ids)) continue;
            $color = (count($descriptions) % 2 == 0) ? "#FAFAFA" : "#FFFFFF";
            $descriptions[] = $this->createDescription($item, $color);
            $this->redis_set_accessor->add($redis_key, $item->getAsin());
        }
        if(empty($descriptions)) return "description is empty";
        $description = '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>'
            .implode("", $descriptions)."<br>";
        $entry = $this->createEntry($title, $description);
        $id = $this->config_accessor->getRequired("ninja_blog_id")->value();
        return $this->ninja_api_client->addEntry($id, $entry);
    }

    /**
     * @param RankingName $ranking_name
     * @return string
     */
    private function createNewsRedisKey($ranking_name){
        return "ninja_blog_entry_news:".$ranking_name->getId();
    }

    /**
     * @param RankingName $ranking_name
     * @return string
     */
    private function createNewsTitle($ranking_name, $time){
        $period = "(".date("m/d", strtotime("-1 week", $time))." ～".date("m/d", $time).")";
        return "今週".$period."発売の【".$ranking_name->getName()."】";
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
            2,
            $this->config_accessor->getRequired("ninja_blog_entry_category_id")->value(),
            $this->config_accessor->getRequired("ninja_blog_entry_open_flg")->value(),
            $description,
            $this->config_accessor->getRequired("ninja_blog_comment_receipt_flg")->value(),
            $title
        );
    }
}
