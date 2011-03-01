=== Add Link to Facebook ===
Contributors: Marcel Bokhorst, M66B
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=AJSBB7DGNA3MJ&lc=US&item_name=Add%20Link%20to%20Facebook%20WordPress%20Plugin&item_number=Marcel%20Bokhorst&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted
Tags: post, posts, Facebook, social, link, links, permalink, wpmu, admin
Requires at least: 3.0
Tested up to: 3.1
Stable tag: 0.57

Automatically add links to published posts to your Facebook wall, pages or groups

== Description ==

Automatically add links to posts that are being published to your Facebook wall, pages or groups. Simple one time setup and forget. The way links appear on Facebook can be customized.

The link title will be the post title. The link description will be the excerpt, or part of the post text if there is none.
It is possible to configure a link image (WordPress icon, first image in the media library or in the text, featured image or custom image) or you can let Facebook select one automatically.
It is possible to exclude individual post links from being added to your wall, pages or groups by ticking a check box just above the publish button.

There is support for multi-user and network sites and shortcodes will be processed.
It works for remote publishing too, for example from [Android](http://android.wordpress.org/ "Android") or [iOS](http://ios.wordpress.org/ "iOS") (iPhone, iPad) powered devices
or using [Window Live Writer](http://explore.live.com/windows-live-writer "Window Live Writer")
or from Linux using [BloGTK](http://blogtk.jayreding.com/ "BloGTK") or [Blogilo](http://blogilo.gnufolks.org/ "Blogilo").

**Beta features:**

* Integrate Facebook comments and likes on added links into Wordpress
* Show the names of the people who liked your post on Facebook below the post text
* Show the standard [Facebook like button](http://developers.facebook.com/docs/reference/plugins/like/ "Facebook like button"); this button is not connected to added links
* Support for the [Open Graph protocol](http://developers.facebook.com/docs/opengraph/ "Open Graph protocol")

If you find this plugin useful, please rate it accordingly.
If you rate this plugin low, please [let me know why](http://blog.bokhorst.biz/5018/computers-en-internet/wordpress-plugin-add-link-to-facebook/#respond "Marcel's weblog").
Please report any issue you have with this plugin on the [support page](http://blog.bokhorst.biz/5018/computers-en-internet/wordpress-plugin-add-link-to-facebook/ "Marcel's weblog"), so I can at least try to fix it.
Solutions to common problems are described in [the FAQ](http://wordpress.org/extend/plugins/add-link-to-facebook/faq/ "FAQ").

**This plugin requires PHP 5 and WordPress 3.0 or better**

Translations are welcome, see [the FAQ](http://wordpress.org/extend/plugins/add-link-to-facebook/faq/ "FAQ") for instructions.

* English (en\_US), built-in, corrections are welcome
* Dutch (nl\_NL) by [Marcel](http://blog.bokhorst.biz/about/ "Marcel")
* Flemish (nl\_BE) by [Marcel](http://blog.bokhorst.biz/about/ "Marcel")
* Norwegian (nb\_NO) by [Stein Ivar Johnsen](http://www.idyrøy.no/ "Stein Ivar Johnsen"), thanks!
* Afrikaans (afr\_AFR) by [Jeremy](http://www.primeimage.co.za/ "Jeremy"), thanks!
* Italian (it\_IT) by [Gianni](http://gidibao.net/ "Gianni"), thanks!
* Turkish (tr\_TR) by [laztrix](http://www.diviksfilm.com/blog "laztrix"), thanks!
* German (de\_DE) by [Dirk Exner](http://www.ping-pongline.de/ "Dirk Exner") and [Björn](http://cooleisbaer.co.funpic.de/ "Björn"), thanks!
* Polish (pl\_PL) by [tomi0011](http://blog.coszsieciami.cba.pl/ "tomi0011"), thanks!
* Hungarian (hu\_HU) by [Pitty](http://www.pittyphoto.hu/ "Pitty"), thanks!
* Your translation ...

**If someone would like to contribute a idiot proof guide for settings up the plugin, I would be grateful. I am happy to make a link to your website if needed.**

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

**--- Usability ---**

= What is a caption, message, etc? =

Take a look at [the screen shot](http://wordpress.org/extend/plugins/add-link-to-facebook/screenshots/ "Screen shot") to get an idea of what is what.

= Why is the option 'Featured post image' grayed out? =

Because your current WordPress theme doesn't support featured images.

= How can I display featured images as Facebook link pictures? =

1. Configure the plugin to use featured images
1. Select a featured image in the WordPress post screen

A few notes:

* Not all Wordpress themes support featured images
* You have to select a featured image before published a post
* If there is no featured image set, the WordPress icon will be used

As an alternate to feature images, you can use the Add Link to Facebook post meta box (since version 0.23).
In this box you can select one of the images attached to the post.
Selecting an image this way takes precedence over the other settings.

= To which wall will a link be added? =

Always to the wall of the post author, if configured.
Even if somebody else is editing the post.

= Which link picture will Facebook select? =

Mostly the first picture in the post, but it depends on the theme and layout of your website.
It also depends on support for the [Open Graph protocol](http://developers.facebook.com/docs/opengraph/ "Open Graph protocol") by your theme.
Since version 0.56 you can enable the Open Graph protocol using the plugin settings.

= Why doesn't Facebook display my link picture? =

Maybe because it is smaller than 50 x 50 pixels.
Facebook might also have had trouble accessing the image.

= I don't want a link picture =

Facebook doesn't support this as far as I know,
but you could let the custom link picture point to a valid but non existing address.

= What happens when I update a post? =

If the link to the post was added already to your wall, page or group, nothing,
else a new link will be added. See also the next question.

= How can I add a link to an existing post? =

Change the post status temporarily to draft, update the post and publish the post again.
If you want to add a link again, you should remove the custom field *al2fb_facebook_link_id* first.

= Will links for future posts be added? =

Yes, when they are published automatically a link will be added to your wall, page or group too.

= How about private / password protected posts? =

Don't worry, no links to private posts will be added.

= I want to add links to my fan/community/business page =

Just go to the plugin settings through the WordPress *Tools* menu and
select the page you want the links to be added to using the option *Add to page*.
Maybe you want to check the option *Add as page owner* too.
If you do that, you have to re-authorize one time more, because an extra Facebook permission is required for that.
Note that pages and groups exclude each other.

= I want to add links to a group =

Just go to the plugin settings through the WordPress *Tools* menu and check *Use groups*.
You have to re-authorize one time more now, because an extra Facebook permission is required to access groups.
After you have done that, you can select the group to add links to.
Note that pages and groups exclude each other.

= How can I use short URL's as Facebook link? =

* Install and configure an URL shortener plugin
* [URL Shortener](http://wordpress.org/extend/plugins/url-shortener/ "URL Shortener") is known to work
* Any short URL plugin that supports the filter *pre_get_shortlink* or *get_shortlink* will work
* Enable the option *Use short URL* (available since version 0.32)
* You probably want to enable the option *Use site title as caption* too

= I don't like the gear wheel application icon =

If you use a private Facebook application, you can change it in the application settings.
The application icon of the shared application cannot be changed.

= How can I translate the plugin? =

You can use the [Dutch translation](http://plugins.svn.wordpress.org/add-link-to-facebook/trunk/language/add-link-to-facebook-nl_NL.po "Dutch") as a start.
After saving the file, you can translate it by using a text editor or [Poedit](http://www.poedit.net/ "Poedit").
[See here](http://drupal.org/node/17564 "Poedit plural forms") for details on plural forms.
Another way is to install and use the [Codestyling Localization](http://wordpress.org/extend/plugins/codestyling-localization/ "Codestyling Localization") plugin.
Please use the [contact form](http://blog.bokhorst.biz/contact/ "the contact form") to send me the new .po file.

= How can I change the styling? =

1. Copy *add-link-to-facebook.css* to your upload directory to prevent it from being overwritten by an update
2. Change the style sheet to your wishes; the style sheet contains documentation

**--- Security ---**

= Which users can use this plugin? =

Users with the *edit_posts* capability: all user roles, except subscriber.
Since version 0.11 administrators can change this using the setting *Required capability to use plugin*.

= Why is the shared application less secure? =

**The shared application is no longer available**

Because the Facebook authorization token is sent to you via a [Google App Engine application](http://code.google.com/appengine/ "Google App Engine application") that I manage.
I theory I could collect your token and manipulate your Facebook wall.
You are free to inspect [the source code](http://wp-al2fb.appspot.com/?source=true "wp-al2fb") of this application.

**--- Compatibility ---**

= Is this plugin compatible with my theme? =

Most likely yes, but featured images can only be used as link picture when your theme supports this.

This plugin is known to be incompatible with:

* [Geo Places](http://templatic.com/news/geo-places-city-directory-wordpress-theme "Geo Places"): publishing from the front-end doesn't add links

= Is this plugin compatible with plugin xxx? =

Probably yes, but it all depends on how the plugin works.

Auto posting plugins will work if one of the following actions is used:

* <em>transition_post_status</em>
* <em>xmlrpc_publish_post</em>
* <em>app_publish_post</em>

This plugin is known to be incompatible with:

* [WP Robot](http://wprobot.net/ "WP Robot"): links will not be added
* Maybe [FeedWordPress](http://feedwordpress.radgeek.com/ "FeedWordPress"): no links are added for syndicated posts

If necessary I am happy to implement a custom action. Just [contact me](http://blog.bokhorst.biz/contact/ "Marcel Bokhorst").

= Are shortcodes being processed? =

Yes, both in the excerpt and the post text.

= Are multi-user and network sites supported? =

Yes, each user can configure his/her own wall or page or group.

One WordPress user can only add links to one wall OR page OR group, even if that user happens to have multiple sites (which is possible within a network site).
Adding the same link to more than one wall may lead to difficulties with Facebook as this can be seen as spam.
I may also be a violation of the [Facebook Platform Policies](http://developers.facebook.com/policy/ "Facebook Platform Policies").
Nevertheless, there could be valid use cases, so maybe I will realize this feature in the near future.
Please let me know if you have such a use case.

An administrator can setup his wall for all users of one site by checking the option *Share with all users on this site*. Only the same administrator can undo this.

= Is remote publishing supported? =

Yes, via both [XML-RPC](http://en.wikipedia.org/wiki/XML-RPC "XML-RPC") and the [Atom Publishing Protocol](http://en.wikipedia.org/wiki/Atom_%28standard%29 "Atom").
So you can use for example an [Android](http://android.wordpress.org/ "Android") or [iOS](http://ios.wordpress.org/ "iOS") powered device (XML-RPC)
or [Window Live Writer](http://explore.live.com/windows-live-writer "Window Live Writer") (Atom)
or [BloGTK](http://blogtk.jayreding.com/ "BloGTK") or [Blogilo](http://blogilo.gnufolks.org/ "Blogilo") for Linux
to publish posts and still have links added to your wall or page automatically.
Don't forget to enable remote publishing using the WordPress menu *Settings > Writing*.

= Are custom post types supported? =

Yes, but the custom post type should support custom values for it to work.

**--- Custom values ---**

= What is the custom field 'al2fb_facebook_link_id' for? =

This is the Facebook identification of the added link.

= What is the custom field 'al2fb_facebook_link_time' for? =

This is the time (UTC) the link was added to Facebook or the time of the last error.

= What is the custom field 'al2fb_facebook_link_picture' for? =

This is the picture type and URL of the link as added to Facebook.

= What is the custom field 'al2fb_facebook_exclude' for? =

This is to remember you ticked the check box *Do not add link to Facebook*.

= What is the custom field 'al2fb_facebook_image_id' for? =

This is to remember the image you have selected as link picture.

= What is the custom field 'al2fb_facebook_error' for? =

If something goes wrong when adding a link to your wall or page, the error message is stored in this field.
You can try to add the link again by updating the post.
Please send me the message and follow the instruction in the last question.

**--- Error messages ---**

= I get 'Error validating application' =

You have probably entered a wrong *App ID* or the Facebook application may be deleted.
If you didn't create a Facebook application yet, you should follow the instructions in the yellow box on the plugin page.

Facebook disabled the shared application, because, according to Facebook,
it didn't conform to the [Facebook Platform Policies](http://developers.facebook.com/policy/ "Facebook Platform Policies").
If you had chosen for this (beta) configuration option, you will now see the message *Error validating application*.
Unfortunately there is not much I can do about it. You can still use the plugin, but you have to create a private application now.

= I get 'Error validating client secret' =

You have probably entered a wrong *App Secret*.

= I get 'Given URL is not allowed by the Application configuration' =

You have probably entered a wrong URL in the Facebook application setting *Web Site > Site URL*.

Assuming you created a Facebook application successfully:

* Go to the plugin page through the WordPress *Tools* menu
* Copy the link after *Web Site > Site URL:*
* Click on the *Click here to create* link
* Do not fill anything in, but instead click on the *Back to My Apps* link
* Click on the *Edit Settings* link and select the tab *Web Site*
* Paste into the field *Site URL* and press *Save Changes*

Now try to authorize again.

= I get 'The user hasn't authorized the application to perform this action' =

You have probably revoked one of the permissions of the Facebook application.
If you did this by accident, you can simply re-authorize the plugin.
If you did this deliberately, you should remove the *App ID* and *App Secret* from the plugin settings.
If you are the only user of the website, you can also disable the plugin.

= I get 'Invalid access token signature' =

You have probably reset the *App Secret*. You should re-enter it.

= I get 'Error validating verification code' =

You have probably deleted the Facebook application.
You should delete the *App ID* and *App Secret* from the plugin settings and create a new Facebook application.
This should not happen if you didn't delete the application.
In that case please send me the debug information, see the last question for instructions.

= I get 'This API call requires a valid app_id' =

You could try to re-authorize to fix this, but it should not happen.
Please send me the debug information, see the last question for instructions.

= I get 'An active access token must be used to query information about the current user' =

If you keep getting this error after upgrading to the latest version, please report it and send me the debug information (see the last question for instructions).

= I get 'Invalid access token signature' =

You have probably entered an access token manually, but incomplete or with extra characters.

= I get 'Your server may not allow external connections' =

This means the PHP setting [allow_url_fopen](http://www.php.net/manual/en/filesystem.configuration.php#ini.allow-url-fopen "allow_url_fopen") is disabled
and that [cURL](http://php.net/manual/en/book.curl.php "cURL") is not available too. You may have to ask your hosting provider to enable at least one of the two.

= I get 'cURL error ...' =

Please help me to find out the cause by sending me the debug information, see the last question for instructions.
You can find the cURL error codes on the [libcurl error page](http://curl.haxx.se/libcurl/c/libcurl-errors.html "libcurl-errors.3 -- man page").

cURL errors encountered so far:

* Error 6: *Couldn’t resolve host*: the DNS of the hosting server may not work correct
* Error 7: *Failed to connect() to host or proxy*: the hosting server is probably not allowing connections to the internet
* Error 60: *Peer certificate cannot be authenticated with known CA certificates*: the security certificates on the hosting server could be missing or outdated
* Error 77: *Problem with reading the SSL CA cert*: the certificate files on the hosting server are not accessible or missing

For above cURL errors you need to contact your hosting provider.

= I get 'HTTP 400 Bad Request' =

You are probably using Microsoft Internet Explorer.
This browser has the bad habit not to display the content
when there is an [HTTP](http://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol "HTTP") error.
Actually you are most probably having one of the above errors, but you cannot see which one.
You can switch to [Mozilla Firefox](http://www.mozilla.com/ "Mozilla Firefox") or
if you don't want that you can [send me](http://blog.bokhorst.biz/contact/ "Marcel Bokhorst") the address in the address bar.

= I get 'Javascript not enabled' =

You can only authorize with the shared application if [JavaScript](http://en.wikipedia.org/wiki/JavaScript "JavaScript") in your browser is enabled.
You can either enable JavaScript or try to use a private Facebook application.

**--- Support ---**

= Where can I ask questions, report bugs and request features? =

You can write a comment on the [support page](http://blog.bokhorst.biz/5018/computers-en-internet/wordpress-plugin-add-link-to-facebook/ "Marcel's weblog").

= How can I send the debug information? =

Please go to the plugin page (via the *Tools* menu) and click on the link *Debug information* in the *Resources* panel.
Optionally fill in your name and describe the problem as accurate as possible and press the *Send* button.

== Screenshots ==

1. Added Link on Facebook

== Changelog ==

= 0.58 =
* Updated German (de\_DE) translation by [Björn](http://cooleisbaer.co.funpic.de/ "Björn")
* Updated Norwegian (nb\_NO) translation by [Stein Ivar Johnsen](http://www.idyrøy.no/ "Stein Ivar Johnsen")

= 0.57 =
* New feature: Share with all users on this site (network sites only)
* Improvement: better styling of likers (margin, block, clear)
* Improvement: extended Open Graph protocol to pages
* Improvement: extended Open Graph protocol with image url
* Improvement: no external reference for WordPress logo anymore
* Improvement: post error messages only for current user
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations
* Updated Italian (it\_IT) translation by [Gianni](http://gidibao.net/ "Gianni")
* Updated Norwegian (nb\_NO) translation by [Stein Ivar Johnsen](http://www.idyrøy.no/ "Stein Ivar Johnsen")

= 0.56 =
* New feature: option to show the [Facebook like button](http://developers.facebook.com/docs/reference/plugins/like/ "Facebook like button")
* New feature: option to use the [Open Graph protocol](http://developers.facebook.com/docs/opengraph/ "Open Graph protocol")
* New feature: option to see/enter the Facebook access token in debug mode
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations
* Updated Hungarian (hu\_HU) translation by [Pitty](http://www.pittyphoto.hu/ "Pitty")
* Updated Italian (it\_IT) translation by [Gianni](http://gidibao.net/ "Gianni")
* Updated Norwegian (nb\_NO) translation by [Stein Ivar Johnsen](http://www.idyrøy.no/ "Stein Ivar Johnsen")
* Updated Polish (pl\_PL) translation by [tomi0011](http://blog.coszsieciami.cba.pl/ "tomi0011")

= 0.55 =
* New feature: display likers below post text
* Updated description and FAQ
* Added Hungarian (hu\_HU) translation by [Pitty](http://www.pittyphoto.hu/ "Pitty")
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations
* Updated Norwegian (nb\_NO) translation by [Stein Ivar Johnsen](http://www.idyrøy.no/ "Stein Ivar Johnsen")

= 0.54 =
* Improvement: display correct number of comments when integrating
* Improvement: option to integrate comments and/or likes separately
* Improvement: dummy e-mail addresses for Facebook comments for generated avatars
* Updated FAQ
* Updated Italian (it\_IT) translation by [Gianni](http://gidibao.net/ "Gianni")

= 0.53 =
* Improvement: better styling of admin area
* Updated description and FAQ

= 0.52 =
* New feature: add links to group pages
* Improvement: 'sentences' option has precedence over 'trailer' option
* Improvement: 'trailer' option applies to excerpt too
* Improvement: Facebook texts are not truncated within a sentence anymore
* Improvement: extended debug information with all settings
* Bugfix: preserve page selection
* Bugfix: for <em>An active access token must be used ...</em>
* Updated description and FAQ
* Updated Norwegian (nb\_NO) translation by [Stein Ivar Johnsen](http://www.idyrøy.no/ "Stein Ivar Johnsen")

= 0.51 =
* New feature: integrate Facebook likes (beta)
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations

= 0.50 =
* New feature: option for trailer texts like *Read more ...*
* Updated description and FAQ
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations

= 0.49 =
* Added some *htmlspecialchars* calls and fixed one
* Removed link to shared Facebook application

= 0.48 =
* Improvement: authorization clears last error
* Improvement: authorization fail clears access token
* Improvement: logging authorization time
* Improvement: authorization failure reason logged
* Improvement: get page info with page access token
* Improvement: check result get page info
* Disabled beta client-side flow (shared Facebook app) completely

= 0.47 =
* Updated description and FAQ
* Added Polish (pl\_PL) translation by [tomi0011](http://blog.coszsieciami.cba.pl/ "tomi0011")

= 0.46 =
* Improvement: better search for links and images in text
* Bugfix: selecting first image in post
* Update FAQ
* Updated Italian (it\_IT) translation by [Gianni](http://gidibao.net/ "Gianni")

= 0.45 =
* Disabled shared application beta
* Updated description

= 0.44 =
* New feature: link picture: first image in the post
* Bugfix: keeping hyperlinks should work correct now
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations

= 0.43 =
* New feature: support for keeping hyperlinks
* Improvement: include plugin version in availability check
* Updated description
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations

= 0.42 =
* New feature: support for future posts
* Updated Italian (it\_IT) translation by [Gianni](http://gidibao.net/ "Gianni")

= 0.41 =
* Added link to security considerations shared application
* Added link to [Facebook application wall](http://www.facebook.com/apps/application.php?id=191927664162191 "Facebook application wall")
* Improvement: debug information links
* Updated description and FAQ
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations

= 0.40 =
* Improvement: cache availability *wp-al2fb* service
* Updated FAQ
* Updated Norwegian (nb\_NO) translation by [Stein Ivar Johnsen](http://www.idyrøy.no/ "Stein Ivar Johnsen")

= 0.39 =
* New feature: really simple setup (beta)
* Improvement: option to set refresh time of Facebook comments
* Improvement: save changes: no re-authorize
* Improvement: registering link picture
* Bugfix: *First attached image* is working again
* Added German (de\_DE) translation by [Dirk Exner](http://www.ping-pongline.de/ "Dirk Exner")
* Updated description and FAQ
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations

= 0.38 =
* Bugfix: correct authorize URL

= 0.37 =
* Bugfix: pre-authorization check only when safe mode off
* Updated Norwegian (nb\_NO) translation by [Stein Ivar Johnsen](http://www.idyrøy.no/ "Stein Ivar Johnsen")
* Updated Italian (it\_IT) translation by [Gianni](http://gidibao.net/ "Gianni")

= 0.36 =
* Bugfix: pre-authorization check only when safe mode off
* Improvement: extended debug information
* Improvement: trimming input fields

= 0.35 =
* New feature: integrate comments from Facebook (beta!)
* Improvement: better layout of description to create application
* Improvement: pre-authorization check
* Improvement: added a few *stripslashes*
* Improvement: assume delete succeeded
* Bugfix: site wide options can be set again
* Updated FAQ
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations

= 0.34 =
* New feature: select number of sentences to use
* Improvement: more consequent image handling
* Improvement: security hardened again
* Updated Norwegian (nb\_NO) translation by [Stein Ivar Johnsen](http://www.idyrøy.no/ "Stein Ivar Johnsen")
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations

= 0.33 =
* New feature: delete existing Facebook link from post screen
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations

= 0.32 =
* Added Turkish (tr\_TR) translation by [laztrix](http://www.diviksfilm.com/blog "laztrix")
* Updated Norwegian (nb\_NO) translation by [Stein Ivar Johnsen](http://www.idyrøy.no/ "Stein Ivar Johnsen")
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations
* Updated description and FAQ
* Improvement: less verbose error if no cURL error
* New feature: use short URL, see [the FAQ](http://wordpress.org/extend/plugins/add-link-to-facebook/faq/ "FAQ") for setup instructions

= 0.31 =
* Bugfix: enable menu for new installations

= 0.30 =
* More informative cURL error messages
* Improvement: extended debug information
* Solved some PHP notices

= 0.29 =
* Added Italian (it\_IT) translation by [Gianni](http://gidibao.net/ "Gianni")
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations
* Moved language files to sub-folder
* Updated description
* Hardened security
* Reorganized source code
* Improvement: notices only with minimum capability
* Improvement: post list column only with minimum capability
* Improvement: post meta box only with minimum capability
* Improvement: using current user for debug info form
* Improvement: post meta box disabled if link added

= 0.28 =
* New feature: first attached image as link picture
* Updated description
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations

= 0.27 =
* Improvement: extended debug information
* Improvement: option to e-mail debug information
* Improvement: move debug information to resources
* Improvement: removed re-authorize on change page
* Updated FAQ

= 0.26 =
* Improvement: styling of post meta box
* Improvement: displaying posts with errors
* Improvement: always showing post meta box
* Improvement: change page and post as owner: re-authorize
* Improvement: check if page still exists
* Bug fix: request manage pages permission if needed
* Updated description and FAQ
* Added Afrikaans (afr\_AFR) translation by [Jeremy](http://www.primeimage.co.za/ "Jeremy")

= 0.25 =
* Improvement: workaround for Internet Explorer authorization problem

= 0.24 =
* Improvement: changed detecting Facebook redirect
* Improvement: check if theme supports featured images
* Improvement: extended debug option
* Updated FAQ
* Added Norwegian (nb\_NO) translation by [Stein Ivar Johnsen](http://www.idyrøy.no/ "Stein Ivar Johnsen")

= 0.23 =
* New feature: image select in post meta box
* Improvement: init authorization through plugin
* Improvement: using *wp_redirect*
* Improvement: extended debug information
* Bugfix: only calling *get_post_thumbnail_id* if supported
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations

= 0.22 =
* Improvement: better Facebook referrer check

= 0.21 =
* Improvement: check for connectivity
* Updated FAQ
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations

= 0.20 =
* Improvement: WordPress logo if no featured or custom image
* Improvement: moved authorization to top of page
* Improvement: authorization only possible after configuration
* Added debug option *Do not use cURL*
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations

= 0.19 =
* New feature: column in post list
* Change: reduced request time-out to 30 seconds
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations
* Updated FAQ

= 0.18 =
* New feature: use excerpt as message
* Improvement: extended debug option
* Added screen shot
* Updated description and FAQ
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations
* Removed blog/site URI workaround

= 0.17 =
* Workaround: blog/site URI

= 0.16 =
* Improvement: better error handling

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
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations
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
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations

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
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations

= 0.6 =
* New feature: user settings for donated and clean options
* Admin notices jump to anchors
* Updated FAQ
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations

= 0.5 =
* New feature: add links to page
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations

= 0.4 =
* New feature: support for remote publishing via XML-RPC
* Bugfix: domains with path, including networks with sub-directories install
* Bugfix: activation hook
* Bugfix: some PHP notices
* Updated description and FAQ

= 0.3 =
* Added Dutch (nl\_NL) and Flemish (nl\_BE) translations
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

= 0.57 =
New feature: Share with all users on site, improvements, translation

= 0.56 =
New features, translations

= 0.55 =
New feature: display likers below post text, translations

= 0.54 =
Integration improved, updated translation

= 0.53 =
Better styling of admin area

= 0.52 =
New feature: add links to group pages

= 0.51 =
New feature: integrate Facebook likes (beta)

= 0.50 =
New feature: trailer texts like *Read more*

= 0.49 =
Small improvements

= 0.48 =
Small improvements

= 0.47 =
Translation

= 0.46 =
Small improvement, bugfix, translation update

= 0.45 =
Disabled shared application beta

= 0.44 =
New feature: link picture: first image in the post, bugfix

= 0.43 =
New feature: support for keeping hyperlinks

= 0.42 =
New feature: support for future posts

= 0.41 =
Usability

= 0.40 =
Caching

= 0.39 =
New feature: really simple setup, translation, bugfix

= 0.38 =
Bugfix

= 0.37 =
Bugfix, translations

= 0.36 =
Bugfix, improvements

= 0.35 =
New feature: integrate comments from Facebook, improvements, bugfix

= 0.34 =
New feature: select number of sentences to use

= 0.33 =
New feature: delete existing Facebook link

= 0.32 =
New feature: use short URL, translations

= 0.31 =
Bugfix: enable menu for new installations

= 0.30 =
More informative cURL error messages

= 0.29 =
Translation, security, usability

= 0.28 =
New feature: first attached image as link picture

= 0.27 =
Option to e-mail debug information

= 0.26 =
Translation, style, display more errors, bugfix

= 0.25 =
Compatibility

= 0.24 =
Translation, compatibility

= 0.23 =
Image select in post meta box, compatibility

= 0.22 =
Compatibility

= 0.21 =
Check for connectivity

= 0.20 =
WordPress logo if no featured or custom image

= 0.19 =
New feature: column in post list

= 0.18 =
New feature: use excerpt as message

= 0.17 =
Fix for blog/site URI

= 0.16 =
Better error handling

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
Added Dutch and Flemish translations

= 0.2 =
Bugfixes

= 0.1 =
Initial version

== Planned features ==

* Support for fixed custom texts like 'Read more ...'

== Facebook Authorization ==

*Private Facebook application*: [server-side flow](http://developers.facebook.com/docs/authentication/ "Authentication")

* Authorize button posts to server
* Server checks for Facebook error when [safe mode](http://php.net/manual/en/features.safe-mode.php "safe mode") off (1)
* Server redirects to Facebook or to self when error
* Facebook login (if needed)
* Facebook authorization (if needed)
* Facebook redirects to plugin
* Plugin stores Facebook access token

**The shared Facebook application is not available anymore**

*Shared Facebook application*: [client-side flow](http://developers.facebook.com/docs/authentication/ "Authentication")

* Authorize button posts to server
* Server checks for Facebook error when [safe mode](http://php.net/manual/en/features.safe-mode.php "safe mode") off (1)
* Server redirects to Facebook or to self when error
* Facebook login (if needed)
* Facebook authorization (if needed)
* Facebook redirects to [wp-al2fb service](http://wp-al2fb.appspot.com/ "wp-al2fb")
* wp-al2fb redirects to self with JavaScript (2)
* wp-al2fb checks authorization secret with plugin (3)
* wp-al2fb redirects to plugin
* Plugin stores Facebook access token

1. Workaround for Microsoft Internet Explorer
1. To transform the [URI fragment](http://en.wikipedia.org/wiki/Fragment_identifier "URI fragment") into a [query string](http://en.wikipedia.org/wiki/Query_string "Query string")
1. To prevent using the service as redirection service

== Acknowledgments ==

This plugin uses:

* [jQuery JavaScript Library](http://jquery.com/ "jQuery") published under both the GNU General Public License and MIT License
