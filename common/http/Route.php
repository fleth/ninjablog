<?php

namespace common\http;

class Route {

    /** @var string $method */
    private $method;

    /** @var string $pattern */
    private $pattern;

    /** @var callback $callback */
    private $callback;

    /**
     * @param string $method HTTPメソッド
     * @param string $pattern
     * @param callback $callback
     */
    public function __construct($method, $pattern, $callback){
        $this->method = $method;
        $this->pattern = $pattern;
        $this->callback = $callback;
    }

    public function method(){
        return $this->method;
    }

    public function pattern(){
        return $this->pattern;
    }

    public function callback(){
        return $this->callback;
    }

    public function toArray(){
        return [
            "path" => "{$this->method} {$this->pattern}",
            "callback" => $this->callback
        ];
    }
}
