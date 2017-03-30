<?php
/**
 * Created by PhpStorm.
 * User: Kinna
 * Date: 17-11-2016
 * Time: 13:23
 */

namespace User;
use Model;


class User extends Model
{
	public function __construct($db)
	{
		parent::__construct($db);
		$this->table = 'Users';
		$this->add_column('email', 'TINYTEXT');
		$this->add_column('password', 'TINYTEXT');
		$this->add_column('name', 'TINYTEXT');
	}


}