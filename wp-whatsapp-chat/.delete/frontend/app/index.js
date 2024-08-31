/*
 * Wordpress dependencies
 */
import {
	useRef,
	useEffect,
	useState,
	lazy,
	Suspense,
} from '@wordpress/element';
/*
 * Internal dependencies
 */
import { getCookie } from '../helpers/getCookie';
import { isVisibleInDevice } from '../helpers/isVisibleInDevice';
import { setCookie } from '../helpers/setCookie';
import Button from './components/button';
import Container from './components/container';
import { AppProvider } from './provider';

const Modal = lazy(() => import('./components/modal'));

const App = (props) => {
	const { box } = props;
	const containerRef = useRef(null);
	const [isOpen, setIsOpen] = useState(false);

	const [boxTransitionClass, setBoxTransitionClass] = useState('');

	const isAutoloadEnabled =
		box.auto_open === 'yes' &&
		box.enable === 'yes' &&
		!getCookie('qlwapp-auto-load');

	const autoloadDelay = Number(box.auto_delay_open);

	useEffect(() => {
		if (isAutoloadEnabled) {
			setTimeout(() => {
				setIsOpen(true);
			}, autoloadDelay);
			setCookie('qlwapp-auto-load', true, 1);
		}
	}, [isOpen, isAutoloadEnabled, autoloadDelay]);

	useEffect(() => {
		function handleClickOutside(event) {
			if (isOpen && !containerRef?.current.contains(event.target)) {
				handleBoxClose();
			}
		}
		window.addEventListener('click', handleClickOutside);
		return () => {
			window.removeEventListener('click', handleClickOutside);
		};
	}, [isOpen]);

	const handleBoxOpen = () => {
		setIsOpen(true);
		setBoxTransitionClass('qlwapp__container--opening');
		setTimeout(() => {
			setBoxTransitionClass('qlwapp__container--open');
		}, 300);
	};

	const handleBoxClose = (e) => {
		e?.preventDefault();
		setBoxTransitionClass('qlwapp__container--closing');
		setTimeout(() => {
			setIsOpen(false);
			setBoxTransitionClass('');
		}, 300);
	};

	const handleBoxToggle = () => {
		if (isOpen) {
			handleBoxClose();
		} else {
			handleBoxOpen();
		}
	};

	return (
		<AppProvider {...props}>
			<Container
				boxTransitionClass={boxTransitionClass}
				containerRef={containerRef}
				isOpen={isOpen}
			>
				{isOpen && (
					<Suspense>
						<Modal handleBoxClose={handleBoxClose} />
					</Suspense>
				)}
				<Button onClick={handleBoxToggle} />
			</Container>
		</AppProvider>
	);
};

const AppVisible = (props) => {
	const { display } = props;
	if (!isVisibleInDevice(display?.devices)) {
		return;
	}
	return <App {...props} />;
};

export default AppVisible;
