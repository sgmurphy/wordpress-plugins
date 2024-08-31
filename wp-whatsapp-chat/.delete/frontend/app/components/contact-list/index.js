/*
 * Wordpress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useTransition, useEffect } from '@wordpress/element';
/*
 * Internal dependencies
 */
import { isMobile } from '../../../helpers/isMobile';
import { useAppContext } from '../../provider';
import Contact from './contact';
import triggerWhatsAppClick from '../../../helpers/triggerWhatsAppClick';

const ContactList = ({ onClick }) => {
	const [, startTransition] = useTransition();
	const { box, contacts, setContactId } = useAppContext();

	const handleContactClick = (contact) => (e) => {
		e.preventDefault();
		if (!contact.chat) {
			triggerWhatsAppClick(contact);
			return;
		}
		onClick('qlwapp__modal--opening');
		// Get contact index based on id
		const index = contacts.findIndex((c) => c.id === contact.id);
		// Start transition keep the application ui unchanged until the component finishes lazy loading
		startTransition(() => {
			setContactId(index);
		});
	};

	const handleHeight = () => {
		const headerHeight =
			document.querySelector('.qlwapp__header')?.offsetHeight;

		const footerHeight = box.footer
			? document.querySelector('.qlwapp__footer')?.offsetHeight
			: document.querySelector('.qlwapp__response')?.offsetHeight;

		let height = window.innerHeight - headerHeight - footerHeight;

		if (isMobile()) {
			height = window.innerHeight * 0.7 - headerHeight - footerHeight;
		}

		document.documentElement.style.setProperty(
			'--qlwapp-carousel-height',
			`${height}px`
		);
	};

	useEffect(() => {
		window.addEventListener('resize', handleHeight());
		window.addEventListener('load', handleHeight());

		return () => {
			window.removeEventListener('resize', handleHeight());
			window.removeEventListener('load', handleHeight());
		};
	}, []);

	return (
		<div className="qlwapp__contact-list">
			{contacts.length ? (
				contacts.map((contact) => (
					<Contact
						key={contact.id}
						contact={contact}
						onClick={handleContactClick(contact)}
					/>
				))
			) : (
				<div className="qlwapp__contact-list__empty">
					{__('No contacts found.', 'wp-whatsapp-chat')}
				</div>
			)}
		</div>
	);
};

export default ContactList;
