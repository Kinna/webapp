<?php
/**
 * Created by PhpStorm.
 * User: Kinna
 * Date: 14-09-2016
 * Time: 16:12
 */

namespace File;

use Logger\Logger;

class UploadImage extends UploadFile
{
	private $image;
	private $width;
	private $height;

	public function __construct()
	{
		parent::__construct();

		if($this->is_jpg()) $this->image = imagecreatefromjpeg($this->file['tmp_name']);
		else if($this->is_png()) $this->image = imagecreatefrompng($this->file['tmp_name']);
		else Logger::log('Cannot create image object. File type not supported.');

		$size = getimagesize($this->file['tmp_name']);
		$this->width = $size[0];
		$this->height = $size[1];
	}
	/**
	 * Resize the image to maximum size within the limits while keeping the aspect ratio.
	 * @param $width Max width in px.
	 * @param $height Max height in px.
	 */
	public function resize($width, $height)
	{
		$wScale = $this->width / $width;
		$hScale = $this->height / $height;
		$maxScale = max($wScale, $hScale);
		// Decrease image dimensions
		if($maxScale > 1)
		{
			$width = $this->width / $maxScale;
			$height = $this->height / $maxScale;
		}
		// Increase image dimensions
		else
		{
			$minScale = min($wScale, $hScale);
			$width = $this->width / $minScale;
			$height = $this->height / $minScale;
		}
		$image = imagecreatetruecolor($this->width, $this->height);
		imagecopyresampled($image, $this->image, 0, 0, 0, 0, $width, $height, $this->width, $this->height);

		$this->image = $image;
		$this->width = $width;
		$this->height = $height;
	}

	/**
	 * Crop the image to have the given dimensions while keeping as much of the image as possible.
	 * @param $width Exact width in px.
	 * @param $height Exact height in px.
	 */
	public function crop($width, $height)
	{
		// Resize to minimum size
		$wScale = $this->width / $width; // 4
		$hScale = $this->height / $height; // 3
		$minScale = min($wScale, $hScale);
		// Decrease image dimensions
		if($minScale > 1)
		{
			$widthResize = $this->width / $minScale;
			$heightResize = $this->height / $minScale;
		}
		// Increase image dimensions
		else
		{
			$widthResize = $this->width / $minScale;
			$heightResize = $this->height / $minScale;
		}
		$image = imagecreatetruecolor($width, $height);
		$x = ($widthResize - $width) / 2;
		$y = ($heightResize - $height) / 2;
		imagecopyresampled($image, $this->image, 0, 0, $x, $y, $width, $height, $widthResize, $heightResize);

		$this->image = $image;
		$this->width = $width;
		$this->height = $height;
	}

	public function save($path, $filename)
	{
		if($this->is_jpg()) $success = imagejpeg($this->image, $path . '/' . $filename . '.jpg', 100);
		else if($this->is_png()) $success = imagepng($this->image, $path . '/' . $filename . '.png', 100);
	}

	private function is_jpg()
	{
		return $this->file['type'] == 'image/jpeg';
	}

	private function is_png()
	{
		return $this->file['type'] == 'image/png';
	}
}