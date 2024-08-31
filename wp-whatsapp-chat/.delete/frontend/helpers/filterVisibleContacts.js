import { isVisibleInDevice } from './isVisibleInDevice';

export const filterVisibleContacts = (contacts) => {
	if (!contacts) {
		return [];
	}

	// Make sure contacts is an array
	if (!Array.isArray(contacts)) {
		contacts = Object.values(contacts);
	}
	return contacts.reduce((acc, contact, index) => {
		const isVisible = isVisibleInDevice(contact?.display?.devices);
		if (isVisible) {
			acc[index] = contact;
		}
		return acc;
	}, []);
};
