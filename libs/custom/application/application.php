<?php

/**
 * Created by PhpStorm.
 * User: Kinna
 * Date: 09-09-2016
 * Time: 17:50
 */
namespace Application;


use Environment\Environment;
use Logger\Logger;

class Application
{
	private $getRoutes = Array();
	private $postRoutes = Array();

	public function __construct()
	{
		// This autoload must come before anything else
		spl_autoload_register(function ($class){
			$pathArray = preg_split('/[\\\\\/]/', $class, -1, PREG_SPLIT_NO_EMPTY);
			$filenameArray = array();
			for($i = 0; $i < count($pathArray); $i++)
			{
				//echo $pathArray[$i] . ', ';
				// Convert from capital letter split do dash-split
				$elementArray = preg_split('/(?=[A-Z])/', $pathArray[$i], -1, PREG_SPLIT_NO_EMPTY);
				$element = strtolower(join('-', $elementArray));
				array_push($filenameArray, $element);
			}
			$filename = join('/', $filenameArray);

			//echo '<br />Filename: ' . $filename . '<br />';
			$libFile = __DIR__.'/../'.$filename.'.php';
			$controllerFile = __DIR__.'/../../../app/controllers/'.$filename.'.php';
			$modelFile = __DIR__.'/../../../app/models/'.$filename.'.php';
			if(file_exists($libFile))
			{
				require_once($libFile);
			}
			else if(file_exists($controllerFile))
			{
				require_once($controllerFile);
			}
			else if(file_exists($modelFile))
			{
				require_once($modelFile);
			}
		});

		$env = new Environment();
		$env->load();
	}

	public function run()
	{
		Logger::clear();
		Logger::log('Application is running');
		Logger::log($_ENV);
		$this->execute_route();
	}

	/**
	 * @param $route
	 * @param $action A string representing either the view to return or the controller and function to execute,
	 * separated with @.
	 * @param $restricted Whether access is restricted to logged in users
	 */
	public function get($route, $action, $restricted = false)
	{
		$this->getRoutes[$route] = array('action' => $action, 'restricted' => $restricted);
	}

	public function post($route, $action, $restricted = false)
	{
		$this->postRoutes[$route] = array('action' => $action, 'restricted' => $restricted);
	}

	// uri    /users/2/get/54
	// route  /users/$group/get/$id

	private function execute_route()
	{
		Logger::log($_SERVER);
		$method = $_SERVER['REQUEST_METHOD'];
		// Because localhost does not use htaccess file
		$path = $_SERVER['HTTP_HOST'] == 'localhost' ? $_SERVER['REQUEST_URI'] : $_GET['path'];
		$uri = ltrim(rtrim($path, '/'), '/');

		if($method == 'GET')
		{
			$this->parse_route($this->getRoutes, $uri);
		}
		else if($method == 'POST')
		{
			$this->parse_route($this->postRoutes, $uri);
		}
	}

	private function parse_route($routes, $uri)
	{
		$route = $this->compare_uri($routes, $uri);
		Logger::log('Route: ' . $route);
		if($route)
		{
			if($routes[$route]['restricted']){
				if(!User::has_access($routes[$route]['restricted']))
				{
					http_response_code(401);
					echo '<h1>404</h1><h3>The requested URL needs authenticated user</h3>';
					return;
				}
			}
			$vars = $this->get_variables($route, $uri);
			Logger::log('Variables:');
			Logger::log($vars);
			$this->parseAction($routes[$route]['action'], $vars);
		}
		else
		{
			http_response_code(404);
			echo '<h1>404</h1><h3>The requested URL cannot be found</h3>';
		}
	}

	private function compare_uri($routes, $uri)
	{
		$uriArray = explode('/', $uri);
		// Loop through all routes, the elements are not used, but key => value syntax is needed to get the keys
		foreach ($routes as $route => $elements)
		{
			Logger::log('Comparing URI with route ' . $route);
			$routeArray = explode('/', ltrim(rtrim($route, '/'), '/'));
			if(count($uriArray) == count($routeArray))
			{
				$match = true;
				for($i = 0; $i < count($uriArray); $i++)
				{
					if(!(strpos($routeArray[$i], '$') === 0) && $routeArray[$i] != $uriArray[$i])
					{
						$match = false;
						//break;
					}
				}
				if($match) return $route;
			}
		}
		return false;
	}

	private function get_variables($route, $uri)
	{
		$vars = array();
		$uriArray = explode('/', $uri);
		$routeArray = explode('/', $route);
		for($i = 0; $i < count($routeArray); $i++)
		{
			if(strpos($routeArray[$i], '$') === 0)
			{
				Logger::log('Adding variable: ' . $routeArray[$i]);
				$vars[substr($routeArray[$i], 1)] = $uriArray[$i];
			}
		}
		return $vars;
	}

	private function parseAction($action, $vars)
	{
		$actions = explode('@', $action);
		// Return view
		if(count($actions) == 1){
			$file = $actions[0] . '.php';
			echo file_get_contents($_ENV['ROOT'] . '/app/views/' . $file);

			Logger::log('Display file ' . $file);
		}
		// Execute controller function
		else if(count($actions) == 2){

			Logger::log('Controller: ' . $actions[0]);
			Logger::log('Method: ' . $actions[1]);
			if(!class_exists($actions[0])){
				Logger::log('Controller does not exist: ' . $actions[0]);
				http_response_code(500);
				return;
			}
			Logger::log('Creating controller');
			$controller = new $actions[0]();
			$method = $actions[1];
			Logger::log('Checking method');
			if(!method_exists($controller, $method)){
				Logger::log('Method does not exist in controller object ' . $actions[0] . ': ' . $method);
				http_response_code(500);
				return;
			}

			Logger::log('Executing controller function');
			header('Content-Type: application/json');
			http_response_code(200);
			$controller->getPostData();
			$controller->$method($vars);
		}
		else{
			Logger::log('No action for ' . $action);
			http_response_code(404);
		}
	}
}