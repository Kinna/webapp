<?php

namespace Environment;

class Environment
{


	public function __construct()
	{
	}

	public function load()
	{
		$_ENV['ROOT'] = dirname(dirname(dirname(dirname(__FILE__)))) . '/'; //$_SERVER['DOCUMENT_ROOT'].'/../';
		$file = fopen($_ENV['ROOT'] . '.env', 'r') or die('Unable to open environment file!');
		do
		{
			$env = fgets($file);
			$elem = explode('=', $env);
			if(count($elem) == 2)
			{
				$_ENV[trim(preg_replace('/\s+/', '', $elem[0]))] = trim(preg_replace('/\s+/', '', $elem[1]));
			}
		}
		while($env);

		fclose($file);
	}
}