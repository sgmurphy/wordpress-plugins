import classnames from 'classnames';
/*
 * Wordpress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useRef, useState } from '@wordpress/element';
/*
 * Internal dependencies
 */
import { useAppContext } from '../../provider';
import { Send } from '../../../assets/icons/send';
import triggerWhatsAppClick from '../../../helpers/triggerWhatsAppClick';

const Footer = () => {
	const { box, contactId, contacts } = useAppContext();
	// const {
	// 	assistants,
	// 	contactId,
	// 	contactsConversation,
	// 	setAssistantConversationMessageAgent,
	// 	setAssistantConversationMessageUser,
	// 	setAssistantConversationThreadOpenaiId,
	// 	updateAssistantConversationMessage,
	// 	resetAssistantConversation,
	// } = useAppContext();

	const contact = contacts[contactId];
	const [inputMessage, setInputMessage] = useState('');

	const textareaRef = useRef();

	const isMessageEmpty = !inputMessage.trim();

	// const thread_openai_id =
	// 	contactsConversation[contactId]?.threadOpenaiId;

	// const addMessage = async () => {
	// 	setAssistantConversationMessageAgent({ text: inputMessage });
	// 	setResponseIsLoading(true);
	// 	setInputMessage('');
	// 	resizableTextarea(true);

	// 	const responseMessageId = setAssistantConversationMessageUser({
	// 		status: 'waiting',
	// 	});

	// 	const responseCreateMessage =
	// 		await fetchServicesAssistantMessagesOpenAi('create', {
	// 			thread_openai_id,
	// 			message_content: inputMessage,
	// 			assistant_id: assistants[contactId].assistant_id,
	// 			openai_id: assistants[contactId].openai_id,
	// 		});

	// 	if (!responseCreateMessage) {
	// 		updateAssistantConversationMessage({
	// 			id: responseMessageId,
	// 			message: {
	// 				text: __(
	// 					'There was an error with the response. Please try again.',
	// 					'wp-whatsapp-chat'
	// 				),
	// 				status: 'error',
	// 			},
	// 		});
	// 		setResponseIsLoading(false);
	// 		return;
	// 	}

	// 	const { openai_id } = responseCreateMessage;

	// 	const responseGetMessages = await fetchServicesAssistantMessagesOpenAi(
	// 		'messages',
	// 		{
	// 			thread_openai_id,
	// 			openai_id,
	// 		}
	// 	);

	// 	if (!responseGetMessages) {
	// 		updateAssistantConversationMessage({
	// 			id: responseMessageId,
	// 			message: {
	// 				text: __(
	// 					'There was an error getting the messages. Please try again.',
	// 					'wp-whatsapp-chat'
	// 				),
	// 				status: 'error',
	// 			},
	// 		});
	// 		setResponseIsLoading(false);

	// 		return;
	// 	}

	// 	updateAssistantConversationMessage({
	// 		id: responseMessageId,
	// 		message: {
	// 			text: responseGetMessages[0].message,
	// 			status: 'success',
	// 		},
	// 	});
	// 	setResponseIsLoading(false);
	// };

	const isResponseDisabled = isMessageEmpty;

	const resizableTextarea = (reset = false) => {
		const textareaElement = textareaRef.current;
		if (!textareaElement) return;

		textareaElement.style.height = '';

		if (!reset && !inputMessage === '') {
			textareaElement.style.height = `${textareaElement.scrollHeight}px`;
		}
	};

	const handleSetMessage = (e) => {
		e.preventDefault();
		setInputMessage(e.target.value);
		resizableTextarea();
	};

	const handleWhatsAppLink = (e) => {
		e.preventDefault();
		triggerWhatsAppClick({
			...contact,
			message: inputMessage,
		});
	};

	const handleKeyPress = (e) => {
		if (e.shiftKey && e.key === 'Enter') {
			return;
		}
		if (e.key === 'Enter' && !isResponseDisabled) {
			handleWhatsAppLink(e);
		}
	};

	return (
		<>
			{box.footer && (
				<div
					className="qlwapp__footer"
					dangerouslySetInnerHTML={{
						__html: box.footer,
					}}
				/>
			)}

			<div className="qlwapp__response">
				<pre>{inputMessage}</pre>
				<textarea
					ref={textareaRef}
					maxLength="300"
					onChange={handleSetMessage}
					onKeyDown={handleKeyPress}
					value={inputMessage}
					placeholder={box?.response}
					aria-label={box?.response}
					tabIndex="0"
				/>
				<div className="qlwapp__response__buttons">
					<i
						className="qlwapp__reply--disabled qlwf-emoji"
						role="button"
						tabIndex="0"
						title={__('Add emoji', 'wp-whatsapp-chat')}
						// onClick={() => resetAssistantConversation()}
						// onClick={() => alert('test')}
					>
						{/* <Emoji /> */}
					</i>
					<a
						className={classnames(
							'qlwapp__reply'
							// isResponseDisabled && 'qlwapp__reply--disabled'
						)}
						role="button"
						tabIndex="0"
						onClick={handleWhatsAppLink}
						title={__('Send', 'wp-whatsapp-chat')}
						target="blank"
					>
						<Send />
					</a>
				</div>
			</div>
		</>
	);
};

export default Footer;
