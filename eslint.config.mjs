import wordpress from '@wordpress/eslint-plugin';

export default [
	{
		ignores: [
			'admin/js/*.min.js',
			'assets/js/*.min.js',
			'node_modules/**',
			'vendor/**',
		],
	},
	...wordpress.configs.recommended,
	{
		// CLI scripts and test code legitimately log to the console.
		files: ['scripts/**', 'tests/e2e/**'],
		rules: {
			'no-console': 'off',
		},
	},
];
