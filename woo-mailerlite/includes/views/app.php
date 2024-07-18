<?php

use MailerLite\Includes\Classes\Process\ProductProcess;
use MailerLite\Includes\Classes\Settings\MailerLiteSettings;
use MailerLite\Includes\Classes\Settings\ShopSettings;


if (isset($_POST['group'])) {
    if (!wp_verify_nonce($_POST['_wpnonce'], 'ml_save_settings_nonce')) {
        exit;
    }
    if(!isset($_POST['checkout'])) {
        $_POST = array_diff_key($_POST, array_flip(['checkout_position', 'checkout_preselect', 'checkout_hide', 'checkout_label', 'disable_checkout_sync']));
    }
    $_POST['resubscribe']           = $_POST['resubscribe'] ?? 'no';
    $_POST['additional_sub_fields'] = $_POST['additional_sub_fields'] ?? 'no';
    $_POST['checkout_preselect']    = $_POST['checkout_preselect'] ?? 'no';
    $_POST['disable_checkout_sync'] = $_POST['disable_checkout_sync'] ?? 'no';
    $_POST['popups']                = $_POST['popups'] ?? 'no';
    $_POST['auto_update_plugin']    = $_POST['auto_update_plugin'] ?? 'no';
    $_POST['double_optin']          = $_POST['double_optin'] ?? 'no';
    $_POST['checkout_hide']         = $_POST['checkout_hide'] ?? 'no';
    $_POST['checkout']              = $_POST['checkout'] ?? 'no';
    $_POST['checkout_label']        = (isset($_POST['checkout_label']) && ($_POST['checkout_label'] != '')) ? $_POST['checkout_label'] : 'Yes, I want to receive your newsletter.';
    $_POST['sync_fields']           = $_POST['sync_fields'] ?? [];

    update_option('woocommerce_mailerlite_settings',
        apply_filters('woocommerce_settings_api_sanitized_fields_mailerlite', array_merge($this->settings, $_POST)), 'yes');
    $this->settings = get_option('woocommerce_mailerlite_settings');
}

if(isset($_POST['resetIntegration'])) {
    if (!wp_verify_nonce($_POST['_wpnonce'], 'ml_reset_integration')) {
        exit;
    }
    MailerLiteSettings::getInstance()->softReset();
}
if (!is_array($this->settings)) {
    MailerLiteSettings::getInstance()->softReset();
}
$checkoutPositions        = [
    'checkout_billing'                => 'After billing details',
    'checkout_billing_email'          => 'After billing email address',
    'checkout_shipping'               => 'After shipping details',
    'checkout_after_customer_details' => 'After customer details',
    'review_order_before_submit'      => 'Before submit button',
];
$selectedCheckoutPosition = $this->settings['checkout_position'];

$checkoutDisabled = !($this->settings['checkout'] == 'yes');
$currentGroup = MailerLiteSettings::getInstance()->getCurrentSelectedGroup();
?>
<div class="woo-ml-wizard">
    <div class="woo-ml-header">
        <!-- MailerLite logo -->
        <div>
            <svg width="116" height="31" viewBox="0 0 116 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_123_132)">
                    <path d="M15.6136 16.3109C13.7098 16.3109 12.1972 17.0609 11.1279 18.5352C10.502 17.3972 9.25014 16.3109 7.34632 16.3109C5.39033 16.3109 4.24281 17.1644 3.43434 18.0696V17.811C3.43434 17.0609 2.80842 16.4402 2.05211 16.4402C1.29579 16.4402 0.695953 17.0609 0.695953 17.811V28.2341C0.695953 28.9841 1.29579 29.579 2.05211 29.579C2.80842 29.579 3.43434 28.9841 3.43434 28.2341V21.0181C4.06025 20.0094 4.99913 18.8714 6.69432 18.8714C8.31127 18.8714 8.93719 19.6473 8.93719 21.6647V28.2341C8.93719 28.9841 9.53702 29.579 10.2933 29.579C11.0497 29.579 11.6756 28.9841 11.6756 28.2341V21.0181C12.3015 20.0094 13.2404 18.8714 14.9356 18.8714C16.5525 18.8714 17.1784 19.6473 17.1784 21.6647V28.2341C17.1784 28.9841 17.7783 29.579 18.5346 29.579C19.2909 29.579 19.9168 28.9841 19.9168 28.2341V21.225C19.969 18.8455 18.6128 16.3109 15.6136 16.3109ZM28.7579 16.3109C27.2452 16.3109 25.863 16.5954 24.4286 17.2161C23.9331 17.423 23.6201 17.8369 23.6201 18.38C23.6201 19.0525 24.1417 19.5697 24.7937 19.5697C24.8981 19.5697 25.0285 19.5439 25.1849 19.518C26.1499 19.2076 27.0627 18.949 28.3667 18.949C30.4791 18.949 31.3659 19.7249 31.3919 21.6388H28.6796C24.9763 21.6388 22.7856 23.2165 22.7856 25.8288C22.7856 28.3893 24.9241 29.7342 27.0366 29.7342C28.7318 29.7342 30.1923 29.2169 31.3919 28.2341V28.26C31.3919 29.01 31.9918 29.6049 32.7481 29.6049C33.5044 29.6049 34.1303 29.01 34.1303 28.26V21.3802C34.1303 18.8455 32.4612 16.3109 28.7579 16.3109ZM27.8712 27.2254C26.3324 27.2254 25.524 26.6564 25.524 25.5443C25.524 25.1304 25.524 23.889 28.9665 23.889H31.3659V25.5701C30.6617 26.346 29.3316 27.2254 27.8712 27.2254ZM39.5028 11.4485C40.3373 11.4485 41.0154 12.121 41.0154 12.9486V13.0521C41.0154 13.8797 40.3373 14.5522 39.5028 14.5522H39.3463C38.5117 14.5522 37.8337 13.8797 37.8337 13.0521V12.9486C37.8337 12.121 38.5117 11.4485 39.3463 11.4485H39.5028ZM39.4245 16.4143C40.2069 16.4143 40.8068 17.0351 40.8068 17.7851V28.2082C40.8068 28.9583 40.2069 29.5531 39.4245 29.5531C38.6682 29.5531 38.0684 28.9583 38.0684 28.2082V17.7851C38.0684 17.0092 38.6682 16.4143 39.4245 16.4143ZM46.3879 11.0605C47.1702 11.0605 47.7701 11.6813 47.7701 12.4313V28.2082C47.7701 28.9583 47.1702 29.5531 46.3879 29.5531C45.6315 29.5531 45.0317 28.9583 45.0317 28.2082V12.4313C45.0317 11.6554 45.6315 11.0605 46.3879 11.0605ZM57.2631 16.3109C55.3072 16.3109 53.6902 17.0351 52.5949 18.4059C51.656 19.5956 51.1344 21.225 51.1344 23.0096C51.1344 27.1995 53.612 29.7083 57.7326 29.7083C60.0015 29.7083 61.123 29.1911 62.1401 28.5962C62.6356 28.3117 62.8964 27.8979 62.8964 27.484C62.8964 26.8116 62.3487 26.2684 61.6446 26.2684C61.4359 26.2684 61.2534 26.2943 61.0969 26.3978C60.3666 26.7857 59.4539 27.1219 57.9151 27.1219C55.6201 27.1219 54.264 26.0615 53.9249 24.0442H61.9314C62.7399 24.0442 63.3137 23.4752 63.3137 22.6992C63.3658 18.3024 60.2102 16.3109 57.2631 16.3109ZM57.2631 18.6904C58.4107 18.6904 60.3406 19.337 60.6014 21.7164H53.9249C54.1857 19.6215 55.7505 18.6904 57.2631 18.6904ZM72.885 16.3109C73.6413 16.3109 74.2151 16.8799 74.2151 17.6299C74.2151 18.38 73.6413 18.9231 72.8328 18.9231H72.7024C71.2941 18.9231 70.0423 19.6215 69.1556 20.8888V28.2082C69.1556 28.9583 68.5296 29.5531 67.7733 29.5531C67.017 29.5531 66.4172 28.9583 66.4172 28.2082V17.7851C66.4172 17.0351 67.017 16.4143 67.7733 16.4143C68.5296 16.4143 69.1556 17.0351 69.1556 17.7851V18.1214C70.2509 16.9316 71.4506 16.3109 72.7546 16.3109H72.885Z"
                          fill="black"/>
                    <path d="M111.572 0.917969H83.4383C81.2701 0.917969 79.472 2.69841 79.472 4.84542V17.9369V20.5028V29.7978L84.9455 24.4303H111.599C113.767 24.4303 115.565 22.6498 115.565 20.5028V4.84542C115.538 2.67223 113.767 0.917969 111.572 0.917969Z"
                          fill="#09C269"/>
                    <path d="M106.39 10.0297C109.404 10.0297 110.779 12.4123 110.779 14.6117C110.779 15.2139 110.329 15.6328 109.721 15.6328H104.168C104.433 16.9682 105.385 17.6751 106.892 17.6751C107.976 17.6751 108.584 17.4395 109.113 17.1776C109.245 17.0991 109.377 17.0729 109.536 17.0729C110.065 17.0729 110.488 17.4918 110.488 18.0155C110.488 18.3559 110.277 18.6701 109.906 18.8795C109.166 19.2985 108.373 19.665 106.733 19.665C103.772 19.665 101.974 17.8584 101.974 14.8474C101.974 11.3127 104.354 10.0297 106.39 10.0297ZM97.5581 8.48489C97.9018 8.48489 98.1398 8.74672 98.1398 9.0871V10.1868H99.8321C100.361 10.1868 100.784 10.6057 100.784 11.1294C100.784 11.653 100.361 12.072 99.8321 12.072H98.1663V16.9944C98.1663 17.7013 98.5364 17.7537 99.0388 17.7537C99.3297 17.7537 99.4883 17.7013 99.647 17.6751C99.7792 17.6489 99.9114 17.5966 100.07 17.5966C100.493 17.5966 100.969 17.9369 100.969 18.4868C100.943 18.8272 100.758 19.1414 100.414 19.2985C99.9114 19.5341 99.409 19.6388 98.8537 19.6388C97.0293 19.6388 96.0509 18.7748 96.0509 17.1253V12.072H95.099C94.7553 12.072 94.5173 11.8101 94.5173 11.4959C94.5173 11.3127 94.5966 11.1294 94.7553 10.9985L97.0821 8.72054C97.135 8.66818 97.3201 8.48489 97.5581 8.48489ZM86.8492 6.33789C87.431 6.33789 87.9069 6.80918 87.9069 7.38521V18.513C87.9069 19.089 87.431 19.5341 86.8492 19.5341C86.2675 19.5341 85.818 19.0628 85.818 18.513V7.38521C85.818 6.80918 86.2675 6.33789 86.8492 6.33789ZM91.7674 10.1082C92.3491 10.1082 92.825 10.5795 92.825 11.1556V18.513C92.825 19.089 92.3491 19.5341 91.7674 19.5341C91.1857 19.5341 90.7362 19.0628 90.7362 18.513V11.1556C90.7362 10.5795 91.1857 10.1082 91.7674 10.1082ZM106.416 11.8887C105.411 11.8887 104.354 12.4909 104.168 13.8786H108.69C108.478 12.4909 107.421 11.8887 106.416 11.8887ZM91.8203 6.59972C92.4549 6.59972 92.9573 7.0972 92.9573 7.72559V7.80414C92.9573 8.43253 92.4549 8.93001 91.8203 8.93001H91.7145C91.0799 8.93001 90.5775 8.43253 90.5775 7.80414V7.72559C90.5775 7.0972 91.0799 6.59972 91.7145 6.59972H91.8203Z"
                          fill="white"/>
                </g>
                <defs>
                    <clipPath id="clip0_123_132">
                        <rect width="115" height="29.3249" fill="white"
                              transform="translate(0.617676 0.710938)"/>
                    </clipPath>
                </defs>
            </svg>
        </div>
        <!-- MailerLite logo -->
        <div class="status flex-ml align-items-center-ml">
            <div style="padding: 2px 8px; background-color: rgba(9, 194, 105, 0.3); border-radius: 4px;">
                <span style="color: #022715; font-size: 13px;">
                    Connected
                </span>
            </div>
            <div class="separator-bubble-ml"></div>
            <div>
                <h3 style="font-weight: 500; font-size: 14px; margin-bottom: 0;">MailerLite WooCommerce integration</h3>
                <p style="font-size: 12px; font-weight: 400; margin-top: 0; color: rgba(0,0,0,0.5);"><?php echo get_option("woo_ml_account_name", false) ? "Account: " . get_option("woo_ml_account_name", false): "" ; ?></p>
                <input type="hidden" value="<?php echo get_option("account_id", false); ?>" id="woo_ml_account_id"/>
            </div>
        </div>
    </div>
    <?php require_once __DIR__.'/./components/woo-mailerlite-alerts.php'; ?>

    <input type="hidden" value="<?php echo $this->settings['group'] ?? ''; ?>" id="selectedGroupValue"/>
    <input type="hidden" value="<?php echo $total_untracked_resources ?? 0; ?>" id="totalUntrackedResources"/>
    <input type="hidden" id="woo_ml_wizard_step" value="<?php echo get_option('woo_ml_wizard_setup'); ?>"</input>
    <form method="post" id="updateSettingsForm">
        <div class="settings-block">
            <div class="settings-block-fixed">
                <h2 class="settings-block-header">Synchronization settings</h2>
                <div class="form-group-ml vertical">
                    <label for="wooMlSubGroup" class="settings-label mb-3-ml">Subscriber group</label>
                    <label class="input-mailerlite mb-2-ml" style="display: flex;">
                        <select id="wooMlSubGroup" class="wc-enhanced-select" type="select" name="group"
                                style="width: 100%;">
                            <option value="<?php echo $currentGroup['id'] ?? ''; ?>" selected="selected" ><?php echo $currentGroup['name'] ?? ''; ?></option>
                        </select>
                        <button id="createGroupModal" type="button" class="btn-secondary-ml" style="margin-left: 0.5rem; white-space: nowrap;">Create group</button>
                    </label>
                    <label class="settings-label-small">Subscribers from WooCommerce will join this MailerLite
                        subscriber group. </label>
                </div>

                <div class="form-group-ml vertical">
                    <label for="wooMlSubGroup" class="settings-label flex-ml align-items-center-ml mb-3-ml">Ignore products list
                        <div class="tooltip-ml">
                            <span class="tooltiptext-ml">This field lists products that are configured to be ignored in MailerLite e-commerce automation. To add or remove a product from this list, go to the WordPress product list and click "Quick Edit" on the relevant item.</span>
                        </div>
                    </label>
                    <?php
                    $ignoredProducts = ProductProcess::getInstance()->getIgnoredProductList();
                    if(!empty($ignoredProducts)) {
                        ?>
                        <label class="input-mailerlite" style="cursor: default;">
                            <div multiple class="wc-enhanced-select" name="ignore_product_list"
                                 style="min-height: 26px; padding-left: 8px; display: flex; flex-direction: row; overflow: hidden; flex-wrap: wrap; padding: 4px; padding-top: 0; border: 1px solid #d1d5db; border-radius: 0.25rem;">
                                <?php
                                foreach ($ignoredProducts as $product) {
                                    ?>
                                    <option style="background-color: #e5e7eb; padding: 2px 5px; border-radius: 2px; font-size: 13px; margin-right: 4px; margin-top: 4px;"><?php echo $product; ?></option>
                                    <?php
                                }
                                ?>
                            </div>
                        </label>
                    <?php } else { ?>
                        <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=product' ) ); ?>">
                            <button type="button" class="btn btn-secondary-ml flex-start-ml">Go to your products</button>
                        </a>
                    <?php } ?>
                </div>
                <div class="form-group-ml vertical">
                    <label for="wooMlSubGroup" class="settings-label flex-ml align-items-center-ml mb-3-ml">Add language
                        field
                        <div class="tooltip-ml">
                            <span class="tooltiptext-ml">Collect subscriber languages in a hidden field stored in MailerLite.</span>
                        </div>
                    </label>
                    <div class="checkbox-text-ml">
                        <input type="checkbox"
                               class="woo-ml-form-checkbox" <?php echo $this->settings['additional_sub_fields'] == 'yes' ? 'checked' : ''; ?>
                               name="additional_sub_fields"
                               value="yes"
                               id="language_field_checkbox"
                        />
                        <label for="language_field_checkbox" class="settings-label-medium">Collect subscriber language data.</label>
                    </div>
                </div>
                <?php
                $syncFields = $this->settings['sync_fields'] ?? ShopSettings::getInstance()->initSyncFields();
                ?>
                <div class="form-group-ml vertical">
                    <label for="sync_fields" class="settings-label flex-ml align-items-center-ml mb-3-ml">
                        Synced fields
                        <div class="tooltip-ml">
                            <span class="tooltiptext-ml">Select which fields you would like to sync. Please note that Email and Name fields are mandatory.</span>
                        </div>
                    </label>
                    <label class="input-mailerlite">
                        <select id="sync_fields" multiple="multiple" name="sync_fields[]" data-placeholder="Click to select fields you want to sync" class="wc-enhanced-select" style="width: 100%;">
                            <option value="name" ml-default data-badge="" <?php echo in_array('name', $syncFields) ? 'selected' : '';
                            ?>>Name</option>
                            <option value="email" ml-default data-badge="" <?php echo in_array('email', $syncFields) ? 'selected' : '';
                            ?>>Email</option>
                            <option value="company" data-badge="" <?php echo in_array('company', $syncFields) ? 'selected' : ''; ?>>Company</option>
                            <option value="city" data-badge="" <?php echo in_array('city', $syncFields) ? 'selected' : '';
                            ?>>City</option>
                            <option value="zip" data-badge="" <?php echo in_array('zip', $syncFields) ? 'selected' : '';
                            ?>>ZIP</option>
                            <option value="state" data-badge="" <?php echo in_array('state', $syncFields) ? 'selected' : '';
                            ?>>State</option>
                            <option value="country" data-badge="" <?php echo in_array('country', $syncFields) ? 'selected' : ''; ?>>Country</option>
                            <option value="phone" data-badge="" <?php echo in_array('phone', $syncFields) ? 'selected' : '';
                            ?>>Phone</option>
                        </select>
                    </label>
                </div>
                <div class="form-group-ml vertical">
                    <label for="wooMlSubGroup" class="settings-label flex-ml align-items-center-ml mb-3-ml">Synchronize
                        store
                        <div class="tooltip-ml">
                            <span class="tooltiptext-ml">Synchronize categories, products and customer data that hasn't been submitted to MailerLite.</span>
                        </div>
                    </label>
                <?php if ( ! get_transient('woo_ml_resource_sync_in_progress')) { ?>
                    <input type="hidden" name="ml_platform" id="ml_platform"
                           value="<?php echo get_option('woo_mailerlite_platform', 1); ?>"/>
                <?php } ?>
                <?php if ( ! MailerLiteSettings::getInstance()->getMlOption('api_status', false)) { ?>
                    <p class="description">
                        <?php _e('Plugin not connected to MailerLite yet.', 'woo-mailerlite'); ?>
                    </p>
                <?php } elseif ($total_tracked_resources === 0 && $total_untracked_resources === 0) { ?>
                    <p class="description">
                <?php _e('No shop resources found.', 'woo-mailerlite'); ?>
                    </p>
                <?php } elseif (!empty($total_untracked_resources) && !get_transient('woo_ml_resource_sync_in_progress')) { ?>
                    <legend class="screen-reader-text">
                        <span><?php echo wp_kses_post('Synchronize Shop'); ?></span>
                    </legend>
                    <button type="button" id="startImport" class="btn-secondary-ml">
                        <?php printf(esc_html(_n('Synchronize %d untracked resources',
                            'Synchronize %d untracked resources', $total_untracked_resources)),
                            $total_untracked_resources); ?>
                    </button>
                    <?php if (!get_option('woo_ml_last_synced_customer', 0) && !(get_option('woo_ml_new_sync', 0))): ?>
                        <div class="woo-ml-alert-warning-small mb-2" style="display:flex; align-items: center;">
                            <svg width="12" height="12" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10,0 C15.5228475,0 20,4.4771525 20,10 C20,15.5228475 15.5228475,20 10,20 C4.4771525,20 0,15.5228475 0,10 C0,4.4771525 4.4771525,0 10,0 Z M10,2 C5.581722,2 2,5.581722 2,10 C2,14.418278 5.581722,18 10,18 C14.418278,18 18,14.418278 18,10 C18,5.581722 14.418278,2 10,2 Z M10,12 C10.5522847,12 11,12.4477153 11,13 C11,13.5522847 10.5522847,14 10,14 C9.44771525,14 9,13.5522847 9,13 C9,12.4477153 9.44771525,12 10,12 Z M10,5 C10.5522847,5 11,5.44771525 11,6 L11,10 C11,10.5522847 10.5522847,11 10,11 C9.44771525,11 9,10.5522847 9,10 L9,6 C9,5.44771525 9.44771525,5 10,5 Z" fill-rule="nonzero"></path></svg>
                            We updated the syncing process to make it faster. Please sync your resources again.</div>
                    <?php endif ?>
                <?php } elseif (empty($total_untracked_resources) && !get_transient('woo_ml_resource_sync_in_progress')) { ?>
                    <button type="button" class="btn btn-secondary-ml flex-start-ml"
                            data-woo-ml-reset-resources-sync="true">Reset synchronized resources
                    </button>

                <?php } else { ?>
                    <p class="description">
                        <?php _e('Right now there are no untracked resources.', 'woo-mailerlite'); ?>
                    </p>
                <?php } ?>

                </div>
            </div>
        </div>

        <div class="settings-block">
            <div class="settings-block-fixed">
                <h2 class="settings-block-header">Checkout settings</h2>
                <div class="form-group-ml vertical">
                    <label for="wooMlSubGroup" class="settings-label mb-3-ml">Subscribe on checkout</label>
                    <div class="checkbox-text-ml">
                        <input type="checkbox"
                               class="woo-ml-form-checkbox" <?php echo $this->settings['checkout'] == 'yes' ? 'checked' : ''; ?>
                               name="checkout"
                               value="yes"
                               id="subscribe_checkout_checkbox"
                        />
                        <label for="subscribe_checkout_checkbox" class="settings-label-medium">Enable list subscription via checkout page.</label>
                    </div>
                </div>
                <div class="checkout-settings-group" style="display: <?php echo $checkoutDisabled ? "none;" : "block;" ?>">
                    <div class="form-group-ml vertical">
                        <label for="wooMlSubGroup" class="settings-label mb-3-ml"> Resubscribe</label>
                        <div class="checkbox-text-ml">
                            <input type="checkbox"
                                   class="woo-ml-form-checkbox" <?php echo $this->settings['resubscribe'] == 'yes' ? 'checked' : ''; ?>
                                   name="resubscribe"
                                   value="yes"
                                   id="resubscribe_checkbox"
                            />
                            <label for="resubscribe_checkbox" class="settings-label-medium"> Allow unsubscribers to rejoin the email list if they
                                resubscribe via the checkout page.</label>
                        </div>
                    </div>
                    <div class="form-group-ml vertical">
                        <label for="wooMlSubGroup" class="settings-label mb-3-ml">Subscribe checkbox position</label>
                        <label class="input-mailerlite">
                            <select class="wc-enhanced-select" name="checkout_position" <?php echo $checkoutDisabled ? "disabled" : "" ?>>
                                <?php
                                foreach ($checkoutPositions as $key => $checkout_position) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php echo $selectedCheckoutPosition == $key ? 'selected=selected' : ''; ?>><?php echo $checkout_position; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </label>
                    </div>
                    <div class="form-group-ml vertical">
                        <label for="wooMlSubGroup" class="settings-label mb-3-ml">Pre-select subscribe checkbox</label>
                        <div class="checkbox-text-ml">
                            <input type="checkbox"
                                   class="woo-ml-form-checkbox" <?php echo $this->settings['checkout_preselect'] == 'yes' ? 'checked' : ''; ?>
                                   name="checkout_preselect"
                                   value="yes"
                                   id="preselect_subscribe_checkbox"
                                <?php echo $checkoutDisabled ? "disabled" : "" ?>
                            />
                            <label for="preselect_subscribe_checkbox" class="settings-label-medium">Pre-select the signup checkbox by default.</label>
                        </div>
                    </div>
                    <div class="form-group-ml vertical">
                        <label for="wooMlSubGroup" class="settings-label mb-3-ml">Hide subscribe checkbox</label>
                        <div class="checkbox-text-ml">
                            <input type="checkbox"
                                   class="woo-ml-form-checkbox" <?php echo $this->settings['checkout_hide'] == 'yes' ? 'checked' : ''; ?>
                                   name="checkout_hide"
                                   value="yes"
                                   id="hide_subscriber_checkbox"
                                <?php echo $checkoutDisabled ? "disabled" : "" ?>
                            />
                            <label for="hide_subscriber_checkbox" class="settings-label-medium">Check to hide the checkbox. All customers will be
                                subscribed automatically.</label>
                        </div>
                    </div>
                    <div class="form-group-ml vertical">
                        <label for="wooMlSubGroup" class="settings-label mb-3-ml">Subscribe checkbox label</label>
                        <label class="input-mailerlite">
                            <input type="text"
                                   class="woo-ml-form-checkbox text-input flex-start-ml mb-3-ml"
                                   value="<?php echo $this->settings['checkout_label'] ?? 'Yes, I want to receive your newsletter.'; ?>"
                                   name="checkout_label"
                                   placeholder="I.e. I want to receive your newsletter."
                                <?php echo $checkoutDisabled ? "disabled" : "" ?>
                            />
                        </label>
                        <label class="settings-label-small">This text will be displayed next to the signup
                            checkbox. </label>
                    </div>
                    <div class="form-group-ml vertical">
                        <label for="wooMlSubGroup" class="settings-label flex-ml align-items-center-ml mb-3-ml">Add subscribers after checkout
                            <div class="tooltip-ml">
                                <span class="tooltiptext-ml">Only customers that have completed the checkout process will be added to your MailerLite account as subscribers. Enabling this option disables abandoned cart functionality.</span>
                            </div>
                        </label>
                        <div class="checkbox-text-ml">
                            <input type="checkbox"
                                   class="woo-ml-form-checkbox" <?php echo $this->settings['disable_checkout_sync'] == 'yes' ? 'checked' : ''; ?>
                                   name="disable_checkout_sync"
                                   value="yes"
                                   id="synchronize_after_checkout_checkbox"
                                <?php echo $checkoutDisabled ? "disabled" : "" ?>
                            />
                            <label for="synchronize_after_checkout_checkbox" class="settings-label-medium">Add subscribers to your MailerLite account after the checkout process has been completed.</label>
                        </div>
                        <div class="woo-ml-alert-warning-small" style="display:<?php echo $this->settings['disable_checkout_sync'] == 'yes' ? 'flex;' : 'none;' ?> align-items: center;">
                            <svg width="12" height="12" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10,0 C15.5228475,0 20,4.4771525 20,10 C20,15.5228475 15.5228475,20 10,20 C4.4771525,20 0,15.5228475 0,10 C0,4.4771525 4.4771525,0 10,0 Z M10,2 C5.581722,2 2,5.581722 2,10 C2,14.418278 5.581722,18 10,18 C14.418278,18 18,14.418278 18,10 C18,5.581722 14.418278,2 10,2 Z M10,12 C10.5522847,12 11,12.4477153 11,13 C11,13.5522847 10.5522847,14 10,14 C9.44771525,14 9,13.5522847 9,13 C9,12.4477153 9.44771525,12 10,12 Z M10,5 C10.5522847,5 11,5.44771525 11,6 L11,10 C11,10.5522847 10.5522847,11 10,11 C9.44771525,11 9,10.5522847 9,10 L9,6 C9,5.44771525 9.44771525,5 10,5 Z" fill-rule="nonzero"></path></svg>
                            Enabling this option disables abandoned cart functionality.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="settings-block">
            <div class="settings-block-fixed">
                <h2 class="settings-block-header">General settings</h2>
                <div class="form-group-ml vertical">
                    <label for="wooMlSubGroup" class="settings-label flex-ml align-items-center-ml mb-3-ml">Double opt-in
                        <div class="tooltip-ml">
                            <span class="tooltiptext-ml">Changing this setting will automatically update your double opt-in setting for your MailerLite account.</span>
                        </div>
                    </label>
                    <div class="checkbox-text-ml">
                        <input type="checkbox"
                               class="woo-ml-form-checkbox" <?php echo $this->settings['double_optin'] == 'yes' ? 'checked' : ''; ?>
                               name="double_optin"
                               value="yes"
                               id="double_optin_checkbox"
                        />
                        <label for="double_optin_checkbox" class="settings-label-medium">Check to enforce email confirmation before being added
                            to your list.</label>
                    </div>
                </div>
                <div class="form-group-ml vertical">
                    <label for="wooMlSubGroup" class="settings-label mb-3-ml"> MailerLite pop-ups</label>
                    <div class="checkbox-text-ml">
                        <input type="checkbox"
                               class="woo-ml-form-checkbox" <?php echo $this->settings['popups'] == 'yes' ? 'checked' : ''; ?>
                               name="popups"
                               value="yes"
                               id="mailerlite_popups_checkbox"
                        />
                        <label for="mailerlite_popups_checkbox" class="settings-label-medium">Enable MailerLite pop-up forms. <a href="https://www.mailerlite.com/features/popups" target="_blank">Learn more.</a></label>
                    </div>
                </div>
                <div class="form-group-ml vertical">
                    <label for="wooMlSubGroup" class="settings-label mb-3-ml">Auto updates</label>
                    <div class="checkbox-text-ml">
                        <input type="checkbox"
                               class="woo-ml-form-checkbox" <?php echo $this->settings['auto_update_plugin'] == 'yes' ? 'checked' : ''; ?>
                               name="auto_update_plugin"
                               value="yes"
                               id="autoupdate_plugin_checkbox"
                        />
                        <label for="autoupdate_plugin_checkbox" class="settings-label-medium">Receive automatic plugin updates.</label>
                    </div>
                </div>
            </div>
        </div>

        <?php  wp_nonce_field('ml_save_settings_nonce'); ?>
        <div class="settings-block" style="display: flex; justify-content: flex-end;">
            <button type="submit" class="btn-primary-ml" style="margin-top: 2rem;" id="updateSettingsBtn"><span class="woo-ml-button-text">Save changes</span></button>
        </div>
    </form>
</div>
<?php if ( ! isset($stepThree)) : ?>
    <div class="woo-ml-wizard card-between">
        <div>
            <h2 class="settings-block-header" style="margin-top:0; margin-bottom: 8px;">Debug logs</h2>
            <label class="settings-label-medium">This is an advanced troubleshooting method which gives a deeper insight and helps our support team to identify problems.</label>
        </div>
        <button type="button" id="openDebugLog" class="btn-secondary-ml"><span class="woo-ml-button-text">Open debug logs</span></button>
    </div>
    <div class="woo-ml-wizard card-between">
        <div>
            <h2 class="settings-block-header" style="margin-top:0; margin-bottom: 8px;">Reset integration</h2>
            <label class="settings-label-medium">Once you click on the "Reset integration" button this action will reset
                all integration configurations and the process can not be reverted.</label>
        </div>
        <button type="button" id="wooMlResetIntegration" class="btn-danger-ml">Reset integration</button>
    </div>
<?php endif; ?>

<?php require_once __DIR__.'/./components/woo-mailerlite-modals.php'; ?>

