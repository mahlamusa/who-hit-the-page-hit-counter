<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$total_hits = WHTP_Hits::total();

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

$offset = $number != 'all' ? $paging * $number: 0;

$hits   = WHTP_Hits::get_hits( $offset, $number );
$total	= count( $hits );

if( $total > 0 ): ?>
    <div class="mdl-grid mdl-shadow--3dp">
        <div class="mdl-cell mdl-cell--3-col mdl-cell--3-col-tablet mdl-cell--12-col-phone">
            <input type="text" name="hits-filter-text" id="hits-filter-text">
        </div>
        <div class="mdl-cell mdl-cell--9-col mdl-cell--9-col-tablet mdl-cell--12-col-phone">
            <?php echo WHTP_Functions::pagination( $number, $paging, $total, 'whtp-view-page-hits' ); ?>
        </div>
    </div>
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
        <thead>
            <th class="mdl-data-table__cell--non-numeric"><?php _e( 'Page Visited', 'whtp' ); ?></th>
            <th><?php _e( 'Number of Hits', 'whtp' ); ?></th>
            <th class="mdl-data-table__cell--non-numeric"><?php _e( 'Discount By', 'whtp' ); ?></th>
            <th><?php _e( 'Actions', 'whtp' ); ?></th>
        </thead>
        <tbody id="hits-table">        
            <?php  foreach($hits as  $row  ) : ?>
            <tr>
                <td class="mdl-data-table__cell--non-numeric"><?php echo $row->page; ?></td>
                <td><?php echo $row->count_hits; ?></td>	
                <td class="mdl-data-table__cell--non-numeric">						
                    <form action="" method="post">
                        <input type="hidden" name="discount_page" value="<?php echo $row->page; ?>" />
                        <input type="number" name="discountby" value="1" />
                        <!--<input type="submit" name="submit" value="--" class="button-primary" />-->
                        <button type="submit" class="mdl-button mdl-js-button mdl-button--icon">
                            <i class="material-icons">remove_circle</i>
                        </button>
                    </form>
                </td>					
                <td>						
                    <button id="demo-menu-lower-right-<?php echo $row->page; ?>"
                        class="mdl-button mdl-js-button mdl-button--icon">
                        <i class="material-icons">more_vert</i>
                    </button>
                    <?php $nonce = wp_create_nonce( 'delete_reset_action' ); ?>
                    <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                        for="demo-menu-lower-right-<?php echo $row->page; ?>">
                        <li class="mdl-menu__item">
                            <a href="<?php echo admin_url( 'admin.php?page=whtp-view-page-hits&delete_page='.$row->page. '&nonce='. $nonce ); ?>"><?php _e( 'Delete', 'whtp' ); ?></a></li>
                        <li class="mdl-menu__item">
                            <a href="<?php echo admin_url( 'admin.php?page=whtp-view-page-hits&reset_page='. $row->page. '&nonce='. $nonce ); ?>"><?php _e( 'Reset', 'whtp' ); ?></a>
                        </li>
                    </ul>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">&nbsp;</td>
                <td class="mdl-data-table__cell--non-numeric"><h4><?php _e( 'Total Hits', 'whtp' ); ?></h4></td>
                <td><h4><?php echo $total_hits; ?></h4></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
                <td>
                    <form action="" method="post">
                    <input type="hidden" name="reset_page" value="all" />
                    <input type="submit" name="submit" value="<?php _e( 'Reset All', 'whtp' ); ?>" class="button-primary" />
                    </form>	
                </td>
                <td>
                    <form action="" method="post">
                    <input type="hidden" name="delete_page" value="all" />
                    <input type="submit" name="submit" value="<?php _e( 'Delete All', 'whtp' ); ?>" class="button" />
                    </form>
                </td>
            </tr>
        </tfoot>        
    </table>
    <?php else: ?>
        <div id="welcome-panel" class="welcome-panel">
            <h4 class="handle">
                <?php _e( "No Data Found", "whtp" ); ?>
            </h4>
            <p>
                <?php _e( "No Page visits yet or the page counters have been reset. Read documentation to learn how to get started", "whtp" ); ?>
            </p>
        </div>          
        <?php
    endif;    
?>