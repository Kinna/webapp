<?php
/**
 * Created by PhpStorm.
 * User: Kinna
 * Date: 10-12-2016
 * Time: 20:35
 */

namespace File;


class WriteFile
{
	private $text;

	public function __construct($initialText = '')
	{
		$this->text = $initialText;
	}

	public function save($filename)
	{
		$file = fopen($_SERVER['DOCUMENT_ROOT'] . $filename, "w") or die("Unable to open file!");
		fwrite($file, $this->text);
		fclose($file);
	}

	public function append($text)
	{
		$this->text .= $text;
	}

	public function overwrite($text)
	{
		$this->text = $text;
	}
}