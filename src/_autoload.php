<?php

/**
 * Register our auto-loader.
 *
 * @link https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md
 */

spl_autoload_register(
	function ( $class_name ) {
		// project-specific namespace prefix
		$prefix = 'PedalCMS\\Core\\';

		// base directory for the namespace prefix
		$base_dir = __DIR__ . '/';

		// does the class use the namespace prefix?
		$len = strlen( $prefix );

		if ( strncmp( $prefix, $class_name, $len ) !== 0 ) {
			// no, move to the next registered autoloader
			return;
		}

		// get the relative class name
		$relative_class = substr( $class_name, $len );

		// convert to WP code standards convention.
		$file = sprintf(
			'%sclass-%s.php',
			$base_dir,
			strtolower( $relative_class )
		);

		// if the file exists, require it
		if ( file_exists( $file ) ) {
			require $file;
		}
	}
);
