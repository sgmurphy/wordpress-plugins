<?php
    $user_id = null;
    $user_role_key = null;
    if( isset( $_GET['orderbyuser'] ) && $_GET['orderbyuser'] != ''){
        $user_id = intval($_GET['orderbyuser']);
    }
    if( isset( $_GET['orderbyuserrole'] ) && $_GET['orderbyuserrole'] != ''){
        $user_role_key = $_GET['orderbyuserrole'];
    }
    
?>
<div class="wrap">
    <div class="ays-sccp-heading-box">
        <div class="ays-sccp-wordpress-user-manual-box">
            <a href="https://ays-pro.com/wordpress-copy-content-protection-user-manual" target="_blank" style="text-decoration: none;font-size: 13px;">
                <i class="ays_fa ays_fa_file_text"></i>
                <span style="margin-left: 3px;text-decoration: underline;"><?php echo __("View Documentation", $this->plugin_name); ?></span>
            </a>
        </div>
    </div>
    <h1 class="wp-heading-inline">
        <?php
            echo esc_html(get_admin_page_title());
        ?>
    </h1>
    <div class="sccp-action-butons">
        <a href="javascript:void(0)" class="ays-sccp-export-filters page-title-action" style="float: right;"><?php echo __('Export', $this->plugin_name); ?></a>
    </div>
    <div class="nav-tab-wrapper">
        <a href="#tab1" class="nav-tab nav-tab-active"><?= __('Results', $this->plugin_name); ?></a>
        <!-- <a href="#tab2" class="nav-tab"><?php // echo __('Statistics', $this->plugin_name); ?></a> -->
    </div>
    <div id="tab1" class="ays-sccp-tab-content ays-sccp-tab-content-active">
        <div id="poststuff">
            <div id="post-body" class="metabox-holder">
                <div id="post-body-content">
                    <div class="meta-box-sortables ui-sortable">
                        <form method="get" id="filter-div" class="alignleft actions bulkactions">
                            <div style="display:flex;justify-content:space-between;flex-wrap: wrap;">
                                <div class="ays_shortocode_id_filter">
                                    <div>
                                        <label for="shortcode-filter-selector-top">Shortcode ID</label>
                                        <input type="hidden" name="page" value="secure-copy-content-protection-results-to-view">
                                    </div>
                                    <select name="orderbyshortcode" id="shortcode-filter-selector-top">
                                        <option value="0" selected><?=__('No Filtering', $this->plugin_name);?></option>
                                        <?php
                                            foreach ($this->results_obj->get_sccp_by_id() as $copy_content) {?>
                                            <option value="<?=$copy_content['subscribe_id'];?>" <?=(isset($_REQUEST['orderbyshortcode']) && $_REQUEST['orderbyshortcode'] == $copy_content['subscribe_id']) ? 'selected' : '';?>><?=$copy_content['subscribe_id'];?></option>
                                            <?php }
                                        ?>
                                    </select>
                                    <div>
                                        <input type="submit" class="button action" value="<?= __('Filter', $this->plugin_name); ?>" style="width: 3.7rem;">
                                    </div>
                                </div>
                                <div class="ays_user_roles_filter">
                                    <div>
                                        <label for="user-role-filter-selector-top">User Role</label>
                                        <input type="hidden" name="page" value="secure-copy-content-protection-results-to-view">
                                    </div>
                                    <select name="orderbyuserrole" id="user-role-filter-selector-top">
                                        <option value="0" selected><?=__('No Filtering', $this->plugin_name);?></option>
                                        <?php
                                            foreach ($this->results_obj->get_user_roles_by_user_id() as $key => $roles) {?>
                                            <option value="<?=$key;?>" <?php echo $user_role_key == $key ? 'selected' : ''; ?>><?=$roles;?></option>
                                            <?php }
                                        ?>
                                    </select>
                                    <div>
                                        <input type="submit" class="button action" value="<?= __('Filter', $this->plugin_name); ?>" style="width: 3.7rem;">
                                    </div>
                                </div>
                                <div class="ays-sccp-filte-by-user" style="display:flex;margin-left:10px;">
                                    <select name="orderbyuser" class="ays-sccp-search-users-select" id="bulk-action-select2-sccp" >
                                        <option value=""><?php echo __('Select User',$this->plugin_name)?></option>
                                        <?php
                                            foreach($this->results_obj->get_users_by_id() as $key => $value){
                                                $selected2 = "";
                                                if (is_array($value)) {
                                                   if($user_id === intval($value['data']['ID'])){
                                                        $selected2 = "selected";
                                                    }
                                                    echo "<option ".$selected2." value='".$value['data']['ID']."'>".$value['data']['display_name']."</option>";
                                                }else{
                                                    if($user_id === intval($value->data->ID)){
                                                        $selected2 = "selected";
                                                    }
                                                    echo "<option ".$selected2." value='".$value->data->ID."'>".$value->data->display_name."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                    <div style="margin-left:5px;">
                                        <input type="submit" class="button action" value="<?= __('Filter', $this->plugin_name); ?>" style="width: 3.7rem;">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form method="post" id="ays-sccp-results-form">
                            <?php                            
                                $this->results_obj->prepare_items();
                                $search = __( "Search", $this->plugin_name );
                                $this->results_obj->search_box($search, $this->plugin_name);
                                $this->results_obj->display();
                                // $this->results_obj->mark_as_read();
                            ?>
                        </form>
                    </div>
                </div>
            </div>
            <br class="clear">
        </div>
    </div>

    <div class="ays-modal" id="sccp_export_filters">
        <div class="ays-modal-content">
            <div class="ays-sccp-preloader">
                <img class="loader" src="<?php echo SCCP_ADMIN_URL; ?>/images/loaders/3-1.svg">
            </div>
          <!-- Modal Header -->
            <div class="ays-modal-header">
                <span class="ays-close">&times;</span>
                <h2><?=__('Export Filter', $this->plugin_name)?></h2>
            </div>

          <!-- Modal body -->
            <div class="ays-modal-body">
                <form method="post" id="ays_sccp_export_filter">              
                    <div class="filter-col">
                        <label for="sccp_id-filter"><?=__("Shortcode ID", $this->plugin_name)?></label>
                        <button type="button" class="ays_sccpid_clear button button-small wp-picker-default"><?=__("Clear", $this->plugin_name)?></button>
                        <select name="sccp_id-select[]" id="sccp_id-filter" multiple="multiple"></select>
                    </div>
                    <div class="filter-block">
                        <div class="filter-block filter-col">
                            <label for="sccp_start-date-filter"><?=__("Start Date from", $this->plugin_name)?></label>
                            <input type="date" name="start-date-filter" id="sccp_start-date-filter">
                        </div>
                        <div class="filter-block filter-col">
                            <label for="sccp_end-date-filter"><?=__("Start Date to", $this->plugin_name)?></label>
                            <input type="date" name="end-date-filter" id="sccp_end-date-filter">
                        </div>
                    </div>
                </form>
            </div>

          <!-- Modal footer -->
            <div class="ays-modal-footer">
                <div class="export_results_count">
                    <p>Matched <span>0</span> results</p>
                </div>
                <span style="margin-right: 5px;"><?php echo __('Export to', $this->plugin_name); ?></span>
                
                <button type="button" class="button button-primary sccp_results_export-action" data-type="csv"><?=__('CSV', $this->plugin_name)?></button>
                <button type="button" class="button button-primary sccp_results_export-action" data-type="xlsx"><?=__('XLSX', $this->plugin_name)?></button>
                <button type="button" class="button button-primary sccp_results_export-action" data-type="json"><?=__('JSON', $this->plugin_name)?></button>
                <a href="javascript:void(0)" id="download" style="display: none;">Download</a>
            </div>

        </div>
    </div>
</div>
