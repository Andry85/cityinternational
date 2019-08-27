<?php

namespace IllicitWeb;

function format_money($input, $currency_sym='', $thousands_sep='') {
	$mf = new MoneyFormatter($input, $currency_sym, $thousands_sep);

	return $mf->getOutput();
}

// Trims & removes protocol from a URL
function pretty_url($url)
{
	return preg_replace('/(^\\s*(https?\\:)?\\/*)|(\\/+\\s*$)/i', '', $url);
}

// Resolves any shortcodes in dynamic sidebar content
// @return {string|null} String if $echo false
function dynamic_sidebar_shortcode($id, $echo=true)
{
	ob_start();

	dynamic_sidebar($id);
	
	$html = ob_get_clean();
	
	$html = do_shortcode($html);
	
	if ($echo) 
	{
		echo $html;
	} 
	else 
	{
		return $html;
	}
}

// Truncates a string according to the given word count.
// @param {string} $s Any string
// @param {int} $word_count Max no. of words in returned string
// @return {string} $s truncated to $word_count words
function truncate($s, $word_count = null)
{
	if (!$word_count)
	{
		$word_count = apply_filters('excerpt_length', 55);
	}
	
	$words = explode(' ', trim($s), $word_count + 1);

	if (count($words) > $word_count) 
	{
		array_pop($words);
		array_push($words, '…');
		$s = implode(' ', $words);
	}
	
	return $s;
}

function ehtml($s)
{
	echo htmlspecialchars($s);
}

function snake_case($s)
{
	$s = strtolower(trim($s));
	$s = preg_replace('/[^\w]+/', '_', $s);
	return $s;
}

function spinal_case($s)
{
	$s = strtolower(trim($s));
	$s = preg_replace('/[^\w]+/', '-', $s);
	return $s;
}

function live_links($text, $target_blank=false)
{
	$pattern = '/\bhttps?\:\/\/.+(\s|$)/';

	$html = preg_replace_callback($pattern, function ($match) use ($target_blank) {
		$url = $match[0];

		$html = '<a href="'.$url.'"';

		if ($target_blank)
		{
			$html .= ' target="_blank"';
		}

		$html .= '>'.$url.'</a> ';

		return $html;

	}, $text);

	return $html;
}

function scrub_background_image_url($url)
{
	return htmlspecialchars(str_replace("'", "\\'", $url));
}
