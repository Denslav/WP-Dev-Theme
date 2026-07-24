<?php
/**
 * Search results template.
 *
 * @package main-theme
 */

get_header();
?>

<main id="primary" class="site-main search">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<header class="search__header">
				<h1 class="search__title">
					<?php
					printf(
						/* translators: %s: search query. */
						esc_html__( 'Search results for: %s', 'main' ),
						esc_html( get_search_query() )
					);
					?>
				</h1>
			</header>

			<div class="search__results">
				<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'parts/loops/loop', 'post' );
				}
				?>
			</div>

			<div class="search__pagination">
				<?php
				the_posts_pagination(
					array(
						'mid_size'  => 2,
						'prev_text' => esc_html__( '← Previous', 'main' ),
						'next_text' => esc_html__( 'Next →', 'main' ),
					)
				);
				?>
			</div>
		<?php else : ?>
			<section class="search__empty no-results not-found">
				<h1><?php esc_html_e( 'Nothing Found', 'main' ); ?></h1>
				<p><?php esc_html_e( 'Try searching again with different keywords.', 'main' ); ?></p>
				<?php get_search_form(); ?>
			</section>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>
