/// <reference path="../../wp-types/index.d.ts" />

export async function resetTable( tables: string | string[] ): Promise< void > {
	if ( typeof tables === 'string' ) {
		tables = [ tables ];
	}

	await page.evaluate( ( wpTables ) => {
		return fetch(
			`${ window.wpApiSettings.root }wp-react/test/v1/reset-table`,
			{
				method: 'POST',
				body: JSON.stringify( wpTables ),
			}
		);
	}, tables );
}
