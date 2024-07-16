import { registerBlockType } from '@wordpress/blocks';

import Edit from './edit';
import save from './save';
import metadata from './block.json';


const saveThisIcon = (
	<svg
		viewBox="0 0 24 24"
		xmlns="http://www.w3.org/2000/svg"
		aria-hidden="true"
		focusable="false"
	>
		<path d="M23.52,22.12l-4.7-4.86-14.21-.04L.68,5.06,23.52.63v4.56h-1.1v-3.15L2.14,5.97l3.26,10.09,13.87.04,3.15,3.26v-3.3h1.1v6.07Z"/>
		<rect x="6.26" y="8.88" width="10.55" height="2.08"/>
		<rect x="17.74" y="8.65" width="5.1" height="2.53"/>
	</svg>
);

registerBlockType( metadata.name, {
	icon: saveThisIcon,
	/**
	 * @see ./edit.js
	 */
	edit: Edit,
	/**
	 * @see ./save.js
	 */
	save,
} );
