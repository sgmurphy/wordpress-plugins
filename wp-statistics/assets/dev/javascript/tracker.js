let WP_Statistics_CheckTime = WP_Statistics_Tracker_Object.jsCheckTime;

// Check DoNotTrack Settings on User Browser
let WP_Statistics_Dnd_Active = parseInt(navigator.msDoNotTrack || window.doNotTrack || navigator.doNotTrack, 10);

// Prevent init() from running more than once
let hasTrackerInitializedOnce = false;

const referred = encodeURIComponent(document.referrer);

let wpStatisticsUserOnline = {
    hitRequestSuccessful: true, // Flag to track hit request status

    init: function () {
        if (hasTrackerInitializedOnce) {
            return;
        }
        hasTrackerInitializedOnce = true;

        if (typeof WP_Statistics_Tracker_Object == "undefined") {
            console.log('Variable WP_Statistics_Tracker_Object not found on the page source. Please ensure that you have excluded the /wp-content/plugins/wp-statistics/assets/js/tracker.js file from your cache and then clear your cache.');
        } else {
            this.checkHitRequestConditions();
            this.keepUserOnline();
        }
    },

    // Check Conditions for Sending Hit Request
    checkHitRequestConditions: function () {
        if (WP_Statistics_Tracker_Object.option.isClientSideTracking) {
            if (WP_Statistics_Tracker_Object.option.dntEnabled) {
                if (WP_Statistics_Dnd_Active !== 1) {
                    this.sendHitRequest();
                }
            } else {
                this.sendHitRequest();
            }
        }
    },

    // Sending Hit Request
    sendHitRequest: async function () {
        if (!WP_Statistics_Tracker_Object.option.isClientSideTracking) {
            return;
        }

        try {
            const timestamp = Date.now();
            const requestUrl = `${WP_Statistics_Tracker_Object.hitRequestUrl}&referred=${referred}&_=${timestamp}`;

            const response = await fetch(requestUrl, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json;charset=UTF-8',
                },
            });

            if (!response.ok) {
                if (response.status === 403) {
                    this.hitRequestSuccessful = false; // Set flag to false if status is 403
                }
            } else {
                this.hitRequestSuccessful = true; // Set flag to true if request is successful
            }
        } catch (error) {
            this.hitRequestSuccessful = false;
        }
    },

    // Send Request to REST API to Show User Is Online
    sendOnlineUserRequest: function () {
        if (!this.hitRequestSuccessful || !WP_Statistics_Tracker_Object.option.isClientSideTracking) {
            return; // Stop if hit request was not successful or isClientSideTracking is false
        }

        try {
            const timestamp = Date.now();
            const requestUrl = `${WP_Statistics_Tracker_Object.keepOnlineRequestUrl}&referred=${referred}&_=${timestamp}`;

            var WP_Statistics_http = new XMLHttpRequest();
            WP_Statistics_http.open("GET", requestUrl);
            WP_Statistics_http.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            WP_Statistics_http.send(null);
        } catch (error) {

        }
    },

    // Execute Send Online User Request Function Every n Sec
    keepUserOnline: function () {
        setInterval(
            function () {
                if ((!WP_Statistics_Tracker_Object.option.dntEnabled ||
                    (WP_Statistics_Tracker_Object.option.dntEnabled && WP_Statistics_Dnd_Active !== 1)) &&
                    this.hitRequestSuccessful && WP_Statistics_Tracker_Object.option.isClientSideTracking) {
                    this.sendOnlineUserRequest();
                }
            }.bind(this), WP_Statistics_CheckTime
        );
    },
};

document.addEventListener('DOMContentLoaded', function () {
    if (WP_Statistics_Tracker_Object.option.consentLevel == 'disabled' || WP_Statistics_Tracker_Object.option.trackAnonymously ||
        !WP_Statistics_Tracker_Object.option.isWpConsentApiActive || wp_has_consent(WP_Statistics_Tracker_Object.option.consentLevel)) {
        wpStatisticsUserOnline.init();
    }

    document.addEventListener("wp_listen_for_consent_change", function (e) {
        const changedConsentCategory = e.detail;
        for (let key in changedConsentCategory) {
            if (changedConsentCategory.hasOwnProperty(key)) {
                if (key === WP_Statistics_Tracker_Object.option.consentLevel && changedConsentCategory[key] === 'allow') {
                    wpStatisticsUserOnline.init();

                    // When trackAnonymously is enabled, the init() call above will get ignored (since it's already initialized before)
                    // So, in this specific case, we can call checkHitRequestConditions() manually
                    // This will insert a new record for the user (who just gave consent to us) and prevent other scripts (e.g. event.js) from malfunctioning
                    if (WP_Statistics_Tracker_Object.option.trackAnonymously) {
                        wpStatisticsUserOnline.checkHitRequestConditions();
                    }
                }
            }
        }
    });
});
