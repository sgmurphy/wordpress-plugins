=== Solid Mail – SMTP email and logging made by SolidWP  ===
Contributors: solidwp, jack-kitterhing
Donate link: https://solidwp.com/email
Tags: wordpress smtp, email, email log, smtp
Requires at least: 6.4
Tested up to: 6.5.2
Stable tag: 2.0.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Email deliverability made SOLID. Connect to your chosen email provider with an intuitive set-it-and-forget-it SMTP plugin. Reliable, efficient, secure.

== Description ==
Your WordPress website is sending emails out daily, but are your users and visitors receiving them? When it comes to ensuring email deliverability, lean on a proven equation: SMTP plugin + email service provider = success. Solid Mail is an easy-to-use, set-it-and-forget-it SMTP plugin that will help you stop worrying about email deliverability.

= ❓How does Solid Mail Help You Implement SMTP Email on your website? =

Solid Mail makes connecting to many popular SMTP services straightforward and clear. Solid Mail currently supports the following Email Service Providers (ESPs):

* Sendgrid
* MailGun
* Brevo (formally Sendinblue)
* Amazon SES
* Manual connection (connect to any ESP)

[Learn more about transactional email services for your WordPress website here](https://solidwp.com/blog/alternatives-for-wordpress-transactional-emails/).

= 🤔Why Should You Use an SMTP Plugin for Your WordPress Website Instead of the Native PHP Mail? =

WordPress out the box uses PHP’s built-in mail function to send emails such as password reset requests, WooCommerce order invoices and more. The issue? PHP Mail is only as good as your server and most hosts don’t have dedicated PHP Mail monitoring.

Even hosts that specialize in hosting WordPress either don’t offer email services or don’t actively monitor for deliverability. That means you can be at the mercy of noisy neighbors sending spam to purchased email subscriber lists, or spammers running the latest scam. Either way it impacts the health of the server in the eyes of ESPs such as Google, Yahoo, Outlook, and others meaning that most of the time your emails don’t even hit the inbox!

Go from spam-box to inbox with Solid Mail: an SMTP (Simple Mail Transfer Protocol) plugin. Combine with an email service provider such as SendGrid, Brevo, Amazon SES, and others and see your emails start getting delivered.

An SMTP plugin – like Solid Mail – is essentially a higher-level and more advanced method of sending emails between servers that uses a username and password or other secure method to create the connection to an email service provider (ESP). ESPs (like those listed below) provide robust solutions to deliverability issues by running dedicated servers for sending that are managed ‘round the clock for issues like blacklisting, spam removal, and more. In addition they use authentication protocols like SSL/TLS to secure email transmissions and ensure better deliverability.

Using an SMTP plugin combined with an email service provider instead of PHP Mail on the server leads to more reliable, secure, and efficient email communication for WordPress websites. [Find out more about SMTP and WordPress email deliverability here](https://solidwp.com/blog/wordpress-not-sending-email/).

= 📑How does Solid Mail Validate Email Deliverability with Email Logs? =

Solid Mail gives you an easy-on-the-eyes interface to review and inspect your comprehensive email logs and understand if your email was sent or not. This transparency helps in debugging any email deliverability issues with your website.

Many email service providers offer advanced features like email tracking and analytics. Solid Mail’s email logs help optimize email strategies by making it easy for you to view and act on patterns and trends.

= 📧 Email Logging is a great way to help troubleshoot WordPress email deliverability issues =

But how do you know and validate that your emails are actually being sent from your website correctly? The answer is email logs.

Email logs are crucial for validating that your emails are being delivered as intended, serving as an indispensable tool for troubleshooting and ensuring reliability in communication. These logs provide detailed records of every email transaction, including timestamps, recipient addresses, and errors in the SMTP authentication process.

== Frequently Asked Questions ==

= What SMTP services does Solid Mail support? =

Currently, Solid Mail supports the following SMTP services:
* SendGrid
* MailGun
* Brevo (formally Sendinblue)
* Amazon SES
* Manual connection (connect to any SMTP email service provider)

We are considering additional SMTP services for our roadmap. If you have specific recommendations that you’d like to see added, [contact us here](https://solidwp.com/contact).

= I need help troubleshooting an email problem with Solid Mail, where can I get support? =

Solid Mail is 100% free, and [we provide top-notch technical support for all users here](https://wordpress.org/support/plugin/wp-smtp).

= What email services does the Solid Mail SMTP Plugin support?  =

✉️SendGrid ✉️

When you want to send transactional and marketing emails at scale, SendGrid from Twilio is a preferred option for millions of users worldwide. SendGrid offers free and paid options, lets you get started quickly, and is well suited for both large and small businesses.

📧MailGun 📧

MailGun is known as a flexible, scalable, and reliable platform. With MailGun, you can select a package that works best for your monthly delivery needs, starting as low as 100 emails per day (currently free). MailGun also offers Optimization packages that help with email address validation, inbox placement tests, and more.

⏩Brevo ⏩

Brevo, formerly sendinblue, is a top-rated email marketing solution that is easy to use but also offers powerful deliverability – even with their free plan.

🚀Amazon SES 🚀

Amazon SES (Simple Email Service) ensures compliance and efficiency at competitive prices. It’s a cloud-based email service for transactional, marketing, and newsletter emails – including at high volume.

= How to Send Email Using a SMTP service with WordPress? =

To configure your WordPress website to send email using any SMTP email provider with Solid Mail, follow these steps:

1. Navigate to “Solid Mail > Connections
2. Select the appropriate email provider from the dropdown
3. Add the credentials for that email provider.

For more information, see the [documentation](https://go.solidwp.com/solid-mail-documentation).

== Installation ==

There are several ways to install and activate Solid Mail for your website. Here are two of them:

= Install Solid Mail via the “Add Plugins” screen =

To install and activate Solid Mail via your WordPress admin area, navigate to “Plugins > Add New Plugin”. On that screen, go to the search field on the far right top of the screen and type in “Solid Mail” and hit Enter. The “Solid Mail” plugin should be your first result.

In the “Solid Mail” plugin card, click on the “Install Now” button. You’ll see the button change to “Installing”, then it will switch to say “Activate”, click “Activate”. At that point, Solid Mail is active on your website.

Lastly, navigate to the Dashboard, then navigate to “Settings > Solid Mail” and choose your SMTP provider and add your settings. Now your site is SOLID with Solid Mail.

= Install Solid Mail via SFTP =

1. Navigate to wordpress.org/plugins/wp-smtp and near the top right of the screen, click on “Download.” That will download the `wp-smtp.zip` file.
2. Unzip the file locally on your computer. That should give you a folder called “wp-smtp” with all the plugin files. If there is a sub-folder in that folder also called “wp-smtp” then we’ll use the sub-folder.
3. Upload the whole “wp-smtp” sub-folder to the `/wp-content/plugins/` directory
4. Navigate to your WordPress admin area, and then to “Plugins”. You’ll see “Solid Mail” in your list of plugins, but it will not be activated. Click on the “Activate” link.
5. The page will refresh automatically. Navigate to “Settings > Solid Mail”.
6. Enable and configure your SMTP email provider of choice and click “Save”.

Now your website email deliverability is SOLID with Solid Mail!

== Screenshots ==
1. Configure your favorite SMTP email provider with the Solid Mail interface
2. Send a quick test email to confirm that emails are being sent successfully
3. See a comprehensive log of all emails sent from your WordPress website at a glance

== Changelog ==

= [2.0.0] 2024-09-17 =

* Feature - Re-launched as Solid Mail 🎉
* Feature - New UI
* Feature - Support for popular SMTP providers each with a custom UI

= [1.2.7] 2024-04-27 =

* Security - Various security improvements.

= [1.2.6] 2023-10-16 =

* Tweak - Plugin author to reflect ownership changes.

= [1.2.5] 2022-08-09 =

* Fix -: base64_encoding problem for passwords and users that may appear that they are already in base64_encoding but in reality, they are not
* Tweak - Removed CDN files and added them locally

= [1.2.4] 2022-04-15 =

* Feature - Added: Setting to disable the email logging.
* Tweak  - Added base64 encode for username and passwords


= [1.2.3] 2022-04-05 =

* Fix - Resolved issue with auto loading require path

= [1.2.2] 2022-02-15 =

* Tweak - Just update info

= [1.2] 2020-07-29 =

* Feature - New and shiny mail logger.
* Fix - Handle the mail parts as needed


= [1.1.11] 2020-05-25 =

* Tweak - All good, still maintained, just update some info

= [1.1.10] 2019-05-20 =

* Feature - Credentials can now be configured inside wp-config.php
* Tweak - New maintainer – yehudah
* Tweak - Code structure and organize.


= [1.1.9] 2014-08-02 =

* Tweak - Some optimization

= [1.1.7] 2014-03-23 =

* Security - Using a nonce to increase security.

= [1.1.6] 2013-10-06 =

* Tweak - Add Yahoo! example
* Tweak - Some optimization

= [1.1.5] 2013-01-08 =

* Tweak - Some optimization

= [1.1.4] 2012-11-13 =

* Fix - If the field “From” was not a valid email address, or the field “Host” was left blank, it will not reconfigure the wp_mail() function.
* Tweak - Add some reminders.

= [1.1.3] 2012-11-12 =

* Fix - If “SMTP Authentication” was set to no, the values “Username””Password” are ignored.

= [1.1.2] 2012-11-10 =

* Feature - First release.

[See the full changelog here](https://github.com/ithemes/wp-smtp/changelog.txt)