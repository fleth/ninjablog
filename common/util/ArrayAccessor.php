<?php

namespace common\util;

class ArrayAccessor {

    /** @var string $parent_key */
    private $parent_key;

    /** @var array $array */
    private $array;

    /** @var bool $is_strict */
    private $is_strict;

    /**
     * @param array $array 扱う配列
     * @param string $parent_key 親のキー
     * @param bool $is_strict キーが存在しない場合に例外を投げるか
     */
    public function __construct($array, $parent_key="root", $is_strict=false){
        $this->array = $array;
        $this->parent_key = $parent_key;
        $this->is_strict = $is_strict;
    }

    /**
     * 指定したキーのConfigAccessorを取得する
     * keyが存在しない場合、デフォルト値を返す
     *
     * @param string $key キー
     * @param mixed $default デフォルト値
     * @return ConfigAccessor
     */
    public function get($key, $default=null){
        if(!$this->exists($key)) $this->setDefault("{$this->createKey($key)} not found", $key, $default);
        return new ConfigAccessor($this->array[$key], $this->createKey($key));
    }

    /**
     * 指定したキーのConfigAccessorを取得する
     * keyが存在しない場合、Exceptionを投げる
     *
     * @param string $key キー
     * @return ConfigAccessor
     */
    public function getRequired($key){
        if(!$this->exists($key)) throw new \InvalidArgumentException("{$this->createKey($key)} not found");
        return new ConfigAccessor($this->array[$key], $this->createKey($key));
    }

    /**
     * 現在のキーの値を取得する
     *
     * @return mixed
     */
    public function value(){
        if(is_array($this->array)) throw new \InvalidArgumentException("{$this->parent_key} is not a value");
        return $this->array;
    }

    /**
     * 指定したインデックスのConfigAccessorを取得する
     * keyが存在しない場合、デフォルト値を返す
     *
     * @param int $index インデックス
     * @param mixed $default デフォルト値
     * @return ConfigAccessor
     */
    public function index($index, $default=null){
        if(!is_array($this->array)) throw new \InvalidArgumentException("{$this->parent_key} is not array ");
        if(!$this->isVector($this->array)) throw new \InvalidArgumentException("{$this->parent_key} is not vector");
        if(!$this->exists($index))  $this->setDefault("{$this->createKey($index)} not found", $index, $default);
        return new ConfigAccessor($this->array[$index], $this->createKey($index));
    }

    /**
     * 指定したインデックスのConfigAccessorを取得する
     * keyが存在しない場合、Exceptionを投げる
     *
     * @param int $index インデックス
     * @return ConfigAccessor
     */
    public function indexRequired($index){
        if(!is_array($this->array)) throw new \InvalidArgumentException("{$this->parent_key} is not array ");
        if(!$this->isVector($this->array)) throw new \InvalidArgumentException("{$this->parent_key} is not vector");
        if(!$this->exists($index)) throw new \InvalidArgumentException("{$this->createKey($index)} not found");
        return new ConfigAccessor($this->array[$index], $this->createKey($index));
    }

    /**
     * 指定したキーが存在するか
     *
     * @param string $key キー
     * @return bool
     */
    public function exists($key){
        if(!is_array($this->array)) throw new \InvalidArgumentException("{$this->parent_key} is not array ");
        return array_key_exists($key, $this->array);
    }

    /**
     * 配列を返す
     *
     * @return array
     */
    public function toArray(){
        return $this->array;
    }

    /**
     * （連想配列ではない）配列かどうか
     *
     * @param array $array 扱う配列
     * @return bool
     */
    private function isVector($array){
        return array_values($array) == $array;
    }

    /**
     * キーの構造を表す文字列を返す
     *
     * @param string $key キー
     * @return string
     */
    private function createKey($key){
        return "$this->parent_key>>$key";
    }

    /**
     * デフォルト値を設定する。is_strictがtrueなら例外を返す
     *
     * @param string $message メッセージ
     * @param string $key キー
     * @param mixed $default デフォルト値
     */
    private function setDefault($message, $key, $default=null){
        if($this->is_strict){
            throw new \InvalidArgumentException($message);
        }else{
            $this->array[$key] = $default;
        }
    }
}