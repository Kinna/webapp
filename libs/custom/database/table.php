<?php
/**
 * Created by PhpStorm.
 * User: Kinna
 * Date: 20-11-2016
 * Time: 12:15
 */

namespace Database;


class Table
{
	private $name;
	public $sql;
	private $added_columns = array();
	private $deleted_columns = array();
	private $renamed_columns = array();

	public $add = false;
	public $delete = false;
	public $rename = false;

	public function __construct($db, $name)
	{
		$this->name = $name;
		// General columns

	}

	public function model()
	{
		$this->addColumn('id', 'INT UNSIGNED AUTO_INCREMENT PRIMARY KEY');
		$this->addColumn('date_created', 'DATETIME');
		$this->addColumn('date_uptated', 'DATETIME');
	}

	public function getAddedColumns()
	{
		return $this->added_columns;
	}

	public function getDeletedColumns()
	{
		return $this->deleted_columns;
	}

	public function getRenamedColumns()
	{
		return $this->renamed_columns;
	}

	// Data types

	public function tinytext($name)
	{
		$this->addColumn($name, 'TINYTEXT');
	}

	public function text($name)
	{
		$this->addColumn($name, 'TEXT');
	}

	public function int($name)
	{

	}

	public function datetime($name)
	{

	}

	// Alterings

	public function add()
	{
		$this->add = true;
		return $this;
	}

	public function delete($column)
	{
		$this->delete = true;
		$this->deleteColumn($column);
	}

	public function rename($from, $to)
	{
		$this->rename = true;
		$this->renameColumn($from, $to);
	}


	private function deleteColumn($name)
	{
		//$sql = 'ALTER TABLE ' . $this->name . 'DROP COLUMN ' . $name;
		//$this->db->execute_sql($sql);
		array_push($this->deleted_columns, $name);
	}

	private function addColumn($name, $value)
	{
		array_push($this->added_columns, array($name, $value));
	}

	private function renameColumn($from, $to)
	{
		array_push($this->renamed_columns, array($from, $to));
	}


}