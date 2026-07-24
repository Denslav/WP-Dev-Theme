<?php
/**
 * Theme setup and WordPress feature support.
 *
 * @package main-theme
 */

/**
 * Set up theme defaults and register supported WordPress features.
 */
function main_setup() {
	load_theme_textdomain( 'main', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'appearance-tools' );
	add_theme_support( 'editor-styles' );
	add_editor_style( array( 'dist/css/fonts.css', 'dist/css/admin-styles.css' ) );

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'main' ),
			'footer'  => esc_html__( 'Footer Menu', 'main' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		)
	);

	add_theme_support(
		'custom-background',
		apply_filters(
			'main_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'main_setup' );

/**
 * Set the content width in pixels.
 */
function main_content_width() {
	$width = function_exists( 'main_get_container_width' ) ? main_get_container_width() : 1200;
	$GLOBALS['content_width'] = apply_filters( 'main_content_width', $width );
}
add_action( 'after_setup_theme', 'main_content_width', 0 );

/**
 * Register local block metadata when the block directory exists.
 */
function main_register_acf_blocks() {
	$blocks = array( 'main-hero' );

	foreach ( $blocks as $block ) {
		$block_path = get_template_directory() . '/parts/blocks/' . $block;

		if ( file_exists( $block_path . '/block.json' ) ) {
			register_block_type( $block_path );
		}
	}
}
add_action( 'init', 'main_register_acf_blocks' );
