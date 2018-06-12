<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset( $_GET['number'] ) ) {
    $number = esc_attr( $_GET['number'] );
}else{
    $number = "all";
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
    <div class="pagination">
        <?php echo $pagination; ?>
    </div>
    <table class="table-responsive mdl-data-table mdl-js-data-table mdl-shadow--2dp">
        <thead>
            <th class="mdl-data-table__cell--non-numeric">Visitor's  IP</th>
            <th class="mdl-data-table__cell--non-numeric">Visits</th>
            <th class="mdl-data-table__cell--non-numeric">User Agent</th>
            <th class="mdl-data-table__cell--non-numeric">1st Visit</th>
            <th class="mdl-data-table__cell--non-numeric">Last Visit</th>
            <th class="mdl-data-table__cell--non-numeric">Actions</th>
        </thead>
        
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
                        <a href="<?php echo admin_url( 'admin.php?page=whtp-view-all&delete_ip=this_ip&delete_this_ip='.$row->ip_address. '&nonce='. $nonce ); ?>">Delete This IP</a>
                    </li>
                    <li class="mdl-menu__item">
                        <a href="<?php echo admin_url( 'admin.php?page=whtp-view-all&deny_ip=this_ip&ip_address='.$row->ip_address. '&nonce='. $nonce ); ?>">Delete</a>
                    </li>
                    <li class="mdl-menu__item">
                        <a href="<?php echo admin_url( 'admin.php?page=whtp-view-all&reset_ip=this_ip&ip_address='. $row->ip_address . '&nonce='. $nonce ); ?>">Reset IP</a>
                    </li>
                </ul>
            </td>
        </tr>
        <?php endforeach; ?>		 
        <tr>
            <td class="title-footer mdl-data-table__cell--non-numeric" colspan="5" align="right">
                <h4>Total unique IP´s </h4>
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
                    <input type="submit" name="submit" value="Reset All" class="button-primary" />
                </form>
            </td>
            <td class="title-footer ftime-title">
                <form action="" method="post">
                    <input type="hidden" name="delete_ip" value="all" />
                    <input type="submit" name="submit" value="Delete All" class="button" />
                </form>
            </td>	
        </tr>
    </table>
<?php else: ?>
<div id="welcome-panel" class="welcome-panel">
    <h4 class="not-found">There are currently no registered IP addresses, please read above to get started</h4>
</div>
<?php endif;
?>