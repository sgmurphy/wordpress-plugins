=== WP Statistics - The Most Popular Privacy-Friendly Analytics Plugin ===
Contributors: mostafa.s1990, kashani, veronalabs, GregRoss
Donate link: https://wp-statistics.com/donate/
Tags: analytics, google analytics, insights, stats, site visitors
Requires at least: 5.0
Tested up to: 6.5
Stable tag: 14.6.4
Requires PHP: 5.6
License: GPL-2.0+
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This plugin gives you the complete information on your website's visitors.

== Description ==
= WP Statistics: THE #1 WORDPRESS STATISTICS PLUGIN =
Do you need a simple tool to know your website statistics? Do you need to represent these statistics? Are you caring about your users’ privacy while analyzing who are interested in your business or website? With WP Statistics you can know your website statistics without any need to send your users’ data anywhere. You can know how many people visit your personal or business website, where they’re coming from, what browsers and search engines they use, and which of your contents, categories, tags and users get more visits.

[Checkout Demo](https://wp-statistics.com/demo)

= Data Privacy =
WP Statistics stores all data, including IP addresses, safely on your server. WP Statistics respects user privacy and is GDPR, CCPA compliant, as detailed on our [GDPR, CCPA and cookie law compliant](https://wp-statistics.com/resources/what-we-collect/) page. It anonymizes IPs, uses IP hashing with random daily Salt Mechanism for extra security, and follows Do Not Track (DNT) requests from browsers. This keeps user information private while giving you insights into your website traffic.

= ACT BETTER  BY KNOWING WHAT YOUR USERS ARE LOOKING FOR =
* Anonymize IP to Better Privacy
* Enhance IP Hashing with Random Daily Salt Mechanism
* Respect for User Privacy with [Do Not Track (DNT)](https://en.wikipedia.org/wiki/Do_Not_Track) Compliance
* Visitor Data Records including IP, Referring Site, Browser, Search Engine, OS, Country and City
* Stunning Graphs and Visual Statistics
* Visitor’s Country & City Recognition
* The number of Visitors coming from each Search Engine
* The number of Referrals from each Referring Site
* Top 10 common browsers; Top 10 countries with most visitors; Top 10 most-visited pages; Top 10 referring sites
* Hits Time-Based Filtering
* Statistics on Contents based on Categories, Tags, and Writers
* Widget Support for showing Statistics
* Data Export in TSV, XML, and CSV formats
* Statistical Reporting Emails
* Statistical of pages with query strings and UTM parameters
* [Premium] [Data Plus](https://wp-statistics.com/product/wp-statistics-data-plus?utm_source=wporg&utm_medium=link&utm_campaign=dp)
 * Link Tracker: Tracks clicks on outgoing links, offering insights into visitor engagement with external content.
 * Download Tracker: Observes which files are downloaded, providing clarity on content effectiveness.
* [Premium] [More Advanced reporting](http://bit.ly/2MjZE3l)
* And much more information represented in graphs & charts along with data filtering

= NOTE =
Some advanced features are Premium, which means you need to buy extra add-ons to unlock those features. You can get [Premium add-ons](http://bit.ly/2x6tGly) here!

= REPORT BUGS =
If you encounter any bug, please create an issue on [GitHub](https://github.com/wp-statistics/wp-statistics/issues/new) where we can act upon them more efficiently. Since [Github](https://github.com/wp-statistics/wp-statistics) is not a support forum, just bugs are welcomed, and any other request will be closed.

== Installation ==
1. Upload `wp-statistics` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Make sure the Date and Time are set correctly in WordPress.
4. Go to the plugin settings page and configure as required (note this will also include downloading the GeoIP database for the first time).

== Frequently Asked Questions ==
= GDPR Compliant? =
The greatest advantage of WP Statistics is that all the data is saved locally in WordPress.
This helps a lot while implementing the new GDPR restrictions; because it’s not necessary to create a data processing contract with an external company! [Read more about WP Statistics compliance with GDPR](https://wp-statistics.com/resources/what-we-collect/).

= Does WP Statistics support Multisite? =
WP Statistics doesn't officially support the multisite feature; however, it does have limited functionally associated with it and should function without any issue. However, no support is provided at this time.
Version 8.8 is the first release that can be installed, upgraded and removed correctly on multi-site. It also has some basic support for the network admin menu. This should not be taken as an indication that WP Statistics fully supports the multisite, but only should be considered as a very first step.

= Does WP Statistics work with caching plugins? =
Yes, the cache support added in v12.5.1

If you're using a plugin cache:
* Don't forget to clear your enabled plugin cache.
* You should enable the plugin cache option in the Settings page.
* Making sure the below endpoint registered in your WordPress.
http://yourwebsite.com/wp-json/wpstatistics/v1

To register, go to the Permalink page and update the permalink with press Save Changes.

= What’s the difference between Visits and Visitors? =
Visits is the number of page hits your site has received.
Visitors is the number of unique users which have visited your site.
Visits should always be greater than Visitors (though, there are a few cases when this won’t be true due to having low visits).
The average number of pages a visitor views on your site is Visits/Visitors.

= Are All visitors’ locations set to ‘unknown’? =
Make sure you’ve downloaded the GeoIP database and the GeoIP code is enabled.
Also, if you are running an internal test site with non-routable IP addresses (like 192.168.x.x or 172.28.x.x or 10.x.x.x), these addresses will be always shown as ‘unknown’. You can define a location IP for these IP addresses in the “Country code for private IP addresses” setting.

= I’m using another statistics plugin/service and get different numbers from them, why? =
Probably, each plugin/service is going to give you different statistics on visits and visitors; there are several reasons for this:

* Web crawler detections
* Detection methods (Javascript vs. Server Side PHP)
* Centralized exclusions

Services that use centralized databases for spam and robot detections , such as Google Analytics, have better detection than WP Statistics.

= Not all referrals are showing up in the search words list, why? =
Search Engine Referrals and Words are highly dependent on the search engines providing the information to us. Unfortunately, we can’t do anything about it; we report everything we receive.

= Does WP Statistics support the UTM parameters? =
Yes, It does! WP Statistics logs all query strings in the URL such as UTM parameters.

= PHP v8.0 Support? =
WP Statistics is PHP 8.0 compliant.

= IPv6 Support? =
WP Statistics supports IPv6 as of version 11.0; however, PHP must be compiled with IPv6 support enabled; otherwise you may see warnings when a visitor from an IPv6 address hits your site.

You can check if IPv6 support is enabled in PHP by visiting the Optimization > Resources/Information->Version Info > PHP IPv6 Enabled section.

If IPv6 is not enabled, you may see a warning like:

	Warning: inet_pton() [function.inet-pton]: Unrecognized address 2003:0006:1507:5d71:6114:d8bd:80c2:1090

= What 3rd party services does the plugin use? =
IP location services are provided by data created by [MaxMind](https://www.maxmind.com/), to detect the Visitor's location (Country & City) the plugin downloads the GeoLite2 Database created by [MaxMind](https://www.maxmind.com/) on your server locally and use it.

Referrer spam blacklist is provided by Matomo, available from https://github.com/matomo-org/referrer-spam-blacklist

== Screenshots ==
1. Overview
2. Website Traffic Overview
3. Live User Activity Tracker
4. Optimization
5. Settings
6. Real-Time Stats
7. Download Tracker
8. Referrals
9. Countries
10. Author Analytics
11. Browsers
12. Link Tracker

== Upgrade Notice ==
= 14.0 =
**IMPORTANT NOTE**
Welcome to WP Statistics v14.0, our biggest update!
Thank you for being part of our community. We’ve been working hard for one year to develop this version and make WP Statistics better for you. after updating, please update all Add-Ons to tha latest version as well.

If you encounter any bug, please create an issue on [GitHub](https://github.com/wp-statistics/wp-statistics/issues/new) where we can act upon them more efficiently. Since [GitHub](https://github.com/wp-statistics/wp-statistics) is not a support forum, just bugs are welcomed, and any other request will be closed.

== Changelog ==
= 14.6.4 - 03.05.2024 =
* Fixes: Improved data comparison logic.
* Fixes: Fixed some fields visibility on settings page.
* Fixes: Fixed filter loading on Visitors page.
* Fixes: Fixed and improved the Convert IP Addresses to Hash in Optimization.
* Fixes: Fixed loading Date Picker in Visitors filter.
* Improvement: Updated plugin header and screenshots.
* Improvement: Add-ons settings page now located under Settings for simplicity.
* Improvement: Minor enhancements made.

[See changelog for all versions](https://raw.githubusercontent.com/wp-statistics/wp-statistics/master/CHANGELOG.md).
