<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hit_info	= WHTP_Hit_Info::get_hits( $page, $number );
$total	= count( $hit_info );

if ( isset( $_GET['number'] ) ) {
    $number = esc_attr( $_GET['number'] );
}else{
    $number = "all";
}

if ( isset( $_GET['page'] ) ) {
    $page = es_attr( $_GET['page'] );
}else{
    $page = 1;
}
$pagination = WHTP_Functions::pagination( $number, $page, $total, 'whtp-pagination' );

if( $total > 0 ): ?>
    <div class="pagination">
        <?php echo $pagination; ?>
    </div>
    <table class="ip-table widefat fixed table" cellspacing="0" cellpadding="5px" width="98%">
        <thead>
            <th class="title-footer ip-title">Visitor's  IP</th>
            <th class="title-footer ipv-title">Visits</th>
            <th class="title-footer agent-title">User Agent</th>
            <th class="title-footer ftime-title">1st Visit</th>
            <th class="title-footer ltime-title">Last Visit</th>
            <th class="title-footer ipv-title">Don't Count</th>
            <th class="title-footer ipv-title">Reset</th>
            <th class="title-footer ipv-title">Delete</th>
        </thead>
        
        <?php foreach( $hit_info as $row ): ?>
        <tr>
            <td class="ip">
                <a href="admin.php?page=whtp-visitor-stats&ip=<?php echo esc_attr( $row->ip_address); ?>">
                    <?php echo esc_attr( $row->ip_address ); ?>
                </a>
            </td>
            <td class="ipv"><?php echo esc_attr( $row->ip_total_visits );?></td>		
            <td class="agent"><?php echo esc_attr( $row->user_agent ); ?></td>
            <td class="ftime"><?php echo esc_attr( $row->datetime_first_visit ); ?></td>
            <td class="ltime"><?php echo esc_attr( $row->datetime_last_visit );   ?></td>
            <td class="ipv">					
                <form action="" method="post">
                <input type="hidden" name="deny_ip" value="this_ip" />
                <input type="hidden" name="ip_address" 
                    value="<?php echo esc_attr( $row->ip_address ); ?>" />
                <input type="submit" name="submit" value="Deny" class="button-primary" />
                </form>
            </td>
            <td class="ipv">					
                <form action="" method="post">
                <input type="hidden" name="reset_ip" value="this_ip" />
                <input type="hidden" name="ip_address" 
                    value="<?php echo esc_attr( $row->ip_address ); ?>" />
                <input type="submit" name="submit" value="Reset" class="button-primary" />
                </form>
            </td>
            <td class="ipv">					
                <form action="" method="post">
                <input type="hidden" name="delete_ip" value="this_ip" />
                <input type="hidden" name="delete_this_ip" 
                    value="<?php echo esc_attr( $row->ip_address ); ?> . '" />
                <input type="submit" name="submit" value="Delete" class="button" />
                </form>
            </td>
        </tr>
        <?php endforeach; ?>		 
        <tr>
            <td class="title-footer" colspan="7" align="right">
                <h4>Total unique IP´s </h4>
            </td>
            <td class="title-footer ipv-title">
                h4><?php echo esc_attr( $total_ips );   ?> </h4>
            </td>
        </tr>
        <tr>
            <td class="title-footer" colspan="4"></td>					
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
            <td class="title-footer ipv-title"><h4>&nbsp;</h4></td>
        </tr>
    </table>
<?php else: ?>
<div id="welcome-panel" class="welcome-panel">
    <h4 class="not-found">There are currently no registered IP addresses, please read above to get started</h4>
</div>
<?php endif;
?>