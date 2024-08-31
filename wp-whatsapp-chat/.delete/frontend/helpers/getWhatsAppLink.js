import { decodeHTMLEntities } from '../../helpers/decodeHTMLEntities';
import { formatPhone } from './formatPhone';
import { isMobile } from './isMobile';

export const getWhatsAppLink = ({ type, group, phone, message }) => {
	const url = isMobile()
		? 'https://api.whatsapp.com/send'
		: 'https://web.whatsapp.com/send';
	if (type === 'group') {
		return group;
	}
	return `${url}?phone=${formatPhone(phone)}&text=${encodeURIComponent(
		decodeHTMLEntities(message)
	)}`;
};
