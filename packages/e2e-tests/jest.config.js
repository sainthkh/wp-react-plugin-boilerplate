module.exports = {
	preset: 'jest-puppeteer',
	testMatch: [ '**/?(*.)+(spec|test).[t]s' ],
	testRunner: 'jest-circus/runner',
	testPathIgnorePatterns: [ '/node_modules/', 'dist' ],
	testTimeout: 300000,
	setupFilesAfterEnv: [ '<rootDir>/jest.setup.ts' ],
	transform: {
		'^.+\\.ts?$': 'ts-jest',
	},
	globalSetup: './jest.global-setup.ts', // will be called once before all tests are executed
	// globalTeardown: './jest.global-teardown.ts' // will be called once after all tests are executed
};
