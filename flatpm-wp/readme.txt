# FlatPM – Ad Manager, AdSense and Custom Code #
* Contributors: FlatBoy
* Donate link: https://mehanoid.pro/flat-pm/
* Tags: custom code, ad injection, ads plugin, ad rotation, ad manager, ads, adsense, advertising, banner, rotator, ad blocking detection, header code, footer code, banners, adverts, sticky fixed widgets, flatpm, flat pm, flat profit maker
* Requires at least: 5.9
* Tested up to: 6.5.2
* Stable tag: 3.1.17
* Requires PHP: 5.6
* License: GPLv3
* License URI: https://www.gnu.org/licenses/gpl.html


## Description ##
**Flat PM** is an ad management plugin. You might be thinking, "why do I need it?". It's simple: this is the best plugin for organizing ads at a professional level.

You can compare it with plugins like Advanced Ads, Ad Inserter, believe me, it's nothing compared to FlatPM.
If you're worried about front-end performance, then the plugin code is written without using jQuery!

Flat PM has all the functionality, with the exception of GEO, completely free.

This is a new level of advertising management. You can not only create and save ad blocks, but also divide them into folders. Manage general settings for a folder so that you don't have to make changes to each individual ad block.

You can create 3 different types of AB tests.

### The plugin has the following options for displaying ads: ###
* Output based on pixels or the height of the user's screen (a completely unique solution that is not found in other plugins);
* Output based on characters or percentage of your article text;
* Output once, or with repetitions based on css selectors (you are not limited by the content of your article, works without hooks on the backend, very configurable);
* Output of pop-ups and leaving blocks on the left/bottom/right and so on, 9 positions in total;
* Display ads when hovering over an element: images, text, video, and whatever you want;
* Video preroll before watching videos on YouTube, Vimeo.

The plugin does not have any restrictions, it is a fully customizable tool.

### Content targeting options: ###
* Publications;
* Publication types;
* Categories and taxonomies;
* The number of characters and headings in the publication;
* The authors of the publication;
* Types of templates and templates.

### User targeting options: ###
* GEO: country or city (PRO functionality, paid base of IP addresses is used);
* referrer;
* Browser;
* Operating system;
* ISP - Internet Service Provider;
* Get parameter in the link address;
* Cookies;
* Date and time;
* You can specify the schedule by day of the week;
* The role of the user on the site;
* user-agent;
* You can block the display by ip.

### Additional options: ###
* Reloading ads;
* Fixed Widgets;
* Laziload advertising;
* Stylization;
* Fine-tuning the interface of the plugin itself;
* Export Import;
* Output in head and footer;
* Full compatibility with caching plugins;
* Auto reset cache when changing ad settings.

### The plugin has been translated into English, Ukrainian and Russian languages. ###
In the future, translation into German, Spanish, French will be made. You can contact us for help with translation.

### Conclusion: ###
Flat PM is a professional solution that has been perfected over 7 years. The code is clean, does not create a load on the server. Ease of use in the admin panel. The interface is clear and structured.


## Installation ##
Install like any other plugin or:
* Upload the files to the `/wp-content/plugins/flatpm-wp` directory, or install the plugin via the WordPress plugin installation screen in the admin panel.
* Activate the plugin through the list of all plugins on your site.


## Screenshots ##
1. List of all ad blocks (compact)
2. List of all ad blocks (advanced)
3. Adding a new ad block
4. Based on pixels
5. Based on selectors (iterable)
6. Popup / Sticky side
7. Video pre-roll
8. Hover-roll
9. Content targeting
10. User targeting
11. Header and footer inserting code
12. Blacklist ip
13. Main plugin settings
14. PageSpeed Insights settings
15. Stylization
16. Advanced settings
17. Prsonalization admin interface
18. Import
19. Export
20. Plugin shortcodes
21. License


## Changelog ##

### 3.1.17 ###
1. Bug fix.

### 3.1.16 ###
1. Global ab tests for folders. Those you can test entire swathes of advertising. Available for PRO users;
2. Shortcode {{increment}}. Prints a number starting from 1, each call to this shortcode increases the value by one.
{{increment_1}}, {{increment_2}}, etc. - it is possible to display several separate increments.
3. For all popups, added the ability to confirm actions by pressing the Enter button.

### 3.1.14 ###
1. Added the option to close popups by clicking on the overlay.
2. Added shortcode {{fpm-close-event}}, which displays a css class for closing popups and moving blocks.

### 3.1.10 ###
1. Fixed bug with GEO detection.
2. Added targeting by browser color scheme.
3. Added a special get parameter for sites with infinite loading, now you just need to add ?fpm-ajax for your links.
4. In User Targeting I made smart toggles. If you start filling in fields inside, the toggle will turn on automatically, and if the fields are blank, it will turn off. 
5. In Output options I added a checkbox to enable all record types and templates at once.
6. Now the referrer is additionally taken from utm_referrer if it is present in the link. This will be useful for owners of Antibot, which prevents referrer detection due to captcha padding.
7. Design edits in the admin area.

### 3.1.05 ###
**Fixes:**
1. Fixed processing of third-party shortcodes in header and footer;
2. Fixed counting of characters in article (it's not a perfect algorithm, some users will still have problems) - I will rewrite everything from scratch in the near future.
This item will not be noticed by 90% of users;
3. some improvements in the admin area (including the ability to disable the helper when editing a block);
4. Fixed a bug with OS detection;
5. Fixed a bug with the definition of the current time of the user;
6. Minor edits to the interface in the admin area;
7. Moved the list of ip for blocking from `/ip.txt` to `/wp-content/uploads/fpm/ip.html` - this will fix compatibility with gtranslate.io;
8. Renamed macros to: Picture, Link, Slider, Sticky in content, Sticky in sidebar, Skyscraper in sidebar (new), Interscroller (new);
9. Fixed the definition of metric, float, top, etc. from RFCs for quick insertion;
10. Closed a super minor vulnerability in the plugin;
11. Removed the "Prohibit block output for Google PageSpeed robot" setting as it was outdated;
12. Fixed a bug where the ">" symbol on the frontend was replaced with "&gt;" in the style editor

**Improvements:**
1. Improved output of shortcodes of advertising blocks, now everything works without additional settings speech about `[flat_pm id="block ID"]`;
2. Added support for ajax output of ad block shortcodes;
3. Befriended "Slider" with "Sticky in sidebar", personally for me this solution is better than reloading ads in the sidebar;
4. Added functionality for "Sticky in content": now it can be set left or right alignment and width, with these settings text and content will "streamline" advertising;
5. Added support for xpath selectors (exceptions) for pixel and character based output types;
6. Made multi-line input to search for a block by code, name or description;
7. Improved cookie and utm-get definitions: added new syntax to allow multiple values for each parameter;
8. Updated translations;
9. Over the last year, 3 users had their databases broken when moving to another server (well, what can you do, there are crooked proggers), including some blocks in FlatPM. Especially for this purpose, I made a definition of broken blocks in the database and visualization in the general list of blocks with the ability to delete these blocks.

**New in the plugin:**
1. Added a new format to the "Interscroller" macros. This format has an option "block scroll on timer";
2. Added targeting by browser language;
3. Added ipv6 support for blocking ip addresses. The range can be specified the same way as with ipv4: `2a0d:5600:24:61:a0::1 - 2a0d:5600:24:61:a0::4`.
If you specify the range:
`::2 - ffff:ffff:ffff:ffff:ffff:ffff:ffff:ffff:ffff`, all ipv6 addresses will be blocked.
4. Moved all GEO, user role and ISP checks from the backend to the frotnend. Now it does not affect the backend, which in turn will reduce (actually completely remove) the load on the server from the plugin;
5. Changed the definition of the user's ip, this now works through ip.php instead of admin-ajax.php. This will significantly reduce the load on the server.
6. Especially for the paranoid, added an option to the plugin to not scorch the ad weight via base64 encryption, each block can be encrypted separately from the rest. Plus it will really add a kind of noindex for anything you want to hide from the robots;
7. Added a special widget for the sidebar, so that you can easily display any block there without any additional work on prescribing selectors or shortcodes.

### 3.0.42 ###
Release new 3.0 version


## Upgrade Notice ##
Bugfix release.