<div class="wrap copy_protection_wrap container-fluid">
    <div class="ays-sccp-heading-box">
        <div class="ays-sccp-wordpress-user-manual-box">
            <a href="https://ays-pro.com/wordpress-copy-content-protection-user-manual" target="_blank" style="text-decoration: none;font-size: 13px;">
                <i class="ays_fa ays_fa_file_text"></i>
                <span style="margin-left: 3px;text-decoration: underline;"><?php echo __("View Documentation", $this->plugin_name); ?></span>
            </a>
        </div>
    </div>
    <h1 class="wp-heading-inline">
		<?php echo __(esc_html(get_admin_page_title()), $this->plugin_name); ?>
        
    </h1>

    <div id="features" class="only_pro">
        <div class="copy_protection_container form-group row">
            <div class="ays-sccp-features-wrap" style="width: 100%">
                <div class="comparison">
                    <table>
                        <thead>
                        <tr>
                            <th class="tl tl2"></th>
                            <th class="product"
                                style="background:#69C7F1; border-top-left-radius: 5px; border-left:0px;">
                                <span style="display: block"><?php echo __('Personal', $this->plugin_name) ?></span>
                                <img src="<?php echo SCCP_ADMIN_URL . '/images/avatars/personal_avatar.png'; ?>"
                                     alt="Free" title="Free" width="100"/>
                            </th>
                            <th class="product" style="background:#69C7F1;">
                                <span style="display: block"><?php echo __('Business', $this->plugin_name) ?></span>
                                <img src="<?php echo SCCP_ADMIN_URL . '/images/avatars/business_avatar.png'; ?>"
                                     alt="Business" title="Business" width="100"/>
                            </th>
                            <th class="product"
                                style="border-top-right-radius: 5px; border-right:0px; background:#69C7F1;">
                                <span style="display: block"><?php echo __('Developer', $this->plugin_name) ?></span>
                                <img src="<?php echo SCCP_ADMIN_URL . '/images/avatars/pro_avatar.png'; ?>"
                                     alt="Developer" title="Developer" width="100"/>
                            </th>
                        </tr>
                        <tr>
                            <th></th>
                            <th class="price-info">
                                <div class="price-now"><span><?php echo __('Free', $this->plugin_name) ?></span></div>
                            </th>
                            <th class="price-info">
                                <div class="price-now"><span style="text-decoration: line-through; color: red;">$75</span>
                                </div>
                                <div class="price-now"><span>$49</span>
                                </div>                                
                                <div class="ays-sccp-pracing-table-td-flex">
                                    <a href="https://ays-pro.com/wordpress/secure-copy-content-protection" class="price-buy"><?php echo __('Buy now',$this->plugin_name)?><span class="hide-mobile"></span></a>
                                    <span><?php echo __('(One-time payment)', $this->plugin_name); ?></span>
                                </div>
                            </th>
                            <th class="price-info">
                                <div class="price-now"><span style="text-decoration: line-through; color: red;">$250</span>
                                </div>
                                <div class="price-now"><span>$149</span>
                                </div>                                
                                <div class="ays-sccp-pracing-table-td-flex">
                                    <a href="https://ays-pro.com/wordpress/secure-copy-content-protection" class="price-buy"><?php echo __('Buy now',$this->plugin_name)?><span class="hide-mobile"></span></a>
                                    <span><?php echo __('(One-time payment)', $this->plugin_name); ?></span>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td></td>
                            <td colspan="4"><?php echo __('Support for', $this->plugin_name) ?></td>
                        </tr>
                        <tr class="compare-row">
                            <td><?php echo __('Support for', $this->plugin_name) ?></td>
                            <td><?php echo __('1 site', $this->plugin_name) ?></td>
                            <td><?php echo __('5 site', $this->plugin_name) ?></td>
                            <td><?php echo __('Unlimited sites', $this->plugin_name) ?></td>
                        </tr>    
                        <tr>
                            <td> </td>
                            <td colspan="3"><?php echo __('Upgrade for', $this->plugin_name) ?></td>
                        </tr>
                        <tr>
                            <td><?php echo __('Upgrade for', $this->plugin_name) ?></td>
                            <td><?php echo __('1 months', $this->plugin_name) ?></td>
                            <td><?php echo __('12 months', $this->plugin_name) ?></td>
                            <td><?php echo __('Lifetime', $this->plugin_name) ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="4"><?php echo __('Support for', $this->plugin_name) ?></td>
                        </tr>
                        <tr class="compare-row">
                            <td><?php echo __('Support for', $this->plugin_name) ?></td>
                            <td><?php echo __('1 months', $this->plugin_name) ?></td>
                            <td><?php echo __('12 months', $this->plugin_name) ?></td>
                            <td><?php echo __('Lifetime', $this->plugin_name) ?></td>
                        </tr>                                            
                        <tr>
                            <td> </td>
                            <td colspan="3"><?php echo __('Usage for lifetime', $this->plugin_name) ?></td>
                        </tr>
                        <tr>
                            <td><?php echo __('Usage for lifetime', $this->plugin_name) ?></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td colspan="3"><?php echo __('Content Protection', $this->plugin_name) ?></td>
                        </tr>
                        <tr class="compare-row">
                            <td><?php echo __('Content Protection', $this->plugin_name) ?></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td colspan="3"><?php echo __('Disable right-click', $this->plugin_name) ?></td>
                        </tr>
                        <tr>
                            <td><?php echo __('Disable right-click', $this->plugin_name) ?></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td colspan="3"><?php echo __('Style settings', $this->plugin_name) ?></td>
                        </tr>
                        <tr class="compare-row">
                            <td><?php echo __('Style settings', $this->plugin_name) ?></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td colspan="3"><?php echo __('Block content with password', $this->plugin_name) ?></td>
                        </tr>
                        <tr class="compare-row">
                            <td><?php echo __('Block content with password', $this->plugin_name) ?></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td colspan="3"><?php echo __('Subscribe to view content', $this->plugin_name) ?></td>
                        </tr>
                        <tr class="compare-row">
                            <td><?php echo __('Subscribe to view content', $this->plugin_name) ?></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="4"><?php echo __('Mailchimp integration', $this->plugin_name) ?></td>
                        </tr>
                        <tr>
                            <td><?php echo __('Mailchimp integration', $this->plugin_name) ?></td>
                            <td><span>–</span></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="4"><?php echo __('Export results', $this->plugin_name) ?></td>
                        </tr>
                        <tr>
                            <td><?php echo __('Export results', $this->plugin_name) ?></td>
                            <td><span>–</span></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="4"><?php echo __('Block by IP', $this->plugin_name) ?></td>
                        </tr>
                        <tr>
                            <td><?php echo __('Block by IP', $this->plugin_name) ?></td>
                            <td><span>–</span></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="4"><?php echo __('Block by Country', $this->plugin_name) ?></td>
                        </tr>
                        <tr class="compare-row">
                            <td><?php echo __('Block by Country', $this->plugin_name) ?></td>
                            <td><span>–</span></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                        </tr>                        
                        <tr>
                            <td></td>
                            <td colspan="4"><?php echo __('Front/back blocker', $this->plugin_name) ?></td>
                        </tr>
                        <tr>
                            <td><?php echo __('Front/back blocker', $this->plugin_name) ?></td>
                            <td><span>–</span></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="4"><?php echo __('Block Rest api', $this->plugin_name) ?></td>
                        </tr>
                        <tr class="compare-row">
                            <td><?php echo __('Block Rest api', $this->plugin_name) ?></td>
                            <td><span>–</span></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="4"><?php echo __('Protection by user roles', $this->plugin_name) ?></td>
                        </tr>
                        <tr>
                            <td><?php echo __('Protection by user roles', $this->plugin_name) ?></td>
                            <td><span>–</span></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="4"><?php echo __('Protection by post/post type', $this->plugin_name) ?></td>
                        </tr>
                        <tr class="compare-row">
                            <td><?php echo __('Protection by post/post type', $this->plugin_name) ?></td>
                            <td><span>–</span></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="4"><?php echo __('Watermark images', $this->plugin_name) ?></td>
                        </tr>
                        <tr class="compare-row">
                            <td><?php echo __('Watermark images', $this->plugin_name) ?></td>
                            <td><span>–</span></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="4"><?php echo __('Paid content via PayPal', $this->plugin_name) ?></td>
                        </tr>
                        <tr>
                            <td><?php echo __('Paid content via PayPal', $this->plugin_name) ?></td>
                            <td><span>–</span></td>
                            <td><span>–</span></td>
                            <td><i class="ays_fa ays_fa_check"></i></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="4"></td>
                        </tr>
                        <tr class="compare-row">
                            <td></td>
                            <td></td>
                            <td>                                
                                <div class="ays-sccp-pracing-table-td-flex">
                                    <a href="https://ays-pro.com/wordpress/secure-copy-content-protection" class="price-buy"><?php echo __('Buy now',$this->plugin_name)?><span class="hide-mobile"></span></a>
                                    <span><?php echo __('(One-time payment)', $this->plugin_name); ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="ays-sccp-pracing-table-td-flex">
                                    <a href="https://ays-pro.com/wordpress/secure-copy-content-protection" class="price-buy"><?php echo __('Buy now',$this->plugin_name)?><span class="hide-mobile"></span></a>
                                    <span><?php echo __('(One-time payment)', $this->plugin_name); ?></span>
                                </div>                                
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="ays-sccp-sm-content-row-sg">
            <div class="ays-sccp-sm-guarantee-container-sg ays-sccp-sm-center-box-sg">
                <img src="<?php echo SCCP_ADMIN_URL ?>/images/money_back_logo.webp" alt="Best money-back guarantee logo">
                <div class="ays-sccp-sm-guarantee-text-container-sg">
                    <h3><?php echo __("30 day money back guarantee !!!", $this->plugin_name); ?></h3>
                    <p>
                        <?php echo __("We're sure that you'll love our Secure Copy Content Protection plugin, but, if for some reason, you're not
                        satisfied in the first 30 days of using our product, there is a money-back guarantee and
                        we'll issue a refund.", $this->plugin_name); ?>
                        
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>