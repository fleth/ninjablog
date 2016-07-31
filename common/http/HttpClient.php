<?php

namespace common\http;
require_once(__DIR__."/../../vendor/autoload.php");

trait HttpClient {

	/**
	 * 指定したURLをGETする
	 *
	 * @param string $url
	 * @param array $params
	 * @return string
	 */
	protected function httpGet($url, $params=[]){
		$client = new \GuzzleHttp\Client();
		$response = $client->request("GET", $url, ["query" => $params]);

		return $response;

	}

	/**
	 * 指定したURLにPOSTする
	 *
	 * @param string $url
	 * @param array $params
	 * @return string
	 */
	protected function httpPost($url, $params=[]){
		$client = new \GuzzleHttp\Client();
		$response = $client->request("POST", $url, ["body" => $params]);

		return $response;
	}

	/**
	 * 指定したURLにPUTする
	 *
	 * @param string $url
	 * @param array $params
	 * @return string
	 */
	protected function httpPut($url, $params=[]){
		$client = new \GuzzleHttp\Client();
		$response = $client->request("PUT", $url, ["body" => $params]);

		return $response;
	}

	protected function httpDelete(){
		throw new \Exception("DELETE method is no supported");
	}
}
