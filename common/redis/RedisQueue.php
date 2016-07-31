<?php

namespace common\redis;

trait RedisQueue {

	abstract protected function getQueueKey();

	private $redis_accessor;

	public function __construct(RedisConfig $redis_config) {
		$this->redis_accessor = new RedisListAccessor($redis_config);
	}

	public function pop($timeout=1){
		return $this->redis_accessor->blPop($this->getQueueKey(), $timeout);
	}

	public function push($value){
		return $this->redis_accessor->rPush($this->getQueueKey(), $value);
	}

	public function remove($value, $count=1){
		return $this->redis_accessor->lRem($this->getQueueKey(), $value, $count);
	}

	public function size(){
		return $this->redis_accessor->lLen($this->getQueueKey());
	}

	public function toArray($from=0, $to=-1){
		return $this->redis_accessor->lRange($this->getQueueKey(), $from, $to);
	}
}
