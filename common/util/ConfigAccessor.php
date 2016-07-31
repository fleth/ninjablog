<?php

namespace common\util;

class ConfigAccessor extends ArrayAccessor{

	/**
	 * @param array $config コンフィグ
	 * @param string $parent_key 親のキー
	 */
	public function __construct($config, $parent_key="root"){
		parent::__construct($config, $parent_key, true);
	}
}
