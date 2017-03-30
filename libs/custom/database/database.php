<?php

namespace Database;

use Logger\Logger;
use PDO;

class Database
{
	private $debug;
	private $db;
	private $query_string;
	private $query_values = array();
	private $query_type;
	private $statement;

	public function __construct()
	{
		$test = $_ENV['TEST'] ? '_TEST' : '';
		echo 'Host: ' . $_ENV['DB_HOST' . $test] . PHP_EOL;
		echo 'Database: ' . $_ENV['DB_DATABASE' . $test] . PHP_EOL;
		echo 'Username: ' . $_ENV['DB_USERNAME' . $test] . PHP_EOL;
		echo 'Password: ' . $_ENV['DB_PASSWORD' . $test] . PHP_EOL;
		$this->db = new PDO('mysql:host='.$_ENV['DB_HOST' . $test].';dbname='.$_ENV['DB_DATABASE' . $test].';charset=utf8', $_ENV['DB_USERNAME' . $test], $_ENV['DB_PASSWORD' . $test]);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

		// Check the connection
		if($this->db->connect_errno > 0)
		{
			die('Unable to connect to database: ' . $this->db->connect_error());
		}
	}

	/*
	* Make the query ready for selecting data from a table.
	*/
	public function select($table)
	{
		$this->query_string = "SELECT * FROM $table";
		$this->query_type = 'select';
		$this->query_values = array();
		return $this;
	}

	/*
	* Make the query ready for getting max column row in a table.
	*/
	public function selectMax($table, $column)
	{
		$this->query_string = "SELECT MAX($column) FROM $table";
		$this->query_type = 'select';
		$this->query_values = array();
		return $this;
	}

	/*
	* Make the query ready for inserting data in a table.
	*/
	public function insert($table)
	{
		$this->query_string = "INSERT INTO $table";
		$this->query_type = 'insert';
		$this->query_values = array();
		return $this;
	}

	/*
	* Make the query ready for updating a table.
	*/
	public function update($table)
	{
		$this->query_string = "UPDATE $table";
		$this->query_type = 'update';
		$this->query_values = array();
		return $this;
	}

	/*
	* Make the query ready for deleting from a table.
	*/
	public function delete($table)
	{
		$this->query_string = "DELETE FROM $table";
		$this->query_type = 'delete';
		$this->query_values = array();
		return $this;
	}

	/*
	* Add the SET key and the first value to the query.
	*/
	public function set($row, $value)
	{
		$this->query_string .= " SET $row = ?";
		array_push($this->query_values, $value);
		return $this;
	}

	/*
	* Add additional values to the query
	*/
	public function andSet($row, $value)
	{
		$this->query_string .= ", $row = ?";
		array_push($this->query_values, $value);
		return $this;
	}

	/*
	* Add the WHERE key to the query.
	*/
	public function where($row, $comparator, $value)
	{
		$this->query_string .= " WHERE $row $comparator ?";
		array_push($this->query_values, $value);
		return $this;
	}

	/*
	* Add additional WHERE keys to the query.
	*/
	public function andWhere($row, $comparator, $value)
	{
		$this->query_string .= " AND $row $comparator ?";
		array_push($this->query_values, $value);
		return $this;
	}

	/*
	* Add the ORDER BY key to the query.
	*/
	public function orderBy($row, $order)
	{
		$this->query_string .= " ORDER BY $row $order";
		return $this;
	}

	/*
	* Add the LIMIT key to the query.
	*/
	public function limit($limit, $offset = 0)
	{
		if($offset > 0)	$this->query_string .= " LIMIT $offset , $limit";
		else $this->query_string .= " LIMIT $limit";
		return $this;
	}

	/*
	* Execute the query. The return value depends on the query type.
	*/
	public function execute()
	{
		//$this->statement->closeCursor();
		if($this->debug){
			Logger::log($this->query_string);
			Logger::log($this->query_values);
		}

		try
		{
			$this->statement = $this->db->prepare($this->query_string);

			if($this->debug) Logger::log('...prepared');
		}
		catch(PDOException $e)
		{
			Logger::log('Unable to prepare query string ' . $this->query_string . ': ' . $e->getMessage());
			return false;

		}

		try
		{
			$success = $this->statement->execute($this->query_values);
			if($this->debug) Logger::log('...executed');
		}
		catch(PDOException $e)
		{
			Logger::log('Unable to execute query. ' . $e->getMessage());
			return false;
		}

		switch($this->query_type)
		{
			case 'select':
				$result = $this->statement->fetchAll(PDO::FETCH_ASSOC);
				if($this->debug) Logger::log('...returned');
				return $result;
				break;
			case 'insert':
				if($this->debug) Logger::log('...returned');
				return $success;
				//return $this->db->lastInsertId();
				break;
			case 'update':
			case 'delete':
				if($this->debug) Logger::log('...returned');
				return $success;
				//return $stmt->rowCount();
				break;
			default:
				if($this->debug) Logger::log('Error: Unknown query type');
				return false;
				break;
		}
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
		echo $sql . PHP_EOL;
		$result = $this->db->exec($sql);
		echo 'Created table ' . $name . '(' . $result . ')' . PHP_EOL;
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
		$sql = 'DROP TABLE ' . $name;
		$this->db->exec($sql);
	}
}