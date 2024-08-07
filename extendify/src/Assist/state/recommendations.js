import apiFetch from '@wordpress/api-fetch';
import { create } from 'zustand';
import { persist, createJSONStorage } from 'zustand/middleware';
import { safeParseJson } from '@assist/lib/parsing';

const key = 'extendify-assist-recommendations';
const startingState = {
	viewedRecommendations: [],
	dismissedRecommendations: [],
	// initialize the state with default values
	...(safeParseJson(window.extAssistData.userData.recommendationData)?.state ??
		{}),
};

const state = (set, get) => ({
	...startingState,
	track(slug) {
		const lastViewedAt = new Date().toISOString();
		const firstViewedAt = lastViewedAt;
		set(({ viewedRecommendations }) => {
			const viewed = viewedRecommendations.find((a) => a.slug === slug);
			return {
				viewedRecommendations: [
					// Remove if it's already in the list
					...viewedRecommendations.filter((a) => a.slug !== slug),
					// Either add it or update the count
					viewed
						? { ...viewed, count: viewed.count + 1, lastViewedAt }
						: { slug, firstViewedAt, lastViewedAt, count: 1 },
				],
			};
		});
	},
	isDismissedRecommendation(id) {
		return get().dismissedRecommendations.some((rec) => rec.id === id);
	},
	dismissRecommendation(id) {
		if (get().isDismissedRecommendation(id)) return;
		const rec = { id, dismissedAt: new Date().toISOString() };
		set((state) => ({
			dismissedRecommendations: [...state.dismissedRecommendations, rec],
		}));
	},
});

const path = '/extendify/v1/assist/recommendations-data';
const storage = {
	getItem: async () => await apiFetch({ path }),
	setItem: async (_name, state) =>
		await apiFetch({ path, method: 'POST', data: { state } }),
};

export const useRecommendationsStore = create(
	persist(state, {
		name: key,
		storage: createJSONStorage(() => storage),
		skipHydration: true,
	}),
);
