import { writeFile } from 'node:fs/promises';

const homePageSetup = `<?php
require_once '/wordpress/wp-load.php';

$home = get_page_by_path( 'home', OBJECT, 'page' );

if ( ! $home instanceof WP_Post ) {
	throw new RuntimeException( 'The imported Home page could not be found.' );
}

update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', (int) $home->ID );
`;

export function createBlueprint({ pluginResource, contentResource }) {
	return {
		$schema: 'https://playground.wordpress.net/blueprint-schema.json',
		meta: {
			title: 'PedalCMS demo',
			description:
				'A ready-to-use PedalCMS demo with Astra and sample content.',
			author: 'PedalCMS',
			categories: ['demo'],
		},
		preferredVersions: {
			php: '8.2',
			wp: 'latest',
		},
		features: {
			networking: true,
		},
		landingPage: '/',
		login: true,
		steps: [
			{
				step: 'installPlugin',
				pluginData: pluginResource,
				options: {
					activate: true,
					targetFolderName: 'pedalcms',
				},
			},
			{
				step: 'installTheme',
				themeData: {
					resource: 'wordpress.org/themes',
					slug: 'astra',
				},
				options: {
					activate: true,
				},
			},
			{
				step: 'installPlugin',
				pluginData: {
					resource: 'wordpress.org/plugins',
					slug: 'wordpress-importer',
				},
				options: {
					activate: true,
				},
			},
			{
				step: 'importWxr',
				file: contentResource,
				fetchAttachments: true,
				rewriteUrls: true,
				authorsMode: 'default-author',
				defaultAuthorUsername: 'admin',
			},
			{
				step: 'runPHP',
				code: homePageSetup,
			},
		],
	};
}

function encodePathSegment(value) {
	return encodeURIComponent(value).replaceAll('%2F', '/');
}

async function main() {
	const [command, ...args] = process.argv.slice(2);

	if (command === 'bundle') {
		const [outputPath] = args;

		if (!outputPath) {
			throw new Error('Usage: playground-blueprint.mjs bundle <output-path>');
		}

		const blueprint = createBlueprint({
			pluginResource: { resource: 'bundled', path: '/pedalcms.zip' },
			contentResource: { resource: 'bundled', path: '/demo-content.xml' },
		});

		await writeFile(outputPath, `${JSON.stringify(blueprint, null, 2)}\n`);
		return;
	}

	if (command === 'release-url') {
		const [repository, tag, commit] = args;

		if (!repository || !tag || !commit) {
			throw new Error(
				'Usage: playground-blueprint.mjs release-url <owner/repository> <tag> <commit>',
			);
		}

		const encodedRepository = repository
			.split('/')
			.map(encodeURIComponent)
			.join('/');
		const encodedTag = encodePathSegment(tag);
		const encodedCommit = encodeURIComponent(commit);
		const blueprint = createBlueprint({
			pluginResource: {
				resource: 'url',
				url: `https://github.com/${encodedRepository}/releases/download/${encodedTag}/pedalcms.zip`,
			},
			contentResource: {
				resource: 'url',
				url: `https://raw.githubusercontent.com/${encodedRepository}/${encodedCommit}/.github/demo-content.xml`,
			},
		});
		const encodedBlueprint = Buffer.from(JSON.stringify(blueprint)).toString(
			'base64',
		);

		process.stdout.write(
			`https://playground.wordpress.net/#${encodedBlueprint}`,
		);
		return;
	}

	throw new Error(
		'Usage: playground-blueprint.mjs <bundle|release-url> [arguments]',
	);
}

if (import.meta.url === `file://${process.argv[1]}`) {
	main().catch((error) => {
		console.error(error.message);
		process.exitCode = 1;
	});
}
