<?php

namespace IllicitWeb;

class CategoryArchivePrinter extends SectionPrinter
{
	public function printHtml()
	{
		?>
		<div class="content-block category-archive">
			<div class="content-block-inner">
				<h2>Post Categories</h2>
				<ul>
					<?php wp_list_categories(array(
						'title_li' => false,
					)) ?>
				</ul>
			</div>
		</div>
		<?php
	}	
}
