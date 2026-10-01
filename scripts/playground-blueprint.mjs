import { readFile, writeFile } from 'node:fs/promises';

const BLUEPRINT_SOURCE = new URL(
	'../.github/playground/blueprint.json',
	import.meta.url
);
const PLUGIN_SLUG = 'pedalcms';
const CORS_PROXY_URL = 'https://wordpress-playground-cors-proxy.net/?';

/**
 * Loads the Playground blueprint, inlines PHP files referenced as
 * `"code": { "file": "<name>" }`, and points its PedalCMS install step at
 * the given plugin resource.
 *
 * @param {Object} options
 * @param {Object} options.pluginResource Playground resource for the plugin zip.
 * @return {Promise<Object>} The blueprint.
 */
export async function createBlueprint({ pluginResource }) {
	const blueprint = JSON.parse(await readFile(BLUEPRINT_SOURCE, 'utf8'));
	const pluginStep = blueprint.steps?.find(
		(step) =>
			step.step === 'installPlugin' &&
			step.options?.targetFolderName === PLUGIN_SLUG
	);

	if (!pluginStep) {
		throw new Error(
			`No installPlugin step with targetFolderName "${PLUGIN_SLUG}" found in the blueprint.`
		);
	}

	pluginStep.pluginData = pluginResource;

	for (const step of blueprint.steps) {
		if (typeof step.code?.file === 'string') {
			step.code = await readFile(
				new URL(step.code.file, BLUEPRINT_SOURCE),
				'utf8'
			);
		}
	}

	return blueprint;
}

function encodePathSegment(value) {
	return encodeURIComponent(value).replaceAll('%2F', '/');
}

function releaseAssetUrl(repository, tag, fileName) {
	const encodedRepository = repository
		.split('/')
		.map(encodeURIComponent)
		.join('/');

	return `https://github.com/${encodedRepository}/releases/download/${encodePathSegment(tag)}/${fileName}`;
}

async function writeBlueprint(outputPath, blueprint) {
	await writeFile(outputPath, `${JSON.stringify(blueprint, null, 2)}\n`);
}

async function main() {
	const [command, ...args] = process.argv.slice(2);

	if (command === 'bundle') {
		const [outputPath] = args;

		if (!outputPath) {
			throw new Error('Usage: playground-blueprint.mjs bundle <output-path>');
		}

		await writeBlueprint(
			outputPath,
			await createBlueprint({
				pluginResource: { resource: 'bundled', path: '/pedalcms.zip' },
			})
		);
		return;
	}

	if (command === 'release') {
		const [repository, tag, outputPath] = args;

		if (!repository || !tag || !outputPath) {
			throw new Error(
				'Usage: playground-blueprint.mjs release <owner/repository> <tag> <output-path>'
			);
		}

		await writeBlueprint(
			outputPath,
			await createBlueprint({
				pluginResource: {
					resource: 'url',
					url: releaseAssetUrl(repository, tag, 'pedalcms.zip'),
				},
			})
		);
		return;
	}

	if (command === 'release-url') {
		const [repository, tag] = args;

		if (!repository || !tag) {
			throw new Error(
				'Usage: playground-blueprint.mjs release-url <owner/repository> <tag>'
			);
		}

		// Release assets are served without CORS headers, so Playground has
		// to fetch the blueprint through its own CORS proxy.
		const blueprintUrl = `${CORS_PROXY_URL}${releaseAssetUrl(repository, tag, 'blueprint.json')}`;

		process.stdout.write(
			`https://playground.wordpress.net/?blueprint-url=${encodeURIComponent(blueprintUrl)}`
		);
		return;
	}

	throw new Error(
		'Usage: playground-blueprint.mjs <bundle|release|release-url> [arguments]'
	);
}

if (import.meta.url === `file://${process.argv[1]}`) {
	main().catch((error) => {
		console.error(error.message);
		process.exitCode = 1;
	});
}
