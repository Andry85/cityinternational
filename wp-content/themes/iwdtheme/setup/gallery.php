<?php

namespace IllicitWeb;

if (definedtrue('IW_DISABLE_GALLERIES'))
{
	return;
}

add_action('admin_footer', function () {
	global $post;

	if (empty($post) || ($post->post_type !== PTYPE_GALLERY) ||
		empty($_GET['action']) || $_GET['action'] !== 'edit')
	{
		return;
	}

	?>
	<script>
	jQuery(function ($) {
		$('#post-body-content').append(
			 '<p>To insert this gallery into a post, use the shortcode: '
			+ '<b>[iw_gallery id="<?= $post->ID ?>"]</b></p>'
			+ '<p>If you want to apply a custom thumbnail size, you can specify a <em>size</em> attribute, e.g.: '
			+ '<b>[iw_gallery id="<?= $post->ID ?>" size="gallery-thumb"]</b></p>'
		);
	});
	</script>
	<?php
});
