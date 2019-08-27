<?php

namespace IllicitWeb;

?>	</div><?php /* #body-wrapper */ ?>

	<footer id="footer">
		<div id="footer-mid">
			<?= dynamic_sidebar_shortcode('footer_mid') ?>
			<a href="https://www.illicitwebdesign.co.uk/" target="_blank">Web Design Devon</a>
		</div>
	</footer>
	
</div><?php /* #global-wrapper */ ?>

<?php wp_footer() ?>

<?php

if (debugging())
{
	wc_debug_fill_checkout_inputs();
}

echo new ScriptsPrinter();

?>
</body>
</html>
