<?php

namespace IllicitWeb;

use Exception;

class PagePrinter extends Printer
{
	public function printHtml()
	{
		get_header();

		echo new TopBannerPrinter();

		echo '<div id="more"></div>';
		
		global $post;
		if ($post)
		{
			$page_sections = get_field('page_sections');

			if (!empty($page_sections))
			{
				foreach ($page_sections as $section)
				{
					switch ($section['acf_fc_layout'])
					{
						case 'page_section_banner':
							$banner = new Banner($section['page_section_banner_item']);
							echo new BannerPrinter($banner);
							break;

						case 'page_section_big_links':
							echo new BigLinksPrinter($section);
							break;

						case 'page_section_full_screen_section':
							echo new FullScreenSection($section);
							break;

						case 'page_section_columns_content_section':
							echo new ColumnSectionPrinter($section);
							break;

						case 'page_section_areas_of_law':
							echo new AreasOfLawPrinter($section);
							break;

						case 'page_section_team':
							echo new TeamPrinter($section);
							break;

						default:
							break;
					}
				}
			}
		}
		
		get_footer();
	}
}
