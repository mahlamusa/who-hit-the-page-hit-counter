<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset ( $_POST['update-backup-options'] ) ){
    $update_backup = stripslashes( $_POST['backup-action'] );
    $update_export_action = update_option ( "whtp_data_export_action",  $update_backup);
}
$export_option = get_option("whtp_data_export_action");

if ( isset ( $_POST['update-uninstall-option'] ) ){
    $update_uninstall = stripslashes( $_POST['uninstall-action'] );
    $update_uninstall_action = update_option ( "whtp_data_action",  $update_uninstall);
}
$option = get_option('whtp_data_action');

if ( $update_uninstall_action || $update_export_action ) : ?>
    <div id="message" class="updated">
        <p>Settings updated.</p> 
    </div><?php
else: ?>
    <div id="message" class="updated">
        <p>Failed to update settings.</p> 
    </div><?php
endif;
?>
<form action="" name="" method="post">
    <div class="whtp-card-container mdl-grid">
        <div class="mdl-cell mdl-cell--5-col mdl-cell--5-col-tablet mdl-cell--12-col-phone mdl-card mdl-shadow--3dp">
            <div class="mdl-card__title">
                <h4 class="mdl-card__title-text">Uninstall Settings!</h4>
            </div>
            <div class="mdl-card__supporting-text">
                <span class="mdl-typography--font-light mdl-typography--subhead">
                What should happen when you un-install the plugin?
                </span>
                
                <p>
                    <label for="uninstall-action">Select One Option</label>
                </p>
                <p>
                    <input type="radio" name="uninstall-action" value="delete-all" 
                    <?php if ($option == "delete-all") echo "checked"; ?>  />
                    <strong>Delete all Tables</strong> and <strong>Data</strong>
                </p>
                <p>
                    <input type="radio" name="uninstall-action" value="clear-tables"
                    <?php if ($option == "clear-tables") echo "checked"; ?>  />
                    <strong>Clear data</strong>, leave table structures.
                </p>
                <p>
                    <input type="radio" name="uninstall-action" value="do-nothing"
                    <?php if ($option == "do-nothing") echo "checked"; ?>  />
                    <strong>Leave all</strong> tables and data
                </p>
            </div>
            <div class="mdl-card__actions">
                <input type="hidden" name="update-uninstall-option" value="update-uninstall-option" /> 
                <input type="submit" value="Update Options" class="whtp-link mdl-button mdl-js-button mdl-typography--text-uppercase" />
            </div>
        </div>

        <div class="mdl-cell mdl-cell--3-col mdl-cell--3-col-tablet mdl-cell--4-col-phone mdl-card mdl-shadow--3dp">
            <div class="mdl-card__title">
                <h4 class="mdl-card__title-text">Backup Settings</h4>
            </div>
            <div class="mdl-card__supporting-text">
                <span class="mdl-typography--font-light mdl-typography--subhead">
                What should happen when you restore a backup?
                </span>
                <p>
                    <label for="uninstall-action">Select One Option</label>
                </p>
                <p>
                    <input type="radio" name="backup-action" value="delete-all"
                    <?php if ($export_option == "delete-all") echo "checked"; ?>  />
                    <strong>Override</strong> existing data 
                </p>
                <p>
                    <input type="radio" name="backup-action" value="clear-tables"
                    <?php if ($export_option == "clear-tables") echo "checked"; ?>  />
                    <strong>Update</strong> existing data, <strong>accumulate</strong> counts
                </p>
                <p>
                    <input type="radio" name="backup-action" value="do-nothing"
                    <?php if ($export_option == "do-nothing") echo "checked"; ?>  />
                    <strong>Skip/Ignore</strong> Existing Records
                </p>
            </div>
            <div class="mdl-card__actions">
                <input type="hidden" name="update-backup-options" value="update-backup-options" /> 
                <input type="submit" value="Update Options" class="whtp-link mdl-button mdl-js-button mdl-typography--text-uppercase" />
            </div>
        </div>
    </div>
</form>