<div class="customize-control" id="customize-control-<?php echo $control['field']; ?>">
	<?php do_action( "happyforms_setup_control_{$control['field']}_before", $control ); ?>

	<label for="<?php echo $control['field']; ?>" class="customize-control-title"><?php echo $control['label']; ?></label>
	<input type="text" id="<?php echo $control['field']; ?>" value="<%- <?php echo $control['field']; ?> %>" data-attribute="<?php echo $control['field']; ?>" placeholder="<?php echo ( isset( $control['placeholder'] ) ) ? $control['placeholder'] : ''; ?>" data-pointer-target<?php echo ( isset( $control['autocomplete'] ) ) ? ' autocomplete="' . $control['autocomplete'] . '"' : ''; ?> />

	<?php if ($control['field']=="alert_email_subject") {
			$form = happyforms_get_form_controller()->get( $_GET['form_id'] );
			$text_exists = false;
			$available_tags = "";

			if ($form) {
				foreach ($form['parts'] as $form_part){
					if( $form_part['type'] == "single_line_text" || $form_part['type'] == "hidden_text"){
						$text_exists = true;
						$available_tags .= $form_part['label']." - <strong>%%".$form_part['id']."%%</strong><br />";
					}
				}
			}
			if ($text_exists) {
				echo "<p>Use the following tags [%%tag%%] to get the field value from the form.</p>";
				echo $available_tags;
			}
		}?>
	<?php do_action( "happyforms_setup_control_{$control['field']}_after", $control ); ?>
</div>
