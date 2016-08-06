<?php

require_once(__DIR__."/../config.php");

use common\util\ConfigAccessor;
use infra\AmazonAssociateAPIClient;
use infra\NinjaBlogEntryPublisher;

class NewsPublisher {

    private $amazon_api_client;

    public function __construct(ConfigAccessor $config_accessor){
        $this->amazon_api_client = new AmazonAssociateAPIClient($config_accessor);
        $this->ninja_blog_publisher = new NinjaBlogEntryPublisher($config_accessor);
    }

    public function execute(){
        $names = $this->amazon_api_client->getRankingNames();

        foreach($names as $name){
            $this->ninja_blog_publisher->publishNews($name);
        }
    }
}

(new NewsPublisher(new ConfigAccessor($config)))->execute();