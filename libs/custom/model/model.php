<?php

namespace Model;
/**
 * Created by PhpStorm.
 * User: Kinna
 * Date: 12-09-2016
 * Time: 09:50
 */
use Logger\Logger;
use Database\Database;

abstract class Model
{
	protected $db;
	protected $tableRow;
	protected $validator;

	public function __construct()
	{
		Logger::log('Model::construct()');
		$this->db = new Database();
		$this->validator = new Validator();
	}

	public function getRecordById($id)
	{
		$array = $this->tableRow->get(null, array('id' => '= ' . $id));
		return count($array) > 0 ? $array[0] : false;
	}

	public function getAllRecords($columns = null)
	{
		return $this->tableRow->get($columns);
	}

	public function set_record_field($field, $value)
	{

	}

	public function save_record()
	{

	}
	public function get($param)
	{

	}


}