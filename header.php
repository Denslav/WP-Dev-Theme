<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="format-detection" content="telephone=no,email=no,url=no">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'main' ); ?></a>

<header id="header" class="header">
	<div class="container">
		<div class="header__row">
			<div class="header__branding">
				<div class="header__logo">
					<?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title" rel="home">
							<?php bloginfo( 'name' ); ?>
						</a>
					<?php endif; ?>
				</div>

				<?php $main_description = get_bloginfo( 'description', 'display' ); ?>
				<?php if ( $main_description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo esc_html( $main_description ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( has_nav_menu( 'primary' ) ) : ?>
				<div class="header__navigation">
					<nav id="primary-menu" class="header__nav" aria-label="<?php esc_attr_e( 'Primary Menu', 'main' ); ?>">
						<button class="navbar-toggle-button js-nav-toggle"
								type="button"
								aria-controls="menu-header"
								aria-expanded="false"
								aria-label="<?php esc_attr_e( 'Toggle primary menu', 'main' ); ?>">
							<span class="navbar-toggle-line" aria-hidden="true"></span>
						</button>

						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'container'      => false,
								'menu_id'        => 'menu-header',
								'menu_class'     => 'list-inline',
								'fallback_cb'    => false,
							)
						);
						?>
					</nav>
				</div>
			<?php endif; ?>
		</div>
	</div>
</header>
