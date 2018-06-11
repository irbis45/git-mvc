<?php

/**
 * Class Logger
 */
class Logger
{
	/**
	 * @var null
	 */
	private static
		$instance = null;
	
	/**
	 * @return Logger
	 */
	public static function getInstance()
	{
		if (null === self::$instance)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	private function __clone() {}
	private function __construct() {}
	
	/**
	 * @param        $data
	 * @param string $file_name
	 */
	public function log($data, $file_name = 'log')
	{
		$handle = fopen(getcwd() . '/' . $file_name . '-' . date('Y.m.d') . '.log', 'a+');
		
		if (is_array($data) || is_object($data)) {
			$data = json_encode($data);
		}
		
		$data = date('[d.m.Y H:i:s] ') . $data . "\n";
		fwrite($handle, $data);
		fclose($handle);
	}
}
