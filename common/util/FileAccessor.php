<?php

namespace common\util;

class FileAccessor {

    /** @var string $filename */
    private $filename;

    /**
     * @param string $filename ファイル名
     */
    public function __construct($filename){
        $this->filename = $filename;
    }

    /**
     * ファイル名を返す
     *
     * @return string
     */
    public function filename(){
        return $this->filename;
    }

    /**
     * ファイルへ書き込む
     *
     * @param string $data データ
     * @return int
     */
    public function write($data){
        return file_put_contents($this->filename, $data);
    }

    /**
     * ファイルから読み込む
     *
     * @return string
     */
    public function read(){
        return file_get_contents($this->filename);
    }

    /**
     * ファイルが存在するか
     *
     * @return bool
     */
    public function exists(){
        return file_exists($this->filename);
    }
}
