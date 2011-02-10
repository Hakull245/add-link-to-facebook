=== Add Link to Facebook ===
Contributors: Marcel Bokhorst
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=AJSBB7DGNA3MJ&lc=US&item_name=Add%20Link%20to%20Facebook%20WordPress%20Plugin&item_number=Marcel%20Bokhorst&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted
Tags: post, posts, facebook, social, link, links, permalink, wpmu, admin
Requires at least: 3.0
Tested up to: 3.1
Stable tag: 0.15

Automatically add links to published posts to your Facebook wall or pages

== Description ==

Automatically add links to posts that are being published to your Facebook wall or pages. Simple one time setup and forget. Just two fields to fill in.

The link title will be the post title. The link description will be the excerpt, or part of the post text if there is none.
It is possible to configure a link image (WordPress icon, featured image or custom image) or you can let Facebook select one automatically.
It is possible to exclude individual post links from being added to your wall or pages by ticking a check box just above the publish button.
There is support for multi user and network sites and shortcodes will be processed.
It works for remote publishing too, for example from [Android](http://android.wordpress.org/ "Android") or [iOS](http://ios.wordpress.org/ "iOS") powered devices
or using [Window Live Writer](http://explore.live.com/windows-live-writer "Window Live Writer").

**This plugin requires PHP 5 and WordPress 3.0 or better**

Translations are welcome, see [FAQ](http://wordpress.org/extend/plugins/add-link-to-facebook/faq/ "FAQ") for instructions.

* English (en\_US): built-in, corrections are welcome
* Dutch (nl\_NL): [Marcel Bokhorst](http://blog.bokhorst.biz/about/ "Marcel Bokhorst")
* Flemisch (nl\_BE): [Marcel Bokhorst](http://blog.bokhorst.biz/about/ "Marcel Bokhorst")
* ...

Please report any issue you have with this plugin on the [support page](http://blog.bokhorst.biz/5018/computers-en-internet/wordpress-plugin-add-link-to-facebook/ "Marcel's weblog"), so I can at least try to fix it.
If you rate this plugin low, please [let me know why](http://blog.bokhorst.biz/5018/computers-en-internet/wordpress-plugin-add-link-to-facebook/#respond "Marcel's weblog").

See [my other plugins](http://wordpress.org/extend/plugins/profile/m66b "Marcel Bokhorst").

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

You have probably entered a wrong *App ID* or the application may be deleted.

= I get 'Error validating client secret' =

You have probably entered a wrong *App Secret*.

= I get 'Given URL is not allowed by the Application configuration' =

You have probably entered a wrong URL in the Facebook application setting *Web Site > Site URL*.

= I get 'The user hasn't authorized the application to perform this action' =

You have probably revoked the publishing permissions of the Facebook application.
If you did this by accident, you can simply re-authorize the plugin.
If you did this deliberately, you should remove the *App ID* and *App Secret* from the plugin settings.
If you are the only user of the website, you can also disable the plugin.

= I get 'Invalid access token signature' =

You have probably reset the *App Secret*. You should re-enter it.

= I get 'Error validating verification code' =

This should not happen. Please go to the plugin page (via the *Tools* menu), click on the link *Debug info* at the bottom of the page and
send me the debug output that appears at the top of the page using the [contact form](http://blog.bokhorst.biz/contact/ "contact form").
**Do not** post the output on the support page, because it contains some sensitive information about your Facebook application
(but not your App Secret and access token).

= Which link picture will Facebook select? =

Mostly the first picture in the post, but it depends on the theme and layout of your website.

= Why doesn't Facebook display my custom link picture? =

Maybe because it is smaller than 50 x 50 pixels.

= What happens when I update a post? =

If the link to the post was added already to your wall or page nothing,
else a new link will be added. See also the next question.

= What is the custom field 'al2fb_facebook_link_id' for? =

This is the Facebook identification of the added link.
If you remove it, the link will be added again.

= What is the custom field 'al2fb_facebook_exclude' for? =

This is to remember you ticked the check box *Do not add link to Facebook*.

= What is the custom field 'al2fb_facebook_error' for? =

If something goes wrong when adding a link to your wall or page, the error message is stored in this field.
You can try to add the link again by updating the post.
Please send me the message and follow the steps of the question *I get 'Error validating verification code'* above.

= Is there support for multi user sites? =

Yes, each user can configure his/her own wall or page.

= How about private / password protected posts? =

Don't worry, no links to private posts will be added.

= Will shortcodes be processed? =

Yes, shortcodes in the excerpt, or if none in the text, will be processed.

= Is remote publishing supported? =

Yes, via both [XML-RPC](http://en.wikipedia.org/wiki/XML-RPC "XML-RPC") and the [Atom Publishing Protocol](http://en.wikipedia.org/wiki/Atom_%28standard%29 "Atom").
So you can use for example an [Android](http://android.wordpress.org/ "Android") or [iOS](http://ios.wordpress.org/ "iOS") powered device
or [Window Live Writer](http://explore.live.com/windows-live-writer "Window Live Writer") to publish posts and
still have links added to your wall or page automatically.
Don't forget to enable remote publishing using the WordPress menu *Settings > Writing*.

= Which users can use this plugin? =

Users with the *edit_posts* capability: all user roles, except subscriber.
Since version 0.11 administrators can change this using the setting *Required capability to use plugin*.

= How can I translate the plugin? =

You can use the [Dutch translation](http://plugins.svn.wordpress.org/add-link-to-facebook/trunk/add-link-to-facebook-nl_NL.po "Dutch") as basis.
After saving the file, you can translate it by using a text editor or [Poedit](http://www.poedit.net/ "Poedit").
Another way is to install and use the [Codestyling Localization](http://wordpress.org/extend/plugins/codestyling-localization/ "Codestyling Localization") plugin.
Please use the [contact form](http://blog.bokhorst.biz/contact/ "the contact form") to send me the new .po file.

= Where can I ask questions, report bugs and request features? =

You can write a comment on the [support page](http://blog.bokhorst.biz/5018/computers-en-internet/wordpress-plugin-add-link-to-facebook/ "Marcel's weblog").

== Changelog ==

= 0.15 =
* Improvement: add links for newly published posts only
* Improvement: register time of adding link
* Improvement: better layout admin area
* Improvement: using blog charset
* Improvement: extended debug option
* Improvement: enabled Atom Publishing Protocol
* Improvement: option to use blog title as caption
* Bugfix: handle *Do not add link* when publishing without draft
* Bugfix: use settings of post author in stead of post editor
* Updated Dutch (nl\_NL) and Flemisch (nl\_BE) translations
* Updated description and FAQ

= 0.14 =
* Improvement: check PHP version outside class

= 0.13 =
* Fix for *Error validating verification code*
* Added debug option
* Updated description and FAQ

= 0.12 =
* Added *ENT_QUOTES* to *htmlspecialchars* calls
* Updated description

= 0.11 =
* New feature: suppress admin notices
* New feature: select which users can use the plugin
* Updated Dutch (nl\_NL) and Flemisch (nl\_BE) translations

= 0.10 =
* Improvement: display category if available
* Added some *htmlspecialchars* calls

= 0.9 =
* Improvement: display application name

= 0.8 =
* Improvement: No *Do not add link to Facebook* for subscribers
* Updated description and FAQ

= 0.7 =
* New feature: add links as page owner (requires extra permission)
* Updated Dutch (nl\_NL) and Flemisch (nl\_BE) translations

= 0.6 =
* New feature: user settings for donated and clean options
* Admin notices jump to anchors
* Updated FAQ
* Updated Dutch (nl\_NL) and Flemisch (nl\_BE) translations

= 0.5 =
* New feature: add links to page
* Updated Dutch (nl\_NL) and Flemisch (nl\_BE) translations

= 0.4 =
* New feature: support for remote publishing via XML-RPC
* Bugfix: domains with path, including networks with sub-directories install
* Bugfix: activation hook
* Bugfix: some PHP notices
* Updated description and FAQ

= 0.3 =
* Added Dutch (nl\_NL) and Flemisch (nl\_BE) translations
* Logging Facebook errors when adding links
* Improved styling of administration area

= 0.2 =
* Bugfix: strip html tags from excerpt or message text
* Bugfix: check for access token before adding links

= 0.1 =
* Initial release

= 0.0 =
* Development version

== Upgrade Notice ==

= 0.15 =
Improvements and bugfixes

= 0.14 =
Compatibility

= 0.13 =
Fix for 'Error validating verification code'

= 0.12 =
Small improvements

= 0.11 =
New features: suppress admin notices, select which users can use the plugin

= 0.10 =
Small improvements

= 0.9 =
Small improvement

= 0.8 =
Small improvement

= 0.7 =
New feature: add links as page owner

= 0.6 =
User settings for donated and clean options

= 0.5 =
New feature: add links to page

= 0.4 =
Support for remote publishing, bugfixes

= 0.3 =
Added Dutch and Flemisch translations

= 0.2 =
Bugfixes

= 0.1 =
Initial version
