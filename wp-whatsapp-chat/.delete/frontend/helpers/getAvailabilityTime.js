import { timeStringToInt } from './timeStringToInt';
import { timeDateToString } from './timeDateToString';
import { getTimezoneOffset } from './getTimezoneOffset';
import { isAvailableDay } from './isAvailableDay';

export const getAvailabilityTime = ({
	timezone,
	timefrom,
	timeto,
	timedays,
}) => {
	const isInAvailableDay = isAvailableDay({ timedays });

	const timezoneOffset = getTimezoneOffset(timezone);

	const currentTimeTo = new Date();
	const currentTimeFrom = new Date();
	const currentTime = new Date();

	let timeFromMs = currentTimeFrom.getTime();
	let timeToMs = currentTimeTo.getTime();

	if (timefrom !== timeto) {
		const n = currentTime.getTimezoneOffset();
		const timeZoneOffset = -n - (timezoneOffset || 0);

		let hr, min;

		hr = timeStringToInt(timefrom[0], timefrom[1]);
		min = timeStringToInt(timefrom[3], timefrom[4]);

		currentTimeFrom.setHours(hr);
		currentTimeFrom.setMinutes(min + timeZoneOffset);

		timeFromMs = currentTimeFrom.getTime(); // Update after modifications

		hr = timeStringToInt(timeto[0], timeto[1]);
		min = timeStringToInt(timeto[3], timeto[4]);

		currentTimeTo.setHours(hr);
		currentTimeTo.setMinutes(min + timeZoneOffset);

		timeToMs = currentTimeTo.getTime();

		if (timeFromMs > timeToMs) {
			timeFromMs -= 86400000; // Adjust for date rollover
		}

		const isInAvailableHour =
			timeFromMs <= currentTime.getTime() &&
			currentTime.getTime() <= timeToMs;

		return {
			isAvailableNow: isInAvailableDay && isInAvailableHour,
			isInAvailableDay,
			isInAvailableHour,
			timefrom: timeDateToString(currentTimeFrom),
			timeto: timeDateToString(currentTimeTo),
		};
	}
	return {
		isAvailableNow: isInAvailableDay,
		isInAvailableDay,
		isInAvailableHour: true,
	};
};
