# Who Hit The Page - Hit Counter
Lets you know who visted your pages by adding an invisible page hit counter on your website, so you know how many times a page has been visited in total and how many times each user identified by IP address has visited each page. You will also know the IP addresses of your visitors and relate the IP addresses to the country of the visitor and all browsers used by that IP/user.


## Installation ==

This section describes how to install the plugin and get it working.

1. Upload the folder/directory named `who-hit-the-page` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. 
 * Place [whohit]Page name/identifier[/whohit] on the page or post you want visitors counted - e.g. place `[whohit]About Us[/whohit]`
 on your `About Us` page to see how many people visited that page.
 * Place `<?php who_hit_the_page( "Page Name" ); ?>` on your theme if you are a developer.
 * Optional: link to us by placing [whlinkback] in a wordpress page or post, or `<?php whtp_link_bank(); ?>` on your template files
4. Visit one page you placed the shortcode once and go to your wordpress admin and click on 'Who Hit The Page' on the left to see your new statistics.
5. After an update, look out for the update no
