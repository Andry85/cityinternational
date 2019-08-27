<?php

global $post;

get_header();

?>
<div role="main">
	<?php

	while (have_posts()):

		the_post();

		?>
		<section class="content-block attachment">
			<div class="content-block-inner">
				<header>
					<h1><?php the_title(); ?></h1>
					<nav role="navigation">
						<div class="nav-previous"><?php previous_image_link( false, '&larr;' ); ?></div>
						<div class="nav-next"><?php next_image_link( false, '&rarr;' ); ?></div>
					</nav>
				</header>
				<?php if (wp_attachment_is_image($post->ID)): ?>
				<?php $att_image = wp_get_attachment_image_src( $post->ID, "large" ); ?>
				<p>
					<a href="<?php echo wp_get_attachment_url( $post->ID ); ?>" title="<?php the_title(); ?>" rel="attachment">
						<img src="<?php echo $att_image[0]; ?>" width="<?php echo $att_image[1]; ?>" height="<?php echo $att_image[2]; ?>" alt="<?php $post->post_excerpt; ?>">
					</a>
				</p>
				<?php else : ?>
				<p>
					<a href="<?php echo wp_get_attachment_url( $post->ID ); ?>" title="<?php echo esc_html( get_the_title( $post->ID ), 1 ); ?>" rel="attachment">
						<?php echo basename( $post->guid ); ?>
					</a>
				</p>
				<?php endif ?>
				<div>
					<?php if (!empty( $post->post_excerpt)) the_excerpt(); ?>
				</div>
			</div>
		</section>
		<?php

	endwhile;

	if (has_post_thumbnail()) {
		the_post_thumbnail();
	}

	if (!post_password_required()) {
		comments_template('', true);
	}

	?>
</div>
<?php

get_footer();
