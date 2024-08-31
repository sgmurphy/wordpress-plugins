/*
 * External dependencies
 */
import classNames from 'classnames';
/*
 * Wordpress dependencies
 */
import { sprintf, _x } from '@wordpress/i18n';
/*
 * Internal dependencies
 */
import { ContactAvatar } from '../contact-avatar';
import { getAvailabilityTime } from '../../../helpers/getAvailabilityTime';
import { getNextAvailableDay } from '../../../helpers/days';

const Contact = ({ onClick, contact }) => {
	const {
		isAvailableNow,
		isInAvailableDay,
		isInAvailableHour,
		timefrom,
		timeto,
	} = getAvailabilityTime(contact);

	const nextAvailableDay = getNextAvailableDay(contact);

	return (
		<a
			className={classNames(
				'qlwapp__contact',
				!isAvailableNow && 'qlwapp__contact--disabled'
			)}
			onClick={onClick}
			role="button"
			tabIndex="0"
			target="_blank"
		>
			<ContactAvatar contact={contact} />

			<div className="qlwapp__info">
				<span className="qlwapp__label">{contact?.label}</span>
				<span className="qlwapp__name">
					{contact?.firstname} {contact?.lastname}
				</span>
				{!isInAvailableDay
					? nextAvailableDay && (
							<span className="qlwapp__time">
								{sprintf(
									_x('Available on %s', 'wp-whatsapp-chat'),
									nextAvailableDay
								)}
							</span>
					  )
					: !isInAvailableHour && (
							<span className="qlwapp__time">
								{sprintf(
									_x(
										'Available from %1$s to %2$s',
										'wp-whatsapp-chat'
									),
									timefrom,
									timeto
								)}
							</span>
					  )}
			</div>
		</a>
	);
};

export default Contact;
