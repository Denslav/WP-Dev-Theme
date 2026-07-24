<footer id="footer" class="footer">
	<div class="container">
		<div class="footer__row">
			<div class="footer__logo">
				<?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>
				<?php endif; ?>
			</div>

			<?php if ( has_nav_menu( 'footer' ) ) : ?>
				<div class="footer__navigation">
					<nav id="footer-menu" aria-label="<?php esc_attr_e( 'Footer Menu', 'main' ); ?>">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'footer',
								'menu_class'     => 'footer__menu',
								'container'      => false,
								'fallback_cb'    => false,
							)
						);
						?>
					</nav>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<div class="footer__copyright">
		<div class="container">
			<div class="footer__copyright-text">
				<?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>
			</div>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
