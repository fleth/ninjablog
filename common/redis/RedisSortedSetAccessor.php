<?php

namespace common\redis;

class RedisSortedSetAccessor extends RedisAccessor {

	/**
	 * ソート済みセットに値を追加する
	 *
	 * @param string $key キー
	 * @param string $value 値
	 * @param int $score
	 * @return int
	 */
	public function add($key, $value, $score){
		return $this->redis->zAdd($key, $score, $value);
	}

	/**
 * ソート済みセットの指定した範囲の要素を照準で取得する
 *
 * @param string $key キー
 * @param int $from 開始位置
 * @param int $to 終了位置
 * @return array
 */
	public function range($key, $from, $to){
		return $this->redis->zRange($key, $from, $to);
	}

	/**
	 * ソート済みセットの指定した範囲の要素を降順で取得する
	 *
	 * @param string $key キー
	 * @param int $from 開始位置
	 * @param int $to 終了位置
	 * @return array
	 */
	public function revRange($key, $from, $to){
		return $this->redis->zRevRange($key, $from, $to);
	}

	/**
	 * ソート済みセットの指定したスコアの範囲の要素を昇順で取得する
	 *
	 * @param string $key キー
	 * @param string $from 最小値
	 * @param string $to 最大値
	 * @return array
	 */
	public function rangeByScore($key, $from, $to){
		return $this->redis->zRangeByScore($key, $from, $to);
	}

	/**
	 * ソート済みセットの指定したスコアの範囲の要素を降順で取得する
	 *
	 * @param string $key キー
	 * @param string $from 最小値
	 * @param string $to 最大値
	 * @return array
	 */
	public function revRangeByScore($key, $from, $to){
		return $this->redis->zRevRangeByScore($key, $from, $to);
	}

	/**
	 * ソート済みセットの指定した値を削除する
	 *
	 * @param string $key キー
	 * @param string $value 値
	 * @return int
	 */
	public function delete($key, $value){
		return $this->redis->zDelete($key, $value);
	}

	/**
	 * ソート済みセットのサイズを取得する
	 *
	 * @param string $key キー
	 * @return int
	 */
	public function size($key){
		return $this->redis->zCard($key);
	}
}
