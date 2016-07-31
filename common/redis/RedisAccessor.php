<?php

namespace common\redis;

use Redis;

abstract class RedisAccessor {
	protected $redis;
	private $redis_config;

	public function __construct(RedisConfig $redis_config){
		$this->redis_config = $redis_config;
		$this->redis = new \Redis();
		$this->redis->connect($this->redis_config->host(), $this->redis_config->port());
		$this->redis->setOption(Redis::OPT_PREFIX, $this->redis_config->prefix());
	}
}
