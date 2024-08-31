export function timeDateToString(time) {
	let minutes = '' + time.getMinutes();
	if (minutes.length === 1) {
		minutes = '0' + minutes;
	}
	return time.getHours() + ':' + minutes;
}
