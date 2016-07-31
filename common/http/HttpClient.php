<?php

namespace common\http;

trait HttpClient {

	/**
	 * 指定したURLをGETする
	 *
	 * @param string $url
	 * @param array $params
	 * @return string
	 */
	protected function httpGet($url, $params=[]){
		$param_strings = join('&', array_map(
			function($key, $value){return "{$key}={$value}";},
			array_keys($params),
			array_values($params)
		));
		$request_url = "{$url}";
		$request_url .= empty($params_strings) ? "" : "?{$param_strings}";

		/** TODO: warn発生時の検知方法が複雑になるためfile_get_contents以外の方法に変更する */
		return file_get_contents($request_url);

	}

	/** TODO: file_get_contents以外の方法に変更した際に実装する */
	protected function httpPost(){}
	protected function httpPut(){}
	protected function httpDelete(){}
}
