<?php
/**
 * Created by PhpStorm.
 * User: Kinna
 * Date: 17-11-2016
 * Time: 13:26
 */

namespace User;


class Auth
{
	public static function has_access($level)
	{
		if($level === false) return true;

	}

	public static function login($user)
	{}
}