<?php
global $wpdb;

$limit = isset( $_GET['limit'] ) ? esc_attr( $_GET['limit'] ) : 100;
if( isset( $_GET['paging'] ) ) {
    $paging = $_GET['paging'];
    $offset = $limit * $paging ;
 }else {
    $page = 0;
    $offset = 0;
 }

$total_ips	= WHTP_Hit_Info::count( 'denied' );

// Display visitors
$hit_info_result = WHTP_Hit_info::get_hitinfo( $offset, $limit, 'denied' );
?>
<div class="mdl-grid whtps-content">
	<h2 class="mdl-card__title-text"><?php _e('Who Hit The Page Hit Counter', 'whtp'); ?></h2>
    <p></p>
    <div class="mdl-grid whtps-content">
        <div class="mdl-color--white mdl-cell mdl-cell--12-col">
            <div class="whtp-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
                <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                    <?php _e( 'Add Denied IP', 'whtp' ); ?>
                </div>
                <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                    <?php _e("Please add an IP address to your deny list. All IP addresses in this list will not be counted when visiting your website. To allow an IP to be counted again, click 'Allow This IP' then it will be visible in your IP list on the counters' page and to remove it from the list click 'Delete This IP.", 'whtp'); ?>
                </div>
                <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                    <?php
                        if ( isset ( $_POST['add_deny_ip'] ) ):
                            if ( WHTP_Hit_Info::add_denied_ip() ) : ?>
                            <div class="wrap">
                                <div class="updated">
                                    <p>
                                        <?php echo sprintf( __( 'The IP Address "%s" has been added to your deny list. This IP address will not be counted the next time it visits your website', 'whtp'), esc_attr( $ip_address ) ); ?>
                                    </p>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="wrap">
                                <div class="warning error-msg error">
                                    <p><?php echo sprintf( __( 'Failed to Add IP Address "%s" to deny list.', 'whtp' ), esc_attr( $ip_address ) ); ?></p>
                                </div>
                            </div>			
                            <?php endif;
                        endif;

                        if ( isset ( $_POST['allow_ip'] ) ) :
                            if ( WHTP_Hit_Info::allow_ip() ): ?>
                                <div class="wrap">
                                    <div class="updated">
                                        <p>
                                            <?php echo sprintf( 
                                                __( 'The IP "%" has been allowed and will now be counted the next time it visits your website.', 'whtp'),
                                                esc_attr( $ip_address ) ); ?>
                                        </p>
                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="error-msg warning error not-updated">
                                    <p>
                                        <?php echo sprintf( 
                                            __( 'Failed to Allow "%s"', 'whtp' ),
                                            esc_attr( $ip_address )
                                        ); ?>
                                    </p>
                                </div><?php
                            endif;	
                        endif;


                        if ( isset ( $_POST['delete_ip'] ) ) :
                            $ip_address = esc_attr($_POST['delete_this_ip']);	
                            $delete_ip  = esc_attr ( $_POST['delete_ip'] );

                            if ( WHTP_Hit_Info::delete_ip( $ip_address, $delete_ip ) ) : ?>
                                <div class="updated">
                                    <p>
                                        <?php echo sprintf( 
                                            __( 'The IP address "%s"" has been removed from the database.', 'whtp'),
                                            esc_attr(  $ip_address )
                                        ); ?>
                                    </p>
                                </div><?php
                            else: ?>
                                <div class="updated">
                                    <p><?php _e( 'Failed to remove IP from database.', 'whtp' ); ?></p>
                                </div><?php
                            endif;
                        endif;                            
                    ?>
                    <form action="" method="post" id="adddeny">
                        <p><?php _e("Enter IP address to add to deny list", "whtp"); ?></p>
                        <input type="hidden" name="add_deny_ip" value="add_deny_ip" />
                        <input class="reugular-text" type="text" name="ip_address" placeholder="e.g. 127.0.0.1" />
                        <input type="submit" value="<?php _e("Add To Deny List", "whtp"); ?>" class="mdl-button mdl-js-button mdl-js-ripple-effect button" />                        
                    </form>
                </div>
            </div>
        </div>
        
        <div class="mdl-color--white mdl-cell mdl-cell--12-col">
            <div class="whtp-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
                <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                    <?php _e("Currently denied IP Addresses", "whtp"); ?>
                </div>
                <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                    <p><?php _e("Here is a list of currently denied IP addresses", "whtp"); ?></p>
                    <?php

                    if ( $total_ips && $total_ips > 0) :
                        if( $hit_info_result ) : ?>
                            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" cellspacing="0" cellpadding="5px" width="98%">
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric">
                                        <?php _e("Visitor's  IP Address", "whtp"); ?>
                                    </td>
                                    <td class="mdl-data-table__cell--non-numeric">
                                        <?php _e("Allow Count", "whtp"); ?></td>
                                    <td class="mdl-data-table__cell--non-numeric">
                                        <?php _e("Delete IP", "whtp"); ?></td>
                                </tr>
                                <?php
                                # print rows from table
                                foreach( $hit_info_result as $row) : ?>
                                
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric"><?php echo $row->ip_address; ?></td>
                                    <td class="mdl-data-table__cell--non-numeric">					
                                        <form action="" method="post">
                                        <input type="hidden" name="allow_ip" value="this_ip" />
                                        <input type="hidden" name="ip_address" value="<?php echo $row->ip_address; ?> " />
                                        <input type="submit" name="submit" value="<?php _e("Allow This IP", "whtp"); ?>" class="button-primary" />
                                        </form>
                                    </td>
                                    <td class="mdl-data-table__cell--non-numeric">			
                                        <form action="" method="post">
                                        <input type="hidden" name="delete_ip" value="this_ip" />
                                        <input type="hidden" name="delete_this_ip" value="<?php echo $row->ip_address; ?>" />
                                        <input type="submit" name="submit" value="<?php _e("Delete This IP", "whtp"); ?>" class="button" />
                                        </form>
                                    </td>
                                </tr>

                                <?php endforeach; ?>

                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric" colspan="2" align="right">
                                        <h4><?php _e("Total Denied IP´s ", "whtp"); ?></h4>
                                    </td>
                                    <td class="title-footer ipv-title">
                                        <h4><?php echo $total_ips; ?></h4>
                                    </td>
                                </tr>                                        
                            </table>
                        <?php else : ?>
                            <h4 class="not-found">
                                <?php _e("There are currently no registered IP addresses, please read above to get started", "whtp"); ?>
                            </h4>
                        <?php endif;
                    endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>