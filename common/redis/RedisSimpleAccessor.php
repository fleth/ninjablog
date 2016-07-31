<?php

namespace common\redis;

class RedisSimpleAccessor extends RedisAccessor {

	/**
	 * 指定したキーの値を取得する
	 *
	 * @param string $key キー
	 * @return bool|string
	 */
	public function get($key){
		return $this->redis->get($key);
	}

	/**
	 * 指定したキーに値を設定する
	 *
	 * @param string $key キー
	 * @param string $value 値
	 * @param int $expire 有効期限
	 * @return bool
	 */
	public function set($key, $value, $expire){
		return $this->redis->setEx($key, $expire, $value);
	}

	/**
	 * 指定したキーが存在するか
	 *
	 * @param string $key キー
	 * @return bool
	 */
	public function exists($key){
		return $this->redis->exists($key);
	}

	/**
	 * 指定したキーを削除する
	 *
	 * @param string $key キー
	 */
	public function delete($key){
		return $this->redis->del($key);
	}

	/**
	 * 指定したキーの有効期限を設定する
	 *
	 * @param string $key キー
	 * @param string $expire 有効期限
	 * @return bool
	 */
	public function expire($key, $expire){
		return $this->redis->expire($key, $expire);
	}

	/**
	 * キーのリストを取得する
	 *
	 * @param string $pattern パターン
	 * @return array
	 */
	public function keys($pattern){
		return $this->redis->keys($pattern);
	}
}
