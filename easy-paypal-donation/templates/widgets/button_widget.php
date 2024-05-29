<p>
    <label>
        <span>Widget Name:</span>
        <input class="widefat"
               id="<?=esc_attr($args['field_id']);?>"
               name="<?=esc_attr($args['field_name_title']); ?>"
               type="text" value="<?=esc_attr($args['title']);?>"/>
    </label>
</p>

Choose an existing button:
<br/>
<select id="wpedon_button_id" name="<?= esc_attr($args['field_name_idvalue']); ?>">
	<?php if (isset($args['posts'])):
		foreach ($args['posts'] as $post):
			$id = $post->ID;
			$post_title = $post->post_title;
			$price = get_post_meta($id, 'wpedon_button_price', true);
			$sku = get_post_meta($id, 'wpedon_button_id', true);
			$selected = $args['idvalue'] == $id ? "SELECTED" : ""; ?>
    <option value="<?=$id;?>" <?=$selected;?>>
      <?= __('Name: ').esc_html($post_title).__(' - Amount: ').esc_html($price).__(' - ID: ').esc_html($sku);?>
    </option>
    <?php
		endforeach;
	else:
		echo "<option>No buttons found.</option>";
	endif; ?>
</select>
<br/>
Make a new button: <a target="_blank" href="<?= get_admin_url(null, 'admin.php?page=wpedon_buttons&action=new'); ?>">here</a><br/>
Manage existing buttons: <a target="_blank" href="<?= get_admin_url(null, 'admin.php?page=wpedon_buttons'); ?>">here</a>
<br/>
<br/>