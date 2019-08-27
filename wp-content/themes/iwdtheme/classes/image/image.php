<?php

namespace IllicitWeb;

use Exception;

class Image {

	static public function fromFile($path)
	{
		if (!is_string($path))
		{
			throw new BadImageInputException('Not a string: '.gettype($path));
		}

		if (!file_exists($path))
		{
			throw new BadImageInputException('Image file not found: '.$path);
		}

		$resource = imagecreatefromstring(file_get_contents($path));

		if ($resource === false)
		{
			throw new BadImageInputException('Failed to create image resource from file: '.$path);
		}

		return new static($resource, self::determineMimeType($path));
	}

	static public function fromResource($resource)
	{
		if (!self::isImageResource($resource))
		{
			throw new BadImageInputException('Not an image resource');
		}

		return new static($resource);
	}

	static public function fromDimensions($width, $height)
	{
		if (!is_int($width) || !is_int($height))
		{
			throw new BadImageInputException('Invalid width/height');
		}

		$resource = imagecreatetruecolor($width, $height);

		return new static($resource);
	}

	static private function isImageResource($resource)
	{
		return is_resource($resource) && 
			(get_resource_type($resource) === 'gd');
	}

	static private function determineMimeType($path)
	{
		assert(is_string($path));

		$mime_type = mime_content_type($path);

		assert(is_string($mime_type) && !empty($mime_type));

		if (!self::mimeTypeIsValid($mime_type))
		{
			throw new Exception('Bad MIME type: '.json_encode($mime_type));
		}

		return $mime_type;
	}

	static private function mimeTypeIsValid($mime_type)
	{
		if (!is_string($mime_type))
		{
			return false;
		}

		if (!in_array($mime_type, self::getMimeTypes()))
		{
			return false;
		}

		return true;
	}

	static private function getMimeTypes()
	{
		return array_keys(self::$imageTypes);
	}

	static private $imageTypes = [
		'image/jpeg' => IMAGETYPE_JPEG,
		'image/png' => IMAGETYPE_PNG,
		'image/gif' => IMAGETYPE_GIF,
	];

	static private function mimeToImageType($mime_type)
	{
		assert(is_string($mime_type));

		if (isset(self::$imageTypes[$mime_type]))
		{
			return self::$imageTypes[$mime_type];
		}

		throw new Exception('Bad MIME type: '.$mime_type);
	}

	private function __construct($resource, $mime_type=null)
	{
		if (!self::isImageResource($resource))
		{
			throw new BadImageInputException('Not an image resource');
		}

		$this->resource = $resource;

		$this->backgroundColor = new Color();

		$this->mimeType = $mime_type;
	}
	
	private $resource; // image resource
	
	private $backgroundColor; // Color object

	private $mimeType; // string|null

	private $jpegQuality = 90;

	public function setJpegQuality($quality)
	{
		$quality = (int)$quality;

		if ($quality < 0 || $quality > 100)
		{
			throw new BadImageInputException('Bad JPEG quality value: '.$quality);
		}

		$this->jpegQuality = $quality;
	}

	public function getMimeType()
	{
		return $this->mimeType;
	}

	public function setMimeType($mime_type)
	{
		if ($mime_type === null)
		{
			$this->mimeType = null;
			return;
		}

		if (!$this->mimeTypeIsValid($mime_type))
		{
			throw new BadImageInputException('Bad MIME type');
		}

		$this->mimeType = $mime_type;
	}
	
	public function replaceResource($resource) 
	{
		if (!self::isImageResource($resource))
		{
			throw new BadImageInputException('Not an image resource');
		}

		$this->destroyResource();

		$this->resource = $resource;
	}
	
	public function destroyResource() 
	{
		if ($this->resource !== null)
		{
			imagedestroy($this->resource);

			$this->resource = null;
		}
	}
	
	public function getResource() 
	{
		return $this->resource;
	}
	
	public function setBackgroundColor(Color $color)
	{
		$this->backgroundColor = $color;
	}

	public function getBackgroundColor()
	{
		return $this->backgroundColor;
	}
	
	public function __clone() 
	{
		$this->resource = $this->cloneResource();

		$this->backgroundColor = clone($this->backgroundColor);
	}
	
	public function cloneResource() 
	{
		imagecolortransparent($this->resource);
	
		$w = $this->getWidth();
		$h = $this->getHeight();
	
		$new_resource = imagecreatetruecolor($w, $h);

		imagealphablending($new_resource, false);

		imagesavealpha($new_resource, true);
		
		imagecopy($new_resource, $this->resource, 0, 0, 0, 0, $w, $h);
		
		return $new_resource;
	}
	
	// If $image_type is left null, an attempt is made to detemine image type
	// from the mimeType property (if set). If image type cannot be determined,
	// a default image type is used.
	// Overwrites file if already exists.
	// @return bool Whether file write successful
	public function save($path, $image_type = null)
	{
		if ($image_type === null)
		{
			if ($this->mimeType !== null)
			{
				$image_type = $this->mimeToImageType($this->mimeType);
			}
			else
			{
				$image_type = IMAGETYPE_JPEG; // default
			}
		}

		switch ($image_type)
		{
		case IMAGETYPE_JPEG:
			return imagejpeg($this->resource, $path, $this->jpegQuality);

		case IMAGETYPE_PNG:
			return imagepng($this->resource, $path);
		
		case IMAGETYPE_GIF:
			return imagegif($this->resource, $path);
		
		default:
			throw new BadImageInputException('Bad image type constant passed');
		}
	}
	
	// @param $color Color object or appropriate input param for Color constructor
	// @return void
	// NOTE: This will ERASE the existing graphic and replace it with a block of the
	// color - it does NOT act like a color overlay.
	public function fill(Color $color) 
	{
		$alpha = $color->getAlpha128();
		
		if ($alpha > 0) 
		{
			imagesavealpha($this->resource, true);
			imagealphablending($this->resource, false);
		}
		
		imagefilledrectangle(
			$this->resource,
			0, 0,
			$this->getWidth(), $this->getHeight(),
			$color->allocateToResource($this->resource)
		);
	}
	
	public function clear() 
	{
		$this->fill($this->backgroundColor);
	}

	public function getWidth()
	{
		return imagesx($this->resource);
	}

	public function getHeight()
	{
		return imagesy($this->resource);
	}

	public function setWidth($width)
	{
		if (!is_int($width))
		{
			throw new BadImageInputException('Not an int: '.gettype($width));
		}

		$this->crop(0, 0, $width, $this->getHeight());
	}

	public function setHeight($height)
	{
		if (!is_int($height))
		{
			throw new BadImageInputException('Not an int: '.gettype($height));
		}

		$this->crop(0, 0, $this->getWidth(), $height);
	}

	// @return void
	public function crop($x, $y, $w, $h) 
	{
		$cropped = new static(imagecreatetruecolor($w, $h));

		$cropped->setBackgroundColor($this->backgroundColor);
		
		$cropped->clear();

		$max_w = $this->getWidth() - $x;

		$max_h = $this->getHeight() - $y;

		if ($w > $max_w) 
		{
			$w = $max_w;
		}

		if ($h > $max_h) 
		{
			$h = $max_h;
		}

		$cropped_rsc = $cropped->getResource();

		if (imagecopy($cropped_rsc, $this->resource, 0, 0, $x, $y, $w, $h)) 
		{
			$this->replaceResource($cropped_rsc);
		}
		else 
		{
			throw new Exception('Image::crop() failed because imagecopy() failed');
		}
	}
	
	// @return void
	public function flipHorizontal() 
	{
		$w = $this->getWidth();
		$h = $this->getHeight();

		$dst_rsc = imagecreatetruecolor($w, $h);

		if ($dst_rsc !== false) 
		{
			$dst_ip = new static($dst_rsc);

			$dst_ip->fill(new Color('transparent'));

			for ($dstx = 0, $srcx = $w - 1; $dstx < $w; $dstx++, $srcx--) 
			{
				imagecopy($dst_rsc, $this->resource, $dstx, 0, $srcx, 0, 1, $h);
			}

			$this->replaceResource($dst_rsc);
		}
		else 
		{
			throw new Exception('Could not create image resource');
		}
	}
	
	// @return void
	public function flipVertical() 
	{
		$w = $this->getWidth();
		$h = $this->getHeight();
		
		$dst_rsc = imagecreatetruecolor($w, $h);
		
		if ($dst_rsc !== false) 
		{
			$dst_ip = new static($dst_rsc);
		
			$dst_ip->fill(new Color('transparent'));
		
			for ($dsty=0, $srcy = $h - 1; $dsty < $h; $dsty++, $srcy--) 
			{
				imagecopy($dst_rsc, $this->resource, 0, $dsty, 0, $srcy, $w, 1);
			}
			$this->replaceResource($dst_rsc);
		}
		else 
		{
			throw new Exception('Could not create image resource');
		}
	}	
	
	// @param $alpha float between 0 and 1
	// @return void
	public function applyAlpha($alpha) 
	{
		$alpha = (double)$alpha;

		if ($alpha < 0 || $alpha > 1)
		{
			throw new BadImageInputException('Invalid alpha value (must be 0-1): '.$alpha);
		}

		$alpha = (1 - $alpha) * 127;

		$w = $this->getWidth();
		$h = $this->getHeight();

		$copy_rsc = imagecreatetruecolor($w, $h);

		$copy_image_obj = new static($copy_rsc);

		$transparent = new Color('transparent');
		
		$copy_image_obj->fill($transparent);

		imagecopy($copy_rsc, $this->resource, 0, 0, 0, 0, $w, $h);

		$this->fill($transparent);

		for ($x = 0; $x < $w; $x++) 
		{
			for ($y = 0; $y < $h; $y++) 
			{
				$rgb = imagecolorsforindex($copy_rsc, imagecolorat($copy_rsc, $x, $y));

				$alpha_value = $rgb['alpha'] + $alpha;
				
				if ($alpha_value > 127) 
				{
					$alpha_value = 127;
				}
				
				$color = imagecolorallocatealpha(
					$this->resource, 
					$rgb['red'], $rgb['green'], $rgb['blue'], 
					$alpha_value);
				
				imagesetpixel($this->resource, $x, $y, $color);
			}
		}

		imagedestroy($copy_rsc);
	}
	
	private function restrictToRange($n, $min, $max) 
	{
		if ($n < $min) return $min;

		if ($n > $max) return $max;

		return $n;
	}
	
	// @todo refactor - func too big
	// @return void
	public function addVerticalReflection(
		$curve = 1.5,
		$alpha_start = 1,
		$alpha_end = 0,
		$gap = 0,
		$height_percent = 100) 
	{
		$height_percent = $this->restrictToRange($height_percent, 2, 100);

		$w = $this->getWidth();
		$src_h = $this->getHeight();
		
		$reflection_h = (int)($src_h * ($height_percent / 100));

		$new_rsc = imagecreatetruecolor($w, $src_h + $reflection_h + $gap);
		
		$new_image_obj = new static($new_rsc);
		$new_image_obj->setBackgroundColor($this->backgroundColor);
		$new_image_obj->clear();
		unset($new_image_obj);
		
		imagecopy($new_rsc, $this->resource, 0, 0, 0, 0, $w, $src_h);
		
		$this->crop(0, ($src_h - $reflection_h), $w, $reflection_h);
		
		$reflection = $this->createReflect('v', $curve, $alpha_start, $alpha_end, $height_percent);
		
		$this->destroyResource();
		
		imagecopy($new_rsc, $reflection->getResource(), 0, $src_h + $gap, 0, 0, $w, $reflection_h);
		
		$this->replaceResource($new_rsc);
	}
	
	// @todo refactor - func too big
	// @return void
	public function addHorizontalReflection(
		$side = 'left',
		$curve = 1.5,
		$alpha_start = 1,
		$alpha_end = 0,
		$gap = 0,
		$width_percent = 100) 
	{
		$width_percent = $this->restrictToRange($width_percent, 2, 100);

		
		$src_w = $this->getWidth();
		
		$reflection_w = (int)$src_w * ($width_percent / 100);
		
		$h = $this->getHeight();

		$new_rsc = imagecreatetruecolor($src_w + $reflection_w + $gap, $h);

		$new_image = new static($new_rsc);
		$new_image->setBackgroundColor($this->backgroundColor);
		$new_image->clear();
		unset($new_image);
		
		$left_side = $side == 'left';

		$x = $left_side ? $reflection_w + $gap : 0;
		
		imagecopy($new_rsc, $this->resource, $x, 0, 0, 0, $src_w, $h);
		
		$crop_x = $left_side ? 0 : $src_w - $reflection_w;
		
		$this->crop($crop_x, 0, $reflection_w, $h);
		
		$reflection = $this->createReflect('h'.($left_side ? 'l' : 'r'), $curve, $alpha_start, $alpha_end, $width_percent);
		
		$this->destroyResource();
		
		$x = $left_side ? 0 : $src_w + $gap;
		
		imagecopy($new_rsc, $reflection->getResource(), $x, 0, 0, 0, $reflection_w, $h);
		
		$reflection->destroyResource();
		
		$this->replaceResource($new_rsc);
	}
	
	// @todo refactor - func way too big!
	// @param $direction string 'v' OR 'hl' OR 'hr'
	// @return New Image object for the reflection image
	protected function createReflect($direction, $curve, $alpha_start, $alpha_end) 
	{
		$curve = $this->restrictToRange($curve, 0.1, 10);
	
		$alpha_start = $this->restrictToRange((int)((1 - $alpha_start) * 127), 0, 127);
	
		$alpha_end = $this->restrictToRange((int)((1 - $alpha_end) * 127), 0, 127);
	
		if ($alpha_end < $alpha_start) 
		{
			$alpha_end = $alpha_start;
		} 
		
		$src_rsc = $this->resource;
		
		$w = $this->getWidth();
		$h = $this->getHeight();
		
		$dst_rsc = imagecreatetruecolor($w, $h);
		
		imagesavealpha($dst_rsc, true);
		
		$dst_img = new static($dst_rsc);
		$dst_img->setBackgroundColor($this->backgroundColor);
		$dst_img->clear();
		
		$alpha_diff = $alpha_end - $alpha_start;

		if ($direction === 'v') 
		{
			// Vertical reflection. Iterate through horizontal lines.
			for ($y = 0; $y < $h; $y++) 
			{
				$exp = pow($curve, $y / $h);
				
				$alpha_value = ((pow($y, $exp) / pow($h, $exp)) * $alpha_diff) + $alpha_start;
			
				for ($x = 0; $x < $w; $x++) 
				{
					$rgb = imagecolorsforindex( $src_rsc, imagecolorat($src_rsc, $x, ($h - 1) - $y) );
					
					$adjusted_alpha_value = $alpha_value + $rgb['alpha'];
					
					if ($adjusted_alpha_value > 127) 
					{
						$adjusted_alpha_value = 127;
					}
					
					$color = imagecolorallocatealpha($dst_rsc, $rgb['red'], $rgb['green'], $rgb['blue'], $adjusted_alpha_value);
				
					imagesetpixel($dst_rsc, $x, $y, $color);
				}
			}
		}
		else if ($direction === 'hr') 
		{
			// Horizontal reflection. Reflection appears on right of original image.
			// Iterate through vertical lines.
			for ($x = 0; $x < $w; $x++) 
			{
				$exp = pow($curve, $x / $w);
				$alpha_value = ((pow($x, $exp) / pow($w, $exp)) * $alpha_diff) + $alpha_start;
			
				for ($y = 0; $y < $h; $y++) 
				{
					$rgb = imagecolorsforindex( $src_rsc, imagecolorat($src_rsc, ($w-1) - $x, $y) );
				
					$adjusted_alpha_value = $alpha_value + $rgb['alpha'];
					
					if ($adjusted_alpha_value > 127) 
					{
						$adjusted_alpha_value = 127;
					}
					
					$color = imagecolorallocatealpha($dst_rsc, $rgb['red'], $rgb['green'], $rgb['blue'], $adjusted_alpha_value);
					
					imagesetpixel($dst_rsc, $x, $y, $color);
				}
			}
		}
		else 
		{
			// Horizontal reflection. Reflection appears on left of original image.
			// Iterate through vertical lines.
			for ($x = $w - 1; $x >= 0; $x--) 
			{
				$exp = pow($curve, $x / $w);
			
				$alpha_value = ((pow($x, $exp) / pow($w, $exp)) * $alpha_diff) + $alpha_start;
			
				for ($y = 0; $y < $h; $y++) 
				{
					$rgb = imagecolorsforindex( $src_rsc, imagecolorat($src_rsc, $x, $y) );
				
					$adjusted_alpha_value = $alpha_value + $rgb['alpha'];

					if ($adjusted_alpha_value > 127) 
					{
						$adjusted_alpha_value = 127;
					}
					
					$color = imagecolorallocatealpha($dst_rsc, $rgb['red'], $rgb['green'], $rgb['blue'], $adjusted_alpha_value);
					
					imagesetpixel($dst_rsc, $w - $x, $y, $color);
				}
			}
		}

		return $dst_img;
	}
	
	// Clockwise rotate
	// @param $angle int 0-360 Clockwise angle through which to rotate image
	// @param: $bgd_col = array (RGB) or string (color word or hex, including 'transparent')
	// @return void
	public function rotate($angle)
	{
		$rotated = imagerotate(
			$this->resource, 
			360 - $angle, 
			$this->backgroundColor->toResource($this->resource)
		);
	
		imagesavealpha($rotated, true);
	
		imagealphablending($rotated, true);
	
		$this->replaceResource($rotated);
	}
	
	// @return void
	public function resize($w = null, $h = null)
	{
		$curr_w = $this->getWidth();
		$curr_h = $this->getHeight();

		if ($w === null) 
		{
			$w = $curr_w;
		}
		
		if ($h === null)
		{
			$h = $curr_h;
		}

		$resized = imagecreatetruecolor($w, $h);

		if (imagecopyresampled($resized, $this->resource, 0, 0, 0, 0, $w, $h, $curr_w, $curr_h)) 
		{
			$this->replaceResource($resized);
		}
		else
		{
			throw new Exception('imagecopyresampled() failed');
		}
	}
	
	private function fitContainerCalculate($w, $h, $max_w, $max_h) 
	{
		if ($w > $max_w || $h > $max_h) 
		{
			if ($w > $max_w) 
			{
				$h = ceil(($h / $w) * $max_w);
				$w = $max_w;
			}
			if ($h > $max_h) 
			{
				$w = ceil(($w / $h) * $max_h);
				$h = $max_h;
			}
		}

		return ['w' => $w, 'h' => $h];
	}
	
	// @return void
	public function fitContainer($max_w, $max_h) 
	{
		$w = $this->getWidth();
		$h = $this->getHeight();

		$dimensions = $this->fitContainerCalculate($w, $h, $max_w, $max_h);

		if ($w !== $dimensions['w'] || $h !== $dimensions['h']) 
		{
			$this->resize($dimensions['w'], $dimensions['h']);
		}
	}
	
	// Fills container
	// @param $cw int Container width
	// @param $ch int Container height
	// @return void
	public function fillContainer($cw, $ch) 
	{
		if ($cw > 0 && $cw < 10000 && $ch > 0 && $ch < 10000) 
		{
			$w = $this->getWidth();
			$h = $this->getHeight();

			// Shrink
			if ($w > $cw || $h > $ch) 
			{
				if ($w > $cw) {
					$h = ceil(($h / $w) * $cw);
					$w = $cw;
				}
				if ($h > $ch) {
					$w = ceil(($w / $h) * $ch);
					$h = $ch;
				}
			}
			
			// Grow
			if ($w < $cw) 
			{
				$h = ceil(($h / $w) * $cw);
				$w = $cw;
			}
			
			if ($h < $ch) 
			{
				$w = ceil(($w / $h) * $ch);
				$h = $ch;
			}
			
			$this->resize($w, $h);
			
			$crop_x = ceil($w - $cw) / 2;
			$crop_y = ceil($h - $ch) / 2;
			
			return $this->crop(
				$crop_x,
				$crop_y,
				$cw,
				$ch
			);
		}
		else {
			throw new Exception(
				'Bad values for container width and/or container height: '.$w.' : '.$h);
		}
	}

	// @param $cw int New canvas width
	// @param $ch int New canvas height
	// @param $move string 'center', 'left', 'right', 'top', 'bottom', or a sensible space-separated combination of these
	// The $move param describes where the source image data will end up on the destination canvas.
	// @return void
	public function canvasSize($cw, $ch, $move = 'center') 
	{
		$w = $this->getWidth();
		$h = $this->getHeight();
	
		$directions = explode(' ', strtolower(trim($move)));
	
		if (in_array('left', $directions)) 
		{
			// Image clings to left
			$x = 0;
		}
		else if (in_array('right', $directions)) 
		{
			// Image clings to right
			$x = $cw - $w;
		}
		else {
			// Center
			$x = round(($cw / 2) - ($w / 2));
		}
		
		if (in_array('top', $directions)) 
		{
			// Image clings to top
			$y = 0;
		}
		else if (in_array('bottom', $directions)) 
		{
			// Image clings to bottom
			$y = $ch - $h;
		}
		else 
		{
			// Center
			$y = round(($ch / 2) - ($h / 2));
		}
		
		$dst_rsc = imagecreatetruecolor($cw, $ch);
		
		$dst_img = new static($dst_rsc);
		$dst_img->setBackgroundColor($this->backgroundColor);
		$dst_img->clear();
		
		if (imagecopy($dst_rsc, $this->resource, $x, $y, 0, 0, $w, $h)) 
		{
			$this->replaceResource($dst_rsc);
		}
		else 
		{
			throw new Exception('imagecopy() failed');
		}
	}
	
	// @param $image_type {int} IMAGETYPE_XXX global constant
	// @return {string} Data URI for image (optional, default jpeg)
	public function toDataUri($image_type = IMAGETYPE_JPEG) 
	{
		ob_start();
	
		switch ($image_type) 
		{
		case IMAGETYPE_JPEG:
			imagejpeg($this->resource);
			break;

		case IMAGETYPE_PNG:
			imagepng($this->resource);
			break;

		case IMAGETYPE_GIF:
			imagegif($this->resource);
			break;

		default:
			throw new Exception('Passed bad image file type constant');
		}

		return 'data:'.image_type_to_mime_type($image_type).
			';base64,'.base64_encode(ob_get_clean());
	}
	
	static public function fileIsImage($path)
	{
		if (file_exists($path)) 
		{
			return imagecreatefromstring(file_get_contents($path)) !== false;
		} 
		else 
		{
			throw new Exception('File not found: '.$path);
		}
	}

	// Convenient shorthand for quick conversion to data URI from path
	// @param $path Absolute file path to image file
	// @param $w, $h {ints} Width/height of returned image - fillContainer() is used. Leave either set to 0 for orig size.
	// @param $image_type {int} IMAGETYPE_XXX global constant (optional, default jpeg)
	// @return {string} Data URI or FALSE on failure
	static public function pathToDataURI($path, $w = 0, $h = 0, $image_type = IMAGETYPE_JPEG) {
		if (file_exists($path)) 
		{
			$img = new static($path);
		
			if ($w && $h) 
			{
				$img->fillContainer($w, $h);
			}
		
			return $img->toDataURI($image_type);
		}
		else 
		{
			throw new Exception('File does not exist at '.$path);
		}
	}
}