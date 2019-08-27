<?php
namespace IllicitWeb;

use Exception;

class PathBuilder
{
	// Combines path components.
	static public function combine(array $path_components)
	{
		$path_components = array_values(array_filter($path_components, function ($path_component) {
			return is_string($path_component) && $path_component;
		}));

		if (!$path_components)
		{
			return null;
		}

		$first_char = substr($path_components[0], 0, 1);

		$has_leading_slash = ($first_char === '/');

		$path_components = array_map(function ($path_component) {
			return preg_replace('/\/{2,}/', '/', trim($path_component, '/'));
		}, $path_components);

		$path = implode('/', $path_components);

		if ($has_leading_slash)
		{
			$path = '/'.$path;
		}

		$path = preg_replace('/(\/{2,})/', '/', $path);

		if ($path !== '/')
		{
			$path = preg_replace('/\/+$/', '', $path);
		}

		return $path;
	}

	// Returns array containing:
	//  0 => path with extensionless basename
	//  1 => extension or null
	static public function splitByExtension($path)
	{
		assert(is_string($path));

		$basename = basename($path);
		$pieces = explode('.', $basename);
		$num_pieces = count($pieces);

		if ($num_pieces > 1)
		{
			$extension = $pieces[$num_pieces - 1];

			$extensionless_basename = substr($basename, 0, -(strlen($extension) + 1));
			
			$dirname = dirname($path);

			if ($dirname === '.')
			{
				$dirname = '';
			}

			$extensionless_path = PathBuilder::combine([
				$dirname, 
				$extensionless_basename
			]);
		}
		else
		{
			$extensionless_path = $path;
			$extension = null;
		}

		return [$extensionless_path, $extension];
	}

	static public function basenameAppend($path, $affix)
	{
		$split = self::splitByExtension($path);
		$extensionless = $split[0];
		$extension = $split[1];

		return $extension ? 
			"$extensionless$affix.$extension" : 
			"$extensionless$affix";
	}
}
