module.exports = {
	root: true,
	extends: [ 'plugin:@wordpress/eslint-plugin/recommended' ],
	rules: {
		// --- Indentation ---
		// The codebase uses 4 spaces. WordPress standard is tabs.
		// These are turned off to avoid 300k+ noise errors on existing code.
		// TODO: Run `npm run lint:js:fix` in a dedicated commit to migrate to tabs,
		// then remove these three 'off' overrides to enforce tabs going forward.
		indent: 'off',
		'react/jsx-indent': 'off',
		'react/jsx-indent-props': 'off',

		// --- Auto-fixable formatting rules ---
		// The entire codebase uses a different style (single vs double quotes,
		// spacing conventions). These are turned off to reduce noise.
		// Run `npm run lint:js:fix` in a dedicated one-time commit to auto-fix
		// all of these, then remove these 'off' overrides.
		quotes: 'off',
		'quote-props': 'off',
		'space-in-parens': 'off',
		'computed-property-spacing': 'off',
		'template-curly-spacing': 'off',
		'array-bracket-spacing': 'off',
		'object-curly-spacing': 'off',
		'key-spacing': 'off',
		'comma-dangle': 'off',
		'comma-spacing': 'off',
		'space-unary-ops': 'off',
		'react/jsx-curly-spacing': 'off',

		// --- Downgraded to warnings for gradual adoption ---
		// These are real code quality issues. Upgrade to 'error' over time.
		'no-console': 'warn',
		'no-unused-vars': 'warn',
		'eqeqeq': 'warn',
		'no-shadow': 'warn',
		'camelcase': 'warn',
		'@wordpress/no-unsafe-wp-apis': 'warn',
		'@wordpress/dependency-group': 'warn',
	},
	overrides: [
		{
			// Relax rules for test files when they are added.
			files: [ '**/@(test|__tests__)/**/*.js', '**/?(*.)test.js' ],
			extends: [ 'plugin:@wordpress/eslint-plugin/test-unit' ],
		},
	],
};
