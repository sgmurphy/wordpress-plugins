// PHP: Handles time zone offsets directly in seconds, thus requiring conversion to minutes for readability or practical use.
// JavaScript: Handles differences between Date objects in milliseconds, requiring a division by 60000 to convert to minutes.
export function getTimezoneOffset(timezone) {
	let offset = 0;

	if (timezone.includes('UTC')) {
		// Extract the numeric part from the timezone string
		const numericPart = timezone.replace(/UTC\+?/, '');
		if (!isNaN(numericPart)) {
			offset = parseInt(numericPart) * 60;
		}
	} else {
		try {
			// Get the current date in the specified timezone
			const currentTimezone = new Date().toLocaleString('en-US', {
				timeZone: timezone,
			});
			const localDateObject = new Date(currentTimezone + ' UTC'); // Parsing as UTC to correctly calculate the offset

			const utcDate = new Date();

			// Calculate the difference in milliseconds and convert to minutes
			offset = (localDateObject - utcDate) / 60000;
		} catch (e) {
			//if invalid timezone, return 0
			return 0;
		}
	}

	return offset;
}
