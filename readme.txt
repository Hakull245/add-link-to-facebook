=== Add Link to Facebook ===
Contributors: Marcel Bokhorst
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=AJSBB7DGNA3MJ&lc=US&item_name=Add%20Link%20to%20Facebook%20WordPress%20Plugin&item_number=Marcel%20Bokhorst&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted
Tags: post, posts, facebook, social, link, links, wpmu, admin
Requires at least: 3.0
Tested up to: 3.1
Stable tag: 0.5

Automatically add links to published posts to your Facebook wall

== Description ==

Automatically add links to posts that are being published to your Facebook wall. Simple one time setup and forget. Just two fields to fill in.

It is possible to configure a link image (WordPress icon, featured image or custom image) or you can let Facebook select one automatically. It is possible to exclude individual post links from being added to your wall by ticking a check box just above the publish button. There is support for multi user and network sites and shortcodes will be processed.

**This plugin requires PHP 5 and WordPress 3.0 or better**

Please report any issue you have with this plugin on the [support page](http://blog.bokhorst.biz/5018/computers-en-internet/wordpress-plugin-add-link-to-facebook/ "Marcel's weblog"), so I can at least try to fix it. If you rate this plugin low, please [let me know why](http://blog.bokhorst.biz/5018/computers-en-internet/wordpress-plugin-add-link-to-facebook/#respond "Marcel's weblog").

See my [other plugins](http://wordpress.org/extend/plugins/profile/m66b "Marcel Bokhorst").

== Installation ==

*Using the WordPress dashboard*

1. Login to your weblog
1. Go to Plugins
1. Select Add New
1. Search for *Add Link to Facebook*
1. Select Install
1. Select Install Now
1. Select Activate Plugin

*Manual*

1. Download and unzip the plugin
1. Upload the entire add-link-to-facebook/ directory to the /wp-content/plugins/ directory
1. Activate the plugin through the Plugins menu in WordPress

== Frequently Asked Questions ==

= I get 'Error validating application' =

You have probably entered a wrong App ID.

= I get 'Error validating client secret' =

You have probably entered a wrong App Secret.

= I get 'Given URL is not allowed by the Application configuration' =

You have probably entered a wrong URL in the Facebook application setting 'Web Site > Site URL'.

= I get 'The user hasn't authorized the application to perform this action' =

You have probably revoked the permissions of the Facebook application. You have to re-authorize the plugin.

= Which link picture will Facebook select? =

Mostly the first picture in the post, but it depends on the theme and layout of your website.

= Why doesn't Facebook display my custom link picture? =

Maybe because it is smaller than 50 x 50 pixels.

= What is the custom field 'al2fb_facebook_link_id' for? =

This is the Facebook identification of the added link.
If you remove it, the link will be added again.

= Is there support for multi user sites? =

Yes, each user can configure his own wall.

= How about private / password protected posts? =

Don't worry, no links to private posts will be added.

= Will shortcodes be processed? =

Yes, shortcodes in the excerpt, or if absent in the text, are being processed.

= Is remote publishing via XML-RPC supported? =

Yes.

= Where can I ask questions, report bugs and request features? =

You can write a comment on the [support page](http://blog.bokhorst.biz/5018/computers-en-internet/wordpress-plugin-add-link-to-facebook/ "Marcel's weblog").

== Changelog ==

= 0.5 =
* New feature: add to page

= 0.4 =
* Added support for remote publishing via XML-RPC ([Android](http://android.wordpress.org/ "Android"), [iOS](http://ios.wordpress.org/ "iOS"), etc)
* Bugfix: domains with path, including networks with sub-directories install
* Bugfix: activation hook
* Bugfix: some PHP notices
* Updated description and FAQ

= 0.3 =
* Added Dutch (nl\_NL) and Flemisch (nl\_BE) translations
* Logging Facebook errors when adding link
* Improved styling of administration area

= 0.2 =
* Bugfix: strip html tags from message text
* Bugfix: check for access token before adding link

= 0.1 =
* Initial release

= 0.0 =
* Development version

== Upgrade Notice ==

= 0.5 =
New feature: add to page

= 0.4 =
Support for remote publishing, bugfixes

= 0.3 =
Added Dutch and Flemisch translations

= 0.2 =
Bugfixes

= 0.1 =
Initial version
