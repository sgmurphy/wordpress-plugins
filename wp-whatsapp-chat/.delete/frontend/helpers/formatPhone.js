export function formatPhone(phone) {
	phone = phone.replace(/[^0-9]/g, '');

	phone = phone.replace(/^0+/, '');

	return phone;
}
