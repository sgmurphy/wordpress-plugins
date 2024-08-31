export const isAvailableDay = ({ timedays }) => {
	const today = new Date().getDay().toString();
	return timedays?.includes(today) || timedays?.length === 0;
};
