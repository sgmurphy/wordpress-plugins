import { isMobile } from './isMobile';

export const isVisibleInDevice = (devices) => {
	if (devices === 'hide') {
		return false;
	}

	if (devices === 'desktop' && isMobile()) {
		return false;
	}

	if (devices === 'mobile' && !isMobile()) {
		return false;
	}

	return true;
};
