import { useState, useEffect } from '@wordpress/element';
import { useSelect, useDispatch } from '@wordpress/data';
import apiFetch from '@wordpress/api-fetch';

import { getSquareSettings, filterBusinessLocations } from '../../utils';
import store from '../../onboarding/data/store';

export const useSquareSettings = (fromServer = false) => {
	const dispatch = useDispatch();
	const [squareSettingsLoaded, setSquareSettingsLoaded] = useState(false);
	const getSquareSettingData = (key) =>
		useSelect((select) => select(store).getSquareSettings(key));
	const getSquareSettingsSavingProcess = () =>
		useSelect((select) => select(store).getSquareSettingsSavingProcess());

	const setSquareSettingData = (data) =>
		dispatch(store).setSquareSettings(data);
	const setSquareSettingsSavingProcess = (data) =>
		dispatch(store).setSquareSettingsSavingProcess(data);
	const setBusinessLocation = (locations = []) => {
		setSquareSettingData({ locations: filterBusinessLocations(locations) });
	};

	const settings = getSquareSettingData();
	const isSquareSettingsSaving = getSquareSettingsSavingProcess();

	const saveSquareSettings = async () => {
		setSquareSettingsSavingProcess(true);

		const response = await apiFetch({
			path: '/wc/v3/wc_square/settings',
			method: 'POST',
			data: settings,
		});

		setSquareSettingsSavingProcess(null); // marks that the saving is over.
		await new Promise((resolve) => setTimeout(resolve, 1000));
		setSquareSettingsSavingProcess(false);

		return response;
	};

	useEffect(() => {
		if (!fromServer) {
			setSquareSettingsLoaded(true);
			return;
		}

		(async () => {
			if (!squareSettingsLoaded) {
				const squareSettings = await getSquareSettings();
				setSquareSettingData(squareSettings);
				setBusinessLocation(squareSettings.locations);
				setSquareSettingsLoaded(true);
			}
		})();
	}, [fromServer]);

	return {
		settings,
		squareSettingsLoaded,
		isSquareSettingsSaving,
		getSquareSettingData,
		setSquareSettingData,
		setBusinessLocation, // Extra utility to normalise locations data.
		saveSquareSettings,
	};
};
