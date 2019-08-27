<?php
/*
 * Alpha is stored as 0 <= double <= 1.
 * 
 * There are helper methods for conversion to/from alpha values 0-127.
 *
 */

namespace IllicitWeb;

use Exception;

class Color {

	const MIN_COLOR_VALUE = -255;
	const MAX_COLOR_VALUE = 255;
	const MIN_ALPHA_VALUE = 0;
	const MAX_ALPHA_VALUE = 1;

	// R,G,B are ints 0-255; alpha is double 0-1.
	private $red = 0, 
			$green = 0,
			$blue = 0, 
			$alpha = 1;
	
	// @param $input_color mixed Can be any of the following:
	// 		RGB(A) array: 3- or 4-sized array of ints
	//		CSS-style RGB(A) string: e.g. 'rgb(0, 255, 34)', 'rgba(0,255,34,0.2)'
	// 		CSS-compatible hex string: 3 or 6 numbers (optional leading '#')
	//		CSS-compatible color word string: e.g. 'black'
	public function __construct($input = null) {

		if ($input === null)
		{
			return;
		}

		if ($this->isRgbString($input))
		{
			$this->setByRgbString($input);
		}
		elseif ($this->isHexString($input))
		{
			$this->setByHexString($input);
		}
		elseif ($this->isRgbArray($input))
		{
			$this->setByRgbArray($input);
		}
		elseif ($this->isColorWord($input))
		{
			$this->setByColorWord($input);
		}
		else {
			throw new BadColorInputException(
				'Bad input passed to Color constructor: '.json_encode($input));
		}
	}

	public function setByRgbString($rgb_string)
	{
		if (!$this->isRgbString($rgb_string))
		{
			throw new BadColorInputException('Not an RGB string: '.json_encode($rgb_string));
		}

		$rgb_array = $this->rgbStringToRgbArray($rgb_string);

		assert(is_array($rgb_array));

		$this->setByRgbArray($rgb_array);
	}

	public function setByHexString($hex_string)
	{
		if (!$this->isHexString($hex_string))
		{
			throw new BadColorInputException('Not a hex string: '.gettype($hex_string));
		}

		$cleaned_hex_string = $this->cleanHexString($hex_string);

		$this->setByRgbArray($this->hexStringToRgbArray($cleaned_hex_string));
	}

	public function setByRgbArray(array $rgb)
	{
		if (!$this->isRgbArray($input))
		{
			throw new BadColorInputException('Not an RGB array: '.json_encode($rgb));
		}

		$rgb_values = array_values($rgb);

		$this->setRed((int)$rgb_values[0]);
		$this->setGreen((int)$rgb_values[1]);
		$this->setBlue((int)$rgb_values[2]);

		if (isset($rgb_values[3]))
		{
			$this->setAlpha((double)$rgb_values[3]);
		}
	}

	public function setByColorWord($word)
	{
		if (strtolower($word) === 'transparent')
		{
			$this->setToTransparent();
			return;
		}

		if (!$this->isColorWord($word))
		{
			throw new BadColorInputException('Not a color word: '.json_encode($word));
		}

		$hex = $this->wordToHex($word);

		assert(is_string($hex));

		$this->setByHexString($hex);
	}

	public function setToTransparent()
	{
		$this->red = $this->green = $this->blue = $this->alpha = 0;
	}

	public function setRed($red)
	{
		$this->setRgbValue($red, 'red');
	}

	public function setGreen($green)
	{
		$this->setRgbValue($green, 'green');
	}

	public function setBlue($blue)
	{
		$this->setRgbValue($blue, 'blue');
	}

	public function setAlpha($alpha)
	{
		if (!is_double($alpha) && !is_int($alpha))
		{
			throw new BadColorInputException('Bad alpha type: '.gettype($alpha));
		}

		if ($alpha < 0 || $alpha > 1)
		{
			throw new BadColorInputException('Bad alpha value: '.$alpha);
		}

		$this->alpha = $alpha;
	}

	public function setAlpha128($value) {
		if (!is_int($value))
		{
			throw new BadColorInputException('Bad alpha128 value type: '.gettype($value));
		}

		if ($value < 0 || $value > 127)
		{
			throw new BadColorInputException('Invalid alpha128 value: '.$value);
		}

		$this->alpha = 1 - ($value / 127);
	}

	// @return 3- or 4-sized num array (depending whether alpha < 1)
	public function toRgbArray() 
	{
		$rgb_array = [$this->red, $this->green, $this->blue];

		if ($this->alpha < 1) 
		{
			$rgb_array[] = $this->alpha;
		}

		return $rgb_array;
	}
	
	// @return 4-sized num array
	public function toRgbaArray() 
	{
		return [$this->red, $this->green, $this->blue, $this->alpha];
	}
	
	public function toRgbString()
	{
		if ($this->alpha < 1) 
		{
			return $this->toRgbaString();
		} 

		return 'rgb('.$this->red.', '.$this->green.', '.$this->blue.')';
	}

	public function toRgbaString()
	{
		return 'rgba('.$this->red.', '.$this->green.', '.$this->blue.', '.$this->alpha.')';
	}
	
	// @return string 6-digit hex string without leading '#'
	public function toHexString() 
	{
		return $this->rgbArrayToHexString($this->toRgbArray());
	}

	public function getRed() 
	{
		return $this->red;
	}
	
	public function getGreen() 
	{
		return $this->green;
	}
	
	public function getBlue() 
	{
		return $this->blue;
	}
	
	public function getAlpha() 
	{
		return $this->alpha;
	}

	public function getAlpha128() 
	{
		return round(127 - ($this->alpha * 127));
	}
	
	// @amount $amount int Should probably be -255 >= n >= 255, but this is not enforced
	// @return void
	public function brighten($amount) 
	{
		$amount = (int)$amount;

		foreach (['red', 'green', 'blue'] as $prop)
		{
			$this->{$prop} = $this->limitColorValue($this->{$prop} + $amount);
		}
	}

	public function darken($amount)
	{
		$amount = (int)$amount;

		$this->brighten($amount * -1);
	}

	// @param double $amount Makes sense to be >= -1 && <= 1, but this is not enforced
	public function increaseAlpha($amount) 
	{
		$amount = (double)$amount;

		$this->alpha = $this->limitAlphaValue($this->alpha + 1);
	}

	public function decreaseAlpha($amount)
	{
		$amount = (double)$amount;

		$this->increaseAlpha($amount * -1);
	}

	public function allocateToResource($image_resource) 
	{
		if (!is_resource($image_resource))
		{
			throw new BadColorInputException('Not an image resource');
		}

		if ($this->alpha < 1) 
		{
			imagesavealpha($image_resource, true);

			return imagecolorallocatealpha(
				$image_resource, 
				$this->red, $this->green, $this->blue, $this->getAlpha128()
			);
		}
		
		return imagecolorallocate(
			$image_resource, $this->red, $this->green, $this->blue
		);
	}
	
	private function isRgbString($input)
	{
		if (!is_string($input))
		{
			return false;
		}

		if (preg_match('/^\s*rgba?\s*\(/i', $input))
		{
			return true;
		}

		return false;
	}
	
	private function isHexString($input)
	{
		if (!is_string($input))
		{
			return false;
		}

		if (preg_match('/^\s*\#?[a-f0-9]{3,6}\s*$/i', $input))
		{
			return true;
		}

		return false;
	}

	private function isRgbArray($input)
	{
		if (!is_array($input))
		{
			return false;
		}

		$count = count($input);

		if ($count !== 3 && $count !== 4)
		{
			return false;
		}

		foreach ($input as $value)
		{
			if (!is_numeric($value))
			{
				return false;
			}
		}

		return true;
	}

	private function isColorWord($word)
	{
		if (!is_string($word))
		{
			return false;
		}

		if (strtolower($word) === 'transparent')
		{
			return true;
		}

		return (bool)$this->wordToHex($word);
	}
	
	private function setRgbValue($value, $prop)
	{
		if (!is_int($value))
		{
			throw new BadColorInputException('Non-integer R|G|B value of type '.gettype($value));
		}

		if ($value < 0 || $value > 255)
		{
			throw new BadColorInputException('Invalid R|G|B value: '.$value);	
		}

		$this->{$prop} = $value;
	}

	private function rgbStringToRgbArray($rgb_string)
	{
		assert(is_string($rgb_string));

		$rgb_num_string = preg_replace('/[^0-9\.\,]/i', '', $rgb_string);

		$substrings = preg_split('/\s*\,\s*/', $rgb_num_string);

		$count = count($substrings);

		if ($count !== 3 && $count !== 4)
		{
			throw new BadColorInputException('Bad RGB(A) string: '.$rgb_string);
		}

		$rgba = [];

		for ($i = 0; $i < 3; ++$i)
		{
			$rgba[$i] = $this->limitColorValue((int)$substrings[$i]);
		}

		if (isset($substrings[3]))
		{
			$rgba[3] = $this->limitAlphaValue((double)$substrings[3]);
		}

		return $rgba;
	}
	
	// Removes leading #.
	// Length is enforced to 6.
	// Uppercase.
	private function cleanHexString($hex_string)
	{
		assert(is_string($hex_string));

		$cleaned_hex = preg_replace('/[^0-9a-f]/i', '', $hex_string);

		$length = strlen($cleaned_hex);

		if ($length !== 3 && $length !== 6)
		{
			throw new BadColorInputException('Bad hex string: '.$hex_string);
		}

		if ($length === 3)
		{
			$r = substr($cleaned_hex, 0, 1);
			$g = substr($cleaned_hex, 1, 1);
			$b = substr($cleaned_hex, 2, 1);

			$cleaned_hex = "$r$r$g$g$b$b";
		}

		return strtoupper($cleaned_hex);
	}
	
	// @param $hex string Cleaned 6-digit hex with no leading #
	// @return 3-sized RGB array
	private function hexStringToRgbArray($hex)
	{
		assert(is_string($hex));
		assert(strlen($hex) === 6);

		return [
			hexdec(substr($hex, 0, 2)),
			hexdec(substr($hex, 2, 2)),
			hexdec(substr($hex, 4, 2))
		];
	}
	
	// @param $rgb RGB num array (must be pre-validated)
	// @param string 6-digit UC hex with no leading #
	private function rgbArrayToHexString(array $rgb) 
	{
		$count = count($rgb);

		assert($count === 3 || $count === 4);

		$hex_string = '';

		for ($i = 0; $i < 3; ++$i)
		{
			$decimal = $rgb[$i];

			assert(is_int($decimal));

			$hex_string .= str_pad(dechex($decimal), 2, '0', STR_PAD_LEFT);
		}

		return strtoupper($hex_string);
	}

	// @return string 6-digit hex without leading #, or null if no match found
	private function wordToHex($word) 
	{
		if (!is_string($word))
		{
			throw new BadColorInputException('Non-string word: '.gettype($word));
		}

		$word = trim($word);


		// Try CS search
		
		if (isset(self::$wordHexMap[$word])) 
		{
			return self::$wordHexMap[$word];
		}


		// Try CI search

		$word = strtolower($word);
		
		foreach (self::$wordHexMap as $match_word => $hex) 
		{
			if ($word == strtolower($match_word)) 
			{
				return $hex;
			}
		}

		return null;
	}

	private function limitColorValue($value)
	{
		assert(is_int($value));

		if ($value > self::MAX_COLOR_VALUE)
		{
			return self::MAX_COLOR_VALUE;
		}

		if ($value < self::MIN_COLOR_VALUE)
		{
			return self::MIN_COLOR_VALUE;
		}

		return $value;
	}
	
	private function limitAlphaValue($value)
	{
		assert(is_double($value) || is_int($value));

		if ($value > self::MAX_ALPHA_VALUE)
		{
			return self::MAX_ALPHA_VALUE;
		}

		if ($value < self::MIN_ALPHA_VALUE)
		{
			return self::MIN_ALPHA_VALUE;
		}

		return $value;
	}

	static private $wordHexMap = [
		'AliceBlue' => 'F0F8FF',
		'AntiqueWhite' => 'FAEBD7',
		'Aqua' => '00FFFF',
		'Aquamarine' => '7FFFD4',
		'Azure' => 'F0FFFF',
		'Beige' => 'F5F5DC',
		'Bisque' => 'FFE4C4',
		'Black' => '000000',
		'BlanchedAlmond' => 'FFEBCD',
		'Blue' => '0000FF',
		'BlueViolet' => '8A2BE2',
		'Brown' => 'A52A2A',
		'BurlyWood' => 'DEB887',
		'CadetBlue' => '5F9EA0',
		'Chartreuse' => '7FFF00',
		'Chocolate' => 'D2691E',
		'Coral' => 'FF7F50',
		'CornflowerBlue' => '6495ED',
		'Cornsilk' => 'FFF8DC',
		'Crimson' => 'DC143C',
		'Cyan' => '00FFFF',
		'DarkBlue' => '00008B',
		'DarkCyan' => '008B8B',
		'DarkGoldenRod' => 'B8860B',
		'DarkGray' => 'A9A9A9',
		'DarkGrey' => 'A9A9A9',
		'DarkGreen' => '006400',
		'DarkKhaki' => 'BDB76B',
		'DarkMagenta' => '8B008B',
		'DarkOliveGreen' => '556B2F',
		'Darkorange' => 'FF8C00',
		'DarkOrchid' => '9932CC',
		'DarkRed' => '8B0000',
		'DarkSalmon' => 'E9967A',
		'DarkSeaGreen' => '8FBC8F',
		'DarkSlateBlue' => '483D8B',
		'DarkSlateGray' => '2F4F4F',
		'DarkSlateGrey' => '2F4F4F',
		'DarkTurquoise' => '00CED1',
		'DarkViolet' => '9400D3',
		'DeepPink' => 'FF1493',
		'DeepSkyBlue' => '00BFFF',
		'DimGray' => '696969',
		'DimGrey' => '696969',
		'DodgerBlue' => '1E90FF',
		'FireBrick' => 'B22222',
		'FloralWhite' => 'FFFAF0',
		'ForestGreen' => '228B22',
		'Fuchsia' => 'FF00FF',
		'Gainsboro' => 'DCDCDC',
		'GhostWhite' => 'F8F8FF',
		'Gold' => 'FFD700',
		'GoldenRod' => 'DAA520',
		'Gray' => '808080',
		'Grey' => '808080',
		'Green' => '008000',
		'GreenYellow' => 'ADFF2F',
		'HoneyDew' => 'F0FFF0',
		'HotPink' => 'FF69B4',
		'IndianRed ' => 'CD5C5C',
		'Indigo ' => '4B0082',
		'Ivory' => 'FFFFF0',
		'Khaki' => 'F0E68C',
		'Lavender' => 'E6E6FA',
		'LavenderBlush' => 'FFF0F5',
		'LawnGreen' => '7CFC00',
		'LemonChiffon' => 'FFFACD',
		'LightBlue' => 'ADD8E6',
		'LightCoral' => 'F08080',
		'LightCyan' => 'E0FFFF',
		'LightGoldenRodYellow' => 'FAFAD2',
		'LightGray' => 'D3D3D3',
		'LightGrey' => 'D3D3D3',
		'LightGreen' => '90EE90',
		'LightPink' => 'FFB6C1',
		'LightSalmon' => 'FFA07A',
		'LightSeaGreen' => '20B2AA',
		'LightSkyBlue' => '87CEFA',
		'LightSlateGray' => '778899',
		'LightSlateGrey' => '778899',
		'LightSteelBlue' => 'B0C4DE',
		'LightYellow' => 'FFFFE0',
		'Lime' => '00FF00',
		'LimeGreen' => '32CD32',
		'Linen' => 'FAF0E6',
		'Magenta' => 'FF00FF',
		'Maroon' => '800000',
		'MediumAquaMarine' => '66CDAA',
		'MediumBlue' => '0000CD',
		'MediumOrchid' => 'BA55D3',
		'MediumPurple' => '9370D8',
		'MediumSeaGreen' => '3CB371',
		'MediumSlateBlue' => '7B68EE',
		'MediumSpringGreen' => '00FA9A',
		'MediumTurquoise' => '48D1CC',
		'MediumVioletRed' => 'C71585',
		'MidnightBlue' => '191970',
		'MintCream' => 'F5FFFA',
		'MistyRose' => 'FFE4E1',
		'Moccasin' => 'FFE4B5',
		'NavajoWhite' => 'FFDEAD',
		'Navy' => '000080',
		'OldLace' => 'FDF5E6',
		'Olive' => '808000',
		'OliveDrab' => '6B8E23',
		'Orange' => 'FFA500',
		'OrangeRed' => 'FF4500',
		'Orchid' => 'DA70D6',
		'PaleGoldenRod' => 'EEE8AA',
		'PaleGreen' => '98FB98',
		'PaleTurquoise' => 'AFEEEE',
		'PaleVioletRed' => 'D87093',
		'PapayaWhip' => 'FFEFD5',
		'PeachPuff' => 'FFDAB9',
		'Peru' => 'CD853F',
		'Pink' => 'FFC0CB',
		'Plum' => 'DDA0DD',
		'PowderBlue' => 'B0E0E6',
		'Purple' => '800080',
		'Red' => 'FF0000',
		'RosyBrown' => 'BC8F8F',
		'RoyalBlue' => '4169E1',
		'SaddleBrown' => '8B4513',
		'Salmon' => 'FA8072',
		'SandyBrown' => 'F4A460',
		'SeaGreen' => '2E8B57',
		'SeaShell' => 'FFF5EE',
		'Sienna' => 'A0522D',
		'Silver' => 'C0C0C0',
		'SkyBlue' => '87CEEB',
		'SlateBlue' => '6A5ACD',
		'SlateGray' => '708090',
		'SlateGrey' => '708090',
		'Snow' => 'FFFAFA',
		'SpringGreen' => '00FF7F',
		'SteelBlue' => '4682B4',
		'Tan' => 'D2B48C',
		'Teal' => '008080',
		'Thistle' => 'D8BFD8',
		'Tomato' => 'FF6347',
		'Turquoise' => '40E0D0',
		'Violet' => 'EE82EE',
		'Wheat' => 'F5DEB3',
		'White' => 'FFFFFF',
		'WhiteSmoke' => 'F5F5F5',
		'Yellow' => 'FFFF00',
		'YellowGreen' => '9ACD32'
	];
}