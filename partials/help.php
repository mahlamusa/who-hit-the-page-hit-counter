<div class="wrap">	
	<h2>Who Hit The Page Hit Counter</h2>
    <p></p>
    <div id="poststuff" class="metabox-holder has-right-sidebar">
        <div id="side-info-column" class="inner-sidebar">
            <div id="side-sortables" class="meta-box-sortables ui-sortable">
                <div class="postbox">
                    <div class="handlediv" title="Click to toggle"><br /></div>
                    <h3 class="hndle">Support</h3>
                    <div class="inside welcome-panel-column welcome-panel-last">
                        <h4>Donate $10 via 2Checkout</h4>
                        <p>Any Amount is highly Appreciated</p>
                        <form action='https://www.2checkout.com/checkout/purchase' method='post'>
                          <input type='hidden' name='sid' value='102959491'>
                          <input type='hidden' name='quantity' value='1'>
                          <input type='hidden' name='product_id' value='9'>
                          <label>Quantity</label>
                          <input name='quantity' type='text' size='5' value="1">
                          <input name='submit' type='submit' class="button button-primary" value='Donate through 2CO'>
                        </form>
                        <span>2Checkout.com Inc. (Ohio, USA) is a payment facilitator for goods and services provided by Three Pixels Web Solutions.</span>
                    </div>  
                </div>
                <div class="postbox">
                    <div class="handlediv" title="Click to toggle"><br /></div>
                    <h3 class="hndle">Subscribe to updates</h3>
                    <div class="inside welcome-panel-column welcome-panel-last">
					   <?php
                            if(isset($_POST['whtpsubscr']) && $_POST['whtpsubscr'] == "y"){
                                WHTP_Functions::whtp_admin_message_sender();
                            }
                            WHTP_Functions::signup_form();
                        ?>
                        <p>Thank you once again!</p>
                    </div>
                </div>
                
                <div class="postbox">
                    <div class="handlediv" title="Click to toggle"><br /></div>
                    <h3 class="hndle">Please Rate this plugin</h3>
                    <div class="inside welcome-panel-column welcome-panel-last">
                        <p><b>Dear User</b></p>
                        <p>Please 
                        <a href="http://wordpress.org/support/view/plugin-reviews/who-hit-the-page-hit-counter">Rate this plugin now.</a> if you appreciate it.
                        Rating this plugin will help other people like you to find this plugin because on wordpress plugins are sorted by rating, so rate it high and give it a fair review to help others find it.<br />
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div id="post-body">
            <div id="post-body-content">
                <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                	<div class="postbox inside">
						<div class="handlediv" title="Click to toggle"><br /></div>
                    	<h3 class="hndle">Getting Started</h3>
    					<div class="inside">
                        	<p>1. Before you do anything, please go to the "Export / Import" page under "Who Hit The Page - Hit counter" on the left vertical menuand click "Import Geo Location Data" under the title "Import Geo Location Data" if you have not done so already.</p>
                            <p>2. On the "Export / Import" page under "Merge Existing Records" click "Update Previous Records". This will match the existing IP addresses from the previous version of the plugin with the new Geolocation data so tha you can see the corresponding countries of the IP addresses that were already in the database before the Geolocation data was imported.</p>
                            <p>3. Go to the "Settings" page under "Who Hit The Page - Hit Counter", then under "Uninstall Settings" choose an option that is suitable to your needs and click "Update Options". This is an impotant decision that you need to make regarding the action that should be taken when uninstalling the plugin.</p>
                            
                        </div>
                    </div>
                
                
                	<div class="postbox inside">
						<div class="handlediv" title="Click to toggle"><br /></div>
                    	<h3 class="hndle">Help</h3>
    					<div class="inside">
                             <p>The hits per page are shown on the first table, and the visitor's IP addresses are shown on the last table. Place the following shortcode snippet in any page or post you wish visitors counted on.</p>
                            <p>
                <code>[whohit]-Page name or identifier-[/whohit]</code> <br />- please remember to replace the `<code>-Page name or identifier-</code>` with the name of the page you placed the shortcode on, if you like you can put in anything you want to use as an identifier for the page.
            </p>
            
                            <p>
                For example: On our <a href="https://whohit.co.za/about-us">about us page</a> we placed <code>[whohit]About Us[/whohit]</code> and on our <a href="https://whohit.co.za/web-hosting">web hosting</a> page we placed <code>[whohit]Web Hosting[/whohit]</code>. Please note that what you put between [whohit] and [/whohit] doesn\'t need to be the same as the page name - that means; for our <a href="https://whohit.co.za/web-design-and-development">website design and development page</a> we can use <code>[whohit]Development[whohit]</code> instead of the whole <code>[whohit]website design and development page[whohit]</code> string, its completely up to you what you put as long as you will be able to see it on your admin what page has how many visits.</p>
                
                
                
                        <p> Please make sure you place the shortcode <code>[whohit]..[/whohit]</code> only once in a page or post, if you place it twice, that page will be counted twice and thats not what you want. If you don\'t put anything between the inner square brackets of the shortcode, like so:<code>[whohit][/whohit]</code>, then you will have an unknown page appering with a count on the hits table and you will not know what page that is on your website.</p>
                                
                        <p>Please link to our website if you like our plugin, we really appreciate your kind gesture. Visit our website at <?php echo whtp_link_bank(); ?></p>
                        <p>Please copy and paste this: <code>[supportlink]</code> on any page or post in visual view to display the link shown above.</p>
                
                        <p>Or you can copy and paste the following link on your pages, posts or theme files to display a link to our website</p>
                        <textarea readonly="readonly" rows="4"><?php echo whtp_link_bank(); ?></textarea>
                    
                        <p>
                            <ul class="author">
                                <li><b>Author's website</b></li>
                                <li>
                                    <a href="http://lindeni.co.za" title="Worpress plugins author" target="_blank">
                                        lindeni.co.za
                                    </a>
                                </li>
                                
                                <li><b>Plugin's documentation</b></li>
                                <li>
                                    <a href="http://whohit.co.za/who-hit-the-page-hit-counter" title="Multi Purpose Mail Form wordpress plugin" target="_blank">
                                        http://whohit.co.za/who-hit-the-page-hit-counter
                                    </a>
                                </li>
                                
                                <li><b>Report bugs/ request features</b></li>
                                <li>
                                    <a href="mailto:3pxwebstudios@gmail.com" title="email address to report plugin's bugs or errors" target="_blank">
                                        3pxwebstudios@gmail.com
                                    </a>
                                </li>
                                <li><b>Contact phone number</b><br /><small>(Only from Monday to Friday )</small></li>
                                <li>                    
                                    +27 76 706 4015 (ZA)
                                </li>
                            </ul>
                        </p>
                 	</div> 
					<div class="postbox inside">
                    	<div class="handlediv" title="Click to toggle"><br /></div>
                    	<h3 class="hndle">Disclaimer</h3>
                        <div class="inside">
                            <p>This product includes GeoLite2 data created by MaxMind, available from <a href="http://www.maxmind.com">http://www.maxmind.com</a></p>
                            <p>I, Lindeni Mahlalela, referred to as "mahlamusa" don't guarantee the accuracy of the Geolocation data used in this plugin. I do not claim that I have gathered this data myself, but this product uses GeoLite2 data created by MaxMind, available from <a href="http://www.maxmind.com">http://www.maxmind.com</a>. If the data is inaccurate, please be advisable tha providing accurate data is beyond my personal capacity. When this version of the plugin was released, the data was 80% accurate.</p>
                             <p></p>
                        </div>
                    </div>
                </div>
           	</div>
      	</div>
   	</div>
</div>