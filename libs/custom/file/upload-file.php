<?php
/**
 * Created by PhpStorm.
 * User: Kinna
 * Date: 14-09-2016
 * Time: 16:06
 */

namespace File;


class UploadFile
{
	protected $file;
	/*
	 * name = Billede 288.jpg
	   type = image/jpeg
	   tmp_name = C:\Users\Kinna\AppData\Local\Temp\phpFDE4.tmp
	   error = 0
	   size = 123954
	 */



	public function __construct($file)
	{
		$this->file = $file;
	}

	public function set_max_size($size)
	{

	}

	public function set_allowed_type($type)
	{

	}

	public function validate()
	{

	}

	public function save()
	{

	}
}