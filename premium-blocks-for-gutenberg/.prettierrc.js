module.exports = {
	...require( '@wordpress/prettier-config' ),

	// Match the existing codebase style (4 spaces, no tabs).
	// Change useTabs to true and tabWidth to 1 if the team migrates to tabs.
	useTabs: false,
	tabWidth: 4,
	singleQuote: true,
	printWidth: 120,
};
