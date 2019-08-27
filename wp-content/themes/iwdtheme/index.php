<?php

get_header();

?>
<div class="content-block" role="main">
	<?php

	if (have_posts()):

		while (have_posts()):

			the_post();

			?>
			<div class="content-block-inner post">
				<h1><?php the_title() ?></h1>
				<div class="post-content">
					<?php the_content() ?>
				</div>
			</div>
			<?php

		endwhile;

	endif;

	if (!post_password_required()) {
		comments_template('', true);
	}

	?>
</div>
<?php

get_footer();
