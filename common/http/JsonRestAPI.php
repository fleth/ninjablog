<?php

namespace common\http;

use common\util\ArrayAccessor;
use common\util\ConfigAccessor;
use common\util\FileAccessor;
use common\util\Logger;
use common\util\LoggerConfigFactory;

trait JsonRestAPI {

	/**
	 * @return ConfigAccessor
	 */
	abstract protected function getConfigAccessor();

	/**
	 * @return Array
	 */
	abstract public function routes();

	/**
	 * POSTされたクエリを取得する
	 *
	 * @return ArrayAccessor
	 */
	public function getQuery(){
		$json_string = file_get_contents("php://input");
		return new ArrayAccessor(json_decode($json_string, true), "query");
	}

	/**
	 * エラー時のハンドリングしつつ成功時の処理を実行する
	 *
	 * @param callback $createSuccessResponseCallback 成功時のレスポンスを返す関数
	 * @return string
	 */
	public function createResponse($createSuccessResponseCallback){
		try{
			return $createSuccessResponseCallback();
		}catch(\InvalidArgumentException $e){
			return self::createInvalidArgumentResponse($e->getMessage());
		}catch(\Exception $e){
			self::getLogger()->err($e->__toString());
			return self::createInternalServerErrorResponse("internal server error");
		}
	}

	/**
	 * 成功時のレスポンスを生成する
	 *
	 * @param mixed $data
	 * @param bool $create_cache
	 * @return string
	 */
	public function createSuccessResponse($data, $create_cache=false){
		if($create_cache){
			self::createResponseCache($data);
		}
		$response = $data;
		return json_encode([
			"meta" => self::createMetaResponse(200, "success"),
			"data" => $response
		]);
	}

	/**
	 * パラメータエラー時のレスポンスを生成する
	 *
	 * @param string $message
	 * @return string
	 */
	public function createInvalidArgumentResponse($message){
		return json_encode([
			"meta" => self::createMetaResponse(400, $message)
		]);
	}

	/**
	 * サーバーエラー時のレスポンスを生成する
	 *
	 * @param string $message
	 * @return string
	 */
	public function createInternalServerErrorResponse($message){
		return json_encode([
			"meta" => self::createMetaResponse(500, $message)
		]);
	}

	/**
	 * レスポンスのメタデータを生成する
	 *
	 * @param int $status
	 * @param string $message
	 * @return array
	 */
	private function createMetaResponse($status, $message){
		return [
			"status" => $status,
			"message" => $message
		];
	}

	/**
	 * レスポンスのキャッシュファイルを作成する
	 *
	 * @param mixed $data
	 * @return int
	 */
	public function createResponseCache($data){
		$cache_name = self::getCacheFileName();
		$file = self::getCacheFile($cache_name);
		$dir = dirname($file->filename());
		if(!file_exists($dir)){
			$old = umask(0);
			mkdir($dir, 0777, true);
			umask($old);
		}
		return $file->write(json_encode(["data" => $data]));
	}

	/**
	 * キャッシュファイルの名前を返す
	 *
	 * @return string
	 */
	private function getCacheFileName(){
		/** @var Route $target_route */
		$target_route = null;
		$methodinfo = null;
		for($i=2; $target_route == null; $i++){
			$methodinfo = self::getPrevMethodCallable($i);
			$target_route = array_shift(array_filter(self::routes(), function($route) use ($methodinfo){
				/** @var Route $route */
				return ($route->callback() == $methodinfo["callback"]);
			}));
			if($methodinfo["max_depth"] <= $i+1) return "method_not_found";
		}
		$path = self::replacePathToArg($target_route->pattern(), $methodinfo["args"]);
		return implode("", [
			$target_route->method(),
			$path
		]);
	}

	/**
	 * ルートパスのパラメータに値を割り当てる
	 *
	 * @param string $path
	 * @param array $args
	 * @return mixed
	 */
	private function replacePathToArg($path, $args){
		if(empty($args)) return $path;
		$arg = array_shift($args);
		$replaced_path = preg_replace("/@[^\/]+/", $arg, $path, 1);
		return self::replacePathToArg($replaced_path, $args);
	}

	/**
	 * キャッシュファイルのFileAccessorを取得する
	 *
	 * @param string $cache_name
	 * @return FileAccessor
	 */
	private function getCacheFile($cache_name){
		$cache_dir = self::getConfig()->get("cache_dir")->value();
		$name = $cache_dir."/".$cache_name.".json";
		return new FileAccessor($name);
	}

	/**
	 * 指定した関数の情報を取得する
	 *
	 * @param int $depth 遡る関数の数
	 * @return array
	 */
	private function getPrevMethodCallable($depth){
		$dbg = debug_backtrace();
		return [
			"callback" => [$dbg[$depth]["class"], $dbg[$depth]["function"]],
			"args" => $dbg[$depth]["args"],
			"max_depth" => count($dbg)
		];
	}

	/**
	 * JsonRestAPI用のConfigAccessorを取得する
	 *
	 * @return ConfigAccessor
	 */
	private function getConfig(){
		return self::getConfigAccessor()->get("json_rest_api");
	}

	/**
	 * @return Logger
	 */
	private function getLogger(){
		return new Logger(LoggerConfigFactory::create(self::getConfigAccessor()));
	}
}
