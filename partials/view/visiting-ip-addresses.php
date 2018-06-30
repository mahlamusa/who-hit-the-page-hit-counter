<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset( $_GET['number'] ) ) {
    $number = esc_attr( $_GET['number'] );
}else{
    $number = 25;
}

if ( isset( $_GET['paging'] ) ) {
    $paging = esc_attr( $_GET['paging'] );
}else{
    $paging = 1;
}

$offset = $number != 'all'? $number * $paging: 0;

$hit_info	= WHTP_Hit_Info::get_hitinfo( $offset, $number );
$total	= count( $hit_info );



$pagination = WHTP_Functions::pagination( $number, $paging, $total, 'whtp-pagination' );

if( $total > 0 ): ?>
    <div class="mdl-grid mdl-shadow--3dp">
        <div class="mdl-cell mdl-cell--3-col mdl-cell--3-col-tablet mdl-cell--12-col-phone">
            <input type="text" name="ip-filter-text" id="ip-filter-text">
        </div>
        <div class="mdl-cell mdl-cell--9-col mdl-cell--9-col-tablet mdl-cell--12-col-phone">
            <?php echo WHTP_Functions::pagination( $number, $paging, $total, 'whtp-view-ip-hits' ); ?>
        </div>
    </div>
    <table class="table-responsive mdl-data-table mdl-js-data-table mdl-shadow--2dp">
        <thead>
            <th class="mdl-data-table__cell--non-numeric"><?php _e( 'Visitor\'s  IP', 'whtp' ); ?></th>
            <th class="mdl-data-table__cell--non-numeric"><?php _e( 'Visits', 'whtp' ); ?></th>
            <th class="mdl-data-table__cell--non-numeric"><?php _e( 'User Agent', 'whtp' ); ?></th>
            <th class="mdl-data-table__cell--non-numeric"><?php _e( '1st Visit', 'whtp' ); ?></th>
            <th class="mdl-data-table__cell--non-numeric"><?php _e( 'Last Visit', 'whtp' ); ?></th>
            <th class="mdl-data-table__cell--non-numeric"><?php _e( 'Actions', 'whtp' ); ?></th>
        </thead>
        <tbody  id="ips-table">        
            <?php foreach( $hit_info as $row ): ?>
            <tr>
                <td  class="ip mdl-data-table__cell--non-numeric">
                    <a href="admin.php?page=whtp-visitor-stats&ip=<?php echo esc_attr( $row->ip_address); ?>">
                        <?php echo esc_attr( $row->ip_address ); ?>
                    </a>
                </td>
                <td class="ipv"><?php echo esc_attr( $row->ip_total_visits );?></td>		
                <td class="agent mdl-data-table__cell--non-numeric">
                    <?php echo esc_attr( $row->user_agent ); ?>
                </td>
                <td class="ftime mdl-data-table__cell--non-numeric">
                    <?php echo esc_attr( $row->datetime_first_visit ); ?>
                </td>
                <td class="ltime mdl-data-table__cell--non-numeric">
                    <?php echo esc_attr( $row->datetime_last_visit );   ?>
                </td>
                <td>						
                    <button id="demo-menu-lower-right-<?php echo $row->ip_address; ?>"
                        class="mdl-button mdl-js-button mdl-button--icon">
                        <i class="material-icons">more_vert</i>
                    </button>
                    <?php $nonce = wp_create_nonce( 'delete_reset_action' ); ?>
                    <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                        for="demo-menu-lower-right-<?php echo $row->ip_address; ?>">
                        <li class="mdl-menu__item">
                            <a href="<?php echo admin_url( 'admin.php?page=whtp-view-ip-hits&delete_ip=this_ip&delete_this_ip='.$row->ip_address. '&nonce='. $nonce ); ?>"><?php _e( 'Delete This IP', 'whtp' ); ?></a>
                        </li>
                        <li class="mdl-menu__item">
                            <a href="<?php echo admin_url( 'admin.php?page=whtp-view-ip-hits&deny_ip=this_ip&ip_address='.$row->ip_address. '&nonce='. $nonce ); ?>"><?php _e( 'Delete', 'whtp' ); ?></a>
                        </li>
                        <li class="mdl-menu__item">
                            <a href="<?php echo admin_url( 'admin.php?page=whtp-view-ip-hits&reset_ip=this_ip&ip_address='. $row->ip_address . '&nonce='. $nonce ); ?>"><?php _e( 'Reset IP', 'whtp' ); ?></a>
                        </li>
                    </ul>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="title-footer mdl-data-table__cell--non-numeric" colspan="5" align="right">
                    <h4><?php _e( 'Total unique IP´s', 'whtp'); ?></h4>
                </td>
                <td class="title-footer ipv-title">
                    <h4><?php echo esc_attr( $total );   ?> </h4>
                </td>
            </tr>
            <tr>
                <td class="title-footer" colspan="3"></td>					
                <td class="title-footer ltime-title"></td>
                <td class="title-footer ipv-title">
                    <form action="" method="post">
                        <input type="hidden" name="reset_ip" value="all" />
                        <input type="submit" name="submit" value="<?php _e( 'Reset All', 'whtp' ); ?>" class="button-primary" />
                    </form>
                </td>
                <td class="title-footer ftime-title">
                    <form action="" method="post">
                        <input type="hidden" name="delete_ip" value="all" />
                        <input type="submit" name="submit" value="<?php _e( 'Delete All', 'whtp' ); ?>" class="button" />
                    </form>
                </td>	
            </tr>
        </tfoot>        
    </table>
<?php else: ?>
<div id="welcome-panel" class="welcome-panel">
    <h4 class="not-found">
        <?php _e( 'There are currently no registered IP addresses, please read above to get started', 'whtp'); ?>
    </h4>
</div>
<?php endif;
?>