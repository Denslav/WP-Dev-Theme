<?php
/**
 * Theme Customizer integration.
 *
 * @package main-theme
 */

/**
 * Return a namespaced theme setting with a legacy fallback.
 *
 * @param string $setting_id Namespaced setting ID.
 * @param string $legacy_id  Legacy setting ID.
 * @param mixed  $default    Default value.
 * @return mixed
 */
function main_get_theme_setting( $setting_id, $legacy_id, $default ) {
	$value = get_theme_mod( $setting_id, null );

	if ( null === $value ) {
		$value = get_theme_mod( $legacy_id, $default );
	}

	return $value;
}

/**
 * Sanitize container width.
 *
 * @param mixed $value Setting value.
 * @return int
 */
function main_sanitize_container_width( $value ) {
	return min( 1920, max( 800, absint( $value ) ) );
}

/**
 * Sanitize container padding.
 *
 * @param mixed $value Setting value.
 * @return int
 */
function main_sanitize_container_padding( $value ) {
	return min( 100, absint( $value ) );
}

/**
 * Return the configured container width.
 *
 * @return int
 */
function main_get_container_width() {
	return main_sanitize_container_width(
		main_get_theme_setting( 'main_container_width', 'container_width', 1200 )
	);
}

/**
 * Return the configured container padding.
 *
 * @return int
 */
function main_get_container_padding() {
	return main_sanitize_container_padding(
		main_get_theme_setting( 'main_container_padding', 'container_padding', 16 )
	);
}

/**
 * Return a sanitized theme color.
 *
 * @param string $setting_id Namespaced setting ID.
 * @param string $legacy_id  Legacy setting ID.
 * @param string $default    Default color.
 * @return string
 */
function main_get_theme_color( $setting_id, $legacy_id, $default ) {
	$color = sanitize_hex_color( main_get_theme_setting( $setting_id, $legacy_id, $default ) );

	return $color ? $color : $default;
}

/**
 * Register Customizer settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function main_customize_register( $wp_customize ) {
	$live_preview_settings = array( 'blogname', 'blogdescription', 'header_textcolor' );

	foreach ( $live_preview_settings as $setting_id ) {
		$setting = $wp_customize->get_setting( $setting_id );

		if ( $setting ) {
			$setting->transport = 'postMessage';
		}
	}

	$wp_customize->add_section(
		'main_container_settings_section',
		array(
			'title'    => __( 'Container Settings', 'main' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'main_container_width',
		array(
			'default'           => main_get_container_width(),
			'sanitize_callback' => 'main_sanitize_container_width',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'main_container_width',
		array(
			'label'       => __( 'Container width (px, maximum 1920)', 'main' ),
			'section'     => 'main_container_settings_section',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 800,
				'max'  => 1920,
				'step' => 10,
			),
		)
	);

	$wp_customize->add_setting(
		'main_container_padding',
		array(
			'default'           => main_get_container_padding(),
			'sanitize_callback' => 'main_sanitize_container_padding',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'main_container_padding',
		array(
			'label'       => __( 'Container padding (px)', 'main' ),
			'section'     => 'main_container_settings_section',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_setting(
		'main_header_bg_color',
		array(
			'default'           => main_get_theme_color( 'main_header_bg_color', 'header_bg_color', '#ffffff' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'main_header_bg_color',
			array(
				'label'   => __( 'Header Background', 'main' ),
				'section' => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'main_footer_bg_color',
		array(
			'default'           => main_get_theme_color( 'main_footer_bg_color', 'footer_bg_color', '#272a35' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'main_footer_bg_color',
			array(
				'label'   => __( 'Footer Background', 'main' ),
				'section' => 'colors',
			)
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title',
				'render_callback' => 'main_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'main_customize_partial_blogdescription',
			)
		);
	}
}
add_action( 'customize_register', 'main_customize_register' );

/**
 * Render the site title for selective refresh.
 */
function main_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for selective refresh.
 */
function main_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Enqueue the Customizer preview script.
 */
function main_customize_preview_js() {
	wp_enqueue_script(
		'main-customizer',
		get_template_directory_uri() . '/dist/js/customizer.min.js',
		array( 'jquery', 'customize-preview' ),
		main_asset_version( '/dist/js/customizer.min.js' ),
		true
	);
}
add_action( 'customize_preview_init', 'main_customize_preview_js' );
