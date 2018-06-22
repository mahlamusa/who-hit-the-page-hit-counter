<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="wrap">	
	<h2><?php _e('Help and Support', 'whtp'); ?></h2>
    <p></p>
    <div class="mdl-color--white mdl-cell mdl-cell--12-col">
        <div class="whtp-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
            <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                <?php _e( 'Getting Started', 'whtp' ); ?>
            </div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                <p>1. Before you do anything, please go to the "Export / Import" page under "Who Hit The Page - Hit counter" on the left vertical menuand click "Import Geo Location Data" under the title "Import Geo Location Data" if you have not done so already.</p>
                <p>2. On the "Export / Import" page under "Merge Existing Records" click "Update Previous Records". This will match the existing IP addresses from the previous version of the plugin with the new Geolocation data so tha you can see the corresponding countries of the IP addresses that were already in the database before the Geolocation data was imported.</p>
                <p>3. Go to the "Settings" page under "Who Hit The Page - Hit Counter", then under "Uninstall Settings" choose an option that is suitable to your needs and click "Update Options". This is an impotant decision that you need to make regarding the action that should be taken when uninstalling the plugin.</p>
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <a href="#" class="mdl-button mdl-js-button mdl-js-ripple-effect">Read More</a>
            </div>
        </div>  
    </div>

    <div class="mdl-color--white mdl-cell mdl-cell--12-col">
        <div class="whtp-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
            <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                <?php _e( 'How to?', 'whtp' ); ?>
            </div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">                
                <p>The hits per page are shown on the first table, and the visitor's IP addresses are shown on the last table. Place the following shortcode snippet in any page or post you wish visitors counted on.</p>
                <p><code>[whohit]-Page name or identifier-[/whohit]</code> <br />- please remember to replace the `<code>-Page name or identifier-</code>` with the name of the page you placed the shortcode on, if you like you can put in anything you want to use as an identifier for the page.</p>

                <p>For example: On our <a href="https://whohit.co.za/about-us">about us page</a> we placed <code>[whohit]About Us[/whohit]</code> and on our <a href="https://whohit.co.za/web-hosting">web hosting</a> page we placed <code>[whohit]Web Hosting[/whohit]</code>. Please note that what you put between [whohit] and [/whohit] doesn\'t need to be the same as the page name - that means; for our <a href="https://whohit.co.za/web-design-and-development">website design and development page</a> we can use <code>[whohit]Development[whohit]</code> instead of the whole <code>[whohit]website design and development page[whohit]</code> string, its completely up to you what you put as long as you will be able to see it on your admin what page has how many visits.</p>
                <p> Please make sure you place the shortcode <code>[whohit]..[/whohit]</code> only once in a page or post, if you place it twice, that page will be counted twice and thats not what you want. If you don\'t put anything between the inner square brackets of the shortcode, like so:<code>[whohit][/whohit]</code>, then you will have an unknown page appering with a count on the hits table and you will not know what page that is on your website.</p>
                        
                <p>Please link to our website if you like our plugin, we really appreciate your kind gesture. Visit our website at https://whohit.co.za/</p>
                <p>Please copy and paste this: <code>[supportlink]</code> on any page or post in visual view to display the link shown above.</p>
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <a href="http://whohit.co.za/who-hit-the-page-hit-counter" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color--teal-300" target="_blank">
                    Read Documentation
                </a>
                <a href="http://lindeni.co.za" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color--teal-300" target="_blank">
                    Author's Website
                </a>
            </div>
        </div>  
    </div>

    <div class="mdl-color--white mdl-cell mdl-cell--12-col">
        <div class="whtp-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
            <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                <?php _e( 'Disclaimer', 'whtp' ); ?>
            </div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                <?php require_once( WHTP_PLUGIN_DIR_PATH . 'partials/disclaimer.php' ); ?>
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <a href="#" class="mdl-button mdl-js-button mdl-js-ripple-effect">Read More</a>
            </div>
        </div>  
    </div>
</div>