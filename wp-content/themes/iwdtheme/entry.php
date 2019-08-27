<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header>

		<?php if (is_singular()): ?><h1><?php else: ?><h2><?php endif; ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
		<?php if (is_singular()): ?></h1><?php else: ?></h2><?php endif; ?>

		<?php
		if (!is_search()) {
			get_template_part('entry', 'meta');
		}
		?>
	</header>
	<?php

	get_template_part( 'entry', ( is_archive() || is_search() ? 'summary' : 'content' ) );

	if (!is_search()) {
		get_template_part('entry-footer');
	}

	?>
</article>
