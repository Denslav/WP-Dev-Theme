<?php
/**
 * Functions which enhance the theme by hooking into WordPress.
 *
 * @package main-theme
 */

/**
 * Add custom classes to the body element.
 *
 * @param array $classes Body classes.
 * @return array
 */
function main_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'main_body_classes' );

/**
 * Add a pingback URL auto-discovery header when needed.
 */
function main_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'main_pingback_header' );

/**
 * Add an accessible submenu toggle button to parent items in the primary menu.
 *
 * @param string   $item_output Menu item HTML.
 * @param WP_Post  $item        Menu item object.
 * @param int      $depth       Menu depth.
 * @param stdClass $args        Menu arguments.
 * @return string
 */
function main_primary_menu_dropdown_toggle( $item_output, $item, $depth, $args ) {
	if (
		isset( $args->theme_location ) &&
		'primary' === $args->theme_location &&
		in_array( 'menu-item-has-children', (array) $item->classes, true )
	) {
		$label = sprintf(
			/* translators: %s: menu item title. */
			esc_attr__( 'Toggle submenu for %s', 'main' ),
			wp_strip_all_tags( $item->title )
		);

		$item_output .= sprintf(
			'<button class="menu-chevron" type="button" aria-expanded="false" aria-label="%1$s"><span class="menu-chevron__icon" aria-hidden="true"></span></button>',
			$label
		);
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'main_primary_menu_dropdown_toggle', 10, 4 );

/**
 * Print post publication date.
 */
function main_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated screen-reader-text" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() )
	);

	printf(
		'<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
		esc_html__( 'Posted on', 'main' ),
		esc_url( get_permalink() ),
		$time_string // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
}

/**
 * Print post author.
 */
function main_posted_by() {
	printf(
		'<span class="byline"><span class="screen-reader-text">%1$s </span><span class="author vcard"><a class="url fn n" href="%2$s">%3$s</a></span></span>',
		esc_html__( 'By', 'main' ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);
}

/**
 * Print category and tag links for posts.
 */
function main_entry_footer() {
	if ( 'post' !== get_post_type() ) {
		return;
	}

	$categories = get_the_category_list( esc_html_x( ', ', 'list item separator', 'main' ) );
	$tags       = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'main' ) );

	if ( $categories ) {
		printf(
			'<div class="cat-links"><span class="entry-footer__label">%1$s</span> %2$s</div>',
			esc_html__( 'Categories:', 'main' ),
			$categories // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}

	if ( $tags ) {
		printf(
			'<div class="tags-links"><span class="entry-footer__label">%1$s</span> %2$s</div>',
			esc_html__( 'Tags:', 'main' ),
			$tags // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}
}
