<?php

namespace common\util;

class LoggerConfigFactory {
    public static function create(ConfigAccessor $config_accessor){
        $logger = $config_accessor->get("logger");
        return new LoggerConfig(
            $logger->get("log_dir")->value(),
            $logger->get("prefix")->value()
        );
    }
}