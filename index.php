<?php
/**
 * Main fallback template.
 *
 * @package main-theme
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="container">
		<div class="wrapper">
			<header class="page-header">
				<h1 class="page-header__title">
					<?php
					if ( is_home() && ! is_front_page() ) {
						single_post_title();
					} else {
						esc_html_e( 'Latest Posts', 'main' );
					}
					?>
				</h1>
			</header>

			<?php if ( have_posts() ) : ?>
				<div class="content posts-list">
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
					<p><?php esc_html_e( 'No posts are available yet.', 'main' ); ?></p>
				</section>
			<?php endif; ?>
		</div>
	</div>
</main>

<?php get_footer(); ?>
