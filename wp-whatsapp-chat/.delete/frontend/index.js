/*
 * Wordpress dependencies
 */
import { createRoot } from '@wordpress/element';
/*
 * Internal dependencies
 */
import App from './app';
import { filterVisibleContacts } from './helpers/filterVisibleContacts';

document.addEventListener('DOMContentLoaded', () => {
	// Get the containers based on the class 'qlwapp'
	const container = document.querySelectorAll('.qlwapp');

	// Foreach container, render the App component
	container.forEach((element) => {
		// Get contacts from the container data attribute
		const display = JSON.parse(element.getAttribute('data-display')) ?? {};
		const button = JSON.parse(element.getAttribute('data-button')) ?? {};
		const box = JSON.parse(element.getAttribute('data-box')) ?? {};
		const contacts = filterVisibleContacts(
			JSON.parse(element.getAttribute('data-contacts')) ?? {}
		);

		createRoot(element).render(
			<App
				display={display}
				button={button}
				box={box}
				contacts={contacts}
			/>
		);
	});
});
