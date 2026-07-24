<?php
/**
 * Theme bootstrap (includes)
 */

$theme_includes = [
	'/inc/template-functions.php',
	'/inc/theme-support.php',
	'/inc/enqueue.php',
	'/inc/customizer.php',
];

foreach ( $theme_includes as $file ) {
	require_once get_template_directory() . $file;
}