<?php

// See http://perfecticons.com/

namespace IllicitWeb;

class SocialIconLinksPrinter extends SectionPrinter
{

	// Contact keys mapped to CSS classes
	private $contactKeys = [
		'facebook' => 'soc-facebook',
		'twitter' => 'soc-twitter',
		'instagram' => 'soc-instagram',
		'linkedin' => 'soc-linkedin',
		'googleplus' => 'soc-google',
		'youtube' => 'soc-youtube',
		'vimeo' => 'soc-vimeo',
		'pinterest' => 'soc-pinterest',
	];

	private $socialLinks; // array
	private $hasEmail; // bool
	private $printWrapper; // bool

	// $field_filter is array of $contactKeys keys or null for no filter
	// $print_wrapper is bool whether to print wrapper (default true)
	// $print_email is bool whether to print mailto link  (default true)
	public function __construct(
		array $field_filter=null, $print_wrapper=null, $print_email=null
	)
	{
		$this->printWrapper = ($print_wrapper === null) ? 
			true : 
			(bool)$print_wrapper;
		
		$this->socialLinks = $this->getSocialLinks($field_filter);

		if ($print_email === null)
		{
			$print_email = true;
		}

		$this->hasEmail = $print_email && get_contact_field('email');
	}

	public function printHtml()
	{
		if ($this->isEmpty())
		{
			return;
		}

		if ($this->printWrapper):

			?>
			<aside class="social-icon-links">
				<ul class="soc">
				<?php 

		endif;

		$this->printSocialLinkListItems();

		$this->printEmailListItem();

		if ($this->printWrapper): 

				?>
				</ul>
			</aside>
			<?php

		endif;
	}

	private function getSocialLinks(array $field_filter=null)
	{
		$links = [];

		foreach ($this->contactKeys as $key => $class)
		{
			if ($field_filter && !in_array($key, $field_filter))
			{
				continue;
			}

			$url = get_contact_field($key);

			if ($url)
			{
				$links[] = [
					'url' => $url,
					'class' => $class,
				];
			}
		}

		return $links;
	}

	private function isEmpty()
	{
		return empty($this->socialLinks) && !$this->hasEmail;
	}

	private function printSocialLinkListItems()
	{
		foreach ($this->socialLinks as $link):

			$class = $link['class'];

			?>
			<li><a href="<?= 
				$link['url'] ?>" target="_blank" class="<?= $class ?>"></a></li>
			<?php
		
		endforeach;
	}

	private function printEmailListItem()
	{
		if (!$this->hasEmail)
		{
			return;
		}

		?>
		<li><?= 
			get_safe_email_link(['class' => 'soc-email1'], '') 
		?></li>
		<?php
	}
}
