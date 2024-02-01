<?php
if (!defined("ABSPATH")) {
    exit();
}

$isLogMeWhereIFinishedEnabled = $this->dbManager->isLogMeWhereIFinishedEnabled();
$LMWIFStatus = checked($isLogMeWhereIFinishedEnabled, true, false);

?>
<div class="custom-body auto-redirect">
    <p class="page__paragraph">
        <?php _e( "Would you like to direct users to their last visited page upon logging in?", "redirect-redirection" ); ?>
    </p>
    <div class="page__custom-flex">
        <div class="page__custom">
            <div class="page__switch-group page-switch-group">
                <span class="page-switch-group__label">
                    <?php _e("Redirect to the last visited page after login", "redirect-redirection"); ?>
                </span>
                <label for="switch-4" class="custom-switch custom-switch">
                    <input type="checkbox" id="switch-4" class="ir-auto-redirect log-me-where-i-finished" <?php echo $LMWIFStatus; ?>>
                    <div class="custom-switch-slider round">
                        <span class="on">
                            <?php _e("On", "redirect-redirection"); ?>
                        </span>
                        <span class="off">
                            <?php _e("Off", "redirect-redirection"); ?>
                        </span>
                    </div>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="custom-body auto-redirect">
    <p class="page__paragraph">
        <?php _e( "If you change the permalink of a post/page, do you want the old permalink automatically redirect to the new one? If yes, please switch it on for the pages/posts you want it:", "redirect-redirection" ); ?>
    </p>
    <div class="page__custom-flex">
        <div class="page__custom-col">
            <div class="page__switch-group page-switch-group custom-tooltip">
                <span class="page-switch-group__label">
                    <?php _e("Posts URLs", "redirect-redirection"); ?>
                </span>
                <label for="switch-1" class="custom-switch custom-switch--disabled">
                    <input disabled type="checkbox" id="switch-1" class="ir-auto-redirect log-me-where-i-finished">
                    <div class="custom-switch-slider round">
                        <span class="on">
                            <?php _e("On", "redirect-redirection"); ?>
                        </span>
                        <span class="off">
                            <?php _e("Off", "redirect-redirection"); ?>
                        </span>
                    </div>
                </label>
                <span class="custom-tooltip__content" style="top: 37px">
                    <?php _e("Coming soon", "redirect-redirection"); ?>
                </span>
            </div>
        </div>
        <div class="page__custom-col">
            <div class="page__switch-group page-switch-group custom-tooltip">
                <span class="page-switch-group__label">
                    <?php _e("Page URLs", "redirect-redirection"); ?>
                </span>
                <label for="switch-2" class="custom-switch custom-switch--disabled">
                    <input disabled type="checkbox" id="switch-2" class="ir-auto-redirect log-me-where-i-finished">
                    <div class="custom-switch-slider round">
                        <span class="on">
                            <?php _e("On", "redirect-redirection"); ?>
                        </span>
                        <span class="off">
                            <?php _e("Off", "redirect-redirection"); ?>
                        </span>
                    </div>
                </label>
                <span class="custom-tooltip__content" style="top: 37px">
                    <?php _e("Coming soon", "redirect-redirection"); ?>
                </span>
            </div>
        </div>
        <div class="page__custom-col">
            <div class="page__switch-group page-switch-group custom-tooltip">
                <span class="page-switch-group__label">
                    <?php _e("Custom posts", "redirect-redirection"); ?>
                </span>
                <label for="switch-3" class="custom-switch custom-switch--disabled">
                    <input disabled type="checkbox" id="switch-3" class="ir-auto-redirect log-me-where-i-finished">
                    <div class="custom-switch-slider round">
                        <span class="on">
                            <?php _e("On", "redirect-redirection"); ?>
                        </span>
                        <span class="off">
                            <?php _e("Off", "redirect-redirection"); ?>
                        </span>
                    </div>
                </label>
                <span class="custom-tooltip__content" style="top: 37px">
                    <?php _e("Coming soon", "redirect-redirection"); ?>
                </span>
            </div>
        </div>
    </div>
    <p class="page__note">
        <?php _e("This will add a new redirect automatically on the “Specific URL Redirection”-tab whenever applicable.", "redirect-redirection"); ?>
    </p>
</div>
