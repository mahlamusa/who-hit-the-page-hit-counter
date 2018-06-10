<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
	global $wpdb;
	
	$user_stats = array();
	$browsers = array();
	$top_countries = array();
	
    $hit_result = WHTP_Hits::get_hits();
    $total_hits = count( $hit_results );
	
	$browsers = WHTP_Browser::get_browsers();
	
	//total unique visitors
	$total_unique = WHTP_Hit_Info::count_unique();
	
	$top_visitors = WHTP_Hit_Info::top( 5 );
	
	$top_countries = WHTP_Visiting_Countries::get_-top_countries( 15 );

?>
<div class="mdl-grid whtp-content">
    <div class="mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--8-col">
        <div class="whtp-cards mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet mdl-grid mdl-grid--no-spacing">
            <div class="whtp-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--12-col-desktop">
                <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                    <h2 class="mdl-card__title-text">
                        <?php _e( 'Summary', 'whtp'); ?>
                    </h2>
                </div>
                <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                    <p class="about-description">This is a summary of your page hit statistics.</p>
                    <!-- Totals -->
                    <br />
                    <p class="about-description"><strong>Total Page Hits: <?php echo $total_hits; ?></strong></p>
                    <p class="about-description"><strong>Total Unique Visitors : <?php echo $total_unique; ?></strong></p>
                </div>
                <div class="mdl-card__actions mdl-card--border">
                    <a href="#" class="mdl-button mdl-js-button mdl-js-ripple-effect">Read More</a>
                </div>
            </div>

            <div class="whtp-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--12-col-desktop">
                <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                    <h2 class="mdl-card__title-text">
                        <?phpp _e( 'Top 5 Visitors', 'whtp' ); ?>
                    </h2>
                </div>
                <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                    <?php 
                    if ( is_admin() ){                                                    
                        $limit = count ( $top_visitors );                                                    
                        if ($limit > 5) {
                            $limit = 5;
                        }
                        if ($limit > 0){
                            echo '<table cellpadding="5" cellspacing="2">' . "\n";
                            echo "\t<tbody>\n";
                            for ($count = 0; $count < $limit; $count ++){
                                $top = $top_visitors[$count] ;	
                                echo '<tr><td><a href="admin.php?page=whtp-visitor-stats&ip=' 
                                . $top->ip_address 
                                . '">' . $top->ip_address 
                                . '</a></td><td>' . $top->ip_total_visits
                                . '</td></tr>' . "\n";
                            }
                            echo "\t</tbody>\n";
                            echo "</table>";
                        }
                    }
                    ?>
                </div>
                <div class="mdl-card__actions mdl-card--border">
                    <a href="#" class="mdl-button mdl-js-button mdl-js-ripple-effect">Read More</a>
                </div>
            </div>

            <div class="whtp-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--12-col-desktop">
                <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                    <h2 class="mdl-card__title-text">
                        <?php _e('Top Visiting Countries', 'whtp'); ?>
                    </h2>
                </div>
                <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                    <?php
                    
                    if ( count ( $top_countries ) ) :
                    ?>
                    <ul>
                        <?php
                        
                        for ( $count = 0; $count < count ( $top_countries ); $count ++ ) :
                            $top_country = $top_countries[$count];
                            $image_prefix =  $top_country['country_name'] ;
                            if ( $image_prefix == 'Unknown Country')
                                $image_prefix = '0';
                            else
                                $image_prefix = strtolower( $top_country['country_code'] );
                            ?>
                            <li>
                                <img 
                                src="<?php echo WHTP_FLAGS_URL . $image_prefix; ?>.png" 
                                alt="Flag of '<?php echo $top_country['country_code']; ?>" 
                                title="<?php echo $top_country['country_name']; ?>" />
                                <?php echo  $top_country['country_name'] . "\t ,"
                            . $top_country['country_code'] . "\t ("
                            . $top_country['count']; ?>) 
                            </li>';
                        <?php endfor; ?>
                    </ul>
                    
                    <?php endif;?>
                </div>
                <div class="mdl-card__actions mdl-card--border">
                    <a href="#" class="mdl-button mdl-js-button mdl-js-ripple-effect">Read More</a>
                </div>
            </div>

            <div class="whtp-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--12-col-desktop">
                <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                    <h2 class="mdl-card__title-text">
                        <?php _e( 'Used Browsers', 'whtp' ); ?>
                    </h2>
                </div>
                <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                    <?php if ( count ( $browsers ) > 0 ): ?>
                        <ul>
                        <?php foreach ( $browsers as $browser ) : ?>
                            <li>
                                <div class="welcome-icon welcome-widgets-menus">
                                    <?php echo esc_attr( $browser->agent_name ); ?>
                                </div>
                            </li>                      
                        <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p><?php _e( "No Browsers used so far", "whtp"); ?></p>
                    <?php endif; ?>
                </div>
                <div class="mdl-card__actions mdl-card--border">
                    <a href="#" class="mdl-button mdl-js-button mdl-js-ripple-effect">Read More</a>
                </div>
            </div>

            <div class="whtp-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--12-col-desktop">
                <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                    <h2 class="mdl-card__title-text">
                        <?php _e( 'Disclaimer', 'whtp' ); ?>
                    </h2>
                </div>
                <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                    <?php require_once( WHTP_PLUGIN_DIR_PATH . 'partials/disclaimer.php' ); ?>
                </div>
                <div class="mdl-card__actions mdl-card--border">
                    <a href="#" class="mdl-button mdl-js-button mdl-js-ripple-effect">Read More</a>
                </div>
            </div>

            <div class="whtp-separator mdl-cell--1-col"></div>           
        </div>
    </div>

    <!-- Tools Sidebar -->
    <div class="mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--4-col">
        <div class="whtp-options mdl-card mdl-color--deep-purple-500 mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--3-col-tablet mdl-cell--12-col-desktop">
            <div class="mdl-card__supporting-text mdl-color-text--blue-grey-50">
            <h3>View options</h3>
            <ul>
                <li>
                <label for="chkbox1" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
                    <input type="checkbox" id="chkbox1" class="mdl-checkbox__input">
                    <span class="mdl-checkbox__label">Click per object</span>
                </label>
                </li>            
            </ul>
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <a href="#" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--blue-grey-50">Change location</a>
            <div class="mdl-layout-spacer"></div>
                <i class="material-icons">location_on</i>
            </div>
        </div>
    </div>
    <!--<div class="whtp-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
        <svg fill="currentColor" width="200px" height="200px" viewBox="0 0 1 1" class="whtp-chart mdl-cell mdl-cell--4-col mdl-cell--3-col-desktop">
            <use xlink:href="#piechart" mask="url(#piemask)" />
            <text x="0.5" y="0.5" font-family="Roboto" font-size="0.3" fill="#888" text-anchor="middle" dy="0.1">82<tspan font-size="0.2" dy="-0.07">%</tspan></text>
        </svg>
        <svg fill="currentColor" width="200px" height="200px" viewBox="0 0 1 1" class="whtp-chart mdl-cell mdl-cell--4-col mdl-cell--3-col-desktop">
            <use xlink:href="#piechart" mask="url(#piemask)" />
            <text x="0.5" y="0.5" font-family="Roboto" font-size="0.3" fill="#888" text-anchor="middle" dy="0.1">82<tspan dy="-0.07" font-size="0.2">%</tspan></text>
        </svg>
        <svg fill="currentColor" width="200px" height="200px" viewBox="0 0 1 1" class="whtp-chart mdl-cell mdl-cell--4-col mdl-cell--3-col-desktop">
            <use xlink:href="#piechart" mask="url(#piemask)" />
            <text x="0.5" y="0.5" font-family="Roboto" font-size="0.3" fill="#888" text-anchor="middle" dy="0.1">82<tspan dy="-0.07" font-size="0.2">%</tspan></text>
        </svg>
        <svg fill="currentColor" width="200px" height="200px" viewBox="0 0 1 1" class="whtp-chart mdl-cell mdl-cell--4-col mdl-cell--3-col-desktop">
            <use xlink:href="#piechart" mask="url(#piemask)" />
            <text x="0.5" y="0.5" font-family="Roboto" font-size="0.3" fill="#888" text-anchor="middle" dy="0.1">82<tspan dy="-0.07" font-size="0.2">%</tspan></text>
        </svg>
    </div>-->
    <!-- Updates -->
    <!-- <div class="whtp-graphs mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--8-col">
        <svg fill="currentColor" viewBox="0 0 500 250" class="whtp-graph">
            <use xlink:href="#chart" />
        </svg>
        <svg fill="currentColor" viewBox="0 0 500 250" class="whtp-graph">
            <use xlink:href="#chart" />
        </svg>
    </div> -->
</div>
