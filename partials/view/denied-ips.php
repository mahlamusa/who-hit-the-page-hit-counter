<?php
global $wpdb;

$limit = isset( $_GET['limit'] ) ? esc_attr( $_GET['limit'] ) : 100;
if( isset($_GET{'page'} ) ) {
    $page = $_GET['page'] + 1;
    $offset = $limit * $page ;
 }else {
    $page = 0;
    $offset = 0;
 }

$total_ips	= WHTP_Hit_Info::count( 'denied' );

// Display visitors
$hit_info_result = WHTP_Hit_info::get_hitinfo( $offset, $limit, 'denied' );
?>
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
                          <input name='quantity' type='number' size='5' value="1">
                          <input name='submit' type='submit' class="button button-primary" value='Donate through 2CO'>
                        </form>
                    </div>  
                </div>
            </div>
        </div>
        <div id="post-body">
            <div id="post-body-content">
                <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                	<div class="postbox inside">
						<div class="handlediv" title="Click to toggle"><br /></div>
                    	<h3 class="hndle"><?php _e( 'Add Denied IP', 'whtp' ); ?></h3>
    					<div class="inside">
                            <p> <?php _e("Please add an IP address to your deny list. All IP addresses in this list will not be counted when visiting your website. To allow an IP to be counted again, click 'Allow This IP' then it will be visible in your IP list on the counters' page and to remove it from the list click 'Delete This IP.'", 'whtp'); ?></p>
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
                            <ul id="denyip" style="height:100px;">
                                <li>
                                    <b>
                                        <?php _e("Enter IP address to add to deny list", "whtp"); ?>
                                    </b>
                                </li>
                                <li>
                                    <input class="reugular-text" type="text" name="ip_address" placeholder="e.g. 127.0.0.1" />
                                </li>
                                <li><input type="hidden" name="add_deny_ip" value="add_deny_ip" /></li>
                                <li><input type="submit" value="<?php _e("Add To Deny List", "whtp"); ?>" class="button button-hero button-primary" /></li>
                             </ul>
                          </form>
                      </div>
                      <br />
                      <br />
                 </div>                  
             </div>
    </div>

    <div class="mdl-grid whtps-content">
        <div class="mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--12-col">
            <h3>
                <?php _e("Currently denied IP Addresses", "whtp"); ?>
            </h3>   
            <p><?php _e("Here is a list of currently denied IP addresses", "whtp"); ?></p>
            <?php

            if ( $total_ips && $total_ips > 0) :
                if( $hit_info_result ) : ?>
                    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" cellspacing="0" cellpadding="5px" width="98%">
                        <tr>
                            <td class="mdl-data-table__cell--non-numeric">
                                <h4><?php _e("Visitor's  IP Address", "whtp"); ?></h4>
                            </td>
                            <td class="mdl-data-table__cell--non-numeric">
                                <h4><?php _e("Allow Count", "whtp"); ?></h4></td>
                            <td class="mdl-data-table__cell--non-numeric"><h4>
                                <?php _e("Reset", "whtp"); ?></h4></td>
                            <td class="mdl-data-table__cell--non-numeric">
                                <h4><?php _e("Delete IP", "whtp"); ?></h4></td>
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