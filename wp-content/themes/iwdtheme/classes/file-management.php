<?php

namespace IllicitWeb;

use Exception;

class FileManagement
{
	// Saves file to a currently non-existent file path.
	// Returns the saved file path.
	static public function saveUnique($base_dest_path, $data)
	{
		if (!is_string($base_dest_path))
		{
			throw new Exception('Not a string: '.gettype($base_dest_path));
		}

		$path = self::getUniquePath($base_dest_path);

		assert(!file_exists($path));

		$result = file_put_contents($base_dest_path, $data);

		if ($result === false)
		{
			throw new Exception('Failed to save file: '.$path);
		}

		return $path;
	}

	static public function getUniquePath($base_path)
	{
		assert(is_string($base_path));

		$dirname = dirname($base_path);

		if (!is_dir($dirname))
		{
			throw new Exception('Dir not found: '.$dirname);
		}

		$path = $base_path;

		$number = 1;

		while (file_exists($path))
		{
			++$number;

			$affix = "-$number";

			$path = PathBuilder::basenameAppend($base_path, $affix);
		}

		assert(is_string($path));

		return $path;
	}
}
