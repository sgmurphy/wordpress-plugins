=== Simple Membership ===
Contributors: smp7, wp.insider
Donate link: https://simple-membership-plugin.com/
Tags: member, members, members only, membership, memberships, register, WordPress membership plugin, content, content protection, paypal, restrict, restrict access, Restrict content, admin, access control, subscription, teaser, protection, profile, login, login page, bbpress, stripe, braintree
Requires at least: 5.0
Requires PHP: 7.4
Tested up to: 6.6
Stable tag: 4.5.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple membership plugin adds membership functionality to your site. Protect members only content using content protection easily.

== Description ==

= A flexible, well-supported, and easy-to-use WordPress membership plugin for offering free and premium content from your WordPress site =

The simple membership plugin lets you protect your posts and pages so only your members can view the protected content.

= Unlimited Membership Access Levels =
Set up unlimited membership levels (example: free, silver, gold etc) and protect your posts and pages using the membership levels you create.

= User Friendly Interface for Content Protection = 
When you are editing a post or page in the WordPress editor, you can select to protect that post or page for your members.

Non-members viewing a protected page will be prompted to log in or become a member.

= Have Free and Paid Memberships =
You can configure it to have free and/or paid memberships on your site. Paid membership payment is handled securely via PayPal. Membership payment can also be accepted using Stripe or Braintree payment gateways.

Both one time and recurring/subscription payments are supported for PayPal and Stripe.

You can accept one time membership payment via Braintree payment gateway.

Option to make membership payment buttons using the new PayPal Checkout API. 

There is also option to use PayPal smart buttons for membership payment.

You can enable email activation or email confirmation for the free memberships.

= Membership Payments Log = 
All the payments from your members are recorded in the plugin. You can view them anytime by visiting the payments menu from the admin dashboard.

= Developer API =

There are lots of action and filter hooks that a developer can use to customize the plugin.

There is also an API that can be used to query, create, update member accounts.

= Member Login Widget on The Sidebar =
You can easily add a member login widget on the sidebar of your site. Simply use the login form shortcode in the sidebar widget.

You can also customize the member login widget by creating a custom template file in your theme (or child theme) folder.

Option to show a password visibility toggle option in the login form.

= Documentation =

Read the [setup documentation](https://simple-membership-plugin.com/simple-membership-documentation/) after you install the plugin to get started.

= Plugin Support =

If you have any issue with this plugin, please visit the plugin site and post it on the support forum or send us a contact:
https://simple-membership-plugin.com/

You can create a free forum user account and ask your questions.

= Miscellaneous =

* Works with any WordPress theme.
* Ability to protect photo galleries.
* Ability to protect attachment pages.
* Show teaser content to convert visitors into members.
* Comments on your protected posts will also be protected automatically.
* There is an option to enable debug logging so you can troubleshoot membership payment related issues easily (if any).
* Ability to customize the content protection message that gets shown to non-members.
* Ability to partially protect post or page content.
* You can apply protection to posts and pages in bulk.
* Ability to use merge vars in the membership email notification.
* Membership management side is handled by the plugin.
* Ability to manually approve your members.
* Ability to import WordPress users as members.
* Search for a member's profile in your WP admin dashboard.
* Filter members list by account status.
* Filter members list by membership level.
* Site admins can save private notes about members, providing a convenient way to keep track of important information.
* Can be translated to any language.
* Hide the admin toolbar from the frontend of your site.
* Allow your members to delete their membership accounts.
* Send quick notification email to your members.
* Email all members by membership level, with an option to filter by account status.
* Customize the password reset email for members.
* Use Google reCAPTCHA on your member registration form.
* Use Google reCAPTCHA on your member login and password reset form.
* The login and registration widgets will be responsive if you are using a responsive theme.
* Ability to restrict the commenting feature on your site to your members only.
* Front-end member registration page.
* Front-end member profiles.
* Front-end member login page.
* Option to configure after login redirection for members.
* Option to configure after registration redirect for members.
* Option to configure after logout redirection for members.
* Option force the members to use strong password.
* Option to make the users agree to your terms and conditions before they can register for a member account.
* Option to make the users agree to your privacy policy before they can register for a member account.
* Option to automatically logout the members when they close the browser.
* Ability to forward the payment notification to an external URL for further processing.
* Option to configure whitelisting for user email addresses to allow registration only from specific email addresses or email domains.
* Option to configure blacklisting for user email addresses to block registration from certain email addresses or email domains.
* Option to configure PayPal payment buttons for memberships (one-time and recurring payments).
* Option to configure Stripe payment buttons for memberships (one-time and recurring payments).
* Option to configure Braintree payment buttons for memberships (one-time payments).

= Language Translations =

The following language translations are already available:

* English
* German
* French
* Spanish
* Spanish (Venezuela)
* Chinese
* Portuguese (Brazil)
* Portuguese (Portugal)
* Swedish
* Macedonian
* Polish
* Turkish
* Russian
* Dutch (Netherlands)
* Dutch (Belgium)
* Romanian
* Danish
* Lithuanian
* Serbian
* Japanese
* Greek
* Latvian
* Indonesian
* Hebrew
* Catalan
* Hungarian
* Bosnian (Bosnia and Herzegovina)
* Slovak
* Italian
* Norwegian
* Mexican
* Arabic
* Czech
* Finnish

You can translate the plugin using the language [translation documentation](https://simple-membership-plugin.com/translate-simple-membership-plugin/).

== Installation ==

Do the following to install the membership plugin:

1. Upload the 'simple-wp-membership.zip' file from the Plugins->Add New page in the WordPress administration panel.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= Where can I find complete documentation for this plugin? =
You can find the full documentation for this plugin on the [Simple Membership plugin documentation](https://simple-membership-plugin.com/simple-membership-documentation/) page.

== Screenshots ==

Please visit the membership plugin page to view screenshots:
https://simple-membership-plugin.com/

== Changelog ==

= 4.5.0 =
- Added membership level specific default account status feature.
- New admin notes feature added. It can be used to save private notes about members.
- Added new 'login' API endpoint to the free SWPM API addon.
- PHP 8.2 compatibility related improvements.
- New two filter hooks added to the mini/compact login shortcode.
- The custom messages addon can now be used to customize the output of the mini/compact login shortcode's output.
- Added a new action hook "swpm_login_failed". This is equivalent to the "wp_login_failed" action hook.

= 4.4.9 =
- Minor update to the German language file.
- Added a new filter hook 'swpm_after_email_activation_redirect_url' to allow customizing the email activation redirect URL.
- Added a check in the member's add/edit interface to ensure a membership level exists before attempting to add or edit a member record.
- If the site admin deletes the membership level of a member who then tries to log in, an appropriate error message will be displayed instead of a fatal error.
- When the debug feature is enabled and the debug log file doesn't exist, it will create one automatically.
- Added reCAPTCHA V3 support. You can now enable [reCAPTCHA V3 for the member registration](https://simple-membership-plugin.com/simple-membership-google-recaptcha-v3-integration/).

= 4.4.8 =
- Rolled back one of the changes from the previous version that was causing an issue with the WP user profile update process.
- If your site is experiencing any issue after the update and you need the older version 4.4.6 (before the profile update related improvements/changes), you can download it using the following link:
- [Simple Membership Plugin v4.4.6](https://downloads.wordpress.org/plugin/simple-membership.4.4.6.zip)

= 4.4.7 =
- The PayPal PPCP subscriptions will also save the is_live parameter in the transaction record.
- Minor improvements to the newly added cancel subscription shortcode.
- Changed the status of the 1st transaction of a Stripe subscription to 'subscription created' for better clarity.
- Added more output escaping to the payment button shortcode output.
- Fixed a minor issue with the manual transaction add feature.
- Added architecture so the password update from profile edit page doesn't require a re-login.
- The PayPal's new API button options have been moved to the top in the button creation interface.
- Improved the 'profile_update' action hoook handling code - the user will remain logged-in after the password is changed from WP User profile page.
- Added a new filter hook swpm_wp_profile_update_hook_override.

= 4.4.6 =
- Various translation related changes to the button configuration admin interface.
- Generated a new translation POT file for the plugin.
- Fixed an error with the cancel Stripe subscription shortcode.
- Added output escaping to the PayPal cancel subscription shortcode.

= 4.4.5 =
- Added a link to the corresponding member profile in the newly added transaction view/edit interface.
- Added a link to the corresponding membership level in the newly added transaction view/edit interface.
- Minor PHP compatibility related improvements for PayPal and Stripe checkout.
- Minor updates to the the debug log messaging for the refund/cancelation process.

= 4.4.4 =
- Added an option to configure a Cancel URL for Stripe SCA Subscription type buttons.
- Some options related to hiding the WP Admin Bar have been moved from the General Settings menu to the Advanced Settings tab.
- A warning message is displayed when editing membership levels if both manual approval and email activation settings are enabled simultaneously.
- Output escaping added to the shortcode output of the subscription cancel shortcode.
- PayPal PPCP button's JS SDK related code has been converted to use vanilla JavaScript to eliminate the dependency on jQuery.
- Stripe promotion code feature added for Stripe SCA Buy Now type buttons.
- The Payments menu now shows the transactions from the SWPM_Transactions custom post type. This will allow us to add more features to the transaction records in the future.
- Added the option to edit a transaction record from the payments menu of the plugin.
- Added a new shortcode that can show any active subscriptions and offer an option to cancel it for the logged-in member. It works for the New PayPal API and Stripe Subscription buttons.
- [Documentation for the new subscription cancel shortcode](https://simple-membership-plugin.com/show-active-subscriptions-and-providing-a-cancellation-option/)

= 4.4.3 =
- The accepted payment method types can now be controlled from your Stripe account settings. This will allow you to enable/disable certain payment methods.
- Updated the documentation link for the Stripe Subscription button configuration.
- Enhanced the auto-login feature's redirect URL handling for better compatibility with some servers.
- New registration and profile form UI and validation is the default UI for all new installs. The old UI can be enabled from the advanced settings menu.
- Added Arabic translation files to the plugin. Thanks to @Adham.
- Added output escaping to the new registration and edit profile forms.

= 4.4.2 =
- Added an option to specify a cancel URL for Stripe buy now button.
- The PayPal order ID is also passed to the PayPal payment capture API call's header.
- Added a check for the PayPal Buy Now payment capture status in the IPN handling script.
- Updated the Spanish language translation file.
- Minor spelling mistake fixed.

= 4.4.1 =
- Added 'Cayman Islands' to the country dropdown list.
- The unique session ID generation process improved.
- The PayPal Token cache will be deleted automatically if the Live/Test mode option is changed in the settings menu.
- Fixed an issue with the PayPal test/live mode toggle issue with the new API.

= 4.4.0 =
- Added a new feature in the 'Bulk Operation' menu tab to allow bulk update members account status.
- Improved the email validation in the new registration form UI.
- Updated the Spanish language translation file.
- Changed the aciton hook name 'swpm_login' to 'swpm_after_login_authentication' to describe the hook better.
- The after login redirection feature won't be application when the login form originates from the WP Login form. 
- This will remove confusion for some users when they login from the standard WP login form (not the simple membership's login form) and then the page redirects to the after login redirection URL.

Full changelog available at [change-log-of-old-versions.txt](https://plugins.svn.wordpress.org/simple-membership/trunk/change-log-old-versions.txt)

== Upgrade Notice ==
If you are using the form builder addon, then that addon will need to be upgraded to v1.1 also.

== Arbitrary section ==
None
