<?php

namespace domain;


class RankingName {
    private $asin;
    private $name;

    public function __construct($asin, $name){
        $this->asin = $asin;
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAsin()
    {
        return $this->asin;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}