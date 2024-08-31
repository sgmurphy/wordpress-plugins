/*
 * External dependencies
 */
import classnames from 'classnames';
/*
 * Wordpress dependencies
 */
import { lazy, Suspense, useState } from '@wordpress/element';
/*
 * Internal dependencies
 */
import { useAppContext } from '../../provider';
import Header from '../header';
import Footer from '../footer';
import ContactList from '../contact-list';

const MessageList = lazy(() => import('../message-list'));

const ModalContent = ({ handleBoxClose }) => {
	const { contactId, setContactId } = useAppContext();
	const [closing, setClosing] = useState('');
	const isContactSelected = contactId !== null;

	const handlePrevious = (e) => {
		e.preventDefault();
		setClosing('qlwapp__modal--closing');
		setTimeout(() => {
			setContactId(null);
			setClosing('');
		}, [300]);
	};

	return (
		<div
			className={classnames(
				'qlwapp__modal',
				isContactSelected && 'qlwapp__modal--response',
				closing
			)}
		>
			<Header onClose={handleBoxClose} onPrevious={handlePrevious} />

			<div className="qlwapp__modal__body">
				<div className="qlwapp__carousel">
					<div className="qlwapp__carousel-slide">
						<ContactList onClick={setClosing} />
					</div>
					<Suspense>
						<div className="qlwapp__carousel-slide">
							{contactId !== null && <MessageList />}
						</div>
					</Suspense>
				</div>
			</div>
			<Footer />
		</div>
	);
};

const Modal = (props) => {
	return <ModalContent {...props} />;
};

export default Modal;
