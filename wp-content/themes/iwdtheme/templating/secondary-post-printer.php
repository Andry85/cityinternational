<?php
namespace IllicitWeb;

class SecondaryPostPrinter extends SectionPrinter
{
	public function printHtml()
	{
		if (!get_field('display_secondary_post')) 
		{
			return;
		}
		
		$title = get_field('secondary_post_title');
		
		$html = get_field('secondary_post_content');
		
		?>
		<div class="content-block secondary-post">
			<div class="content-block-inner">
				<?php if ($title): ?>
				<h2 class="secondary-post-title"><?= $title ?></h2>
				<?php endif ?>
		
				<div class="secondary-post-content">
					<?= apply_filters('the_content', do_shortcode($html)) ?>
				</div>
			</div>
		</div>
		<?php	
	}
}
