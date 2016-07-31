<?php

namespace common\redis;

class RedisConfig {
	/** @var string $host */
	private $host;

	/** @var int $port */
	private $port;

	/** @var string $prefix */
	private $prefix;

	/**
	 * @param string $host ホスト名
	 * @param int $port ポート
	 * @param string $prefix keyのprefix
	 */
	public function __construct($host, $port=6379, $prefix=""){
		$this->host = $host;
		$this->port = $port;
		$this->prefix = $prefix;
	}

	/**
	 * ホスト名を取得する
	 * @return string
	 */
	public function host(){
		return $this->host;
	}

	/**
	 * ポートを取得する
	 * @return int
	 */
	public function port(){
		return $this->port;
	}

	/**
	 * keyのprefixを取得する
	 * @return string
	 */
	public function prefix(){
		return $this->prefix;
	}
}
