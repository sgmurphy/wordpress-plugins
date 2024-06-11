<?php defined('ABSPATH' ) || wp_die; ?>
<form id="import" name="import" method="post" enctype="multipart/form-data">
	<?php wp_nonce_field('pz-lkc-cacheman' ); ?>
	<input type="hidden" name="action" value="import">
	<table class="pz-lkc-man-filemenu">
		<tr>
			<td><input  type="file"   id="import_file"   name="import_file"  accept=".csv" required /></td>
			<td><button type="submit" id="import_button" name="action" value="exec-import" class="pz-lkc-man-file-button button button-primary"><?php _e('Upload Import File', $this->text_domain ); ?></button></td>
			<td><label><input type="checkbox" id="import_clear" name="import_clear" value="1" /><?php _e('Clear all cache', $this->text_domain ); ?></label></td>
		</tr>
	</table>
</form>
