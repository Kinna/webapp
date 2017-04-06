<?php
/**
 * Created by PhpStorm.
 * User: Kinna
 * Date: 06-04-2017
 * Time: 14:44
 */

namespace Model;


class ValidationResult{
	private $valid;
	private $propertyResults;

	public function __construct($valid, $propertyResults){
		$this->valid = $valid;
		$this->propertyResults = $propertyResults;
	}

	public function isValid(){
		return $this->valid;
	}

	public function getPropertyResults(){
		return $this->propertyResults;
	}
}