<?php

namespace IllicitWeb;

use WP_Query;
use WP_Post;
use WP_Term;

use Exception;
use Countable;

class Banner extends Post implements Countable
{
	private $items = [];
	private $videoHtml = null;

	public function __construct(WP_Post $wp_post)
	{
		parent::__construct($wp_post);
		
		if ($this->type() === PTYPE_BANNER) 
		{
			$this->items = $this->buildItemsArray();
			$this->videoHtml = $this->buildVideoHtml();
		}
	}

	public function getVideoHtml()
	{
		return $this->videoHtml;
	}

	public function showScrollDownButton()
	{
		return !!$this->acf('iw_banner_scroll_button');
	}

	public function shouldDoParallax()
	{
		return !$this->acf('iw_banner_disable_parallax') &&
				((defined('PARALLAX_SPEED') || 
				defined(__NAMESPACE__.'\\PARALLAX_SPEED')) && 
				(count($this) === 1));
	}

	// Returns string: full_screen, normal or short (empty string on fail)
	public function getSize()
	{
		return $this->acf('iw_banner_size');
	}

	public function getOverlayImage()
	{
		$image = $this->acf('iw_banner_overlay_bgd_image');

		return $image ? $image : null;
	}

	public function forOverlay($fn)
	{
		$html = $this->getOverlay();

		if ($html)
		{
			$html = do_shortcode($html);
		}

		$image = $this->getOverlayImage();

		if ($html || $image)
		{
			$fn($html, $image);
		}
	}

	public function hasOverlayDarkBgd()
	{
		return $this->acf('iw_banner_overlay_dark_bgd');
	}

	// @return {int} Wait duration for this banner
	public function getWaitDuration()
	{
		return $this->acf('iw_banner_wait_duration');
	}

	// @return {int} Wait duration for this banner
	public function getTransitionDuration()
	{
		return $this->acf('iw_banner_transition_duration');
	}

	public function shouldDisplayControls()
	{
		return (count($this) > 1) && $this->acf('iw_banner_ctrls');
	}

	// @param {int} $post_id WP Post ID
	private function buildItemsArray()
	{
		return $this->acf('iw_banner_items');
	}

	private function buildVideoHtml()
	{
		if (!$this->allowVideo())
		{
			return null;
		}

		$rows = $this->acf('iw_banner_video_urls');

		if (!$rows)
		{
			return null;
		}

		return $this->videoUrlsToHtml($this->videoRowsToUrls($rows));		
	}

	private function videoUrlsToHtml(array $urls)
	{
		ob_start();

		?>
		<video loop="loop" autoplay="autoplay" muted="muted">
			<?php
			
			foreach ($urls as $url):
				$type = $this->urlToMime($url);
			
				?>
				<source src="<?= $url ?>"<?php 
					if ($type): 

						?> type="<?= $type ?>"<?php 

					endif;

				?>>
				<?php
			
			endforeach;

			?>
		</video>
		<?php

		return ob_get_clean();
	}

	private function allowVideo()
	{
		return !on_mobile();
	}

	// @param {array} $rows Rows returned by ACF get_field() for banner_video_urls
	// Each item in returned array is guaranteed to be non-empty
	// @return {array} Array of {string} video URLs
	private function videoRowsToUrls(array $rows)
	{
		$urls = [];

		foreach ($rows as $row)
		{
			$url = trim($row['url']);
		
			if (!empty($url))
			{
				$urls[] = $url;
			}
		}
		
		return $urls;
	}

	// @param {string} $url Video URL
	// @return {string} Mime type as determined by URL file extension, or empty string if not recognised
	private function urlToMime($url)
	{
		return $this->fileExtensionToMime($this->getFileExtension($url));
	}

	// @param {string} $ext File extension
	// @return {string} MIME type or empty string if extension not recognised
	private function fileExtensionToMime($ext)
	{
		static $map = array(
			'mp4' => 'video/mp4',
			'ogg' => 'video/ogg',
			'ogm' => 'video/ogg',//@todo check correct
			'ogv' => 'video/ogg',
			'webm' => 'video/webm',
			'avi' => 'video/avi',
		);

		$ext = strtolower($ext);

		if (isset($map[$ext]))
		{
			return $map[$ext];
		}
		else
		{
			return '';
		}
	}

	private function getFileExtension($url)
	{
		$pieces = explode('.', $url);
		
		$n = count($pieces);

		if ($n < 2)
		{
			return '';
		}
		else
		{
			return $pieces[$n - 1];
		}
	}

	public function forFirstItem($fn)
	{
		if ($this->items)
		{
			$fn($this->items[0]);
		}
	}

	public function forEachItem($fn)
	{
		if ($this->items)
		{
			$index = 0;

			foreach ($this->items as $item)
			{
				$fn($item, $index);
				++$index;
			}
		}
	}

	public function count()
	{
		return count($this->items);
	}

	public function isEmpty()
	{
		return empty($this->items);
	}

	// returns string|null
	public function getOverlay()
	{
		return $this->acfTrim('iw_banner_overlay_html');
	}
}
