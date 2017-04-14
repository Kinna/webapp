<?php
/**
 * Created by PhpStorm.
 * User: Kinna
 * Date: 06-04-2017
 * Time: 13:59
 */

namespace Model;


class Validator{

	private $valid;
	private $properties = array();

	public function int($data){
		return is_integer($data);
	}

	public function intNotZero($data){
		if(!is_integer($data)) return false;
		if($data == 0) return false;
		return true;
	}

	public function stringNotEmpty($data){
		if(!is_string($data)) return false;
		if($data == '') return false;
		return true;
	}

	public function string($data){
		return is_string($data);
	}

	public function arrayOfInt($data){
		if(!is_array($data)) return false;
		foreach($data as $val){
			if(!is_int($val)) return false;
		}
		return true;
	}

	public function arrayOfDecimal($data){
		if(!is_array($data)) return false;
		foreach($data as $val){
			if(!is_int($val) && !is_double($val) && !is_float($val)) return false;
		}
		return true;
	}

	public function arrayOfString($data){
		return false;
	}



	public function validateObject($data, $expect){
		$propertyResult = array();
		$valid = true;

		foreach($expect as $key => $value){
			switch($value){
				case 'int':
					$propertyResult[$key] = $this->int($data[$key]);
					break;
				case 'intNotZero':
					$propertyResult[$key] = $this->intNotZero($data[$key]);
					break;
				case 'stringNotEmpty':
					$propertyResult[$key] = $this->stringNotEmpty($data[$key]);
					break;
				case 'arrayOfInt':
					$propertyResult[$key] = $this->arrayOfInt($data[$key]);
					break;
				case 'arrayOfDecimal':
					$propertyResult[$key] = $this->arrayOfDecimal($data[$key]);
					break;
				default:
					$propertyResult[$key] = null;
			}
			if(!$propertyResult[$key]) $valid = false;
		}
		$validationResult = new ValidationResult($valid, $propertyResult);
		return $validationResult;
	}

}