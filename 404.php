<?php
/**
 * 404 template.
 *
 * @package main-theme
 */

get_header();
?>

<main id="primary" class="site-main error-404">
	<div class="container not-found">
		<div class="text-center">
			<h1><?php esc_html_e( '404: Page Not Found', 'main' ); ?></h1>
			<p><?php esc_html_e( 'Sorry, we cannot find that page. It may have been moved or deleted.', 'main' ); ?></p>
			<div class="not-found__actions">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
					<?php esc_html_e( 'Go to Homepage', 'main' ); ?>
				</a>
				<button type="button" class="btn btn-secondary js-history-back" data-home-url="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php esc_html_e( 'Go Back', 'main' ); ?>
				</button>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>
