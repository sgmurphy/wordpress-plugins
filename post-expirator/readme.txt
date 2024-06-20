=== Schedule Post Changes: Unpublish, Delete, Change Status, Trash, Change Categories and Tags with PublishPress Future ===
Contributors: publishpress, kevinB, stevejburge, andergmartins
Author: publishpress
Author URI: https://publishpress.com
Tags: expire posts, update posts, schedule changes, automatic changes
Requires at least: 6.1
Requires PHP: 7.2.5
Tested up to: 6.5
License: GPLv2 or later
Stable tag: 3.4.0

PublishPress Future can make scheduled changes to your content. You can unpublish posts, move posts to a new status, update the categories, and more.

== Description ==

The PublishPress Future plugin allows you to schedule changes to posts, pages and other content types. On a date you choose, PublishPress Future can delete your post, change the status, or update the post categories, or make other changes.

Here's an overview of what you can do with PublishPress Future:

* Choose unpublish dates for your posts.
* Modify, remove or completely delete content when the expiry date arrives.
* Add or remove categories.
* Modify expiry dates using "Quick Edit" and "Bulk Edit".
* Receive email notifications when your content expires.
* Show expiry dates in your content, automatically or with shortcodes.
* Control post changes via integrations with Advanced Custom Fields and other plugins (available in the Pro version).
* Import changes via plugin such as WP All Import (available in the Pro version).

## PublishPress Future Pro ##

> <strong>Upgrade to PublishPress Future Pro</strong><br />
> This plugin is the free version of the PublishPress Future plugin. The Pro version comes with all the features you need to schedule changes to your WordPress content. <a href="https://publishpress.com/future"  title="PublishPress Future Pro">Click here to purchase the best plugin for scheduling WordPress content updates!</a>

## Options for Future Actions on Posts

With PublishPress Future, you can configure actions that will happen automatically to your content. Here are the changes you can choose for your posts:

* Change the status to "Draft".
* Delete the post.
* Send the post to the Trash.
* Change the status to "Private".
* Enable the “Stick to the top of the blog” option.
* Disable the “Stick to the top of the blog” option.
* Remove all existing categories, and add new categories.
* Keep all existing categories, and add new categories.
* Keep all existing categories, except for those specified in this change.
* Move the post to a custom status (available in the Pro version)

[Click here for details on scheduling post changes](https://publishpress.com/knowledge-base/ways-to-expire-posts/).

## Display the Action Date in Your Content

PublishPress Future allows you to place automatically show the expiry or action date inside your articles. The date will be added at the bottom of your post.

[Click here to see the Footer Display options](https://publishpress.com/knowledge-base/footer-display/).

You can use shortcodes to show the expiration date inside your posts. You can customize the shortcode output with several formatting options.

[Click here to see the shortcode options](https://publishpress.com/knowledge-base/shortcodes-to-show-expiration-date/).

## Expiry Defaults for Post Types

PublishPress Future can support any post type in WordPress. Go to Settings > PublishPress Future > Defaults and you can choose default expiry options for each post type.

[Click here to see the default options](https://publishpress.com/knowledge-base/defaults-for-post-types/).

## PublishPress Future Email Notifications

The PublishPress Future plugin can send you email notifications when your content is changed. You can control the emails by going to Settings > PublishPress Future > General Settings.

[Click here to see the notification options](https://publishpress.com/knowledge-base/email-notifications/).

## Integrations With Other Plugins

In PublishPress Future Pro it is possible to schedule changes to your posts based on metadata. This makes it possible to integrate PublishPress Future with other plugins.  For example, you can create a date field in the Advanced Custom Fields plugin and use that to control the date for Future Actions.

When you are using an integration, there are five types of data that you can update in PublishPress Future:

* Action Status: This field specifies if the action should be enabled.
* Action Date: This field stores the scheduled date for the action.
* Action Type: This field stores the type of action that will be executed.
* Taxonomy Name: The taxonomy name for being used when selecting terms.
* Taxonomy Terms: A list of term's IDs for being used by the action.

[Click here to see how to integrate Future with other plugins](https://publishpress.com/knowledge-base/metadata-scheduling/).

## Import the Future Actions

PublishPress Future Pro supports imports from external data sources. You can import posts and automatically create Future Actions associated with those posts.

The best approach is to use the Metadata Scheduling feature. If you're using a plugin such as WP All Import, you can match up the import tables with the fields you have selected in the Metadata Scheduling feature.

[Click here to see how to import data for Future Actions](https://publishpress.com/knowledge-base/imports-and-metadata-scheduling/).

## Details on How Post Changes Works

For each expiration event, a custom cron job is scheduled. This can help reduce server overhead for busy sites. This plugin REQUIRES that WP-CRON is setup and functional on your webhost.  Some hosts do not support this, so please check and confirm if you run into issues using the plugin.

[Click here to see the technical details for this plugin](https://publishpress.com/knowledge-base/scheduling-cron-jobs/).

## Logs for All Your Post Changes

PublishPress Future Pro allows you to keep a detailed record of all the post updates. PublishPress Future records several key data points for all actions:

* The post that the action was performed on.
* Details of the post update.
* When the change was made to the post.

[Click here to see more about the logs feature](https://publishpress.com/knowledge-base/action-logs/).

## Join PublishPress and get the Pro plugins ##

The Pro versions of the PublishPress plugins are well worth your investment. The Pro versions have extra features and faster support. [Click here to join PublishPress](https://publishpress.com/pricing/).

Join PublishPress and you'll get access to these nine Pro plugins:

* [PublishPress Authors Pro](https://publishpress.com/authors) allows you to add multiple authors and guest authors to WordPress posts.
* [PublishPress Blocks Pro](https://publishpress.com/blocks) has everything you need to build professional websites with the WordPress block editor.
* [PublishPress Capabilities Pro](https://publishpress.com/capabilities) is the plugin to manage your WordPress user roles, permissions, and capabilities.
* [PublishPress Checklists Pro](https://publishpress.com/checklists) enables you to define tasks that must be completed before content is published.
* [PublishPress Future Pro](https://publishpress.com/future)  is the plugin for scheduling changes to your posts.
* [PublishPress Permissions Pro](https://publishpress.com/permissions)  is the plugin for advanced WordPress permissions.
* [PublishPress Planner Pro](https://publishpress.com/publishpress) is the plugin for managing and scheduling WordPress content.
* [PublishPress Revisions Pro](https://publishpress.com/revisions) allows you to update your published pages with teamwork and precision.
* [PublishPress Series Pro](https://publishpress.com/series) enables you to group content together into a series

Together, these plugins are a suite of powerful publishing tools for WordPress. If you need to create a professional workflow in WordPress, with moderation, revisions, permissions and more... then you should try PublishPress.

= Bug Reports =

Bug reports for PublishPress Future are welcomed in our [repository on GitHub](https://github.com/publishpress/publishpress-future). Please note that GitHub is not a support forum, and that issues that are not properly qualified as bugs will be closed.

== Installation ==

This section describes how to install the plugin and get it working.

1. Unzip the plugin contents to the `/wp-content/plugins/post-expirator/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. You can select future action dates in the right sidebar when you are editing a post. This works with Gutenberg, the Classic Editor, and most page builder plugins.
2. You can modify action dates using the “Quick Edit” and “Bulk Edit” modes. This enables you to quickly add automatic actions to as many posts as you need.
3. PublishPress Future allows you to modify, remove or completely delete content when the scheduled date arrives.
4. The PublishPress Future plugin can send you email notifications when automatic actions happen on your content.
5. PublishPress Future allows you to choose action dates for post, pages, WooCommerce products, LearnDash classes, or any other custom post types.
6. PublishPress Future allows you to automatically show the scheduled date inside your articles. The action date will be added at the bottom of your post. You can also use shortcodes to show the action date and customize the output.
7. The PublishPress Future plugin creates a log of all the modified posts. This allows you to have a detailed record of all the automatic actions for your posts.
8. PublishPress Future Pro supports custom statuses such as those provided by WooCommerce. This means that Pro users can set their content to move to any status in WordPress.

== Frequently Asked Questions ==

= Can I schedule changes to WooCommerce Products? =

Yes, the PublishPress Future plugin allows you to schedule automatic changes to posts, pages and other content types including WooCommerce products. To enable this feature, go to Future > Post Types. Check the “Active” box in the “Product” area.

[Click here for more details on WooCommerce changes](https://publishpress.com/knowledge-base/schedule-changes-woocommerce-products/)

= Can I schedule changes to Elementor posts? =

Yes, the PublishPress Future plugin allows you to schedule automatic changes to posts, pages and other content types including WooCommerce products. To enable this feature, go to Future > Post Types. Check the “Active” box for the post type you're using with Elementor.

[Click here for more details on Elementor post changes](https://publishpress.com/knowledge-base/schedule-changes-elementor/)

== Changelog ==

The full changelog can be found on [GitHub](https://github.com/publishpress/PublishPress-Future/blob/main/CHANGELOG.md).

= [3.4.0] - 19 Jun, 2024 =

* ADDED: In the JS context, implemented a way to extend the future action panel using SlotFill `FutureActionPanelAfterActionField` and setting extra fields to the panel, right after the action field;
* ADDED: Add a new filter to allow filtering the options of the future action being scheduled: `publishpressfuture_prepare_post_expiration_opts`;
* ADDED: Add method `scheduleRecurringAction` to the `CronToWooActionSchedulerAdapter` to schedule recurring action;
* ADDED: Add method `scheduleAsyncAction` to the `CronToWooActionSchedulerAdapter` to schedule async action;
* ADDED: In the JS context, added the slot `FutureActionPanelTop` to the beginning of the future panel;
* CHANGED: Added `$unique` and `$priority` arguments to the `scheduleSingleAction` method in the `CronToWooActionSchedulerAdapter` class;
* CHANGED: Method `scheduleRecurringAction` renamed to `scheduleRecurringActionInSeconds` in the `CronToWooActionSchedulerAdapter` class;
* CHANGED: Added argument `$clearOnlyPendingActions` to the method signature `clearScheduledAction` to the `CronInterface` interface;
* CHANGED: Changed the method `clearScheduledAction` in the class `CronToWooActionSchedulerAdapter` adding new argument `$clearOnlyPendingActions`, allowing to remove running actions;
* CHANGED: The plugin activation and deactivation callback functions were moved from the main file to independent files;
* CHANGED: Change the admin menu names for clarity;
* CHANGED: Update the promo sidebar for mentioning the Actions Workflow feature;
* FIXED: Fix error when quick-edit data is not available, #730;
* FIXED: Fix dependency of the enqueued scripts for the future action box. Add 'wp-i18n', 'wp-components', 'wp-url', 'wp-data', 'wp-api-fetch', 'wp-element', 'inline-edit-post', 'wp-html-entities', 'wp-plugins' as dependencies;
* FIXED: Updated ES, FR and IT translations, #698;
* FIXED: Redirects to the settings page after activating the plugin, #764;
* FIXED: Fix access to the View Debug settings tab when debug is disabled;
* FIXED: Fix the position of the "Upgrade to Pro" and "Settings" menu items in the admin bar;

= [3.3.1] - 19 Mar, 2024 =

* ADDED: Add validation for the date and time offset in the settings page, #683;
* ADDED: Add form validation to the settings panel;
* ADDED: Add form validation to the metabox panel;
* ADDED: Add a date preview to the date/time offset setting field;
* CHANGED: The actions to move posts to another status where grouped in a single action, with a dropdown to select the status, #668;
* CHANGED: The actions "draft", "private" and "trash" are deprecated in favor of "change-status", #668;
* CHANGED: The metadata hash key has now a prefix "_" marking it as a private key, #695;
* CHANGED: Improved the name of some actions;
* CHANGED: Change the label of the field to select terms when "Replace all terms" is selected, #664;
* FIXED: Make it impossible to choose dates in the past, #443;
* FIXED: Enter key submits quick-edit panel when selecting a taxonomy term, #586;
* FIXED: The name of the taxonomy in the actions field is now updated in the settings panel when the taxonomy is changed, #676;
* FIXED: Possible to add an action using an empty category setting, #587;
* FIXED: Fix language files for ES, IT, FR, #685;
* FIXED: Fix inconsistent text in the filter for "Pending" actions, #673;
* FIXED: Improve the message when no actions are found: "No Future Actions", #666;

= [3.3.0] - 28 Fev, 2024 =

* ADDED: Add new filter for filtering the list of post types supported by the plugin: publishpressfuture_supported_post_types, #677;
* ADDED: Add new filter for choosing to hide or not the Future Action in the post editors: publishpressfuture_hide_metabox, #69;
* ADDED: Add new filter for filtering the post metakeys in the post model: publishpressfuture_action_meta_key, #69;
* ADDED: Add new method `medataExists` to the `PublishPress\Future\Framework\WordPress\Models\PostModel` class;
* ADDED: Add support to a hash in the the post meta `pp_future_metadata_hash`, to identify if the future action's post meta has changed or was scheduled by metadata (fully availale only on PRO);
* CHANGED: Deprecated the filter `postexpirator_unset_post_types` in favor of the new filter `publishpressfuture_supported_post_types`, allowing not only remove, but add new post types to the list of supported post types, #677;
* CHANGED: The list of post types in the settings page now also shows the non-public post types that are not built in on WordPress, #677;
* CHANGED: Remove the X and Facebook icons from the footer in the admin pages, #667;
* CHANGED: Updated the URLs on the plugin's footer, #667;
* CHANGED: Minor change in the description of the setting that controls the activation/deactivation future action for the post type;
* CHANGED: The metadata `_expiration-date-status` now can be specified as `1` or `'1'` and not only `'saved'`, #69;
* CHANGED: The action `publishpress_future/run_workflow` is now depreacated in favor of `publishpressfuture_run_workflow`;
* FIXED: Fix language files for ES, IT, FR, #665;
* FIXED: Fix error when a term does not exists, #675;
* FIXED: Add new interface for NoticeFacade: NoticeInterface;
* REMOVED: Remove the legacy action `postExpiratorExpire`. This action will not trigger the future actions anymore;
* REMOVED: Remove the legacy action `publishpressfuture_expire`. This action will not trigger the future actions anymore;

= [3.2.0] - 25 Jan, 2024 =

* ADDED: Add the possibility to use non hierarchical taxonomies, #285;
* ADDED: Add new future action to remove all taxonomy terms of a post, #652;
* ADDED: Add new action hook `publishpressfuture_saved_all_post_types_settings` to allow developers to trigger an action when the Post Types settings are saved;
* CHANGED: Deprecate the constant PublishPress\Future\Modules\Settings\SettingsFacade::DEFAULT_CUSTOM_DATE and replaced it with ::DEFAULT_CUSTOM_DATE_OFFSET;
* CHANGED: Moved the date and time format settings fields to the Display tab, #605;
* CHANGED: Added description to the taxonomy setting field in the Post Types tab, #641;
* CHANGED: Moved the Post Types settings tab to the first position, #619;
* CHANGED: Simplify the name of actions on taxonomy related actions, adding the actual name of the taxonomy, #294;
* CHANGED: Change the text on the Status column in the Future Actions list, from "Pending" to "Scheduled", #661;
* CHANGED: Fixed typos and improved the text in the Post Types settings tab, #659;
* CHANGED: The list of supported post types in the settings page only shows public post types, and non-public that are built-in and show the UI;
* FIXED: Fix consistency on radio buttons alignment on the settings page;
* FIXED: Hides the legacy cron event field from Diagnostics and Tools settings tab if no legacy cron event is found;
* FIXED: Fix the "Change Status to Trash action" on custom post types, #655;
* FIXED: Added back support for reusable blocks, #200;
* FIXED: Updated the language files, #653;
* FIXED: Fix error 404 when activating future action on a post type that has no taxonomy registered, #662;
