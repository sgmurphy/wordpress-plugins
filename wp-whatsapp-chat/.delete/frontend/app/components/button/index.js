/*
 * External dependencies
 */
import classnames from 'classnames';
/*
 * Wordpress dependencies
 */
import { sprintf, _x } from '@wordpress/i18n';
/*
 * Internal dependencies
 */
import { getAvailabilityTime } from '../../../helpers/getAvailabilityTime';
import { getNextAvailableDay } from '../../../helpers/days';
import triggerWhatsAppClick from '../../../helpers/triggerWhatsAppClick';
import { useAppContext } from '../../provider';

function Toggle({ onClick }) {
	const { button, box } = useAppContext();

	const {
		isAvailableNow,
		isInAvailableDay,
		isInAvailableHour,
		timefrom,
		timeto,
	} = getAvailabilityTime(button);

	if (!isAvailableNow && button.visibility === 'hidden') {
		return;
	}

	const handleWhatsAppLink = (e) => {
		e.preventDefault();
		triggerWhatsAppClick(button);
	};

	const handleOnClick = (e) => {
		e.preventDefault();

		if (button.box === 'yes') {
			if (box.enable !== 'yes') {
				return;
			}
			onClick(e);
		} else {
			handleWhatsAppLink(e);
		}
	};

	const nextAvailableDay = getNextAvailableDay(button);

	return (
		<a
			className={classnames(
				'qlwapp__button',
				`qlwapp__button--${button.layout}`,
				// buttonTransitionClass,
				!isAvailableNow && 'qlwapp__button--disabled'
			)}
			role="button"
			tabIndex="0"
			onClick={(e) => handleOnClick(e)}
		>
			<i className={classnames('qlwapp__icon', button.icon)}></i>
			{button.layout === 'bubble' && <i className="qlwapp__close">×</i>}
			{button.text && <span className="qlwapp__text">{button.text}</span>}

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
		</a>
	);
}

export default Toggle;
