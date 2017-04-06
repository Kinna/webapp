<?php
/**
 * Created by PhpStorm.
 * User: Kinna
 * Date: 12-09-2016
 * Time: 20:55
 */

namespace Controller;
use Logger\Logger;

class Controller
{
	protected $postData = array();
	protected $filesData = array();

	public function __construct()
	{
	}

	public function fetchPostData()
	{
		if(count($_POST) > 1) $this->postData = $_POST;
		else{
			$this->postData = json_decode(file_get_contents('php://input'));
			if($this->postData == '') $this->postData = array();
			if(is_object($this->postData)) $this->postData = get_object_vars($this->postData);
		}
		$this->filesData = $_FILES;
	}

	protected function respond($error, $data = null)
	{
		$array = array('error' => $error, 'data' => $data);
		Logger::log('Respond:');
		Logger::log(json_encode($array));
		header('Content-Type: application/json');
		echo json_encode($array);
	}
}