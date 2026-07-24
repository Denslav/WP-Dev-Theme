<?php
/**
 * Enqueue theme assets.
 *
 * @package main-theme
 */

/**
 * Return a cache-busting version for a theme file.
 *
 * @param string $relative_path Relative path from the theme directory.
 * @return string
 */
function main_asset_version( $relative_path ) {
	$path = get_template_directory() . $relative_path;

	if ( file_exists( $path ) ) {
		return (string) filemtime( $path );
	}

	return defined( 'MAIN_THEME_VERSION' ) ? MAIN_THEME_VERSION : wp_get_theme()->get( 'Version' );
}

/**
 * Determine whether Fancybox assets are needed on the current request.
 *
 * @return bool
 */
function main_should_enqueue_fancybox() {
	$should_enqueue = false;

	if ( is_singular() ) {
		$post = get_queried_object();

		if ( $post instanceof WP_Post ) {
			$should_enqueue = false !== stripos( $post->post_content, 'data-fancybox' )
				|| has_block( 'core/gallery', $post )
				|| has_block( 'acf/fancy-box-gallery', $post )
				|| has_shortcode( $post->post_content, 'gallery' );
		}
	}

	/**
	 * Filter whether Fancybox assets should be loaded.
	 *
	 * @param bool $should_enqueue Whether the assets should be loaded.
	 */
	return (bool) apply_filters( 'main_should_enqueue_fancybox', $should_enqueue );
}

/**
 * Build dynamic CSS from Customizer settings.
 *
 * @return string
 */
function main_get_dynamic_css() {
	$container_width   = function_exists( 'main_get_container_width' ) ? main_get_container_width() : 1200;
	$container_padding = function_exists( 'main_get_container_padding' ) ? main_get_container_padding() : 16;
	$header_bg         = function_exists( 'main_get_theme_color' )
		? main_get_theme_color( 'main_header_bg_color', 'header_bg_color', '#ffffff' )
		: '#ffffff';
	$footer_bg         = function_exists( 'main_get_theme_color' )
		? main_get_theme_color( 'main_footer_bg_color', 'footer_bg_color', '#272a35' )
		: '#272a35';
	$header_textcolor  = get_header_textcolor();
	$site_title_css    = '';

	if ( is_string( $header_textcolor ) && preg_match( '/^[0-9a-fA-F]{6}$/', $header_textcolor ) ) {
		$site_title_css = '.site-title{color:#' . $header_textcolor . ';}';
	}

	return sprintf(
		':root{--main-container-width:%1$dpx;--main-container-padding:%2$dpx;--main-header-background:%3$s;--main-footer-background:%4$s}.header{background-color:var(--main-header-background)}.footer{background-color:var(--main-footer-background)}%5$s',
		$container_width,
		$container_padding,
		$header_bg,
		$footer_bg,
		$site_title_css
	);
}

/**
 * Enqueue frontend styles and scripts.
 */
function main_theme_assets() {
	$uri = get_template_directory_uri();

	wp_enqueue_style(
		'main-fonts',
		$uri . '/dist/css/fonts.css',
		array(),
		main_asset_version( '/dist/css/fonts.css' )
	);
	wp_enqueue_style(
		'main-global',
		$uri . '/dist/css/global.css',
		array( 'main-fonts' ),
		main_asset_version( '/dist/css/global.css' )
	);
	wp_add_inline_style( 'main-global', main_get_dynamic_css() );

	wp_enqueue_style(
		'main-header',
		$uri . '/dist/css/header.css',
		array( 'main-global' ),
		main_asset_version( '/dist/css/header.css' )
	);
	wp_enqueue_style(
		'main-footer',
		$uri . '/dist/css/footer.css',
		array( 'main-global' ),
		main_asset_version( '/dist/css/footer.css' )
	);

	$page_styles = array(
		'front-page' => is_front_page(),
		'single'     => is_single(),
		'page'       => is_page() && ! is_front_page(),
		'archive'    => is_archive() || is_home(),
		'search'     => is_search(),
		'404'        => is_404(),
	);

	foreach ( $page_styles as $name => $should_enqueue ) {
		$relative_path = '/dist/css/pages/' . $name . '.css';

		if ( $should_enqueue && file_exists( get_template_directory() . $relative_path ) ) {
			wp_enqueue_style(
				'main-' . $name,
				$uri . $relative_path,
				array( 'main-global' ),
				main_asset_version( $relative_path )
			);
		}
	}

	if ( main_should_enqueue_fancybox() ) {
		wp_enqueue_style(
			'main-fancybox',
			$uri . '/dist/css/libs/fancybox.css',
			array(),
			main_asset_version( '/dist/css/libs/fancybox.css' )
		);

		wp_enqueue_script(
			'main-fancybox',
			$uri . '/dist/js/libs/fancybox.min.js',
			array(),
			main_asset_version( '/dist/js/libs/fancybox.min.js' ),
			true
		);

		wp_enqueue_script(
			'main-fancybox-gallery',
			$uri . '/dist/js/blocks/fancy-box-gallery.min.js',
			array( 'main-fancybox' ),
			main_asset_version( '/dist/js/blocks/fancy-box-gallery.min.js' ),
			true
		);
	}

	wp_enqueue_script(
		'main-header',
		$uri . '/dist/js/header.min.js',
		array(),
		main_asset_version( '/dist/js/header.min.js' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'main_theme_assets' );
