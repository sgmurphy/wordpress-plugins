/*
 * External dependencies
 */
import classnames from 'classnames';
import { useAppContext } from '../../provider';
/*
 * Wordpress dependencies
 */

const Container = ({ children, containerRef, boxTransitionClass, isOpen }) => {
	const { button } = useAppContext();
	// const isPositionMiddle = isOpen && button?.position?.includes('middle');
	const isButtonRounded = button.rounded === 'yes';

	return (
		<div
			ref={containerRef}
			className={classnames(
				'qlwapp__container',
				`qlwapp__container--${button.position}`,
				// isPositionMiddle &&
				// 	`qlwapp__container--${button.position}--open`,
				isButtonRounded && 'qlwapp__container--rounded',
				boxTransitionClass
			)}
		>
			{children}
		</div>
	);
};

export default Container;
