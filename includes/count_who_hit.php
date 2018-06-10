<?php

# reset page counts


# reset ip counters


# delete page




# check if an IP is denied

/*
* Discount a page's counter by -1
*
*/



# updates signup form
function whtp_signup_form(){?>
<form action="" method="post" id="signup">
    <input type="hidden" name="whtpsubscr" value="y" />
    <label for="asubscribe_email">Enter your email address to subscribe to updates</label>
    <input type="email" placeholder="e.g. <?php echo get_option('admin_email'); ?>" name="asubscribe_email" value="" class="90" /><br />
    <input type="submit" value="Subscribe to updates" class="button button-primary button-hero" />
</form>
<?php }

/*
* These functions reliy on the BroserDetection class
* Resturns an array ( $name, $version )
*
*/
function whtp_browser_info(){
	require_once('BrowserDetection.php');
	$browser_info = array();
	$browser = new BrowserDetection();
	if ($browser->getBrowser() == BrowserDetection::BROWSER_AMAYA ) {
		$browser_info['name'] = 'Amaya';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_ANDROID ) {
		$browser_info['name'] = 'Android';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_BINGBOT) {
		$browser_info['name'] = 'Bingbot';
		$broswer_info['version'] = $browser->getVersion();
	}
	
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_BLACKBERRY) {
		$browser_info['name'] = 'BlackBerry';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_CHROME) {
		$browser_info['name'] = 'Chrome';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_FIREBIRD) {
		$browser_info['name'] = 'Firebird';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_FIREFOX) {
		$browser_info['name'] = 'Firefox';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_GALEON) {
		$browser_info['name'] = 'Galeon';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_GOOGLEBOT) {
		$browser_info['name'] = 'Googlebot';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_ICAB) {
		$browser_info['name'] = 'iCab';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_ICECAT) {
		$browser_info['name'] = 'GNU IceCat';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_ICEWEASEL) {
		$browser_info['name'] = 'GNU IceWeasel';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_IE) {
		$browser_info['name'] = 'Internet Explorer';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_IE_MOBILE) {
		$browser_info['name'] = 'Internet Explorer Mobile';
		$broswer_info['version'] = $browser->getVersion();
	}elseif ($browser->getBrowser() == BrowserDetection::BROWSER_KONQUEROR) {
		$browser_info['name'] = 'Konqueror';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_LYNX) {
		$browser_info['name'] = 'Lynx';
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_MOZILLA) {
		$browser_info['name'] = 'Mozilla';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_MSNBOT) {
		$browser_info['name'] = 'MSNBot';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_MSNTV) {
		$browser_info['name'] = 'MSN TV';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_NETPOSITIVE) {
		$browser_info['name'] = 'NetPositive';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_NETSCAPE) {
		$browser_info['name'] = 'Netscape';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_NOKIA) {
		$browser_info['name'] = 'Nokia Browser';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_OMNIWEB) {
		$browser_info['name'] = 'OmniWeb';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_OPERA) {
		$browser_info['name'] = 'Opera';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_OPERA_MINI) {
		$browser_info['name'] = 'Opera Mini';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_OPERA_MOBILE) {
		$browser_info['name'] = 'Opera Mobile';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_PHOENIX) {
		$browser_info['name'] = 'Phoenix';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_SAFARI) {
		$browser_info['name'] = 'Safari';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_SLURP) {
		$browser_info['name'] = 'Yahoo! Slurp';
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_TABLET_OS) {
		$browser_info['name'] = 'BlackBerry Tablet OS';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_W3CVALIDATOR) {
		$browser_info['name'] = 'W3C Validator';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ($browser->getBrowser() == BrowserDetection::BROWSER_YAHOO_MM) {
		$browser_info['name'] = 'Yahoo! Multimedia';
		$broswer_info['version'] = $browser->getVersion();
	}
	elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_UNKNOWN ) {
		$browser_info['name'] = 'Unknown';
		$broswer_info['version'] = 'Unknown';
	}
	/*
	*else($browser->getBrowser() == BrowserDetection:: ) {
	*	
	*}
	*/
	
	return $browser_info;
}
/*
* Future functionality
* Collapse or expand all IP details
* Geolocate IP address
* User IP address and all browsers used
* Divide IP's Total Hits to the number of browsers associated to that IP	
*/

/*
* detect wordpress install host
* if host is the same as referrer, or host is the site url, we deny
* The host or developer's IP is not counted
*/

# this is function seems to work diferently on diferent hosts
function deny_wordpress_host_ip(){
	
	$local 		= $_SERVER['HTTP_HOST'];	# this host's name
	$siteurl 	= get_option('siteurl');	# wordpress site url
	$ref 		= $_SERVER['HTTP_REFERER']; # referrer host name	
	$rem 		= $_SERVER['REMOTE_ADDR'];  # visitor's ip address
	
	if ( isset ( $_SERVER['SERVER_ADDR'] ) ) {
		$local_addr	= $_SERVER['SERVER_ADDR'];  # this host's ip address
	}
	
	$deny = false;
	# if local = remote, then its wordpress host, deny
	if ( $local_addr == $rem ) {
		$deny = true;
		return $deny;
	}
	/*
	* try to see if the host name is not the referrer name
	* by exploding host name and referrer into array and comparing indexes of those arrays
	*/	
	$refarr = explode("/", $ref);
	$localarr = explode("/", $local);
	
	# 1. if hostname is in the referrer array, or referrer in hostname array, deny
	if ( in_array( $local, $refarr ) || in_array ( $ref, $localarr ) ){	
		$deny = true;#echo "<br />Another deny rule<br />";
	}	
	# 2. If the index 'localhost' is the same as 'referrerhost' then deny
	if ( $refarr[2] == $localarr[2] ){		
		$deny = true;#echo "Another deny rule.... ";
	}
	# 3. Almost similar to 1 above 	
	if ( $refarr[2] == $local || $localarr[2] == $ref){		
		$deny = true;#echo " Another deny rule " . $refarr[2] ;
	}	
	# 4. explode siteurl into an array and compare index 2 with localhost
	$url = explode ( "/", $siteurl );
	if ( $url[2] == $local ) {		
		$deny = true;#echo "<br />We found local host, deny IP<br />";	
	}	
	# 5. If referrer is the site url or if the admin is browing or previewing pages
	if ( $siteurl == $ref || $local == $ref ){		
		$deny = true;#echo "Deny IP Address";
	}
	return $deny;
}
?>