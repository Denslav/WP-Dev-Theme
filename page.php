<?php
/**
 * Page template.
 *
 * @package main-theme
 */

get_header();
?>

<main id="primary" class="site-main page-template">
	<div class="container">
		<?php
		while ( have_posts() ) {
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="page-header">
					<?php the_title( '<h1 class="page-header__title">', '</h1>' ); ?>
				</header>

				<div class="page__content entry-content">
					<?php
					the_content();
					wp_link_pages(
						array(
							'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Page sections', 'main' ) . '">' . esc_html__( 'Pages:', 'main' ),
							'after'  => '</nav>',
						)
					);
					?>
				</div>
			</article>

			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		}
		?>
	</div>
</main>

<?php get_footer(); ?>
