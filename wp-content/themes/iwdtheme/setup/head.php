<?php

namespace IllicitWeb;

add_action('wp_head', function () {

	$url = get_template_directory_uri();

	// Add some useful JS for old broken versions of IE
	?>
	<!--[if lt IE 9]>
	<meta http-equiv="Page-Enter" content="blendTrans(Duration=0)">
	<meta http-equiv="Page-Exit" content="blendTrans(Duration=0)">
	<link rel="stylesheet" href="<?= $url ?>/scss/stylesheets/ie8.css">
	<script type="text/javascript" src="<?= $url ?>/js/css3-mediaqueries.js"></script>
	<script type="text/javascript" src="<?= $url ?>/js/html5shiv.js"></script>
	<![endif]-->
	<!--[if lt IE 8]>
	<script type="text/javascript" src="<?= $url ?>/js/JSON-js-master/json2.js"></script>
	<script type="text/javascript" src="<?= $url ?>/js/ie7_inline_block_fix.js"></script>
	<![endif]-->
	<?php

	// Grunt livereload when debugging
	if (debugging() &&
		defined('IW_LIVERELOAD') && 
		IW_LIVERELOAD && 
		client_is_dev()):

		$lr_port = is_int(IW_LIVERELOAD) ? IW_LIVERELOAD : 35729;
	
		$lr_host = 'iwdserver';
		
		if (defined('IW_LIVERELOAD_HOST') && IW_LIVERELOAD_HOST)
		{
			assert(is_string(IW_LIVERELOAD_HOST));
			
			$localhost = explode('.', gethostname())[0];
			
			$substrs = explode('|', IW_LIVERELOAD_HOST);
			
			foreach ($substrs as $substr)
			{
				$substr_pieces = explode(':', $substr);
				
				if (!empty($substr_pieces[1]))
				{
					$hostname = $substr_pieces[0];
					$lr_host_value = $substr_pieces[1];
					if ($hostname === $localhost)
					{
						$lr_host = $lr_host_value;
					}
				}
				else
				{
					$lr_host = $substr_pieces[0];
				}
			}
		}
	    ?>
	    <script src="//<?= $lr_host ?>:<?= $lr_port ?>/livereload.js"></script>
	    <?php
	    
    endif;
});
