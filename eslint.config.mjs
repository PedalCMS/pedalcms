import wordpress from '@wordpress/eslint-plugin';

export default [
	{
		ignores: ['admin/js/*.min.js', 'assets/js/*.min.js', 'node_modules/**', 'vendor/**'],
	},
	...wordpress.configs.recommended,
];
