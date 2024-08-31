import { useAppContext } from '../../provider';

export const ContactAvatar = ({ contact }) => {
	const { box } = useAppContext();
	return (
		<div className="qlwapp__avatar">
			<div className="qlwapp__avatar__container">
				{contact?.avatar && (
					<img
						src={contact.avatar}
						alt={contact.firstname}
						loading={box.lazy_load === 'yes' && 'lazy'}
					/>
				)}
			</div>
		</div>
	);
};
