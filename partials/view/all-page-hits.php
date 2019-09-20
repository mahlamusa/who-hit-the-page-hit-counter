<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$total_hits = WHTP_Hits::total();

if ( isset( $_POST['result-perpage'] ) ) {
	$number = esc_attr( $_POST['result-perpage'] );
} else {
	$number = isset( $_GET['number'] ) ? esc_attr( $_GET['number'] ) : 15;
}

if ( isset( $_GET['paging'] ) ) {
	$paging = esc_attr( $_GET['paging'] );
} else {
	$paging = 1;
}

$offset = $number !== 'all' ? $paging * $number : 0;

$hits  = WHTP_Hits::get_hits( $offset, $number );
$total = count( $hits );

if ( $total > 0 ) : ?>
	<?php
	$filter_field_id = 'hits-filter-text';
	include WHTP_PLUGIN_DIR_PATH . 'partials/pagination.php';
	?>
	<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
		<thead>
			<th class="mdl-data-table__cell--non-numeric"><?php esc_attr_e( 'Page Visited', 'whtp' ); ?></th>
			<th><?php esc_attr_e( 'Number of Hits', 'whtp' ); ?></th>
			<th class="mdl-data-table__cell--non-numeric"><?php esc_attr_e( 'Discount By', 'whtp' ); ?></th>
			<th><?php esc_attr_e( 'Actions', 'whtp' ); ?></th>
		</thead>
		<tbody id="hits-table">        
	<?php foreach ( $hits as  $row ) : ?>
			<tr>
				<td class="mdl-data-table__cell--non-numeric"><?php echo $row->page; ?></td>
				<td><?php echo $row->count_hits; ?></td>    
				<td class="mdl-data-table__cell--non-numeric">                        
					<form action="" method="post">
						<input type="hidden" name="discount_page" value="<?php echo $row->page_id; ?>" />
						<input type="number" name="discountby" value="1" />
						<!--<input type="submit" name="submit" value="--" class="button-primary" />-->
						<button type="submit" class="mdl-button mdl-js-button mdl-button--icon confirm-discount">
							<i class="material-icons">remove_circle</i>
						</button>
					</form>
				</td>                    
				<td>                        
					<button id="demo-menu-lower-right-<?php echo $row->page_id; ?>"
						class="mdl-button mdl-js-button mdl-button--icon">
						<i class="material-icons">more_vert</i>
					</button>
		<?php $nonce = wp_create_nonce( 'delete_reset_deny' ); ?>
					<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
						for="demo-menu-lower-right-<?php echo $row->page_id; ?>">
						<li class="mdl-menu__item">
							<a class="confirm-delete" href="<?php echo admin_url( 'admin.php?page=whtp-view-page-hits&delete_page=delete&page_id=' . $row->page_id . '&nonce=' . $nonce ); ?>"><?php esc_attr_e( 'Delete', 'whtp' ); ?></a>
						</li>
						<li class="mdl-menu__item">
							<a class="confirm-reset" href="<?php echo admin_url( 'admin.php?page=whtp-view-page-hits&reset_page=reset&page_id=' . $row->page_id . '&nonce=' . $nonce ); ?>"><?php esc_attr_e( 'Reset', 'whtp' ); ?>
							</a>
						</li>
					</ul>
				</td>
			</tr>
	<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td class="mdl-data-table__cell--non-numeric"><h4><?php esc_attr_e( 'Total Hits', 'whtp' ); ?></h4></td>
				<td><h4><?php echo $total_hits; ?></h4></td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td>
					<form action="" method="post">
					<input type="hidden" name="reset_all_pages" value="all" />
		<?php wp_nonce_field( 'reset_all_pages', 'reset_all_pages_nonce' ); ?>
					<input type="submit" name="submit" value="<?php esc_attr_e( 'Reset All', 'whtp' ); ?>" class="button-primary confirm-reset" />
					</form>    
				</td>
				<td>
					<form action="" method="post">
					<input type="hidden" name="delete_all_pages" value="all" />
		<?php wp_nonce_field( 'delete_all_pages', 'delete_all_pages_nonce' ); ?>
					<input type="submit" name="submit" value="<?php esc_attr_e( 'Delete All', 'whtp' ); ?>" class="button confirm-delete" />
					</form>
				</td>
			</tr>
		</tfoot>        
	</table>
	<?php else : ?>
		<div id="welcome-panel" class="welcome-panel">
			<h4 class="handle">
				<?php esc_attr_e( 'No Data Found', 'whtp' ); ?>
			</h4>
			<p>
				<?php esc_attr_e( 'No Page visits yet or the page counters have been reset. Read documentation to learn how to get started', 'whtp' ); ?>
			</p>
		</div>          
	<?php
	endif;
?>
