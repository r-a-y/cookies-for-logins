Cookies For Logins and BuddyPress
=================================

A companion addon to the popular [Cookies for Comments](http://wordpress.org/plugins/cookies-for-comments/) plugin by Donncha O Caoimh for the WordPress CMS.

This plugin sets a cookie that must exist in order to login or to register in [BuddyPress](http://buddypress.org).  If the cookie does not exist, the login or registration will not be allowed.

How to use?
- 
* Make sure the [Cookies for Comments](http://wordpress.org/plugins/cookies-for-comments/) plugin is already activated and installed on your WordPress site.
* Download, install and activate this plugin.
* That's it!

Advanced usage
-
Block login attempts via .htacess with these rules:

*Change XXXXX to the cookie string as listed on the Cookies for Comments admin page.

    # Login page
    # Blocking only occurs during POST submission and if our cookie does not exist
    RewriteCond %{REQUEST_METHOD} POST
    RewriteCond %{HTTP_COOKIE} !^.*XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX.*$
    RewriteRule ^wp-login.php - [F,L]


Caveats
-
* Requires cookies to be enabled by the users on your site.


Version
-
0.1 - Pre-release


License
-
GPLv2 or later.
