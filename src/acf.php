<?php
/**
 * ACF related functionality.
 *
 * @package PedalCMS
 * @since 0.1.0
 */

namespace PedalCMS\Core;

add_action( 'plugins_loaded', __NAMESPACE__ . '\maybe_load_acf', 0 );

/**
 * Loads bundled ACF Pro if ACF not already loaded.
 *
 * @return void
 */
function maybe_load_acf(): void {
	if ( class_exists( 'ACF' ) ) {
		// TODO: Add minimum version number handling.
		// TODO: Figure out how to deal with Free/Pro discrepancy.
		return;
	}

	$subpath = '/src/acf/';
	define( 'PDL_ACF_PATH', Plugin::$path . $subpath );
	define( 'PDL_ACF_URL', Plugin::$url . $subpath );

	include_once PDL_ACF_PATH . 'acf.php';

	add_filter( 'acf/settings/url', __NAMESPACE__ . '\acf_settings_url' );
	add_filter( 'acf/settings/show_admin', '__return_false' );
}

/**
 * Returns the ACF settings URL override.
 *
 * @param string $url The current URL (unused, but required by filter signature).
 * @return string
 */
function acf_settings_url( string $url ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	return PDL_ACF_URL;
}

