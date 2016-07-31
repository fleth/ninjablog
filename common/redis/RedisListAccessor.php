<?php

namespace common\redis;

class RedisListAccessor extends RedisAccessor {

	/**
	 * リストの先頭の要素をblocking popする
	 * 要素が存在しない場合、指定した時間待つ
	 *
	 * @param string $key キー
	 * @param int $timeout 待ち時間
	 * @return array
	 */
	public function blPop($key, $timeout){
		$pair = $this->redis->blpop($key, $timeout);
		return empty($pair) ? [] : $pair[1];
	}
	/**
	 * リストの末尾の要素をblocking popする
	 * 要素が存在しない場合、指定した時間待つ
	 *
	 * @param string $key キー
	 * @param int $timeout 待ち時間
	 * @return array
	 */
	public function brPop($key, $timeout){
		$pair = $this->redis->brpop($key, $timeout);
		return empty($pair) ? [] : $pair[1];
	}

	/**
	 * リストの先頭に要素を追加する
	 *
	 * @param string $key キー
	 * @param string $value 値
	 * @return int
	 */
	public function lPush($key, $value){
		return $this->redis->lpush($key, $value);
	}

	/**
	 * リストの末尾に要素を追加する
	 *
	 * @param string $key キー
	 * @param string $value 値
	 * @return int
	 */
	public function rPush($key, $value){
		return $this->redis->rpush($key, $value);
	}

	/**
	 * リストの長さを取得する
	 *
	 * @param string $key キー
	 * @return int
	 */
	public function lLen($key){
		return $this->redis->lLen($key);
	}

	/**
	 * リストの指定した範囲の要素を取得する
	 *
	 * @param string $key キー
	 * @param int $from 開始位置
	 * @param int $to 終了位置
	 * @return array
	 */
	public function lRange($key, $from, $to){
		return $this->redis->lRange($key, $from, $to);
	}

	/**
	 * リストの指定した値を指定した数削除する
	 *
	 * @param string $key キー
	 * @param string $value 値
	 * @param int $count 削除する数
	 * @return int
	 */
	public function lRem($key, $value, $count){
		return $this->redis->lRem($key, $value, $count);
	}
}
