import md5 from 'md5';
/*
 * Wordpress dependencies
 */
import {
	createContext,
	useContext,
	useEffect,
	useReducer,
} from '@wordpress/element';
/*
 * Internal dependencies
 */
import { getUnexpiredData } from '../../helpers/getUnexpiredData';
import { setDataWithExpiration } from '../../helpers/setDataWithExpiration';
import { INITIAL_STATE, STORAGE_NAME } from './constants';
import { deepMerge } from '../../../helpers/deepMerge';

const AppContext = createContext();

const reducer = (state, action) => {
	const { contacts, contactId, storeName } = action.payload;

	switch (action.type) {
		case 'PERSIST_STATE':
			setDataWithExpiration(storeName, state);

			return state;

		case 'HYDRATE_STATE':
			const storedState = getUnexpiredData(storeName);

			if (storedState) {
				if (!contacts[storedState.contactId]) {
					storedState.contactId = null;
				}

				return { ...storedState };
			}

			return state;

		case 'SET_CONTACT_ID':
			if (contactId === null) {
				return {
					...state,
					contactId: null,
				};
			}

			const firstMessage = contacts[contactId]?.message;

			// If contactId is not null, create new assistantConversation if not exists
			if (!state.contactsConversation[contactId]) {
				return deepMerge(state, {
					contactId,
					contactsConversation: {
						[contactId]: {
							messageListArray:
								firstMessage !== ''
									? [
											{
												id: '',
												source: 'user',
												text: firstMessage,
												status: '',
											},
									  ]
									: [],

							threadOpenaiId: '',
						},
					},
				});
			}

			return {
				...state,
				contactId,
			};

		// case 'SET_ASSISTANT_CONVERSATION_THREAD_OPENAI_ID':
		// 	return deepMerge(state, {
		// 		contactsConversation: {
		// 			[state.contactId]: {
		// 				threadOpenaiId: action.payload,
		// 			},
		// 		},
		// 	});

		// case 'SET_ASSISTANT_CONVERSATION_MESSAGE':
		// 	const newMessageListArray = [
		// 		...state.contactsConversation[state.contactId].messageListArray,
		// 		{
		// 			...action.payload,
		// 		},
		// 	];
		// 	return deepMerge(state, {
		// 		contactsConversation: {
		// 			[state.contactId]: {
		// 				messageListArray: newMessageListArray,
		// 			},
		// 		},
		// 	});

		// case 'UPDATE_ASSISTANT_CONVERSATION_MESSAGE':
		// 	const { id, message } = action.payload;
		// 	const i = state.contactsConversation[
		// 		state.contactId
		// 	].messageListArray.findIndex((message) => message.id === id);
		// 	const oldMessage =
		// 		state.contactsConversation[state.contactId].messageListArray[i];
		// 	const newMessage = deepMerge(oldMessage, message);
		// 	const updatedMessageListArray = [
		// 		...state.contactsConversation[state.contactId].messageListArray,
		// 	];

		// 	updatedMessageListArray.splice(i, 1, newMessage);

		// 	return deepMerge(state, {
		// 		contactsConversation: {
		// 			[state.contactId]: {
		// 				messageListArray: updatedMessageListArray,
		// 			},
		// 		},
		// 	});

		// case 'RESET_ASSISTANT_CONVERSATION':
		// const confirm = window.confirm(
		// 	__(
		// 		'Do you really want to reset the conversation?',
		// 		'wp-whatsapp-chat'
		// 	)
		// );

		// if (confirm) {
		// 	return deepMerge(state, {
		// 		contactsConversation: {
		// 			[state.contactId]: {
		// 				messageListArray: [],
		// 				threadOpenaiId: '',
		// 			},
		// 		},
		// 	});
		// }

		// return state;
	}
	return state;
};

export const useAppContext = () => {
	return useContext(AppContext);
};

export const AppProvider = (props) => {
	const { contacts, children } = props;
	const [state, dispatch] = useReducer(reducer, INITIAL_STATE);

	// Create storeName key based on contacts objet.
	const storeName = STORAGE_NAME + ':' + md5(JSON.stringify(contacts));

	const persistState = () => {
		dispatch({
			type: 'PERSIST_STATE',
			payload: { contacts, storeName },
		});
	};

	const hydrateState = () => {
		dispatch({
			type: 'HYDRATE_STATE',
			payload: { contacts, storeName },
		});
	};

	const setContactId = (contactId) => {
		dispatch({
			type: 'SET_CONTACT_ID',
			payload: { contacts, contactId, storeName },
		});
	};

	// const setAssistantConversationThreadOpenaiId = (threadOpenaiId) => {
	// 	dispatch({
	// 		type: 'SET_ASSISTANT_CONVERSATION_THREAD_OPENAI_ID',
	// 		payload: threadOpenaiId,
	// 	});
	// };

	// const setAssistantConversationMessageAgent = (response) => {
	// 	const id = generateUUID();

	// 	dispatch({
	// 		type: 'SET_ASSISTANT_CONVERSATION_MESSAGE',
	// 		payload: {
	// 			...MESSAGE_PROPS,
	// 			...response,
	// 			source: 'agent',
	// 			id,
	// 		},
	// 	});

	// 	return id;
	// };

	// const setAssistantConversationMessageUser = (response) => {
	// 	const id = generateUUID();

	// 	dispatch({
	// 		type: 'SET_ASSISTANT_CONVERSATION_MESSAGE',
	// 		payload: {
	// 			...MESSAGE_PROPS,
	// 			...response,
	// 			source: 'user',
	// 			id,
	// 		},
	// 	});

	// 	return id;
	// };

	// const updateAssistantConversationMessage = (response) => {
	// 	dispatch({
	// 		type: 'UPDATE_ASSISTANT_CONVERSATION_MESSAGE',
	// 		payload: response,
	// 	});
	// };

	// const resetAssistantConversation = () => {
	// 	dispatch({
	// 		type: 'RESET_ASSISTANT_CONVERSATION',
	// 	});
	// };

	useEffect(() => {
		hydrateState();
	}, []);

	useEffect(() => {
		persistState();
	}, [state]);

	return (
		<AppContext.Provider
			value={{
				...state,
				...props,
				setContactId,
				// setAssistantConversationThreadOpenaiId,
				// setAssistantConversationMessageAgent,
				// setAssistantConversationMessageUser,
				// updateAssistantConversationMessage,
				// resetAssistantConversation,
			}}
		>
			{children}
		</AppContext.Provider>
	);
};
