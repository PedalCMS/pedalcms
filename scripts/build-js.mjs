import { readdir } from 'node:fs/promises';
import path from 'node:path';
import process from 'node:process';

import { build } from 'esbuild';

const [sourceDir, outputDir] = process.argv.slice(2);

if (!sourceDir || !outputDir) {
	console.error('Usage: node scripts/build-js.mjs <sourceDir> <outputDir>');
	process.exit(1);
}

const entries = await readdir(sourceDir, { withFileTypes: true });
const sourceFiles = entries
	.filter((entry) => entry.isFile() && entry.name.endsWith('.js'))
	.map((entry) => entry.name)
	.sort();

if (!sourceFiles.length) {
	console.error(`No JavaScript source files found in ${sourceDir}.`);
	process.exit(1);
}

for (const fileName of sourceFiles) {
	await build({
		bundle: false,
		entryPoints: [path.join(sourceDir, fileName)],
		legalComments: 'none',
		minify: true,
		outfile: path.join(outputDir, fileName.replace(/\.js$/, '.min.js')),
		sourcemap: false,
		target: ['es2019'],
	});
}
