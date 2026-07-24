<?php
/**
 * Archive template.
 *
 * @package main-theme
 */

get_header();
?>

<main id="primary" class="site-main archive">
	<div class="container">
		<div class="wrapper">
			<header class="page-header archive__header">
				<?php the_archive_title( '<h1 class="page-header__title">', '</h1>' ); ?>
				<?php the_archive_description( '<div class="archive__description">', '</div>' ); ?>
			</header>

			<?php if ( have_posts() ) : ?>
				<div class="posts-list archive__posts">
					<?php
					while ( have_posts() ) {
						the_post();
						get_template_part( 'parts/loops/loop', 'post' );
					}
					?>
				</div>

				<?php
				the_posts_pagination(
					array(
						'mid_size'  => 2,
						'prev_text' => esc_html__( '← Previous', 'main' ),
						'next_text' => esc_html__( 'Next →', 'main' ),
					)
				);
				?>
			<?php else : ?>
				<section class="no-results not-found">
					<h2><?php esc_html_e( 'Nothing Found', 'main' ); ?></h2>
					<p><?php esc_html_e( 'No posts were found in this archive.', 'main' ); ?></p>
				</section>
			<?php endif; ?>
		</div>
	</div>
</main>

<?php get_footer(); ?>
