=== Who Hit The Page - Hit Counter ===
Contributors: mahlamusa
Donate link: https://www.2checkout.com/checkout/purchase?sid=102959491&quantity=1&product_id=9
Author URI: http://lindeni.co.za
Plugin URI: http://whohit.co.za/
Tags: geolocation, geo location, hit counter, visit counter, visitor stats, ip statistics, statistics, ip counter, browser detector
Requires at least: 4.0
Tested up to: 5.0
Stable tag: 1.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Count the number of visitors on your wordpress site, know their IP addresses and browsers they use.

== Description ==

Lets you know who visted your pages by adding an invisible page hit counter on your website, so you know how many times a page has been visited in total and how many times each user identified by IP address has visited each page. You will also know the IP addresses of your visitors and relate the IP addresses to the country of the visitor and all browsers used by that IP/user.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the folder/directory named `who-hit-the-page` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. 
 * Place [whohit]Page name/identifier[/whohit] on the page or post you want visitors counted - e.g. place `[whohit]About Us[/whohit]`
 on your `About Us` page to see how many people visited that page.
 * Place `<?php who_hit_the_page( "Page Name" ); ?>` on your theme if you are a developer.
 * Optional: link to us by placing [whlinkback] in a wordpress page or post, or `<?php whtp_link_bank(); ?>` on your template files
4. Visit one page you placed the shortcode once and go to your wordpress admin and click on 'Who Hit The Page' on the left to see your new statistics.
5. After an update, look out for the update notice and if you see it then click on the button to update the database otherwise some functions may not function properly.

See the Arbitrary Information for more details

== Frequently Asked Questions ==

= Where do I see the visitors' statistics after installing the plugin? =

On your wordpress admin - Go to your admin and look for 'Who Hit The Page' on the main menu on the left, click on it you will see a summary of the data or click on "View All Details" under "Who Hit The Pape" to see all the raw data - also see screenshot-1.

= Do my website visitors see the page hits? =

No! Who Hit The Page -  Hit Counter is an invisible hit counter, it doesn't show visitors that they are counted, instead it helps you know about your visitors by registering their information so you will know where they are and what browser they use to view your website.

= How do I discount myself as a visitor? = 

Go to the counters page on your admin and click the "-" button corresponding to the page(s) you visited, if you have visited one page more than once, then enter the number of times you have visited the page and then click the "-" button 

= Does the plugin block denied IPs access to my site? =
No. In this plugin, denying an IP only means "Do not count this IP as a visitor", this is for IPs such as Web Spiders, Search Engine Bots or yourself - you don't have to count yourself as a visitor when you are editing your page.

= How can I block an IP address from accessing my site? = 
This plugin does not have that feature, when you add an IP to the deny list, the plugin will only ignore the IP and not count it as a Visitor

= How do I Deny my own computer's IP address? =

If you know the IP address of your own devices like Home/Work Computer, you can go to "Who Hit The Page" then "Denied IPs" and 'Enter IP address to add to deny list' and click on 'Add To Deny List' to continuously disallow the plugin to count visits from that IP address. But Make sure this is a static IP address - meaning it doesn't change over time, otherwise you will have to keep updating your denied IP list.

== Screenshots ==

1. screenshot-1.png - Shows the plugin's main menu link; the highlighted/selected menu button is what you will click on to view your website's statisitics, and there is also a link labeled "Denied IPs" this is the page for creating an IP deny list so you can restrict some IPs from being counted when visiting your website.
2. screenshot-2.png - Shows the main dasboard page of the plugin
3. screenshot-3.png - Shows pages that have been visited along with the number of visits for each page, thats the page visited and the number of hits for that page and also action buttons for resestting, deleting, or discount page visits
4. screenshot-4.png - Shows single visitor's detailed information: the ip address, total visits for that Ip address, browser used, time of first and last visit.
5. screenshot-5.png - Shows the IP deny table and a form to add a new IP address to the deny list. IPs in this list will not be counted when visiting your website.
6. screenshot-6.png - Shows denied IP addresses.

== Changelog ==

= 1.5.0 =

* Fixed: Deprecated function warning
* Fixed: Database update checks
* Updated: Removed unnecessary steps in help page
* Updated: WordPress 4.5 compatibility issues
* Updated: Get current time based on site's timezone

= 1.4.9 =

* Fixed: Database update not triggered
* Added: Option to force database update in settings page

= 1.4.8 =

* Fixed: Fatal error vendor autoload not found.
* Fixed: Undefined index page
* Fixed: Minor bugs

= 1.4.7 =

* Fix minor bugs

= 1.4.6 =

* Update: Complete code rewrite to comply with standards
* Update: WordPress 4.9.7 compatibility
* Added: Pagination for long pages
* Added: Filter for displayed results
* Added: Support for multisite subsites, now can activate per blog in multisite
* Added: Translation ready
* Added: File based database to improve lookup results
* Fix: Activation error if plugin was previously installed
* Fix: Avoid direct access to plugin files
* Fix: Load styles and scripts only where required
* Minor bug fixes

= 1.4.5 =

* Minor bug fixes

= 1.4.4 =
* Fixed mysql errors
* Compatibility with wordpress 4.7.4

= 1.4.3 =

* Fixed counter reset bug that was preventing the users to reset hit counters and IP info
* Wordpress 4.3.1 compatibility update

= 1.4.2 =

* Fixed Country count bug
* Added Country Flags
* Changed to list top 15 visiting countries instead of 5

= 1.4.1 =

* Fixed preg_match() bug
* Added detection of more browsers than before. Now the plugin can detect all of the following browsers and bots:
Amaya, Android, Bingbot, BlackBerry, Chrome, Firebird, Firefox, Galeon, Googlebot, iCab, GNU IceCat, GNU IceWeasel, Internet Explorer, Internet Explorer Mobile, Konqueror, Lynx, Mozilla, MSNBot, MSN TV, NetPositive, Netscape, Nokia Browser, OmniWeb, Opera, Opera Mini, Opera Mobile, Phoenix, Safari, Yahoo! Slurp, BlackBerry Tablet OS, W3C Validator, Yahoo! Multimedia

= 1.4.0 =


Major features for version 1.4

* Added IP Geolocation by Country - Import Geo Location data from CSV file
* Relate an IP/visitor with the pages visited
* Relate an IP/visitor with the browsers used by that IP
* Count visiting countries and the number of visitors from each country
* Added Summary of hits (Visiting Countries, Browser's Used, Total Unique Visitors, Total Page Hits)
* Added single visitor statistics (total hits for the visitor, pages visited and hit counts for each, browsers used by user, Country where the visitor visits from)
* Export all data to a CSV file (import feature not yet implemented)

Bugs and fixes

* Bug fixes
* Discount hits by a number specified by user or default to 1
* Fixed browser/user agent string - now browser are identified by name, such as Google Chrome, Mozilla Firefox, Apple Safari, Internet Explorer, Opera, etc

Other changes
* Changed layout to incoporate the layout of WordPress
* New Pages Added each for a specific purpose
- Who Hit The Page, shows the summary of all data (total hits, top 5 visiting countries, browsers used, total unique visitors)
- View All Details, shows the raw data as before (all page hits, all IP addresses in a table)
- Visitor Stats, shows the details of a single visitor, select visitor's IP to see pages visited, browsers used, total visits and date of first and last visit
- Denied IPs, where you add or view a list of denied IP addresses
- Export Import, Import Geolocation data or export statistics data to CSV files
- Settings, options page for backup export and import
- Help, shows get started and other useful information

= 1.3.2 =

* Bug fix
* Attempt to recover page hits and hit info from the installation of version 1.0 - data not truly lost from upgrade

= 1.3.1 =

* Fixed the counter bug - counters must work now

= 1.3 =

* Major Feature Update
New Feature added
- IP deny List, you can now deny an IP address from being counted
- Discount , If you visit your own site and you are counted, you can now discount yourself by clicking on "-1" next to page identifier you visited.
- Separae page for denied IPs

= 1.2 =

* Bug Fixes
* New Features
	- Reset Individual/All Page Counters
    - Reset Individual/All IP total counts
    - Permanently delete page/ip counter information from database
* New Design/Layout

= 1.1 =

Feature update 
* Now the plugin will log the time of first and last visit per IP address
* The total hits per IP address will now be counted
* If the visitor uses different browsers or user agents, the last one used will be shown

= 1.1 =

* Bug Fixes
* Register last used user agent or browser for each IP
* Register time of last visit

= 1.0 =

* No current changes to the plugin, v1.0 is the first release.

== Upgrade Notice ==

= Upgrade to the latest version to enjoy the new features requested by our users and maybe yours too =

* Major Feature Update
	- IP deny List, you can now deny an IP address from being counted - Separate page for denied IPs
	- Discount , If you visit your own site and you are counted, you can now discount yourself by clicking on "-" next to page identifier you visited.	
    - Reset Individual/All Page Counters
    - Reset Individual/All IP total counts
    - Permanently delete page/ip counter information from database
    - Now the plugin will log the time of first and last visit per IP address
    - The total hits per IP address will now be counted
    - If the visitor uses different browsers or user agents, the last one used will be shown
    - Register last used user agent or browser for each IP
	- Register time of last visit
* Bug Fixes
* New Design/Layout

== Arbitrary section ==

The hit counter does not have a visible display on your website, but instead counts the visitors and register the user information on your wordpress database.
You will be able to see the stats on your wordpress admin, just click on the `Who Hit The Page` link on the side menu of your wordpress admin page. 

* Place the following shortcode snippet in any page or post you wish visitors counted on. <code>[whohit]-Page name or identifier-[/whohit]</code> 
- please remember to replace the `<code>-Page name or identifier-</code>` with the name of the page you placed the shortcode on, 
if you like you can put in anything you want to use as an identifier for the page.

* For example: On our [About Us Page](http://whohit.co.za/about/ "") we placed <code>[whohit]About Us[/whohit]</code>
* Please note that what you put between <code>[whohit]</code> and <code>[/whohit]</code> doesn't need to be the same as the page name - that means
for our [website design and development page] we can use <code>[whohit]Development[whohit]</code> instead of the whole <code>[whohit]website design and development page[whohit]</code> string, its completely up to you what you put as long as you will be able to see it on your admin what page has how many visits.


== Links You may need to visit ==

Here's a link to [Who Hit The Page Hit Counter Home Page](http://whohit.co.za/ "") and this one is for the [Documentation](http://whohit.co.za/who-hit-the-page-hit-counter/ "")
Buy the Hit Counter Widget [Buy Widget Here](http://shop.whohit.co.za/ "")

