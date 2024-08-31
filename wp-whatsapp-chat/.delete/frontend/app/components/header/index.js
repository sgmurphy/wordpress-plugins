import { sprintf, _x } from '@wordpress/i18n';

import { ArrowLeft } from '../../../assets/icons/arrow_left';
import { useAppContext } from '../../provider';
import { ContactAvatar } from '../contact-avatar';

const Header = ({ onClose, onPrevious }) => {
	const { contactId, box, contacts } = useAppContext();
	const contact = contacts[contactId];
	return (
		<div className="qlwapp__header">
			<div className="qlwapp__carousel">
				<div className="qlwapp__carousel-slide">
					<i className="qlwapp__close" onClick={onClose}>
						×
					</i>
					{box.header && (
						<div
							className="qlwapp__header-description"
							dangerouslySetInnerHTML={{
								__html: box.header,
							}}
						/>
					)}
				</div>
				<div className="qlwapp__carousel-slide">
					<div className="qlwapp__header-contact">
						<a className="qlwapp__previous" onClick={onPrevious}>
							<ArrowLeft />
						</a>
						<div className="qlwapp__info">
							<span className="qlwapp__name">
								{contact?.firstname} {contact?.lastname}
							</span>
							<span className="qlwapp__time">
								{contact?.timefrom !== contact?.timeto &&
									sprintf(
										_x(
											'Available from %1$s to %2$s',
											'wp-whatsapp-chat'
										),
										contact?.timefrom,
										contact?.timeto
									)}
								{contact?.label && ` - ${contact?.label}`}
							</span>
						</div>
						<ContactAvatar contact={contact} />
					</div>
				</div>
			</div>
		</div>
	);
};

export default Header;
