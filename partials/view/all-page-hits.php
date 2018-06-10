<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$total_hits = WHTP_Hits::total();
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

$hits = WHTP_Hits::get_all( $number );
$total	= count( $hits );
$pagination = WHTP_Functions::pagination( $number, $page, $total, 'whtp-pagination' );

if( $total > 0 ): ?>
    <div class="pagination">
        <?php echo $pagination; ?>
    </div>
    <table class="hits widefat fixed" cellspacing="0" cellpadding="5px" width="98%">
        <thead>
            <th  class="title-footer first-col-title">Page Visited</th>
            <th  class="title-footer second-col-title">Number of Hits</th>
            <th  class="title-footer action-col-title">Discount By</th>
            <th  class="title-footer action-col-title">Reset</th>
            <th  class="title-footer action-col-title">Delete</th>
        </thead>
        <?php  foreach($hits as  $row  ) : ?>
        <tr>
            <td class="first-col"><?php echo $row->page; ?></td>
            <td class="second-col"><?php echo $row->count; ?></td>	
            <td class="action-col discount">						
                <form action="" method="post">
                    <input type="hidden" name="discount_page" value="<?php echo $row->page; ?>" />
                    <input type="number" name="discountby" value="1" />
                    <input type="submit" name="submit" value="--" class="button-primary" />
                </form>
            </td>					
            <td class="action-col">						
                <form action="" method="post">
                    <input type="hidden" name="reset_page" value="<?php echo $row->page; ?>" />
                    <input type="submit" name="submit" value="Reset" class="button-primary" />
                </form>
            </td>
            <td class="action-col">						
                <form action="" method="post">
                <input type="hidden" name="delete_page" value="<?php echo esc_attr( );   ?>$row->page . '" />
                <input type="submit" name="submit" value="Delete" class="button" />
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td class="title-footer first-col-title"><h4>Total Hits</h4></td>
            <td class="title-footer second-col-title"><h4><?php echo $total_hits; ?></h4></td>
            <td class="action-col-title title-footer" bgcolor="#FF0000" colspan="3">&nbsp;</td>
        </tr>
        <tr>
        <td class="title-footer" colspan="3"><h4>&nbsp;</h4></td>
        <td class="action-col-title title-footer">
            <form action="" method="post">
            <input type="hidden" name="reset_page" value="all" />
            <input type="submit" name="submit" value="Reset All" class="button-primary" />
            </form>	
        </td>
        <td class="action-col-title title-footer">
            <form action="" method="post">
            <input type="hidden" name="delete_page" value="all" />
            <input type="submit" name="submit" value="Delete All" class="button" />
            </form>
        </td>
        </tr>
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