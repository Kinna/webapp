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
	protected $transformer;

	public function __construct()
	{
		Logger::log('Model::construct()');
		$this->db = new Database();
		$this->validator = new Validator();
		$this->transformer = new Transformer();
	}

	/**
	 * Get a single record by its ID.
	 * @param $id The id of the record.
	 * @return Returns the records as an array. Will return false if the record doesn't exist.
	 */
	public function getRecordById($id)
	{
		$array = $this->tableRow->get(null, array('id' => '= ' . $id));
		return count($array) > 0 ? $array[0] : false;
	}

	/**
	 * Get all records from a table.
	 * @param $columns Array of columns to include. Default is null and will select all columns.
	 * @return Returns array of records.
	 */
	public function getAllRecords($columns = null)
	{
		return $this->tableRow->get($columns);
	}

	/**
	 * Create a new record in the table.
	 * @param $data Array of key-value pairs.
	 * @return The new record on success and false otherwise
	 */
	public function createRecord($data)
	{
		$ok = $this->tableRow->insert($data);
		if(!$ok) return false;

		$id = $this->tableRow->lastId();
		return $this->getRecordById($id);
	}


}