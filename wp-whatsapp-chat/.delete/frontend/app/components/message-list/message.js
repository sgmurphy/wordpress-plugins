/*
 * External dependencies
 */
import classnames from 'classnames';
/*
 * Internal dependencies
 */
import { MessageLoading } from '../../../assets/icons/message-loading';
import { decodeHTMLEntities } from '../../../../helpers/decodeHTMLEntities';

const Message = ({ text, status, source }) => {
	return (
		<div
			className={classnames(
				'qlwapp__message',
				source && `qlwapp__message--${source}`,
				status && `qlwapp__message--${status}`
			)}
		>
			{status === 'waiting' ? (
				<span className="qlwapp__message--spinner">
					<MessageLoading />
				</span>
			) : (
				decodeHTMLEntities(text)
			)}
		</div>
	);
};

export default Message;
