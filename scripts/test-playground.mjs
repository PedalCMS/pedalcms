import { runCLI } from '@wp-playground/cli';

const bundlePath =
	process.argv[2] ?? '.cache/playground/pedalcms-playground.zip';
let cliServer;

function assert(condition, message) {
	if (!condition) {
		throw new Error(message);
	}
}

try {
	cliServer = await runCLI({
		command: 'server',
		blueprint: bundlePath,
		php: '8.2',
		wp: 'latest',
		debug: true,
		skipBrowser: true,
		'internal-cookie-store': true,
	});

	const stateResponse = await cliServer.playground.run({
		code: `<?php
require_once '/wordpress/wp-load.php';

$home_id = (int) get_option( 'page_on_front' );
$attachments = get_posts(
	array(
		'post_type'      => 'attachment',
		'post_status'    => 'inherit',
		'posts_per_page' => -1,
		'fields'         => 'ids',
	)
);
$downloaded_attachments = array_filter(
	$attachments,
	static function ( $attachment_id ) {
		$file = get_attached_file( $attachment_id );
		return is_string( $file ) && file_exists( $file );
	}
);

echo wp_json_encode(
	array(
		'active_plugins'        => get_option( 'active_plugins', array() ),
		'stylesheet'            => get_option( 'stylesheet' ),
		'show_on_front'         => get_option( 'show_on_front' ),
		'home_slug'             => get_post_field( 'post_name', $home_id ),
		'attachment_count'      => count( $attachments ),
		'downloaded_attachment_count' => count( $downloaded_attachments ),
	)
);
`,
	});

	assert(
		stateResponse.exitCode === 0,
		stateResponse.errors || 'State check failed.',
	);
	const state = JSON.parse(stateResponse.text);

	assert(
		state.active_plugins.includes('pedalcms/pedalcms.php'),
		'PedalCMS is not active.',
	);
	assert(
		state.active_plugins.includes('wordpress-importer/wordpress-importer.php'),
		'WordPress Importer is not active.',
	);
	assert(state.stylesheet === 'astra', 'Astra is not the active theme.');
	assert(
		state.show_on_front === 'page',
		'The front page is not set to a page.',
	);
	assert(
		state.home_slug === 'home',
		'The Home page is not the static front page.',
	);
	assert(state.attachment_count > 0, 'No attachments were imported.');
	assert(
		state.downloaded_attachment_count > 0,
		'No imported attachment files were downloaded.',
	);

	const frontPageResponse = await cliServer.playground.run({
		code: `<?php
require_once '/wordpress/wp-load.php';

$home = get_post( (int) get_option( 'page_on_front' ) );

if ( ! $home instanceof WP_Post ) {
	throw new RuntimeException( 'The configured front page could not be loaded.' );
}

$GLOBALS['post'] = $home;
setup_postdata( $home );
$html = apply_filters( 'the_content', $home->post_content );
wp_reset_postdata();

echo strlen( $html );
`,
	});
	assert(
		frontPageResponse.exitCode === 0,
		frontPageResponse.errors || 'The front page content failed to render.',
	);
	assert(
		Number.parseInt(frontPageResponse.text, 10) > 500,
		'The front page content produced no meaningful HTML.',
	);

	console.log(
		`Playground smoke test passed (${state.downloaded_attachment_count}/${state.attachment_count} attachment files downloaded).`,
	);
} finally {
	if (cliServer) {
		await cliServer[Symbol.asyncDispose]();
	}
}
