module.exports = {
	env: {
		browser: true,
		es6: true,
		node: true,
	},
	extends: [
		'eslint:recommended',
		'plugin:react/recommended',
		'plugin:@wordpress/eslint-plugin/recommended',
		'plugin:@typescript-eslint/eslint-recommended',
		'plugin:@typescript-eslint/recommended',
	],
	globals: {
		wp: 'readonly',
	},
	parser: '@typescript-eslint/parser',
	parserOptions: {
		ecmaFeatures: {
			jsx: true,
		},
		ecmaVersion: 11,
		sourceType: 'module',
	},
	plugins: [ 'react', '@typescript-eslint' ],
	rules: {
		// We don't use jsdoc in this project.
		'jsdoc/no-undefined-types': 'off',
		// It is necessary to import WordPress types.
		'@typescript-eslint/triple-slash-reference': 'off',
	},
	overrides: [
		{
			// Unit test files and their helpers only.
			files: [
				'**/@(test|__tests__)/**/*.js',
				'**/@(test|__tests__)/**/*.ts',
				'**/@(test|__tests__)/**/*.tsx',
				'**/?(*.)test.js',
				'**/?(*.)test.ts',
				'**/?(*.)test.tsx',
			],
			extends: [ 'plugin:@wordpress/eslint-plugin/test-unit' ],
		},
		{
			// End-to-end test files and their helpers only.
			files: [
				'**/specs/**/*.js',
				'**/specs/**/*.ts',
				'**/specs/**/*.tsx',
				'**/?(*.)spec.js',
				'**/?(*.)spec.ts',
				'**/?(*.)spec.tsx',
			],
			extends: [ 'plugin:@wordpress/eslint-plugin/test-e2e' ],
		},
	],
	settings: {
		'import/resolver': {
			typescript: {}, // this loads <rootdir>/tsconfig.json to eslint
		},
	},
};
