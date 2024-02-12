=== ThumbPress - Stop Generating Unnecessary Thumbnails ===
Contributors: pluggable, codexpert, mukto90
Donate link: https://codexpert.io/?utm_source=free-plugins&utm_medium=readme&utm_campaign=image-sizes
Tags: image sizes, multiple image creation, image copy, media file duplicate, image duplicate wordpress, prevent duplicate image, stop creating image sizes, thumbnails, duplicate image
Requires at least: 5.0
Tested up to: 6.4.3
Stable tag: 4.2.3
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Stop WordPress from generating unnecessary thumbnails while uploading an image!

== Description ==

When you upload an image using _Media Uploader_, WordPress generates multiple copies/thumbnails of that image. By default, WordPress generates 5 thumbnails-

- Thumbnail
- Medium
- Medium-large
- Large
- Scaled

But along with this, theme and plugin developers can register their own thumbnails. Although they may be on purpose, but sometimes they remain unused.

Think about it, **unnecessary additional images are eating up your server space** and **slowing down your site**!

Sounds like a problem?

This is where our plugin comes into the picture. Just install the plugin and choose which of the imaze sizes you want to prevent from generating.

- Works with any plugin and theme.
- WooCommerce compatible.
- Multisite compatible.
- Super easy to install and configure.
- It's free and always will be.

### Need Help?
Please [reach out to us](https://help.codexpert.io/?utm_source=free-plugins&utm_medium=readme&utm_campaign=image-sizes) if you need any assistance or have any queries.

== Installation ==

1. Upload `image-sizes` to the `/wp-content/plugins/` directory
2. Activate the plugin through the **Plugins** menu in WordPress
3. Go to **Image Sizes** menu from the left and choose which of the sizes you want to prevent from generating.

== Frequently Asked Questions ==

= Does it work with multisite?  =

Yes, it's fully compatible with WordPress multisite installations

= Does it work with WooCommerce? =

Yes, it does.

= What about my old thumbnails? =

From version 3.0 and higher, you can now regenerate thumbnails of your existing images. Just go to the Regenerate Thumbnails tab and click on the Regenerate button.

= My question is not answered here. =

Please post on our support forum here https://wordpress.org/support/plugin/image-sizes/


== Screenshots ==

1. Image Sizes Settings
2. Regenerate thumbnails
3. Setup Wizard

== Changelog ==

= 2024-02-12 - 4.2.3 =
* [fix] `The plugin does not have a valid header` error fixed
* [fix] JS error fixed

= 2024-02-08 - 4.2.2 =
* [fix] Compatibility tested with WordPress 6.4.3

= 2024-01-31 - 4.2.1 =
* [fix] Invalid header issue fixed

= 2024-01-25 - 4.2 =
* [fix] Compatibility tested and fixed with PHP 8
* [rem] Footer credit removed

= 2023-12-05 - 4.1.1 =
* [imp] Compatibility tested and fixed with previous WP versions

= 2023-08-15 - 4.1 =
* [imp] CSS minified
* [imp] Made compatible with WordPress 6.3
* [imp] Made compatible with PHP 8.1
* [fix] Redirection URL from the setup wizard fixed
* [fix] `<Blogs />` component loads in the `/wp-admin/` screen

= 2023-07-03 - 4.0.5 =
* [imp] Package changed

= 2023-02-28 - 4.0.4 =
* [imp] Upgrader function added
* [fix] Removed legacy `codexpert-blog-json` from the database

= 2023-02-28 - 4.0.4 =
* [imp] Upgrader function added
* [fix] Removed legacy `codexpert-blog-json` from the database

= 2023-02-17 - 4.0.3 =
* [imp] Regenerator imnproved
* [mod] Footer credit hidden by default

= 2023-02-10 - 4.0.2 =
* [fix] Error fixed

= 2023-02-10 - 4.0.1 =
* [fix] Error fixed

= 2023-02-10 - 4.0 =
* [imp] Codebase completely rewritten
* [add] `scaled` size added to filter
* [imp] Unnecessary code and files removed
* [add] Debug tool added

= 2022-10-22 - 3.6.1 =
* [fix] 404 error fixed

= 2022-10-18 - 3.6 =
* [imp] Sanitization issue fixed

= 2022-05-23 - 3.5 =
* [imp] Code optimized and sanitized
* [imp] New dashboard

= 2022-04-24 - 3.4.5.5 =
* [add] Auto redirection to the Setup wizard disabled

= 2022-04-18 - 3.4.5.4 =
* [add] Setup wizard improved

= 2022-04-18 - 3.4.5.3 =
* [add] Skip button added in the setup wizard

= 2022-04-13 - 3.4.5.2 =
* [add] Setup wizard added for easier installation

= 2022-04-09 - 3.4.5.1 =
* [fix] SQL error fixed

= 2022-04-09 - 3.4.5 =
* [fix] Sanitized and escaped

= 2022-03-23 - 3.4.4 =
* [fix] Code better sanitized and secured

= 2022-03-21 - 3.4.3 =
* [fix] Repetitive API call for docs removed

= 2022-02-28 - 3.4.2.3 =
* [fix] Repetitive API call stopped

= 2022-02-26 - 3.4.2.2 =
* [fix] Repetitive API call fixed

= 2022-02-26 - 3.4.2.1 =
* [fix] Missing asset loading fixed

= 2022-02-26 - 3.4.2 =
* [fix] Error fixed.
* [imp] Performance improved. CSS and JS minified.

= 2022-01-09 - 3.4.1 =
* [add] Uninstaller added
* [add] `plugins_api_result` filter added

= 3.4.0.2 =
* [fix] Banner close link fixed

= 3.4.0.1 =
* [fix] Notice cannot be removed

= 3.4.0 =
* [fix] Updated composer package compatibility fixed

= 3.3.1.1 =
* [fix] Blog posts sync fixed

= 3.3.1 =
* [imp] Image improved
* [add] Pgoress bar restored

= 3.3.0 =
* [add] Chunk added for regenerating thumbnails

= 3.2.1 =
* [add] Progress bar added

= 3.2.0 =
* [imp] Interval added for regerate thumbs
* [imp] Notice improved

= 3.1.3 =
* [fix] Errors and bugs fixed

= 3.1.2 =
* [imp] Performance improved

= 3.1.1 =
* [imp] Default image checkox set to No
* [fix] error fixed
* [chg] Checkbox position changed

= 3.1.0 =
* [imp] Code improved
* [imp] Settings page improved
* [fix] Admin bad menu remove
* [chg] Menu moved to under the Media menu

= 3.0.4 =
* [fix] License server moved

= 3.0.3 =
* [fix] Error fixed

= 3.0.2 =
* [imp] Nag dismiss

= 3.0.1 =
* [imp] Code improved

= 3.0 =
* [imp] Code Rewritten
* [add] Regenerate Thumbnail
* [add] Help and FAQs
* [imp] Improved UI and UX

= 2.0.2 =
* [fix] Small fix

= 2.0.1 =
* [fix] Help email
* [imp] Better screenshot

= 2.0.0 =
* [fix] JS fix
* [add] Contact form added
* [imp] Transliteration

= 1.2.1 =
* [fix] Warning fix

= 1.2 =
* [imp] Transliteration
* [fix] jQuery error

= 1.1 =
* [add] Transliteration
* [add] Checkbox to select all

= 1.0 =
* Initial release
== Upgrade Notice ==