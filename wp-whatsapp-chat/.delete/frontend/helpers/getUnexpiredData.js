export const getUnexpiredData = (key) => {
	const data = localStorage.getItem(key);

	if (data) {
		const parsedData = JSON.parse(data);
		const now = new Date();

		if (now.getTime() > parsedData.expiration) {
			localStorage.removeItem(key); // Remove the data if it has expired

			return null;
		}
		return parsedData.value;
	}

	return null; // If the data does not exist in localStorage
};
