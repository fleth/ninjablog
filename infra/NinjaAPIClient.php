<?php

namespace infra;
require_once(__DIR__.'/autoloader.php');

use common\http\HttpClient;
use domain\NinjaBlogEntry;

class NinjaAPIClient {
use HttpClient;

    public function addEntry($id, NinjaBlogEntry $entry){
        $params = $entry->toArray();
        $params["id"] = $id;

        $url = $this->getBaseUrl() . "/blog/v1/entry/add";

        return $this->httpPost($url, $params);
    }

    private function getBaseUrl(){
        return "https://api.shinobi.jp";
    }
}