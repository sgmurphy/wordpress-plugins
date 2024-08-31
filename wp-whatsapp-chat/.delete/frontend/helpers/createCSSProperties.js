export function createCSSProperties(button) {
	const styleObject = {};
	for (const key in button) {
		if (button.hasOwnProperty(key)) {
			let value = button[key];
			if (typeof value === 'number') {
				value = `${value}px`; // Append 'px' to numeric values
			}
			if (value !== '') {
				// Create a CSS variable name by replacing underscores with hyphens and appending a domain-specific prefix
				const cssVarName = `--qlwapp-scheme-${key.replace(/_/g, '-')}`;
				// Add the CSS variable to the style object
				styleObject[cssVarName] = value;
			}
		}
	}
	return styleObject;
}
