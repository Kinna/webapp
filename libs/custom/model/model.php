<?php

/**
 * Created by PhpStorm.
 * User: Kinna
 * Date: 12-09-2016
 * Time: 09:50
 */
abstract class Model
{
	private $db;
	private $record = array();
	protected $table;

	public function __construct($db)
	{
		$this->db = $db;

	}

	public function get_record_by_id($id)
	{
		return $this->db->select($this->table)->where('id','=',$id)->execute();
	}

	public function get_all_records()
	{
		return $this->db->select($this->table)->execute();
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