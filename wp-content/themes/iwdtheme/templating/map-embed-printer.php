<?php

namespace IllicitWeb;

class MapEmbedPrinter extends SectionPrinter
{
	public function printHtml()
	{
		$html = get_field_trimmed('map_embed');

		if (!$html)
		{
			return;
		}

		?>
		<section class="content-block map-embed">
			<div class="content-block-inner">
				<?= $html ?>
			</div>
		</section>
		<?php
	}
}
