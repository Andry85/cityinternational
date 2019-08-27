<?php

namespace IllicitWeb;

use Exception;

function config($path)
{
	static $cache;

	if (!isset($cache))
	{
		$cache = [];
	}

	if (isset($cache[$path]))
	{
		return $cache[$path];
	}

	$parts = explode('.', $path);

	$basename = $parts[0].'.php';

	$file = CONFIG_DIR.$basename;

	if (!file_exists($file))
	{
		throw new Exception('Config file not found: '.$file);
	}

	$value = include $file;

	foreach (array_slice($parts, 1) as $part)
	{
		if (isset($value[$part]))
		{
			$value = $value[$part];
		}
		else
		{
			$value = null;
			break;
		}
	}

	$cache[$path] = $value;

	return $value;
}
