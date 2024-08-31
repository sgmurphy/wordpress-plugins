export const isMobile = () => {
	const isSmartDevice =
		/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
			navigator.userAgent
		);
	const match = window.matchMedia('(pointer:coarse)');
	return match && match.matches && isSmartDevice;
};
