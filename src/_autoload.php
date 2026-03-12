<?php

/**
 * Register our auto-loader.
 *
 * @link https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md
 */

spl_autoload_register(
	function ( $class_name ) {
		// PedalCMS\Core namespace — src/class-*.php
		$core_prefix = 'PedalCMS\\Core\\';
		$core_len    = strlen( $core_prefix );
		if ( strncmp( $core_prefix, $class_name, $core_len ) === 0 ) {
			$relative = substr( $class_name, $core_len );
			$file     = __DIR__ . '/class-' . strtolower( $relative ) . '.php';
			if ( file_exists( $file ) ) {
				require $file;
			}
			return;
		}

		// PedalCMS\Fields namespace — src/Fields/class-*.php
		$fields_prefix = 'PedalCMS\\Fields\\';
		$fields_len    = strlen( $fields_prefix );
		if ( strncmp( $fields_prefix, $class_name, $fields_len ) === 0 ) {
			$relative = substr( $class_name, $fields_len );
			$file     = __DIR__ . '/Fields/class-' . strtolower( str_replace( '_', '-', $relative ) ) . '.php';
			if ( file_exists( $file ) ) {
				require $file;
			}
		}
	}
);
