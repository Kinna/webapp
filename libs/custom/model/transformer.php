<?php
/**
 * Created by PhpStorm.
 * User: Kinna
 * Date: 07-04-2017
 * Time: 17:25
 */

namespace Model;


class Transformer{

	public function int($data){
		if($data == '') return false;
		return intval($data);
	}

	public function toJson($data){
		return json_encode($data);
	}

	public function fromJson($data){
		return json_decode($data);
	}

	public function transformObject($data, $expect){
		$newData = $data;
		foreach($expect as $key => $value){
			switch($value){
				case 'int':
					$newData[$key] = $this->int($data[$key]);
					break;
				case 'toJson':
					$newData[$key] = $this->toJson($data[$key]);
					break;
				case 'fromJson':
					$newData[$key] = $this->fromJson($data[$key]);
					break;
				default:
					break;
			}
		}
		return $newData;
	}
}