<?php

namespace IllicitWeb;

function curr_page_has_top_banner()
{
	return (bool)get_field('top_banner');
}
