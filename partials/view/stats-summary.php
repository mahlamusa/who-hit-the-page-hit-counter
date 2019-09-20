<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
	global $wpdb;

	$user_stats    = array();
	$browsers      = array();
	$top_countries = array();

	$hit_results = WHTP_Hits::get_hits();
	$total_hits  = WHTP_Hits::total();

	$browsers = WHTP_Browser::get_browsers();

	// total unique visitors
	$total_unique = WHTP_Hit_Info::count_unique();

	$number_of_visitors = 15;
	$top_visitors       = WHTP_Hit_Info::top( $number_of_visitors );

	$number_of_countries = 15;
	$top_countries       = WHTP_Visiting_Countries::get_top_countries( $number_of_countries );

?>
<div class="mdl-grid whtps-content">
	<div class="mdl-color--white mdl-cell mdl-cell--12-col">
		<div class="mdl-grid mdl-cell mdl-cell--12-col">
			<div class="mdl-cell mdl-cell--3-col">
				<h3 class="mdl-card__title-text">
		<?php esc_attr_e( 'Summary', 'whtp' ); ?>
				</h3>
				<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
					<tbody>                                    
						<tr>
							<td class="mdl-data-table__cell--non-numeric">
								<?php echo sprintf( __( 'Total Page Hits: %d', 'whtp' ), $total_hits ); ?>
							</td>
						</tr>
						<tr>
							<td class="mdl-data-table__cell--non-numeric">
								<?php echo sprintf( __( 'Total Unique Visitors : %s', 'whtp' ), $total_unique ); ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="mdl-cell mdl-cell--3-col">
				<h3 class="mdl-card__title-text">
		<?php esc_attr_e( 'Top Visitors', 'whtp' ); ?>
				</h3>
				<?php
				if ( count( $top_visitors ) > 0 ) :
				?>
					<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
						<tbody>                                    
		<?php foreach ( $top_visitors as $top ) : ?>
							<tr>
								<td class="mdl-data-table__cell--non-numeric">
									<a href="admin.php?page=whtp-visitor-stats&ip=<?php echo $top->ip_address; ?>">
			<?php echo esc_attr( $top->ip_address ); ?>
									</a>
								</td>
								<td><?php echo esc_attr( $top->ip_total_visits ); ?></td>
							</tr>
		<?php endforeach; ?>
							<tr>
								<td colspan="2" class="mdl-data-table__cell--non-numeric">
									<a href="<?php echo admin_url( 'admin.php?page=whtp-view-ip-hits' ); ?>" class="mdl-button mdl-js-button mdl-js-ripple-effect">
			<?php esc_attr_e( 'View All', 'whtp' ); ?>
									</a>
								</td>
							</tr>
						</tbody>
					</table>
		<?php
				endif;
				?>
			</div>


			<div class="mdl-cell mdl-cell--3-col">
				<h2 class="mdl-card__title-text">
		<?php esc_attr_e( 'Top Countries', 'whtp' ); ?>
				</h2>
				<?php
				if ( count( $top_countries ) ) :
				?>
				<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
					<tbody>
		<?php

		foreach ( $top_countries as $top_country ) :
			$image_prefix = $top_country->country_code;
			if ( $image_prefix == 'AA' ) {
				$image_prefix = '0';
			} else {
				$image_prefix = strtolower( $top_country->country_code );
			}
			?>
		 <tr>
		  <td class="mdl-data-table__cell--non-numeric">
		   <img 
		   src="<?php echo WHTP_FLAGS_URL . $image_prefix; ?>.png" 
								alt="<?php echo sprintf( __( 'Flag of %s', 'whtp' ), esc_attr( $top_country->country_name ) ); ?>" 
								title="<?php echo esc_attr( $top_country->country_name ); ?>" />
								<?php echo esc_attr( $top_country->country_name ); ?>, 
								<?php echo esc_attr( $top_country->country_code ); ?>
		  </td>
		  <td>
								<?php echo esc_attr( $top_country->count_hits ); ?>
		  </td>
		 </tr>
		<?php endforeach; ?>
					</tbody>
				</table>                
				<?php endif; ?>
			</div>

			<div class="mdl-cell mdl-cell--3-col">
				<h2 class="mdl-card__title-text">
		<?php esc_attr_e( 'Used Browsers', 'whtp' ); ?>
				</h2>
				<?php if ( count( $browsers ) > 0 ) : ?>
					<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
						<tbody>
		<?php foreach ( $browsers as $browser ) : ?>
							<tr>
								<td class="mdl-data-table__cell--non-numeric">
			<?php echo esc_attr( $browser->agent_name ); ?>
								</td>
							</tr>                      
		<?php endforeach; ?>
						</tbody>
					</table>
				<?php else : ?>
					<p><?php esc_attr_e( 'No Browsers used so far', 'whtp' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
		
	<div class="mdl-color--white mdl-cell mdl-cell--12-col">
		<div class="whtp-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
			<div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
				<h2 class="mdl-card__title-text">
		<?php esc_attr_e( 'Disclaimer', 'whtp' ); ?>
				</h2>
			</div>
			<div class="mdl-card__supporting-text mdl-color-text--grey-600">
				<?php require_once WHTP_PLUGIN_DIR_PATH . 'partials/disclaimer.php'; ?>
			</div>
			<div class="mdl-card__actions mdl-card--border">
				<a href="#" class="mdl-button mdl-js-button mdl-js-ripple-effect">
		<?php esc_attr_e( 'Read More', 'whtp' ); ?></a>
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
