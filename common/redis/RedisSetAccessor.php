<?php

namespace common\redis;

class RedisSetAccessor extends RedisAccessor {

    /**
     * セットに値を追加する
     *
     * @param string $key キー
     * @param string $value 値
     * @return int
     */
    public function add($key, $value){
        return $this->redis->sAdd($key, $value);
    }

    /**
     * セットの内容を取得する
     *
     * @param string $key キー
     * @return array
     */
    public function member($key){
        return $this->redis->sMembers($key);
    }

    /**
     * セットの指定した値を削除する
     *
     * @param string $key キー
     * @param string $value 値
     * @return int
     */
    public function delete($key, $value){
        return $this->redis->sRem($key, $value);
    }

    /**
     * セットのサイズを取得する
     *
     * @param string $key キー
     * @return int
     */
    public function size($key){
        return $this->redis->sCard($key);
    }
}