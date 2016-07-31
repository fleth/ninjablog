<?php

namespace common\util;

class LoggerConfig{

	/**
	 * @var string $log_dir
	 */
	private $log_dir;

	/**
	 * @param string $log_dir ログディレクトリへのパス
	 */
	public function __construct($log_dir){
		$this->log_dir = $log_dir;
	}

	/**
	 * ログディレクトリへのパスを取得する
	 *
	 * @return string
	 */
	public function logDir(){
		return $this->log_dir;
	}
}
