<?php

namespace common\redis;

use common\util\ConfigAccessor;

class RedisConfigFactory {
    public static function create(ConfigAccessor $config_accessor, $index){
        $redis = $config_accessor->get("redis")->index($index);
        return new RedisConfig(
            $redis->get("host")->value(),
            $redis->get("port")->value(),
            $redis->get("prefix")->value()
        );
    }
}