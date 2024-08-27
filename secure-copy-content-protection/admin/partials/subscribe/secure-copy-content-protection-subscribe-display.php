<?php
$actions = new Secure_Copy_Content_Protection_Subscribe_Actions($this->plugin_name);

if (isset($_REQUEST['ays_submit'])) {
    $actions->store_data($_REQUEST);
}

$data = $actions->get_data();
$data_lastIds = $actions->sccp_get_bs_last_id();
$data_lastId = (array) $data_lastIds;
$data_check = $actions->sccp_get_last_id_check();
$data_check = !empty( $data_check[0]) ? implode(' ', $data_check[0]) : '';
$data_check_id = isset($data_check) && $data_check == '' ? "false" : "true";

$bs_last_id = $data_lastId['AUTO_INCREMENT'];
$block_subscribe = array_reverse($data);

$loader_iamge = "<span class='ays_display_none ays_sccp_loader_box'><img src='". SCCP_ADMIN_URL ."/images/loaders/loading.gif'></span>";

$plus_icon_svg = "<span class=''><img src='". SCCP_ADMIN_URL ."/images/icons/plus=icon.svg'></span>";
?>
<div class="wrap ays-sccp-subscribe-block" style="position:relative;">
    <div class="ays-sccp-heading-box">
        <div class="ays-sccp-wordpress-user-manual-box">
            <a href="https://ays-pro.com/wordpress-copy-content-protection-user-manual" target="_blank" style="text-decoration: none;font-size: 13px;">
                <i class="ays_fa ays_fa_file_text"></i>
                <span style="margin-left: 3px;text-decoration: underline;"><?php echo __("View Documentation", $this->plugin_name); ?></span>
            </a>
        </div>
    </div>
    <div class="container-fluid">
        <form method="post">
            <h1 class="wp-heading-inline">
                <?php echo __('Subscribe to view', $this->plugin_name); ?>
            </h1>
            <?php
            if (isset($_REQUEST['status'])) {
                $actions->sccp_subscribe_notices($_REQUEST['status']);
            }
            ?>
            <div class="ays-sccp-save-button">
                <?php
                $save_attributes = array(
                    'id' => 'ays-button',
                    'title' => 'Ctrl + s',
                    'data-toggle' => 'tooltip',
                    'data-delay'=> '{"show":"1000"}'
                );
                submit_button(__('Save changes', $this->plugin_name), 'primary ays-button ays-sccp-save-comp', 'ays_submit', false, $save_attributes);
                echo $loader_iamge;
                ?>
            </div>
            <hr/>
            <div class="row">        
                <div class="col-sm-12">
                    <p style="font-size:14px; font-style:italic;margin:0px;">
                        <?php echo __("Hide the content of your website and display it only for the users who have subscribed. The users who are not subscribed will see the hidden content. Only after providing their email, they will be able to see the content. For activating this option you will need to use the below mention shortcode. Add the first part of the shortcode at the beginning of the content which you want to be hidden and the second part add after the hidden content.", $this->plugin_name); ?>
                            
                    </p>           
                </div>
            </div>
            <hr/>
            <div class="ays-sccp-settings-wrapper">
                                    
                <button type="button" class="button add_new_block_subscribe ays-sccp-add-new-button-new-design button-primary"
                        style="margin-bottom: 20px">
                        <?php 
                            echo $plus_icon_svg; 
                            echo __('Add new', $this->plugin_name);                        
                        ?>
                </button>
                <div class="all_block_subscribes" data-last-id="<?php echo $bs_last_id; ?>">
                    <?php
                     foreach ( $block_subscribe as $key => $blocsubscribe ) { 
                        $block_id = isset($blocsubscribe['id']) ? absint( intval($blocsubscribe['id'])) : $bs_last_id;
                        $block_options = isset($blocsubscribe['options']) ? json_decode($blocsubscribe['options'], true) : array();
                        $block_sub_require_verification = isset($block_options['require_verification']) && $block_options['require_verification'] == 'on' ? 'checked' : '';
                        $enable_block_sub_name_field = isset($block_options['enable_name_field']) && $block_options['enable_name_field'] == 'on' ? 'checked' : '';
                        $enable_block_sub_desc_field = isset($block_options['enable_desc_field']) && $block_options['enable_desc_field'] == 'on' ? 'checked' : '';
                        $enable_block_sub_desc_field_textarea = isset($block_options['enable_desc_textarea']) ? stripslashes( esc_attr( $block_options['enable_desc_textarea'] ) ) : '';
                    ?>
                        <div class="blockcont_one" id="blocksub<?php echo $block_id; ?>" data-block_id="<?php echo $block_id; ?>">
                            <div class="copy_protection_container row ays_bc_row ">
                                <div class="col sccp_block_sub">
                                    <div class="sccp_block_sub_label_inp">
                                        <div class="sccp_block_sub_label">
                                            <label for="sccp_block_subscribe_shortcode_<?php echo $block_id; ?>" class="sccp_bc_label"><?= __('Shortcode', $this->plugin_name); ?></label>
                                        </div>                                    
                                        <div class="sccp_block_sub_inp">
                                            <input type="text" name="sccp_block_subscribe_shortcode[]" id="sccp_block_subscribe_shortcode_<?php echo $block_id; ?>"
                                                   class="ays-text-input sccp_blockcont_shortcode select2_style"
                                                   value="[ays_block_subscribe id='<?php echo $block_id; ?>'] Content [/ays_block_subscribe]"
                                                   readonly>
                                            <input type="hidden" name="sccp_blocksub_id[]" value="<?php echo $block_id; ?>">
                                            <input type="hidden" class="ays_data_checker" value="<?php echo $data_check_id; ?>">
                                        </div>
                                        <hr>
                                        <div class="copy_protection_container row">
                                            <div class="col-sm-4">
                                                <label for="sccp_enable_block_sub_name_field_<?php echo $block_id; ?>"><?= __("Name field", $this->plugin_name); ?></label>
                                                <a class="ays_help" data-toggle="tooltip"
                                                   title="<?= __('Tick the checkbox to show the Name field', $this->plugin_name) ?>">
                                                    <i class="ays_fa ays_fa_info_circle"></i>
                                                </a>
                                            </div>
                                            <div class="col-sm-8">
                                                <input type="checkbox" class="modern-checkbox" id="sccp_enable_block_sub_name_field_<?php echo $block_id; ?>"
                                                       name="sccp_enable_block_sub_name_field[<?php echo $block_id?>][]" 
                                                       <?php echo $enable_block_sub_name_field; ?>
                                                       value="true">
                                               
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="copy_protection_container row block_sub_description">
                                            <div class="col-sm-4">
                                                <label for="sccp_enable_block_sub_desc_field_<?php echo $block_id; ?>"><?= __("Description field", $this->plugin_name); ?></label>
                                                <a class="ays_help" data-toggle="tooltip"
                                                   title="<?= __('Tick the checkbox to show the Description field', $this->plugin_name) ?>">
                                                    <i class="ays_fa ays_fa_info_circle"></i>
                                                </a>
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="checkbox" class="modern-checkbox checkbox_show_hide" id="sccp_enable_block_sub_desc_field_<?php echo $block_id; ?>"
                                                       name="sccp_enable_block_sub_desc_field[<?php echo $block_id?>][]" 
                                                       <?php echo $enable_block_sub_desc_field; ?>
                                                       value="true">
                                            </div>
                                            <div class="col-sm-7 if_desc_textarea_<?php echo $block_id; ?>" <?php echo isset($block_options['enable_desc_field']) && $block_options['enable_desc_field'] == 'on' ? '' : 'style="display: none;"'; ?>>
                                                <textarea class="ays-textarea" cols="33" rows="4" id="sccp_enable_block_sub_desc_field_textarea_<?php echo $block_id; ?>" 
                                                    name="sccp_enable_block_sub_desc_field_textarea_[<?php echo $block_id?>]"><?php echo $enable_block_sub_desc_field_textarea; ?></textarea>
                                            </div>
                                        </div>                          
                                    </div>
                                    <div class="sccp_block_sub_inp_row">
                                        <div class="sccp_pro " title="<?= __('This feature will available in PRO version', $this->plugin_name); ?>">
                                            <div class="pro_features sccp_general_pro">
                                                <div>
                                                    <a href="https://ays-pro.com/wordpress/secure-copy-content-protection/" target="_blank" class="ays-sccp-new-upgrade-button-link">
                                                        <div class="ays-sccp-new-upgrade-button-box">
                                                            <div>
                                                                <img src="<?php echo SCCP_ADMIN_URL.'/images/icons/sccp_locked_24x24.svg'?>">
                                                                <img src="<?php echo SCCP_ADMIN_URL.'/images/icons/sccp_unlocked_24x24.svg'?>" class="ays-sccp-new-upgrade-button-hover">
                                                            </div>
                                                            <div class="ays-sccp-new-upgrade-button"><?php echo __("Upgrade", $this->plugin_name); ?></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="sccp_block_sub_label">
                                                <label for="sccp_require_verification_<?php echo $block_id; ?>" class="sccp_bc_label"><?= __('Require verification', $this->plugin_name); ?></label>
                                            </div>
                                            <div class="sccp_block_sub_inp">
                                                <input type="checkbox" name="sccp_subscribe_require_verification[]" id="sccp_require_verification_<?php echo $block_id; ?>"
                                                       class="sccp_blocksub select2_style" value="on"
                                                       <?php echo  $block_sub_require_verification; ?>
                                                       >
                                                <input type="hidden" name="sub_require_verification[]" class="sccp_blocksub_hid" value="<?php echo isset($block_options['require_verification']) && $block_options['require_verification'] == 'on' ? 'on' : 'off'; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <br>
                                    <p class="blocksub_delete_icon"><i class="ays_fa fa-trash-o" aria-hidden="true"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <input type="hidden" class="deleted_ids" value="" name="deleted_ids">
                </div>
                <button type="button" class="button add_new_block_subscribe ays-sccp-add-new-button-new-design button-primary"
                        style="margin-top: 20px">
                        <?php 
                            echo $plus_icon_svg; 
                            echo __('Add new', $this->plugin_name);                        
                        ?>                        
                </button> 
                <hr/>                        
            </div>
            <div class="ays-sccp-save-button">
                <?php
                wp_nonce_field('subscribe_action', 'subscribe_action');
                $save_bottom_attributes = array(
                    'title' => 'Ctrl + s',
                    'data-toggle' => 'tooltip',
                    'data-delay'=> '{"show":"1000"}'
                );
                submit_button(__('Save changes', $this->plugin_name), 'primary ays-button ays-sccp-save-comp', 'ays_submit', false, $save_bottom_attributes);
                echo $loader_iamge;
                ?>
            </div>
        </form>
    </div>
</div>