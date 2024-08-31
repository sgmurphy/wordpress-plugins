import { getWhatsAppLink } from './getWhatsAppLink';

export default function triggerWhatsAppClick(props) {
	const link = getWhatsAppLink(props);
	//Trigger "qlwapp.click" js vanilla event
	const clickEvent = new CustomEvent('qlwapp.click', {
		bubbles: true,
		cancelable: true,
	});
	window.dispatchEvent(clickEvent);
	//Redirect to WhatsApp
	window.open(link, '_blank', 'noreferrer');
}
