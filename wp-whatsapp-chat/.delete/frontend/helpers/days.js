import { __ } from '@wordpress/i18n';

function isTimedaysIncludesDay(timedays, day) {
	if (timedays.includes(parseInt(day))) {
		return true;
	}
	if (timedays.includes(day.toString())) {
		return true;
	}
	return false;
}

function parseTimezone(timezone) {
	const match = timezone.match(/^UTC([+-]\d{1,2})$/);
	if (match) {
		const offset = parseInt(match[1], 10);
		return offset * 60 * 60 * 1000;
	}
	return null;
}

function getDayInTimezone(timezone) {
	try {
		let now = new Date();
		const options = { weekday: 'long' };

		const offsetMs = parseTimezone(timezone);
		if (offsetMs !== null) {
			const utcDate = new Date(
				now.getTime() + now.getTimezoneOffset() * 60000 + offsetMs
			);
			options.timeZone = 'UTC';
			now = utcDate;
		} else {
			options.timeZone = timezone;
		}

		const formatter = new Intl.DateTimeFormat('en-US', options);
		const dayName = formatter
			.formatToParts(now)
			.find((part) => part.type === 'weekday').value;

		const dayMap = {
			Sunday: 0,
			Monday: 1,
			Tuesday: 2,
			Wednesday: 3,
			Thursday: 4,
			Friday: 5,
			Saturday: 6,
		};

		return dayMap[dayName];
	} catch (error) {
		return null;
	}
}

export function getNextAvailableDay({ timedays, timezone }) {
	const today = getDayInTimezone(timezone);

	if (today === null) {
		return false;
	}

	const dayNames = [
		__('Sunday', 'wp-whatsapp-chat'),
		__('Monday', 'wp-whatsapp-chat'),
		__('Tuesday', 'wp-whatsapp-chat'),
		__('Wednesday', 'wp-whatsapp-chat'),
		__('Thursday', 'wp-whatsapp-chat'),
		__('Friday', 'wp-whatsapp-chat'),
		__('Saturday', 'wp-whatsapp-chat'),
	];

	// Check from today to the end of the week
	for (let i = today; i <= 6; i++) {
		if (isTimedaysIncludesDay(timedays, i)) {
			return dayNames[i];
		}
	}
	// Check from the start of the week to today
	for (let i = 0; i < today; i++) {
		if (isTimedaysIncludesDay(timedays, i)) {
			return dayNames[i];
		}
	}
	// If no days are available, return a message indicating no available days
	return false;
}
