<?php

namespace IllicitWeb;

?>
<form role="search" method="get" class="search-form" action="/">
	<label>
		<input type="search" class="search-field" placeholder="Search"
			value="<?= get_search_query() ?>" name="s" title="Search">
	</label>
	<input type="image" value="Search" alt="Search"
		src="/wp-content/themes/iwdtheme/images/search.svg">
</form>
