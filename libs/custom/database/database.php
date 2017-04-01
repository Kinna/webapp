<?php

namespace Database;

use Logger\Logger;
use PDO;

class Database
{

	private $db;


	public function __construct()
	{
		$test = $_ENV['TEST'] ? '_TEST' : '';
		Logger::log('Host: ' . $_ENV['DB_HOST' . $test]);
		Logger::log('Database: ' . $_ENV['DB_DATABASE' . $test]);
		Logger::log('Username: ' . $_ENV['DB_USERNAME' . $test]);
		Logger::log('Password: ' . $_ENV['DB_PASSWORD' . $test]);
		$this->db = new PDO('mysql:host='.$_ENV['DB_HOST' . $test].';dbname='.$_ENV['DB_DATABASE' . $test].';charset=utf8', $_ENV['DB_USERNAME' . $test], $_ENV['DB_PASSWORD' . $test]);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

		// Check the connection
		if($this->db->connect_errno > 0)
		{
			Logger::log('Database connection error: ' . $this->db->connect_error());
			die('Unable to connect to database: ' . $this->db->connect_error());
		}
	}

	public function getTableRow($tableName){
		return new Row($tableName, $this->db);
	}







	public function execute_sql($sql)
	{
		$this->db->exec($sql);
	}

	public function createTable($name, $callback){
		$table = new Table($this->db, $name);
		// This will set the table columns
		$callback($table);
		$sql = 'CREATE TABLE IF NOT EXISTS ' . $name . '(';
		$first = true;
		foreach($table->getAddedColumns() as $col)
		{
			if(!$first) $sql .= ', ';
			$sql .= $col[0] . ' ' . $col[1];
			$first = false;
		}
		$sql .= ')';
		Logger::log('Create table: ' . $sql);
		$result = $this->db->exec($sql);
		Logger::log('Created table ' . $name . '(' . $result . ')');
	}

	public function alterTable($name, $callback){
		$table = new Table($this->db, $name);
		// This will set the table columns
		$callback($table);
		$sql = 'ALTER TABLE ' . $name;
		$first = true;
		if($table->delete)
		{
			foreach ($table->getDeletedColumns() as $col)
			{
				if(!$first) $sql .= ', ';
				$sql .= 'DROP COLUMN ' . $col;
				$first = false;
			}
		}
		if($table->add)
		{
			foreach ($table->getAddedColumns() as $col)
			{
				if(!$first) $sql .= ', ';
				$sql .= 'ADD ' . $col[0] . ' ' . $col[1];
				$first = false;
			}
		}

		$this->db->exec($sql);
	}

	public function renameTable($from, $to)
	{
		$sql = 'RENAME TABLE ' . $from . ' TO ' . $to;
		$this->db->exec($sql);
	}

	public function deleteTable($name)
	{
		$sql = 'DROP TABLE IF EXISTS ' . $name;
		$this->db->exec($sql);
	}
}