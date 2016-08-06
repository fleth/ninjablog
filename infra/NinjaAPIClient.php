<?php

namespace infra;
require_once(__DIR__.'/autoloader.php');

use common\http\HttpClient;
use common\util\ConfigAccessor;
use domain\NinjaBlogEntry;

class NinjaAPIClient {
use HttpClient;

    private $config_accessor;

    public function __construct(ConfigAccessor $config_accessor){
        $this->config_accessor = $config_accessor;
    }

    public function addEntry($id, NinjaBlogEntry $entry){
        $params = $entry->toArray();
        $params["id"] = $id;

        $token = $this->config_accessor->getRequired("ninja_api_access_token")->value();

        $headers = [
            "Authorization" => "Bearer " . $token,
            "Content-type" => "application/x-www-form-urlencoded;charset=UTF-8"
        ];

        $url = $this->getBaseUrl() . "/blog/v1/entry/add";

        return $this->httpPost($url, $params, $headers);
    }

    private function getBaseUrl(){
        return "https://api.shinobi.jp";
    }
}