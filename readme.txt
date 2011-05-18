=== Add Link to Facebook ===
Contributors: Marcel Bokhorst, M66B
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=AJSBB7DGNA3MJ&lc=US&item_name=Add%20Link%20to%20Facebook%20WordPress%20Plugin&item_number=Marcel%20Bokhorst&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted
Tags: post, posts, Facebook, social, link, links, permalink, wpmu, admin, comment, comments, shortcode, sidebar, widget
Requires at least: 3.0
Tested up to: 3.1.1
Stable tag: 1.47

Automatically add links to published posts or pages to your Facebook wall, pages or groups and more

== Description ==

Automatically add links to posts or pages that are being published to your Facebook wall, pages or groups. Simple one time setup and forget. The way links appear on Facebook can be customized. This plugin comes with full support.

The link title will be the post title. The link description will be the excerpt, or part of the post text if there is none.
It is possible to configure a link image (WordPress icon, first image in the media library or in the text, featured image or custom image) or you can let Facebook select one automatically.
It is possible to exclude individual post links from being added to your wall, pages or groups by ticking a check box just above the publish button.

[Setup guide](http://wordpress.org/extend/plugins/add-link-to-facebook/other_notes/ "Setup guide")

There is support for multi-user and network sites and shortcodes will be processed.
It works for remote publishing too, for example from [Android](http://android.wordpress.org/ "Android") or [iOS](http://ios.wordpress.org/ "iOS") (iPhone, iPad) powered devices
or using [Window Live Writer](http://explore.live.com/windows-live-writer "Window Live Writer")
or from Linux using [BloGTK](http://blogtk.jayreding.com/ "BloGTK") or [Blogilo](http://blogilo.gnufolks.org/ "Blogilo").

**Additional features:**

* Show the names of the people who liked your post on Facebook below the post text
* Show the standard [Facebook like button](http://developers.facebook.com/docs/reference/plugins/like/ "Facebook like button"); this button is not connected to added links
* Show the standard [Facebook send button](http://developers.facebook.com/docs/reference/plugins/send/ "Facebook send button"); this button is not connected to added links
* Support for the [Open Graph protocol](http://developers.facebook.com/docs/opengraph/ "Open Graph protocol")
* Shortcodes and template tags for liker names, like button and send button
* Integrate Facebook comments and likes on added links into Wordpress

**Beta features:**

* Add *Share* link, thanks to [Micha](http://www.styloweb.de/ "Micha")!
* Post WordPress comments back to Facebook
* Copy Facebook comments to the WordPress database (for archiving, editing, replying, etc)
* Sidebar widget for like/send button

If you find this plugin useful, please rate it accordingly.
If you rate this plugin low, please [let me know why](http://blog.bokhorst.biz/contact/ "Marcel Bokhorst").
Please report any issue you have with this plugin in the [support forum](http://forum.bokhorst.biz/add-link-to-facebook/ "Marcel's weblog - forum"), so I can at least try to fix it.
Solutions to common problems are described in [the FAQ](http://wordpress.org/extend/plugins/add-link-to-facebook/faq/ "FAQ").

**This plugin requires PHP 5 and WordPress 3.0 or better**

Translations are welcome, see [the FAQ](http://wordpress.org/extend/plugins/add-link-to-facebook/faq/ "FAQ") for instructions.

* English (en\_US), built-in, corrections are welcome
* Dutch (nl\_NL) by [Marcel](http://blog.bokhorst.biz/about/ "Marcel Bokhorst") and [Satyamo](http://www.satyamo.nl/ "Satyamo"), thanks!
* Flemish (nl\_BE) by [Marcel](http://blog.bokhorst.biz/about/ "Marcel Bokhorst") and [Satyamo](http://www.satyamo.nl/ "Satyamo"), thanks!
* Norwegian (nb\_NO) by [Stein Ivar Johnsen](http://www.idyrøy.no/ "Stein Ivar Johnsen"), thanks!
* Afrikaans (afr\_AFR) by [Jeremy](http://www.primeimage.co.za/ "Jeremy"), thanks!
* Italian (it\_IT) by [Gianni](http://gidibao.net/ "Gianni"), thanks!
* Turkish (tr\_TR) by [laztrix](http://www.diviksfilm.com/blog "laztrix"), thanks!
* German (de\_DE) by [Dirk Exner](http://www.ping-pongline.de/ "Dirk Exner"), [Björn](http://cooleisbaer.co.funpic.de/ "Björn"), [Micha](http://www.styloweb.de/ "Micha"), [Till Grzegorczyk](http://www.formpix.com "Till Grzegorczyk") and [Wolfgang Tischer](http://www.literaturcafe.de "Wolfgang Tischer"), thanks!
* Polish (pl\_PL) by [tomi0011](http://blog.coszsieciami.cba.pl/ "tomi0011"), thanks!
* Hungarian (hu\_HU) by [Pitty](http://www.pittyphoto.hu/ "Pitty"), thanks!
* Russian (ru\_RU) by *Lurii* and [Pavel](http://jack.kiev.ua "Pavel"), thanks!
* French (fr\_FR) by [Alberto](http://www.wowbelgium.be/ "Alberto"), thanks!
* Vietnamese (vi\_VN) by [Crazywolfdl](http://mydalat.com "Crazywolfdl"), thanks!
* Your translation ...

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

Continue to the [Setup guide](http://wordpress.org/extend/plugins/add-link-to-facebook/other_notes/ "Setup guide").

== Frequently Asked Questions ==

**Warning: if you delete your Facebook application, you will also delete the links it added!**

**--- Usability ---**

= U01 What is a caption, message, etc? =

Take a look at [the screen shot](http://wordpress.org/extend/plugins/add-link-to-facebook/screenshots/ "Screen shot") to get an idea of what is what.

The plugin will use the excerpt if available, else the post text and will use it as description.
The option *Use excerpt as message* will move the excerpt to the message at top and the post text will be used as description at the bottom.
If you specify a *Text trailer* the text will be truncated and the text trailer (for example *Read more ...*) will be used as last words (no link).
If you clear the text trailer, Facebook will show *See more* and if you click on it, see can see the whole post on Facebook.

= U02 Why is the option 'Featured post image' grayed out? =

Because your current WordPress theme doesn't support featured images.

= U03 How can I display featured images as Facebook link pictures? =

1. Configure the plugin to use featured images
1. Select a featured image in the WordPress post screen

A few notes:

* Not all Wordpress themes support featured images
* You have to select a featured image before published a post
* If there is no featured image set, the WordPress icon will be used

As an alternate to feature images, you can use the Add Link to Facebook post meta box (since version 0.23).
In this box you can select one of the images attached to the post.
Selecting an image this way takes precedence over the other settings.

= U04 To which wall will a link be added? =

Always to the wall of the post author, if configured.
Even if somebody else is editing the post.

= U05 Which link picture will Facebook select? =

Mostly the first picture in the post, but it depends on the theme and layout of your website.
It also depends on support for the [Open Graph protocol](http://developers.facebook.com/docs/opengraph/ "Open Graph protocol") by your theme.
Since version 0.56 you can enable the Open Graph protocol using the plugin settings.

= U06 Why doesn't Facebook display my link picture? =

Maybe because it is smaller than 50 x 50 pixels.
Facebook might also have had trouble accessing the image.

= U07 I don't want a link picture =

Facebook doesn't support this as far as I know,
but you could let the custom link picture point to a valid but non existing address.

= U08 What happens when I update a post? =

If the link to the post was added already to your wall, page or group, nothing,
else a new link will be added. See also the next question.

= U09 How can I add a link to an existing post? =

Change the post status temporarily to draft, update the post and publish the post again.
If you want to add a link again, you should remove the custom field *al2fb_facebook_link_id* first.

= U10 Will links for future posts be added? =

Yes, when they are published automatically a link will be added to your wall, page or group too.

= U11 How about private / password protected posts? =

Don't worry, no links to private posts will be added.

= U12 I want to add links to my fan/community/business page =

This option is only available *after* you have authorized, since information from Facebook needs to be fetched.

Just go to the plugin settings through the WordPress *Tools* menu and
select the page you want the links to be added to using the option *Add to page*.
Maybe you want to check the option *Add as page owner* too.
If you do that, you have to re-authorize one time more, because an extra Facebook permission is required for that.
Note that pages and groups exclude each other.

= U13 I want to add links to a group =

This option is only available *after* you have authorized, since information from Facebook needs to be fetched.

Just go to the plugin settings through the WordPress *Tools* menu and check *Use groups*.
You have to re-authorize one time more now, because an extra Facebook permission is required to access groups.
After you have done that, you can select the group to add links to.
Note that pages and groups exclude each other.

= U14 How can I use hyperlinks on Facebook? =

Since Facebook doesn't accept HTML, all HTML is stripped from the post text and excerpt before adding a link to Facebook.
This means that hyperlinks are stripped too. The hyperlink texts are preserved, however.
If you want to keep hyperlinks, check the option *Keep hyperlinks*.
The consequence is that the hyperlink texts will be stripped.
So you have to choose if you want the hyperlink text (the default) or the hyperlink itself.

= U15 How can I use short URL's as Facebook link? =

* Install and configure an URL shortener plugin
* [URL Shortener](http://wordpress.org/extend/plugins/url-shortener/ "URL Shortener") is known to work
* Any short URL plugin that supports the filter *pre_get_shortlink* or *get_shortlink* will work
* Enable the option *Use short URL* (available since version 0.32)
* You probably want to enable the option *Use site title as caption* too

= U16 I don't like the gear wheel application icon =

If you use a private Facebook application, you can change it in the application settings.
The application icon of the shared application cannot be changed.

= U17 Why is the option "add 'Share' link" experimental? =

For two reasons:

1. The Facebook interface for this feature is undocumented
2. Sharing works, but Facebook doesn't handle it correctly ([discussion](http://forum.developers.facebook.net/viewtopic.php?id=50049), [bug report](http://bugs.developers.facebook.net/show_bug.cgi?id=9075))

= U18 How can I translate the plugin? =

You can use the [Dutch translation](http://plugins.svn.wordpress.org/add-link-to-facebook/trunk/language/add-link-to-facebook-nl_NL.po "Dutch") as a start.
After saving the file, you can translate it by using a text editor or [Poedit](http://www.poedit.net/ "Poedit").
[See here](http://drupal.org/node/17564 "Poedit plural forms") for details on plural forms.
Another way is to install and use the [Codestyling Localization](http://wordpress.org/extend/plugins/codestyling-localization/ "Codestyling Localization") plugin.
Please use the [contact form](http://blog.bokhorst.biz/contact/ "Marcel Bokhorst") to send me the new .po file.

= U19 How can I change the styling? =

1. Copy *add-link-to-facebook.css* to your upload directory to prevent it from being overwritten by an update
2. Change the style sheet to your wishes; the style sheet contains documentation

= U20 How can I setup one wall for all users? =

An administrator can setup his wall (personal/page/group) for all users of one site by checking the option *Share with all users on this site*.
The other users cannot configure their own wall amymore if this option is used.
Only the same administrator can undo this.

= U21 I don't see a link to my post on Facebook =

Assuming that you have configured and authorize the plugin, you can check this:

* Is the wall of the *post author* configured? See also question U4 and U20.
* Has the *post author* the configured minimum capability? (default *edit_posts*)
* Is *Do not add link to Facebook* un-checked?
* Is the post password protected? See also question U11.
* Was the post published before using the plugin? See also question U09.
* Was there already a link added? See also question U09.
* Did you check the *Most Recent* link on Facebook?
* Are you logged into the correct Facebook account?
* Are you looking at the correct personal/page/group wall?
* If you are publishing to a page: check the Facebook tab *Others*. See also question U12.

= U22 Where are the settings of the plugin? =

In the WordPress menu *Tools*.
Note that if you checked the option *Share with all users on this site*, only the adminstrator that checked this option can access the settings.

= U23 How can I use the shortcodes? =

Just put one of the shortcodes below in your post or page text.

To show liker names:

* [al2fb_likers]
* [al2fb_likers post_id="123"]

To show a like button:

* [al2fb_like_button]
* [al2fb_like_button post_id="123"]

To show a send button:

* [al2fb_send_button]
* [al2fb_send_button post_id="123"]

= U24 How can I use the template tags? =

Put one of these lines somewhere in your theme:

* if (function_exists('al2fb_likers')) al2fb_likers();
* if (function_exists('al2fb_likers')) al2fb_likers(123);
* if (function_exists('al2fb_like_button')) al2fb_like_button();
* if (function_exists('al2fb_like_button')) al2fb_like_button(123);
* if (function_exists('al2fb_send_button')) al2fb_send_button();
* if (function_exists('al2fb_send_button')) al2fb_send_button(123);

= U25 Can I add links to multiple walls? =

One WordPress user can only add links to one wall OR one page OR one group, even if that user happens to have multiple sites (which is possible within a network site).
Adding the same link to more than one wall may lead to difficulties with Facebook as this can be seen as spam.
It may also be a violation of the [Facebook Platform Policies](http://developers.facebook.com/policy/ "Facebook Platform Policies").

**--- Security ---**

= X01 Which users can use this plugin? =

Users with the *edit_posts* capability: all user roles, except subscriber.
Since version 0.11 administrators can change this using the setting *Required capability to use plugin*.

= X02 Why is the shared application less secure? =

**The shared application is no longer available**

Because the Facebook authorization token is sent to you via a [Google App Engine application](http://code.google.com/appengine/ "Google App Engine application") that I manage.
I theory I could collect your token and manipulate your Facebook wall.
You are free to inspect [the source code](http://wp-al2fb.appspot.com/?source=true "wp-al2fb") of this application.

**--- Compatibility ---**

= C01 Is this plugin compatible with my theme? =

Most likely yes, but featured images can only be used as link picture when your theme supports this.

This plugin is known to be incompatible with:

* [Geo Places](http://templatic.com/news/geo-places-city-directory-wordpress-theme "Geo Places"): publishing from the front-end doesn't add links

= C02 Is this plugin compatible with plugin xxx? =

Probably yes, but it all depends on how the plugin works.

Auto posting plugins will work if one of the following actions is used:

* <em>transition_post_status</em>
* <em>xmlrpc_publish_post</em>
* <em>app_publish_post</em>
* <em>al2fb_publish</em>

This plugin is known to be incompatible with:

* Maybe [WP Robot](http://wprobot.net/ "WP Robot"): links will not be added
* Maybe [FeedWordPress](http://feedwordpress.radgeek.com/ "FeedWordPress"): no links are added for syndicated posts
* [WP-FB-AutoConnect](http://wordpress.org/extend/plugins/wp-fb-autoconnect/ "WP-FB-AutoConnect")

= C03 Are shortcodes being processed? =

Yes, both in the excerpt and the post text.

= C04 Are multi-user and network sites supported? =

Yes, each user can configure his/her own wall or page or group.
See also question U25.

= C05 Is remote publishing supported? =

Yes, via both [XML-RPC](http://en.wikipedia.org/wiki/XML-RPC "XML-RPC") and the [Atom Publishing Protocol](http://en.wikipedia.org/wiki/Atom_%28standard%29 "Atom").
So you can use for example an [Android](http://android.wordpress.org/ "Android") or [iOS](http://ios.wordpress.org/ "iOS") powered device (XML-RPC)
or [Window Live Writer](http://explore.live.com/windows-live-writer "Window Live Writer") (Atom)
or [BloGTK](http://blogtk.jayreding.com/ "BloGTK") or [Blogilo](http://blogilo.gnufolks.org/ "Blogilo") for Linux
to publish posts and still have links added to your wall or page automatically.
Don't forget to enable remote publishing using the WordPress menu *Settings > Writing*.

= C06 Are custom post types supported? =

Yes, but the custom post type should support custom values for it to work.

**--- Custom values ---**

= V01 What is the custom field 'al2fb_facebook_link_id' for? =

This is the Facebook identification of the added link.

= V02 What is the custom field 'al2fb_facebook_link_time' for? =

This is the time (UTC) the link was added to Facebook or the time of the last error.

= V03 What is the custom field 'al2fb_facebook_link_picture' for? =

This is the picture type and URL of the link as added to Facebook.

= V04 What is the custom field 'al2fb_facebook_exclude' for? =

This is to remember you ticked the check box *Do not add link to Facebook*.

= V05 What is the custom field 'al2fb_facebook_image_id' for? =

This is to remember the image you have selected as link picture.

= V06 What is the custom field 'al2fb_facebook_error' for? =

If something goes wrong when adding a link to your wall or page, the error message is stored in this field.
You can try to add the link again by updating the post.
Please send me the message and follow the instruction in the last question.

= V07 What is the custom field 'al2fb_facebook_nolike' for? =

This field indicates that the like button shouldn't be show for the post or page.

= V08 What is the custom field 'c_al2fb_meta_excerpt' for? =

This fields holds the custom excerpt that will be used in stead of the WordPress excerpt.

**--- Error messages ---**

= E01 I get 'Error validating application' =

You have probably entered a wrong *App ID* or the Facebook application may be deleted.
If you didn't create a Facebook application yet, you should follow the instructions in the yellow box on the plugin page.

Facebook disabled the shared application, because, according to Facebook,
it didn't conform to the [Facebook Platform Policies](http://developers.facebook.com/policy/ "Facebook Platform Policies").
If you had chosen for this (beta) configuration option, you will now see the message *Error validating application*.
Unfortunately there is not much I can do about it. You can still use the plugin, but you have to create a private application now.

= E02 I get 'Error validating client secret' =

You have probably entered a wrong *App Secret*.

= E03 I get 'Given URL is not allowed by the Application configuration' =

You have probably entered a wrong URL in the Facebook application setting *Web Site > Site URL*.

Assuming you created a Facebook application successfully:

* Go to the plugin page through the WordPress *Tools* menu
* Copy the link after *Web Site > Site URL:*
* Click on the *Click here to create* link
* Do not fill anything in, but instead click on the *Back to My Apps* link
* Click on the *Edit Settings* link and select the tab *Web Site*
* Paste into the field *Site URL* and press *Save Changes*

Now try to authorize again.

= E04 I get 'The user hasn't authorized the application to perform this action' =

You have probably revoked one of the permissions of the Facebook application.
If you did this by accident, you can simply re-authorize the plugin.
If you did this deliberately, you should remove the *App ID* and *App Secret* from the plugin settings.
If you are the only user of the website, you can also disable the plugin.

= E05 I get 'Invalid access token signature' =

You have probably reset the *App Secret*. You should re-enter it.

= E06 I get 'Error validating verification code' =

You have probably deleted the Facebook application.
You should delete the *App ID* and *App Secret* from the plugin settings and create a new Facebook application.
This should not happen if you didn't delete the application.
In that case please send me the debug information, see the last question for instructions.

= E07 I get 'This API call requires a valid app_id' =

You could try to re-authorize to fix this, but it should not happen.
Please send me the debug information, see the last question for instructions.

= E08 I get 'An active access token must be used to query information about the current user' =

If you keep getting this error after upgrading to the latest version, please report it and send me the debug information (see the last question for instructions).

= E09 I get 'Invalid access token signature' =

You have probably entered an access token manually, but incomplete or with extra characters.

= E10 I get 'Your server may not allow external connections' =

This means the PHP setting [allow_url_fopen](http://www.php.net/manual/en/filesystem.configuration.php#ini.allow-url-fopen "allow_url_fopen") is disabled
and that [cURL](http://php.net/manual/en/book.curl.php "cURL") is not available too. You may have to ask your hosting provider to enable at least one of the two.

= E11 I get 'cURL error ...' =

Please help me to find out the cause by sending me the debug information, see the last question for instructions.
You can find the cURL error codes on the [libcurl error page](http://curl.haxx.se/libcurl/c/libcurl-errors.html "libcurl-errors.3 -- man page").

cURL errors encountered so far:

* Error 1: *The URL you passed to libcurl used a protocol that this libcurl does not support*: the hosting server may not support secure connections (https)
* Error 6: *Couldn’t resolve host*: the DNS of the hosting server may not work correct
* Error 7: *Failed to connect() to host or proxy*: the hosting server is probably not allowing connections to the internet
* Error 60: *Peer certificate cannot be authenticated with known CA certificates*: the security certificates on the hosting server could be missing or outdated
* Error 77: *Problem with reading the SSL CA cert*: the certificate files on the hosting server are not accessible or missing

For above cURL errors you need to contact your hosting provider.

Error 60: try enabling the option *Do not verify the peer's certificate* (since version 1.2).

= E12 I get 'HTTP 400 Bad Request' =

You are probably using Microsoft Internet Explorer.
This browser has the bad habit not to display the content
when there is an [HTTP](http://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol "HTTP") error.
Actually you are most probably having one of the above errors, but you cannot see which one.
You can switch to [Mozilla Firefox](http://www.mozilla.com/ "Mozilla Firefox") or
if you don't want that you can [send me](http://blog.bokhorst.biz/contact/ "Marcel Bokhorst") the address in the address bar.

= E13 I get 'Javascript not enabled' =

You can only authorize with the shared application if [JavaScript](http://en.wikipedia.org/wiki/JavaScript "JavaScript") in your browser is enabled.
You can either enable JavaScript or try to use a private Facebook application.

= E14 I get '(#100) Invalid parameter' =

You may have deleted a link on Facebook that was added by the plugin and also tried to delete it using the plugin.
Go to the post with the error, enabled *Custom fields* with the *Screen Options* in the upper right corner if needed,
now scroll down to the *Custom Fields* section and delete the values starting with *al2fb_* to remove the error.
Since version 1.32 of the plugin, you can use the *Clear error messages* checkbox.

= E15 I get 'Error validating access token' =

The access token the plugin acquired during the authorization process may be revoked.
Maybe because there was a security problem with your Facebook application or Facebook account.
Re-authorizing will probably solve this problem. If you know why you got this error,
please leave a message on the [support forum](http://forum.bokhorst.biz/add-link-to-facebook/ "Marcel's weblog - forum").
You could also try to reset your application secret [here](http://www.facebook.com/developers/apps.php) and enter the new secret in the plugin settings.

= E16 I get 'You failed to provide a valid list of administators' =

This message occurs when clicking on the like button.
The like button probably points to a page without Open Graph Protocol meta tags.
If you didn't enable the Open Graph Protocol try to enable it.
If you have set the option *Link to*, make sure this page has Open Graph Protocol meta tags.
If this option is not set (the default) the like button points to the post or page.
Note that the plugin cannot create the meta tags for pages with more than one post (for example the home page, categories and archives).
The plugin is only able to determine the correct Facebook application for posts and pages, because it needs to know an author for this.
You can use the [URL Linter](http://developers.facebook.com/tools/lint/ "URL Linter") to see if there are valid meta tags.

= E17 I get 'Error finding the requested story' ==

The plugin tried to add a WordPress comment to an added link on Facebook, but the link does not exist anymore.
To prevent this message in the future, you should delete the link from WordPress too.
While deleting, you will probably get the error described in question E14 too.

**--- Support ---**

= S01 Where can I ask questions, report bugs and request features? =

You can open a topic in the [support forum](http://forum.bokhorst.biz/add-link-to-facebook/ "Marcel's weblog - forum").

= S02 How can I send the debug information? =

Please go to the plugin page (via the *Tools* menu) and click on the link *Debug information* in the *Resources* panel.
Optionally fill in your name and describe the problem as accurate as possible and press the *Send* button.

== Screenshots ==

1. Added Link on Facebook

== Changelog ==

= 1.48 =
* Updated Norwegian (nb\_NO) translation by [Stein Ivar Johnsen](http://www.idyrøy.no/ "Stein Ivar Johnsen")

= 1.47 =
* Bugfix: link liker names to profile

= 1.46 =
* New feature: link imported comments to discussion on Facebook, thanks to [Wolfgang Tischer](http://www.literaturcafe.de "Wolfgang Tischer")
* Updated [User Guide](http://wordpress.org/extend/plugins/add-link-to-facebook/other_notes/ "User Guide")
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations
* Updated German (de\_DE) translation by [Wolfgang Tischer](http://www.literaturcafe.de "Wolfgang Tischer")

= 1.45 =
* Improvement: option to override WordPress [locale](http://en.wikipedia.org/wiki/Locale "locale")
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations
* Updated German (de\_DE) translation by [Wolfgang Tischer](http://www.literaturcafe.de "Wolfgang Tischer")

= 1.44 =
* Improvement: disable OGP on home page if no user has enabled it

= 1.43 =
* Added a [User Guide](http://wordpress.org/extend/plugins/add-link-to-facebook/other_notes/ "User Guide"), feedback welcome!
* Updated Norwegian (nb\_NO) translation by [Stein Ivar Johnsen](http://www.idyrøy.no/ "Stein Ivar Johnsen")

= 1.42 =
* Changed Facebook application creation link
* Updated Dutch (nl\_NL) and Flemish (nl\_BE) translations
* Updated Norwegian (nb\_NO) translation by [Stein Ivar Johnsen](http://www.idyrøy.no/ "Stein Ivar Johnsen")

= 1.41 =
* Improvement: added exception handler to widget
* Improvement: some source code organization

= 1.40 =
* Updated FAQ
* Improvement: remove style elements from texts
* Improvement: remove multi-line scripts from texts
* Bugfix: save check box state for custom post types

= Older versions =
* Deleted, because of maximum readme.txt size
* Newer versions are always compatible with older versions

== Upgrade Notice ==

= 1.47 =
One bugfix

= 1.46 =
One improvement, translation updates

= 1.45 =
One improvement, translation updates

= 1.44 =
One improvement

= 1.43 =
Added User Guide, translation update

= 1.42 =
One change, translation updates

= 1.41 =
One improvement

= 1.40 =
Two improvements, one bugfix

== Setup guide ==

The setup of the plugin should be fairly self-explanatory.
Basically there are five steps to follow:

1. Click on the link *Click here to create* in the yellow box on the settings page
2. Create the Facebook application:
	* Give it any name you like (will appear as *via* below the added links)
	* Fill in the URL which the plugin indicates in the yellow box on the tab *Website* in the field *Site URL*
	* Press the *Save Changes* button
3. Copy the *App ID* and *App Secret* from Facebook to the appropriate fields in the plugin
4. Press the *Save* button to save the configuration
5. Press the *Authorize* button to allow the plugin to add links to Facebook

Note that you don't have to submit the Facebook application to the *App Directory* to use it.

Some people need to verify their account before they can create an application.
If you want to use your mobile phone number, take care that the phone number is correct.
When it was wrong, you have to wait more than a week before you can try again.

If you are having a problem, you can probably find the solution in [the FAQ](http://wordpress.org/extend/plugins/add-link-to-facebook/faq/ "FAQ").
If you need help, don't hesitate to leave a message on the [support forum](http://forum.bokhorst.biz/add-link-to-facebook/ "Marcel's weblog - forum").

== User Guide ==

**Easy setup**

Everybody has to start here. Just follow the short instruction on the setup page or the setup guide above.
The first goal is the acquire the following two values from Facebook:

* App ID
* App Secret

After entering these values you should authorize the plugin.
The plugin will use the App ID and Secret to obtain an access token, which is required to access your Facebook wall.

Common problems:

* To create an application you have to verify your account
* Error *Given URL is not allowed by the Application configuration*: see question E03 of [the FAQ](http://wordpress.org/extend/plugins/add-link-to-facebook/faq/ "FAQ")

For administrators (capability *manage\_options*) there is one option in this section:

* Share with all users on this site

The default is that each user of your weblog has to setup/authorize the plugin.
If you check this option all users will use your access token.
After checking this option the setup page of the plugin will be accessible only to the administrator that enabled this option.
Note that all users will use your name, which might not be so bad if you use the option *Add as page owner* (see below).

**Additional settings**

*Link picture*

Links on Facebook can have a link picture, which is displayed between your Facebook profile picture and the link text(s).
The plugin offers several options to automatically select a picture:

* WordPress logo: the default, unless *Default picture URL* is filled in
* First attached image: the image which was first uploaded on the post page
* Featured post image: for themes that support a featured image only
* Let Facebook select: this often doesn't work as you want to, because Facebook can select for example a header image
* First image in the post: similar to first attached image, but the image doesn't have to be associated with the post
* Image from the [User Photo](http://wordpress.org/extend/plugins/user-photo/ "User Photo") plugin
* Custom picture below: complete URL to a static picture of your choice

Most users probably want to use *First image in the post*.
This is also the best option for users that use remote publishing.

Note that the default picture is used if no link picture could be found,
for example if there was no featured post image selected or when there was no picture in the post.

No picture at all is not officially supported by Facebook, but you can try to use an invalid custom picture.

*Pages and groups*

The plugin can add a link to a page or group wall of your choice.
The plugin will always add only one link, see question U25 of [the FAQ](http://wordpress.org/extend/plugins/add-link-to-facebook/faq/ "FAQ").
Just check what you want, page or group, press *Save* and select the page or group you want to add links to.
For pages it is possible to add links as page owner, instead of with your personal account.
For groups this is not possible, since Facebook doesn't support it.

*Link appearance*

Some visual aspects of added links can be controlled, but most of the layout is entirely determined by Facebook.
The plugin will strip all markup, since Facebook doesn't allow it.

To better understand some of the options take a look at [the screen shot](http://wordpress.org/extend/plugins/add-link-to-facebook/screenshots/ "Screen shot") to see what is what.

* Use site title as caption: replace the URL by your blog title (shown below the option)
* Use excerpt as message: by default there is no message, but if you like you can use the standard WordPress excerpt (if any)
* Text trailer: if you use this option, the text will be truncated (whole sentences) and the text trailer will be appended
* Keep hyperlinks: by default hyperlinks are stripped, leaving the title (if any), this options reverses that
* Add 'Share' link: this option is experimental, because it is not officially supported by Facebook (it is not documented)
* Use short URL: see question U15 of [the FAQ](http://wordpress.org/extend/plugins/add-link-to-facebook/faq/ "FAQ") for details
* Add links for new pages: by default only links will be added for new posts, check this option if you want the same for new pages

If you don't use a trailer text, the complete post/page text will be sent to Facebook and
Facebook will truncate the text and display *Read more*, which when clicked will reveal the complete text.

*Comments and likes*

* Integrate comments from Facebook: show Facebook comments in WordPress
* Post WordPress comments back to Facebook: show WordPress comments on Facebook
* Copy comments from Facebook to WordPress: store Facebook comments in the WordPress database, so you can for example edit them
* Integrate likes from Facebook: show Facebook links as WordPress pingbacks
* Show likers below the post text: show a comma separated list of Facebook liker names at the bottom of your post

Link Facebook comment to:

* None: no link at all, good for privacy
* Profile author: default, link to the profile page of comment author
* Added link: link to the discussion on the added link

The Facebook author name is always shown.

The plugin only mirrors comments on links it added. In summary it works like this:

* The plugin adds a link to Facebook
* Somebody writes a comment on the link on Facebook, if enabled the plugin will mirror the comment to WordPress
* Somebody writes a comment on WordPress, if enabled the plugin will mirror the comment to Facebook, using your Facebook account

You can disable comment integration for individual posts/pages by selecting *Do not integrate comments* on the post page.

*Standard Facebook buttons*

The plugin can as an extra add a standard Facebook like and/or send button to your post.
The layout is mostly determined by Facebook.
You can only control the general layout, if there will be faces, the width, the action (like or recommend), the font and color scheme.
See for details [the Facebook documentation](http://developers.facebook.com/docs/reference/plugins/like/ "Like button").

By default the buttons will be shown below your post/page text, but you can change that by checking *Show at the top of the post*.
If you want more control over the location of the buttons, you can use a shortcode or template tag.
See question U23 of [the FAQ](http://wordpress.org/extend/plugins/add-link-to-facebook/faq/ "FAQ") for details.

There are options to suppress showing the like and send button on your home page, on individual posts or pages, in archives and in categories.
It is also possible to check *Do not add like button* on the post page to suppress showing the like/send button for individual posts.

By default the like button will link to the post or page where it is shown (recommended).
It is possible to change this to a static URL with the *Link to* option. Use with care.

If you use a Facebook like button, you should enable the [Open Graph protocol](http://developers.facebook.com/docs/opengraph/ "Open Graph protocol")
(unless you use another plugin for this purpose).
Most problems with the like button do find its cause in not using the Open Graph protocol.

The Facebook like button doesn't look right for some themes.
To remedy this, you can *Use iframe in stead of XFBML*.
Please note that the like/send button combination is not supported for the iframes version.

*Other options*

If you explicitly want to select when to add, check the option *Do not add link by default*.
Alternatively you can select *Do not add link to Facebook* on the post page to prevent the plugin from adding a link.

If your post overview is already full of extra columns, you could check the option *Don't show a summary in the post list*.

I have never had a report about it, but if you have problems displaying the correct characters on Facebook, you could use the *Facebook character encoding* option to override the default character encoding (UTF-8).

When you don't want to use the plugin anymore, you can check *Clean on deactivate* before deactivating the plugin to erase all options. This doesn't erase the administrator option, however.

Checking the option *I have donated to this plugin* will remove the sponsorship messages and all the donate buttons and links.
Developing this plugin took many hours. A small donation as your appreciation is always welcome.

Please let me know if you think this plugin is good or bad by rating it.
Checking *I have rated this plugin* will remove the rating reminder message.
If you don't like the plugin, please [let me know why](http://blog.bokhorst.biz/contact/ "Marcel Bokhorst").
If the plugin isn't working for you, [help is just one question away](http://forum.bokhorst.biz/add-link-to-facebook/ "Marcel's weblog - forum").

*Administrator options*

The administrator options can only be changed by an administrator (obviously) and apply to all users.

When you are running a multi-user weblog, you probably want to check *Do not display notices* to restrict the plugin notices, mostly error messages, to the plugin setting page only.
And maybe you don't want to allow usage of the plugin to all users. This is what the option *Required capability to use plugin* is for.

When comment integration is turned on, Facebook comments are fetched every 10 minutes by default.
You can use the option *Refresh Facebook comments every* to do this more or less often, maybe depending on the number of visitors of your weblog.

The text trailer option will truncate the text to whole sentences with a maximum of 256 characters. This is the maximum number of characters Facebook will display.
For the case this changes or if your local version of Facebook behaves differently, you can use the option *Maximum Facebook text length*.

The plugin supports custom post types if the custom post type support custom values.
Sometimes you don't want to add links for certain custom post types.
That is where the option *Exclude these custom post types* is for.
Enter the names, separated by comma's for which you don't want the plugin add links.

Speaking about excluding things, maybe you don't want to add links for certain categories.
You are in luck, because you can use the option *Exclude these categories* for this.
You should use catergory id's, not names.

If your server isn't setup completely right, there could be problems making a secure link to Facebook.
In case you get cURL error 60, you can try the option *Do not verify the peer's certificate* as a workaround.
Of course this is less secure ...

== Requested features ==

In no particular order:

* Comment with Facebook login

Realized features:

* Disable Facebook yes/no column in post list (version 1.5)
* Facebook comment and like count in post list (version 1.5)
* Default *Do not add link to Facebook* option (version 1.5)
* Add link to Facebook for new pages (version 1.5)
* A choice list for *og:type*; new default: *article* (version 1.5)
* Template tag/shortcode for likers/like button (version 1.5)
* Stop showing Facebook links on posts in archives and categories (version 1.5)
* Change location of like button: option to show at top of post (version 1.5)
* Facebook comment styling (*class="facebook-comment"*) (version 1.5)
* Filters for content (*al2fb_content*) and excerpt (*al2fb_excerpt*) (version 1.5)
* Facebook comments with Avatars (version 1.6)
* Settings link in plugin list (version 1.6)
* Filter by category (version 1.6)
* Div around like button for styling purposes (version 1.8)
* New feature: remove scripts from post/page text (version 1.8)
* Get picture from the [User Photo](http://wordpress.org/extend/plugins/user-photo/ "User Photo") plugin (version 1.9)
* Exclude like button on individual pages (version 1.10)
* Custom exerpt text (version 1.14)
* Option to choose between XFBML and iframe [like button](http://developers.facebook.com/docs/reference/plugins/like/ "like button") (version 1.14)
* Option to post WordPress comments back to Facebook (version 1.21)
* Facebook send button (version 1.25)
* Disable comments integration per post/page (version 1.28)
* Copy Facebook comments into WordPress database (version 1.29)
* Option to not link to Facebook comment author (version 1.36)
* Link back to Facebook wall from comments (version 1.46)

Feature which will not be realized, sorry:

* Add link as group owner: not possible unfortunately
* Adding links to multiple walls: see FAQ, question U25
* Common wall per site/blog: see FAQ, question U25
* Link audio: too far from the core function of the plugin
* Link videos, posted via JW Player plugin: too far from the core function of the plugin
* Display only first name for Facebook comments and likers: not possible unfortunately
* Add Link with author name for multi-user sites: this can be realized by letting each user authorize with his own account
* Postback comments with 'In reply to NAME: ...': comment threading is not supported by Facebook

== Facebook Authorization ==

*Private Facebook application*: [server-side flow](http://developers.facebook.com/docs/authentication/ "Authentication")

* Authorize button posts to server
* Server checks for Facebook error when [safe mode](http://php.net/manual/en/features.safe-mode.php "safe mode") off (1)
* Server redirects to Facebook or to self when error
* Facebook login (if needed)
* Facebook authorization (if needed)
* Facebook redirects to plugin
* Plugin stores Facebook access token

*Shared Facebook application*: [client-side flow](http://developers.facebook.com/docs/authentication/ "Authentication")

**The shared Facebook application is not available anymore**

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
