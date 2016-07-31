<?php

namespace common\redis;

class RedisHashAccessor extends RedisAccessor {

	/** @var string $hash_key  */
	private $hash_key;

	/**
	 * @param string $hash_key キー
	 * @param RedisConfig $redis_config
	 */
	public function __construct($hash_key, RedisConfig $redis_config){
		$this->hash_key = $hash_key;
		parent::__construct($redis_config);
	}

	/**
	 * ハッシュの指定したフィールドの値を取得する
	 *
	 * @param string $field フィールド
	 * @return string
	 */
	public function get($field){
		return $this->redis->hGet($this->hash_key, $field);
	}

	/**
	 * ハッシュの指定したフィールドに値を設定する
	 *
	 * @param string $field フィールド
	 * @param string $value 値
	 * @return int
	 */
	public function set($field, $value){
		return $this->redis->hSet($this->hash_key, $field, $value);
	}

	/**
	 * ハッシュのフィールドリストを取得する
	 *
	 * @return array
	 */
	public function fields(){
		return $this->redis->hKeys($this->hash_key);
	}

	/**
	 * ハッシュにフィールドが存在するか
	 *
	 * @param string $field フィールド
	 * @return bool
	 */
	public function exists($field){
		return $this->redis->hExists($this->hash_key, $field);
	}

	/**
	 * ハッシュのフィールドを削除する
	 *
	 * @param string $field フィールド
	 * @return int
	 */
	public function delete($field){
		return $this->redis->hDel($this->hash_key, $field);
	}
}
