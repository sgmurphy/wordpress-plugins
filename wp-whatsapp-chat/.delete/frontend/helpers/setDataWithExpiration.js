export const setDataWithExpiration = (key, value, expirationDays = 30) => {
	let data = localStorage.getItem(key);

	if (data) {
		data = JSON.parse(data);
		data.value = value;
	} else {
		const now = new Date();
		const expirationDate = new Date(
			now.getTime() + expirationDays * 24 * 60 * 60 * 1000
		); // Calculate expiration date in milliseconds

		data = {
			value,
			expiration: expirationDate.getTime(),
		};
	}

	localStorage.setItem(key, JSON.stringify(data));
};
