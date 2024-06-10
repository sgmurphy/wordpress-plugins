=== PPWP - Password Protect Pages ===
Contributors: gaupoit, rexhoang, ppwp, buildwps, yuryonfolio
Tags: password protect, password, restrict content, sitewide, password protection
Requires at least: 4.7
Requires PHP: 5.6
Tested up to: 6.5.2
Stable tag: 1.9.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Password protect WordPress pages and posts by user roles or with multiple passwords; protect your entire website with a single password.

== Description ==

Password Protect WordPress (PPWP) plugin offers a powerful and **all-in-one solution** to secure your website with passwords.

Whether you want to password protect WordPress categories, WooCommerce products, a few posts, or your entire website, PPWP plugin will help you do so with ease.

This plugin does not protect images or uploaded files so if you attach the media files to the protected pages or posts, they are still accessible to anyone with the link. Use [Prevent Direct Access (PDA) Gold](https://preventdirectaccess.com/features/?utm_source=wp.org&utm_medium=pda-gold-link&utm_campaign=ppwp-free) to block their direct file URL access.

Please note that the passwords will be stored in the post meta and this plugin will set a cookie to allow access to the protected pages or posts.

= An Inside Look at Password Protect WordPress - PPWP Pro =
https://www.youtube.com/watch?v=myYsKXZyNwc

= Password Protected Features =
The Lite version of Password Protect WordPress (PPWP) plugin offers the following features:

== Protect WordPress Pages & Posts with Unlimited Passwords ==
The plugin extends WordPress built-in password protection feature and allows you to set multiple passwords per Page and Post. What's more, you can protect the content with just a single click. Once protected, a random password will be automatically generated for you.

= Password Protect WordPress Pages & Posts by User Roles =
There is an option allowing you to password protect your WordPress Pages & Posts by user roles. In other words, you can set different passwords for different user roles, e.g. one for subscribers and one for editors.

= Prevent Password Abuse with reCAPTCHA =
Stop password abuse and spam by bots and automated software with Google reCAPTCHA v2 or v3. Real users will be able to access protected content with ease as usual.

= Unlock Password Protected Content without Page Refresh =
[Use Ajax to display protected content](https://passwordprotectwp.com/docs/unlock-password-protected-content-without-page-refresh/??utm_source=wp.org&utm_medium=ajax-link&utm_campaign=ppwp-free) without having to reload the entire page. It will help improve user experience and avoid server caching after users enter their password.

== Password Protect WordPress Categories ==
Instead of creating an individual password for each post, you can protect all posts under one or multiple categories at once. Once users unlock a post successfully, they will be able to access the rest of the content automatically.

== Password Protect Entire WordPress Site ==
You can [password protect the whole WordPress site](https://passwordprotectwp.com/features/password-protect-entire-wordpress-site/?utm_source=wp.org&utm_medium=sitewide-link&utm_campaign=ppwp-free) with a single password. All your website content including pages, posts, and other custom post types (but not media files) are locked as well.

== Partial Content Protection ==
Partial Content Protection feature allows you to [password protect certain sections](https://passwordprotectwp.com/features/password-protect-partial-content/?utm_source=wp.org&utm_medium=free-pcp-link&utm_campaign=ppwp-free) of a page or post instead of hiding the entire content under a password form. This is useful when you want to create a teaser of premium content that encourages visitors to register/sign up to unlock the entire post.

= Section Protection =
Section Protection takes PCP to the next level. The feature enables you to add [password-protected sections](https://passwordprotectwp.com/docs/section-protection/?utm_source=wp.org&utm_medium=section-protection-link&utm_campaign=ppwp-free) even on custom post types &  templates created by top page builders such as Elementor and Divi.

= Show/Hide Premium Content at a Specific Time =

You can also choose when to publish the secure content to users. For example, they’re allowed to see the content without having to enter passwords from XXX to XXX using the following shortcode attributes.

`
[ppwp passwords=123 on="2020/10/20 14:00:00" off="2020/10/30 14:00:00"] Your protected section will be shown automatically from 2 pm October 20, 2020 to 2 pm October 30, 2020[/ppwp]
`

== Integrate with Page Builders ==
Instead of using our shortcode to protect part of content, you can use our built-in module for the top page builders including:

* Elementor
* Beaver Builder
* WPBakery Page Builder*
* Divi Builder*

*Supported; built-in UI block to be released soon.

These built-in modules allow you to set passwords, whitelisted roles, customize password forms, and so on via our friendly User Interface. You no longer have to deal with the complex shortcode attributes.

What's more, with PPWP Pro, you can even [protect the entire Elementor's templates](https://passwordprotectwp.com/docs/password-protect-partial-content-elementor/?utm_source=wp.org&utm_medium=pro-elementor-guide-link&utm_campaign=ppwp-free), Beaver Builder's rows, columns, and page templates as well as limiting and tracking password usage.

== Master Passwords ==
When there are many password protected posts on your website, it becomes difficult and time-consuming to create or manage passwords for each content. That’s when master passwords come in handy.

Users will be able to [unlock all protected posts at once](https://passwordprotectwp.com/docs/master-passwords-unlock-all-protected-content/?utm_source=wp.org&utm_medium=master-pwd-link&utm_campaign=ppwp-free) with just one master password.

Please note that this feature **does not** password protect all posts automatically. It simply allows you to use master passwords to unlock those that you’ve already password protected. Original passwords attached to each post will still be working, together with these master passwords.

The master passwords feature also comes with an easy-to-use interface allowing you to create unlimited master passwords simultaneously and manage all of them in one place. You will have full control to (de)activate, delete passwords as well as restrict usage passwords by usage, time, and user role.

== Customize Password Form & Messages with WordPress Customizer ==
Customize all your password forms, i.e. the sitewide login form, single and partial content protection (PCP) password form, via WordPress Customizer.

You’re allowed to remove or change our default logo to your own in the sitewide login form. You can also change the color, background and design of the form to match your theme’s color scheme.

[Besides the default login page](https://passwordprotectwp.com/docs/customize-sitewide-login-page/?utm_source=wp.org&utm_medium=customize-sitewide-link&utm_campaign=ppwp-free), you can now select one from our pre-designed themes that suits your site best.

As for [single password form](https://passwordprotectwp.com/docs/customize-password-form-wordpress-customizer/?utm_source=wp.org&utm_medium=customize-pcp-link&utm_campaign=ppwp-free), you're able to change the WordPress default error message as well as password form instructions, namely headline, descriptions, password input placeholder, and button text.

The button and text's font-size, color, and background can also be customized through a friendly WYSIWYG HTML Editor.


== Hide Password Protected Content ==
By default, your password protected content will still show up on various pages such as home and category page once published.

This feature allows you to control the visibility of your protected post types in different views:

* Hide posts from Recent Posts widgets
* Hide posts from Next & Previous link on the single post
* Hide posts on search results
* Hide posts from Yoast SEO Google XML Sitemaps, and RSS
* Hide posts on Frontpage, Author, and Archive pages including tag and category page
* Protected pages hidden from search results, home page & everywhere they're listed

Even though the posts are hidden, those who know the URL will still have access to the pages (but not the protected content).

= Show Password Protected Content in RSS Feeds =
Even though you choose to show password protected content in RSS, a password form will display instead of its actual content by default. With PPWP plugin, you're able to show all protected content in RSS feeds. There is also an option to make your RSS feeds public even if your site is hidden.

= Show Password Protected Post Excerpts =
Many WordPress themes hide the post excerpt and featured image of password protected content by default. Enable this option to show excerpts of your password protect posts.

= Password's Cookies Expiration =
By default, users won't have to re-enter passwords to access a protected page or post until its cookies expire. You can change the default cookie expiration time on the plugin settings page to whatever suits your use case. Or else, choose session cookies which will be removed automatically whenever users close their browser. As a result, users have to re-enter password when opening the browser again.


> #### Pro Version
> Our [PPWP Pro version](https://passwordprotectwp.com/features/?utm_source=wp.org&utm_medium=ppwp-pro-link&utm_campaign=ppwp-free) offers many more advanced features:
>
>* Password protect all WordPress custom post types including WooCommerce Products
>* Password protect custom fields and custom page templates
>* Manage all passwords while editing content or via our friendly popup
>* Create unlimited passwords per user role
>* Create the same passwords for multiple user roles
>* Bypass password protection with Quick Access Links
>* Customize Quick Access Links
>* Create wildcard passwords
>* Unlock Partial Content Protection (PCP) with master passwords
>* Automatically protect all sub pages with one password
>* Create multiple passwords for each protected category
>* Set the same password for multiple pages
>* Create unlimited global passwords for partial content protection shortcode
>* Redirect to specific URLs after entering site-wide protection passwords
>* Unlock all content at once and unlock partial sitewide protection with [Group Password Protection extension](https://passwordprotectwp.com/extensions/group-protection/?utm_source=wp.org&utm_medium=group-ext-link&utm_campaign=ppwp-free)
>* Give users access to password-protected content upon form submissions with [Forms Integration extension](https://passwordprotectwp.com/extensions/forms-integration/?utm_source=wp.org&utm_medium=forms-integrate-ext-link&utm_campaign=ppwp-free)
>* Use reCAPTCHA or Contact Form 7 in place of the password form with [Passwordless Authentication extension](https://passwordprotectwp.com/extensions/passwordless-authentication/?utm_source=wp.org&utm_medium=pa-ext-link&utm_campaign=ppwp-free)
>* Track password usage, i.e. the time they're logged in, IP address and browser used, with [Statistics extension](https://passwordprotectwp.com/extensions/password-statistics/?utm_source=wp.org&utm_medium=stats-ext-link&utm_campaign=ppwp-free)
>* [Password protect WordPress categories](https://passwordprotectwp.com/extensions/access-levels/?utm_source=wp.org&utm_medium=al-ext-link&utm_campaign=ppwp-free) with different access levels
>* Integrate with [Prevent Direct Access Gold](https://preventdirectaccess.com/features/?utm_source=wp.org&utm_medium=pda-gold-link&utm_campaign=ppwp-free) to password protect files embedded in content
>* Sell password-protected content via WooCommerce with [WooCommerce Integration extension](https://passwordprotectwp.com/extensions/woocommerce-integration/?utm_source=wp.org&utm_medium=woo-integrate-ext-link&utm_campaign=ppwp-free).
>* Protect the entire shop page, including individual products and category pages with the same passwords.
>* Import and export passwords as well as requiring users to provide both password and username or email to unlock protected content with [Password Suite extension](https://passwordprotectwp.com/extensions/password-suite/?utm_source=wp.org&utm_medium=suite-ext-link&utm_campaign=ppwp-free).
>* Restrict password usage based on WordPress users or IP addresses as well as setting password expiration time after first use with [Smart Restriction extension](https://passwordprotectwp.com/extensions/smart-restriction/?utm_source=wp.org&utm_medium=sr-ext-link&utm_campaign=ppwp-free).
>* Password protect files outside Media Library
>
> Check out [Password Protect WordPress (PPWP) Pro](https://passwordprotectwp.com/pricing/?utm_source=wp.org&utm_medium=plugin-desc-link&utm_campaign=ppwp-free) now!

Get access to all extensions and priority support with any of our [PPWP Pro membership](https://passwordprotectwp.com/membership?utm_source=wp.org&utm_medium=pro-memberships-link&utm_campaign=ppwp-free) plans.

= Multilingual supported =
Our plugin works out of the box with the top leading multilingual WordPress plugins such as WPML, Polylang, and Loco Translate. In other words, you can [translate the password forms](https://passwordprotectwp.com/docs/how-to-translate-password-protect-wordpress-plugin/?utm_source=wp.org&utm_medium=guide-translate-link&utm_campaign=ppwp-free), including its headline, description, error message as well as placeholder and button text into the different languages.

= Documentation and support =

* For documentation and tutorials go to our [Documentation](https://passwordprotectwp.com/docs/?utm_source=wp.org&utm_medium=ppwp-pro-link&utm_campaign=ppwp-free)
* Check out [compatible hostings, themes, and plugins](https://passwordprotectwp.com/docs/compatible-wordpress-plugins/?utm_source=wp.org&utm_medium=utm_medium=pro-compatiable-link&utm_campaign=ppwp-free) with PPWP
* Visit our [PPWP Pro landing pages](http://ppwp.pro/?utm_source=wp.org&utm_medium=pro-landing-link&utm_campaign=ppwp-free) for more examples
* If you have any more questions or want to request new features, contact us through [this form](https://passwordprotectwp.com/contact/?utm_source=wp.org&utm_medium=faq-link&utm_campaign=ppwp-free) or drop us an email at [hello@preventdirectaccess.com](mailto:hello@preventdirectaccess.com)

Note that we have to **migrate your default WordPress passwords** to our systems for our protection to work properly.

You may want to restore all your previously created passwords before deactivating the plugin to avoid all protected pages and posts becoming public.

Please check out these guides on [how to password protect WordPress page](https://passwordprotectwp.com/docs/getting-started/?utm_source=wp.org&utm_medium=guide-link&utm_campaign=ppwp-free) the right way.

= Privacy Policy =
PPWP is designed to fully respect and protect personal information of its users. It does not collect any user information without your consent.

We're using GetResponse to communicate with our users in case they would like to opt in and receive future updates from us.
User's emails will be first sent to an external API on our secure server before getting managed by GetResponse.

Please see our complete [Privacy Policy](https://passwordprotectwp.com/privacy-policy/?utm_source=wp.org&utm_medium=privacy-policy-link&utm_campaign=ppwp-free) and [GetResponse's](https://www.getresponse.com/legal/privacy).

== Installation ==

There are 2 easy ways to install our plugin:

= 1.The standard way =
* Go to menu Plugins > Add New from your WordPress admin dashboard
* Search for "WordPress Password Protect Page - PPWP Plugin"
* Click to install
* Activate Password Protect WordPress Lite from your Plugins page
* Go to the editor page and set a secure password to protect your content
* Read the documentation to [get started](https://passwordprotectwp.com/docs/password-protect-wordpress-lite/)

= 2.The nerdy way =
* Download the plugin (.zip file) on the right column of this page
* In your WordPress Admin, go to menu Plugins > Add New
* Select the tab "Upload"
* Upload the .zip file you just downloaded
* Activate Password Protect WordPress Lite from your Plugins page
* Go to the editor page and set a secure password to protect your content
* Read the documentation to [get started](https://passwordprotectwp.com/docs/password-protect-wordpress-lite/)


== Frequently Asked Questions ==

= Why do I get an error message after entering the correct password? =

Below are 4 common reasons why the issue happens:

* You're protecting content on an ACF or WordPress custom field
* You're using a custom page template
* You're using a conflicting theme and unsupported page builder plugin
* You're using an unsupported caching method and/or plugin

Please follow this guide on how to quickly [troubleshoot these common issues](https://passwordprotectwp.com/docs/basic-troubleshooting/?utm_source=wp.org&utm_medium=troubleshoot-faq-link&utm_campaign=ppwp-free). Learn more about [why password protected page is not working](https://passwordprotectwp.com/docs/wordpress-password-protected-page-not-working/?utm_source=wp.org&utm_medium=troubleshoot-faq-link&utm_campaign=ppwp-free).

= Does the plugin password protect WooCommerce products? =

Yes, the Pro version helps [password protect any WordPress custom post types](https://passwordprotectwp.com/docs/password-protect-wordpress-custom-post-types/?utm_source=wp.org&utm_medium=woo-faq-link&utm_campaign=ppwp-free), including WooCommerce product pages.

= Will my password protected content show up in Google search results? =

The Free version doesn't [block search engines from finding and indexing your content](https://passwordprotectwp.com/docs/block-google-search-indexing/?utm_source=wp.org&utm_medium=google-index-faq-link&utm_campaign=ppwp-free). However, your content won’t appear on Google and other search engine results once password protected by the Pro version.

= Can I password protect parts of WordPress page content? =

Yes, you can [secure parts of your post and page content](https://passwordprotectwp.com/docs/password-protect-wordpress-content-sections/?utm_source=wp.org&utm_medium=pcp-protection-faq-link&utm_campaign=ppwp-free) with a password using our [ppwp] shortcode.

= Could I create and manage all shortcode passwords at one place? =

Yes, you will be able to generate passwords under our plugin's settings page and then add them to [ppwp] shortcode in order to protect your content sections with Pro version. All these passwords will be [tracked and controlled in one place](https://passwordprotectwp.com/docs/manage-shortcode-global-passwords/?utm_source=wp.org&utm_medium=manage-pwd-faq-link&utm_campaign=ppwp-free).

= Could users see which passwords they're typing?

Yes, you can add a "show password" button allowing users to see what they're typing. This button can be added either via [WordPress Customizer](https://passwordprotectwp.com/docs/customize-password-form-wordpress-customizer/#pwd-reveal-btn?utm_source=wp.org&utm_medium=customizer-faq-link&utm_campaign=ppwp-free) or [manual template modification](https://passwordprotectwp.com/docs/customize-password-protected-form/#show-hide-pwd/?utm_source=wp.org&utm_medium=customizer-faq-link&utm_campaign=ppwp-free).

= Could I password protect a parent and all its child pages at once? =

Yes, the Pro version enables you to [automatically password protect child pages](https://passwordprotectwp.com/docs/password-protect-sub-pages-and-categories/?utm_source=wp.org&utm_medium=parent-child-pages-faq-link&utm_campaign=ppwp-free) once the parent page is locked up.

== Screenshots ==

1. Protect your private pages and posts with multiple passwords.

2. Click on "Protect" button link for a new random password to be generated automatically.

3. Protect your private pages and posts by user roles. You can create one password per role with our Free version but unlimited passwords with our Pro version.

4. Users don't need to re-enter password when accessing your private content until its cookies expire. Simply change the default value under our plugin's Settings page.

5. It's easy to password protect your whole site with our plugin. Users are required to enter a password when accessing any pages or posts including the homepage.

6. Select which categories you want to protect and set a password. All posts under these categories will be unlocked at the same time.

7. Wrap your private content section with our [ppwp] shortcode.

8. This is what your post will look like after it is published. Visitors have to enter "password1" or "password2" to access the protected content.

9. Type "Password Protection (PPWP)" in the search field to find our built-in element in Elementor.

10. Type "Password Protect WordPress (PPWP)" in the search field to find our built-in module in Beaver Builder.

11. These built-in modules allow you to set passwords and whitelisted roles.

12. Customize password forms via our friendly User Interface.

13. Create master passwords to unlock all protected content at once.

14. You have full control over password tracking and restriction, i.e. by time, usage or user roles.

15. Customize password form text and design with WordPress Customizer.

16. This is our default PPWP sitewide login form.

17. This is our default PPWP single password form.

18. Control the visibility of your password protected content.

19. Enable this option to show excerpts of password protected content.

20. Restore default WordPress passwords before deactivating our plugin.

== Upgrade Notice ==

N/A

== Changelog ==

= 1.9.1.1 =

* [BugFix] Improvements have been implemented in API security measures to guarantee comprehensive sitewide protection.
* [BugFix] Enhancements have also been implemented, transitioning from the $wp_hasher variable to the wp_check_password function.

= 1.9.1 =

* [Improvement] Enhancements have been made to API protection to ensure sitewide security

= 1.9.0 =

* [Feature] Delete All Expired Passwords feature added
* [BugFix] API Protection with Sitewide Protection

= 1.8.9 =

* [Improvement] Comprehensive code comment documentation has been added
* [Improvement] Added text domains for strings in places where they were previously missing
* [Improvement] Removed unnecessary commented-out code, ensuring a cleaner and more efficient codebase
* [Improvement] The settings page sidebar has been revised to provide users with updated information and a helpful guide

= 1.8.8 =

* [Refactoring] Validate data to prevent potential security issues

= 1.8.7 =

* [Refactoring] Update SQL calls to avoid SQL injection vulnerabilities

= 1.8.6.2 =

* [BugFix] Remove broken scripts in integrated page builders

= 1.8.6.1 =

* [BugFix] Remove broken scripts in single password forms

= 1.8.6 =

* [Refactoring] Validate and escape shortcode attributes
* [Refactoring] Secure input and output data

= 1.8.5 =

* [Improvement] Provide a code snippet to show PCP passwords by default
* [Integration] Support reCAPTCHA for PCP forms
* [Improvement] Provide a hook to handle Central Login Forms without page refresh
* [Improvement] Support protecting multilingual categories

= 1.8.4 =

* [Improvement] Allow customizing error messages when entering wrong passwords for Section Protection

= 1.8.3 =

* [Improvement] Not allow spaces at the beginning and ending of category passwords
* [Improvement] Provide hooks to add settings options to Advanced tab in Pro version.

= 1.8.2 =

* [Feature] Display countdown timer in sitewide password form
* [Improvement] Provide an option to hide sitewide password form
* [Improvement] Secure input data

= 1.8.1 =

* [Improvement] Update PPWP settings UI
* [UI Improvement] Display correct sidebar on PPWP settings page when deactivating Pro version

= 1.8.0 =

* [Improvement] Allow customizing description below PCP password form
* [Improvement] Provide a shortcode attribute to add description above PCP password form submit button
* [Improvement] Provide a hook to add a custom checkbox to single password form
* [Improvement] Remove “Use Custom Form Action” option under Settings > Advanced
* [Improvement] Update WordPress Customizer UI
* [BugFix] Add <code><html></code> tags to display sitewide password form

= 1.7.10 =

* [Improvement] Update GetResponse API to 3.0
* [Improvement] Change the PCP password form headline from <code><h3></code> to the <code><div></code> tag
* [Improvement] Update PPWP settings UI

= 1.7.9.1 =

* [BugFix] Function “Use Shortcode within Page Builder” is not compatible with Divi

= 1.7.9 =

* [Feature] Protect content sections
* [BugFix] Couldn’t save changes when customizing password forms via WordPress Customizer
* [Improvement] Remove option “Use Custom Form Action” in the Advanced tab

= 1.7.8 =

* [Feature] Support unlocking Partial Content Protection without a page refresh
* [Improvement] Refactor password form structure to allow changing additional field positions on single password form
* [Improvement] Improve settings UI & add “what’s news” section
* [BugFix] Show wrong error message when creating master passwords
* [BugFix] Couldn’t save changes on text editor under WordPress Customizer

= 1.7.7 =

* [Feature] Unlock PCP content with master passwords; PPWP Pro required.
* [Improvement] Allow removing master password’s expiry date.

= 1.7.6 =

* [Feature] Customize PCP form with WordPress Customizer.
* [Improvement] Add "Show password" checkbox to PCP form.
* [Improvement] Add hooks to improve session cookies feature in the Pro version.
* [BugFix] Always display “on” value for additional field checkboxes on PPWP Statistics

= 1.7.5 =

* [Feature] Modify user permission to access plugin’s settings page
* [Improvement] Allow adding multiple master passwords at once
* [BugFix] Fatal error on PHP 8.0

= 1.7.4 =

* [Feature] Support reCAPTCHA for sitewide protection
* [Feature] Support session cookie for sitewide protection
* [Improvement] Share hook to customize sitewide login form
* [Improvement] Support AJAX to work with reCAPTCHA

= 1.7.3 =

* [Improvement] Allow setting the cookie expiration time in seconds
* [Improvement] Allow editing Label & Error Message in Elementor Widget
* [BugFix] Can't edit password form via WP Customizer in Firefox, Opera, Edge, Safari,...

= 1.7.2 =

* [Feature] Allow customizing description below the password form
* [Feature] Integrate with reCAPTCHA v2

= 1.7.1 =

* [Feature] Bulk action to delete master passwords
* [Improvement] Remove caching notification under plugin's settings page

= 1.7.0 =

* [Feature] Apply reCAPTCHA to single password form
* [Feature] Provide some pre-designed sitewide login page templates
* [Improvement] Integrate "No reload page" feature with top page builders
* [BugFix] Conflict with StoreVilla theme
* [BugFix] Master cookie is saved with wrong format
* [BugFix] Cookie is saved successfully but content is still locked
* [BugFix] Plugin settings inaccessible for Editor role


= 1.6.0 =

* [Feature] Show/hide partial content at a specific time
* [Feature] Unlock password protected content without reloading page
* [Feature] Support session cookies
* [BugFix] Password category doesn't work properly with content belonging multiple categories
* [BugFix] Redirect to homepage after users enter password if there is no referrer URL
* [BugFix] Shortcode attributes of Pro version don't work if "Use Shortcode within Page Builder" is enabled


= 1.5.2 =

* [Improvement] Auto backup default WordPress passwords
* [Improvement] Add ppwp shortcode attributes to edit password label and error message
* [Improvement] Migrate passwords of all post status
* [BugFix] Description of pcp form displays wrong when enable "Use Shortcode within Page Builder" option
* [BugFix] Post excerpts don't display when enable "Use Custom Form Action" option
* [BugFix] Conflict with Impreza theme when displaying pcp form
* [BugFix] Post is not protected with the password role is 0
* [BugFix] Fix PHP Notice: register_rest_route notice happened with WP 5.5


= 1.5.1 =

* [HotFix] Remove category ID in cookie

= 1.5.0 =

* [Feature] Protect content with one click
* [Feature] Protect categories with a single password
* [Improvement] Share hook to customize sitewide login form header and footer
* [BugFix] ppwp shortcode breaks page structures created by page builders
* [BugFix] ppwp shortcode inserted into Group block doesn't work properly
* [BugFix] ppwp shortcode doesn't work on IE 11
* [BugFix] Get WP_Customize_Section fatal error when activating the plugin

= 1.4.5.1 =

* [Feature] Share hook to handle tabs in sitewide sub-menu
* [Improvement] Improve individual password form customizer
* [BugFix] Use space instead of in single password form
* [Improvement] Share hook to support custom form before rendering the password form.

= 1.4.5 =

* [Feature] Add option which forces to show content
* [Feature] Allow users customize sitewide protection
* [Feature] Display error message for sitewide protection
* [Feature] Improve password form and customizer function
* [Improvement] Move sitewide tab in sub-menu
* [Improvement] Page visibility function always run in frontend
* [BugFix] Allow displaying content in RSS while in protection

= 1.4.4 =

* [BugFix] Only load asserts (js) when rendering the shortcode.
* [Improvement] Fire hooks in shortcode content, password handling and redirection.

= 1.4.3.2 =

* [HotFix] Security issue when do not encode the callback query param's value

= 1.4.3.1 =

* [HotFix] Using ob_flush after ob_end_clean that throws warning message in password form

= 1.4.3 =

* [BugFix] Cannot redirect if Referrer policy is no-referrer
* [BugFix] Whitelist role not working as example on settings
* [BugFix] Conflict with PPP because of using template_redirect
* [Improvement] Improve Customize individual page with WP Customizer
* [Feature] Add troubleshooting checklist
* [Feature] Customize password form description for each page

= 1.4.2 =

* Fix shortcode wrong error message for unregistered custom post types
* Add "Show Post Excerpt" option
* Fix caching issue with SG Optimizer plugin

= 1.4.1 =

* Allow translating password forms with WPML & other top multilingual plugins

= 1.4.0 =

* Add option to hide password protected content
* Improve integrating with caching plugins feature

= 1.3.0 =

* Enable Free users to customize Password Form
* Create global passwords for pages and posts
* Add hook whether to show/hide the password form
* Entire site feature changes site title
* Shortcode - Integrate with Beaver Builder
* Shortcode - Integrate with Page Builders

= 1.2.3.4 =

* Fix fatal error when WP version is under 4.7

= 1.2.3.3 =

* Fix warning with add_submenu_page function on WP version 5.3
* Fix style to compatible with WP 5.3
* Add hook after shortcode settings UI
* Add the filters that can adapt the new attributes

= 1.2.3.2 =

* Using the post_class instead of body_class that helps part of content feature works well

= 1.2.3.1 =

* Change Whitelist Roles -> Whitelisted Roles
* Write unit test for part of content and password core service classes
* Apply unit test in building and development process
* Handle password form WooCommerce product when removing "woocommerce_before_single_product"
* Run automation test of Pro version in building and deployment process
* Show error and UI displays wrong
* Unprotected post becomes protected when activating PPWP Pro
* Fix not update post in gutenberg when use ppw

= 1.2.3 =

* HotFix for debug mode flag

= 1.2.2 =

* HotFix for debug mode flag

= 1.2.1 =

* Optimize & Remove Unnecessary CSS & JS files
* Fix issue with the_password_form
* Show error message under password field
* Add new feature part of the content password protection

= 1.2.0 =
* Revamp the architecture design

= 1.1.2.2 =
* Fatal error when activating Pro & Lite version
* Show notification when enter wrong password

= 1.1.2.1 =
* Password Protect Entire Site is enabled but the password field is empty
* Password Protect Entire Site doesn't work if Cookies Expiration Time is more than 9999 days
* WP logo is missing on sub pages
* Can't submit after error notification display in Chrome
* Auto login a protected page without entering a password
* The page reloads after entering the correct password
* Integrate with WP Fastest Cache
* Integrate with W3 Total Cache
* Integrate with WP Super Cache
* Show notice not work with sites use caching
* Update the text when visitors can't see the password field
* Support users which have multiple roles

= 1.1.2 =
* Separate the password protected by roles from the page's content update.
* Set password for Admin, when log-in by Editor then not enter the password.
* Resolve the data conflict between gold and free version

= 1.1.1 =
* Add new features that users can set the post's visibility with multiple passwords.
* Change cookies lifetime to 1 day.
* Enhance the css for the metabox.

= 1.0.0 =
* Add UI in the pages/posts that allow users to set a password for each user role.
