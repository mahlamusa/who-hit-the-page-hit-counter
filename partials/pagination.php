<div class="mdl-shadow--3dp">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--6-col mdl-cell--6-col-tablet mdl-cell--12-col-phone">
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text"
					name="<?php echo $filter_field_id; ?>"
					id="<?php echo $filter_field_id; ?>">
				<label class="mdl-textfield__label" for="<?php echo $filter_field_id; ?>">
		<?php esc_attr_e( 'Search for...', 'whtp' ); ?>
				</label>
			</div>
		</div>
	<?php if ( isset( $number ) && isset( $total ) && $total > $number ) : ?>
		<div class="mdl-cell mdl-cell--6-col mdl-cell--6-col-tablet mdl-cell--12-col-phone">
			<form action="#" method="post">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input class="mdl-textfield__input" type="text"
						pattern="-?[0-9]*(\.[0-9]+)?"
						id="result-perpage"
						name="result-perpage"
						value="<?php echo $number; ?>" />                        
					<label class="mdl-textfield__label" for="result-perpage">
		<?php esc_attr_e( 'Results per page...', 'whtp' ); ?>
					</label>
					<span class="mdl-textfield__error">
		<?php esc_attr_e( 'Input is not a number!', 'whtp' ); ?>
					</span>
				</div>
				<button type="submit" name="set_number_of_results" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored">
					<i class="material-icons">arrow_right</i>
				</button>
			</form>
		</div> 
	<?php endif; ?>          
	</div> 
	
	<?php if ( isset( $number ) && isset( $total ) && $total > $number ) : ?>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet mdl-cell--12-col-phone">
	<?php echo WHTP_Functions::pagination( $number, $paging, $total, 'whtp-view-ip-hits' ); ?>
		</div>
	</div>
	<?php endif; ?>
</div>  
