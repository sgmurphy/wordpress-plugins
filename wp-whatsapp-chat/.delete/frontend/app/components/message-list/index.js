/*
 * Wordpress dependencies
 */
import { useRef, useEffect } from '@wordpress/element';
/*
 * Internal dependencies
 */
import { useAppContext } from '../../provider';
import Message from './message';

const MessageList = () => {
	const spanRef = useRef(null);

	const { contactId, contactsConversation } = useAppContext();

	const { messageListArray } = contactsConversation[contactId];

	useEffect(() => {
		if (spanRef.current && messageListArray.length > 0) {
			setTimeout(() => {
				spanRef.current.scrollIntoView({
					behavior: 'smooth',
				});
			}, [700]);
		}
	}, [messageListArray]);

	return (
		<div className="qlwapp__message-list">
			{messageListArray.map((message) => (
				<Message key={message.id} {...message} />
			))}
			<span ref={spanRef} />
		</div>
	);
};

export default MessageList;
