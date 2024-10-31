=== Send Denial ===
Contributors: giulng
Tags: anti spam, honeypot, captcha, ninja forms, cf7, wpforms, woocommerce, spam, formidable, caldera forms, jetform, elementor forms, formcraft
Donate link: https://senddenial.com/donate
Requires at least: 6.0
Tested up to: 6.4.3
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Anti-Spam protection for the most popular and widly used formbuilders and plugins. GDPR compliant.

== Description ==
Send Denial - a spam sentinel

This plugin will enable honeypot and other anti-spam techniques (in future versions) to protect your business and mailbox from automated script spammers. In "basic" honeypot mode there will be zero impact on your users. they won't see a captcha or puzzle to solve, they can just use your websites forms. Plug and play

This plugin will be compliant with GDPR guidelines as it won't call external apis or databases at all. In future versions there might be a local database table (in your database) where failed submissions (from bots) will be stored so you will have total control over the data.

**currently supported (protected) plugins include:**

1. Caldera Forms
2. WPForms Lite
3. CF7 (Contact Form 7)
4. Ninja Forms (including ajax submissions)
5. Formidable
6. WooCommerce (registration, checkout, login)
7. Elementor Forms (Pro)
8. MC4WP
9. Jetform Builder
10. Ultimate Member (Registration Form)
11. FormCraft Premium

**planned support for the near future:**

1. bbPress
2. Divi Forms
3. Fluentform
4. HTML Form
5. Gravity Forms
6. BuddyPress
7. Easy Digital Downloads Checkout
8. Toolset Forms

This plugin will support as many popular plugins as possible for free. There is no intent to sell "premium" anti spam protection in the future. You can help to support costly formbuilders or other paid plugins by donating a little amout to help fund the licenses for the development environment.

== Installation ==
1. Download and activate from official WordPress repository
2. Plugin works out of the box - no configuration needed
1. For advanced options (in future), visit Send Denial under the settings menu tab

== Changelog ==
= 1.0.10 =
* added honeypot support for FormCraft Premium

= 1.0.9 =
* added honeypot to Ultimate Members Login

= 1.0.8 =
* removed WP Login, Registration and Comments Protection due to unreliability with other plugins and registration/login setups

= 1.0.7 =
* added support for Ultimate Member registration form

= 1.0.6 =
* fixed ninja forms could not be validated
* testet up to php 8.1, WP 6.2.2

= 1.0.5 =
* fixed wp comments anti spam problem
* logs can now also be un-anonymized

= 1.0.4 =
* added support for Jetform Builder

= 1.0.3 =
* added logging

= 1.0.2 =
* added support for Mailchimp for WP (MC4WP)
* fixed error message on wp-login.php when no $_POST ist send

= 1.0.1 =
* added support for Elementor Forms (Pro)

= 1.0.0 =
* Initial release.
* support for: Caldera Forms, CF7 (Contactform 7), Formidable, Ninja Forms, WPForms Lite,  WooCommerce (registration, checkout, login), WordPress (login, registration, comments)