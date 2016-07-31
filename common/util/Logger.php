<?php

namespace common\util;

require_once("Log.php");

class Logger {

	/** @var LoggerConfig $config */
	private $config;

	/** @var \Log $logger */
	private $logger;

	/**
	 * @param LoggerConfig $config
	 * @param string $prefix
	 */
	public function __construct(LoggerConfig $config, $prefix = 'error'){
		$date = date('ymd');
		$this->config = $config;
		$this->logger = \Log::singleton('file', $this->config->logDir().'/'.$prefix.$date.'.log');
	}

	public function info($message){
		$this->logger->info($message);
	}

	public function err($message){
		$this->logger->err($message);
	}

	public function warn($message){
		$this->logger->warning($message);
	}

	public function debug($message){
		$this->logger->debug($message);
	}

	public function notice($message){
		$this->logger->notice($message);
	}
}
