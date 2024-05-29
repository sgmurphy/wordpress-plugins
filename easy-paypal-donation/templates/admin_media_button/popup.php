<script type="text/javascript">
  function wpedon_button_InsertShortcode () {
    const id = document.getElementById('wpedon_button_id').value;
    const wpedon_alignmentc = document.getElementById('wpedon_align');
    const wpedon_alignmentb = wpedon_alignmentc.options[wpedon_alignmentc.selectedIndex].value;

    if (id === 'No buttons found.') {
      alert('Error: Please select an existing button from the dropdown or make a new one.');
      return false;
    }
    if (id === '') {
      alert('Error: Please select an existing button from the dropdown or make a new one.');
      return false;
    }
    const wpedon_alignment = wpedon_alignmentb === 'none' ? '' : ' align="' + wpedon_alignmentb + '"';
    window.send_to_editor('[wpedon id="' + id + '"' + wpedon_alignment + ']');
    document.getElementById('wpedon_button_id').value = '';
    wpedon_alignmentc.selectedIndex = null;
  }
</script>

<div id="wpedon_popup_container" style="display:none;">
    <h2>PayPal & Stripe Donation Button</h2>
    <table>
        <tr>
            <td>
                Choose an existing button:
            </td>
        </tr>
        <tr>
            <td>
                <select id="wpedon_button_id" name="wpedon_button_id">
                    <?php
                    $args = array('post_type' => 'wpplugin_don_button', 'posts_per_page' => -1);
                    $posts = get_posts($args);
                    $count = 0;

                    if (isset($posts)) {
                        foreach ($posts as $post) {
                            $id = $posts[$count]->ID;
                            $post_title = $posts[$count]->post_title;
                            $price = get_post_meta($id, 'wpedon_button_price', true);
                            $sku = get_post_meta($id, 'wpedon_button_id', true);

                            printf('<option value="%d">Name: %s - Amount: %s - ID: %s</option>',
                                $id,
                                esc_html($post_title),
                                esc_html($price),
                                esc_html($sku)
                            );
                            $count++;
                        }
                    } else {
                        echo "<option>No buttons found.</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Make a new button: <a target="_blank" href="<?=get_admin_url(null, 'admin.php?page=wpedon_buttons&action=new');?>">here</a><br/>
                Manage existing buttons: <a target="_blank" href="<?=get_admin_url(null, 'admin.php?page=wpedon_buttons');?>">here</a>
            </td>
        </tr>
        <tr>
            <td>
                <br/>
            </td>
        </tr>
        <tr>
            <td>
                Alignment:
            </td>
        </tr>
        <tr>
            <td>
                <select id="wpedon_align" name="wpedon_align" style="width:100%;max-width:190px;">
                    <option value="none"></option>
                    <option value="left">Left</option>
                    <option value="center">Center</option>
                    <option value="right">Right</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Optional</td>
        </tr>
        <tr>
            <td>
                <br/>
            </td>
        </tr>
        <tr>
            <td>
                <input type="button" id="wpedon-paypal-insert" class="button-primary"
                       onclick="wpedon_button_InsertShortcode();" value="Insert Button">
            </td>
        </tr>
    </table>
</div>