<?php

namespace Database;

use Logger\Logger;
use PDO;

class Row
{

	private $db;
	private $table;


	public function __construct($table, $db){
		$this->db = $db;
		$this->table = $table;
	}

	/**
	 * @param $columns Arrays of columns to be selected from the table.
	 * @param $filter Array of key-value pairs to limit the results. The
	 * values must consist of a comparator and a value, separated by a space.
	 * @param $order Column name and sort order (ASC, DESC).
	 */
	public function get($columns = null, $filter = null, $order = null){
		$sql = 'SELECT ';
		if($columns == null) $sql .= '*';
		else{
			$first = true;
			foreach ($columns as $col){
				if(!$first) $sql .= ', ';
				$sql .= $col;
				$first = false;
			}
		}
		$sql .= ' FROM ' . $this->table;

		if($filter != null){
			$values = array();
			$sql .= ' WHERE ';
			$first = true;
			foreach ($filter as $key => $value){
				$v = explode(' ', $value);
				if(!$first) $sql .= ' AND ';
				$sql .= ' ' . $key . ' ' . $v[0] . ' ?';
				array_push($values, $v[1]);
			}
		}

		if($order != null) $sql .= ' ORDER BY ' . $order;

		$statement = $this->prepareAndExecute($sql, $values);
		if($statement == false) return false;
		else return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function insert($data){
		$sql = 'INSERT INTO ' . $this->table . ' SET ';
		$values = array();
		$first = true;
		foreach ($data as $key=>$value){
			if(!$first) $sql .= ', ';
			$sql .= $key . '=?';
			array_push($values, $value);
			$first = false;
		}
		$statement = $this->prepareAndExecute($sql, $values);
		if($statement == false) return false;
		else return true;
	}

	public function lastId(){
		return $this->db->lastInsertId();
	}

	private function prepareAndExecute($sql, $values){
		Logger::log($sql);
		try{
			$statement = $this->db->prepare($sql);
		}catch(\PDOException $e){
			Logger::log('Unable to prepare query string <' . $sql . '>: ' . $e->getMessage());
			return false;
		}

		try{
			$ok = $statement->execute($values);
		}catch(\PDOException $e){
			Logger::log('Unable to execute query <' . $sql . '>: ' . $e->getMessage());
			return false;
		}

		return $ok;
	}
}