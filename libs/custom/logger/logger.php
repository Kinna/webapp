<?php

namespace Logger;


class Logger
{
	private static $path;

	private function __construct()
	{
	}

	/*public static function create($path)
	{
		self::$path = $path;
		file_put_contents($path,'');
	}*/
	public static function clear()
	{
		$file = fopen($_SERVER['DOCUMENT_ROOT'] . '/../log.txt','w');
		fclose($file);
	}

	public static function log($msg)
	{
		$file = fopen($_SERVER['DOCUMENT_ROOT'] . '/../log.txt','a');

		try
		{
			if(is_array($msg) || is_object($msg))
			{
				fwrite($file, self::logArray($msg, '', '') . PHP_EOL);
			}
			else
			{
				fwrite($file, $msg . PHP_EOL);
			}
		}
		catch(Exception $e)
		{
			fwrite($file, 'ERROR' . PHP_EOL);
		}

		fclose($file);
	}


	private static function logArray($msg, $indent, $text)
	{

		if(is_array($msg)) $text .= $indent . 'Array()' . PHP_EOL;
		elseif(is_object($msg)) $text .= $indent . 'Object()' . PHP_EOL;
		$indent .= '   ';

		foreach ($msg as $key => $value)
		{
			if(is_array($value) || is_object($value)) $text .= $indent . $key . ' = ' . self::logArray($value, $indent, $text);
			elseif(is_bool($value)) $text .= $indent . $key . ' = ' . ($value ? 'TRUE' : 'FALSE') . PHP_EOL;
			else $text .= $indent . $key . ' = ' . $value . PHP_EOL;
		}
		return $text;
	}
}