<?php

namespace IllicitWeb;

class ScriptsPrinter extends Printer
{
	public function printHtml()
	{
		?>
		<script>window.$ = jQuery;</script>
		<script src="<?= NODE_MODULES_URL ?>jquery.scrollto/jquery.scrollTo.min.js"></script>
		<script src="<?= JS_LIBS_URL ?>jquery.touchwipe.min.js"></script>
		<script src="<?= JS_LIBS_URL ?>vminpoly.min.js"></script>
		<script src="<?= JS_LIBS_URL ?>jquery.fittext.js"></script>
		<?php

		if (!debugging() || definedtrue('IW_FORCE_LOAD_JS_BUILD')):

	    ?>
	    <script src="<?= JS_URL ?>main.min.js"></script>
	    <?php

	    else:

	    ?>
	    <script src="<?= JS_URL ?>main.js?<?= time().rand(0, 1000) ?>"></script>
	    <?php
	    
	    endif;

	    ?>

	    <script>
	    	jQuery(function($) {
	    		$('h1').fitText();

				var timer;
				resizeBigLinks();

				$(window).resize(function() {
					clearTimeout(timer);
					timer = setTimeout(function() {
						resizeBigLinks();
					}, 100);
				});

				function resizeBigLinks() {

					if ($(window).width() <= 800)
					{
						$('li.big-link').each(function() {
							$(this).css('height', 'auto');
						});						
					}
					else
					{
						$('li.big-link').each(function() {
							$(this).css('height', ($(this).width() / 2) + 'px');
						});
					}
				}

				$('.open-extra-bio').on('click', function() {
					$(this).next().slideToggle();
					return false;
				});
	    	});
	    </script>

	    <?php
	}
}
