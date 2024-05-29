<?php
use MailerLite\Includes\Shared\Api\ApiType;

if(isset($_GET['step']) && ($_GET['step'] == 1)) {
    \MailerLite\Includes\Classes\Settings\MailerLiteSettings::getInstance()->softReset();
}

?>

<div class="woo-ml-wizard">
    <div class="woo-ml-header">
        <!-- MailerLite logo -->
        <div>
            <svg width="116" height="31" viewBox="0 0 116 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_123_132)">
                    <path d="M15.6136 16.3109C13.7098 16.3109 12.1972 17.0609 11.1279 18.5352C10.502 17.3972 9.25014 16.3109 7.34632 16.3109C5.39033 16.3109 4.24281 17.1644 3.43434 18.0696V17.811C3.43434 17.0609 2.80842 16.4402 2.05211 16.4402C1.29579 16.4402 0.695953 17.0609 0.695953 17.811V28.2341C0.695953 28.9841 1.29579 29.579 2.05211 29.579C2.80842 29.579 3.43434 28.9841 3.43434 28.2341V21.0181C4.06025 20.0094 4.99913 18.8714 6.69432 18.8714C8.31127 18.8714 8.93719 19.6473 8.93719 21.6647V28.2341C8.93719 28.9841 9.53702 29.579 10.2933 29.579C11.0497 29.579 11.6756 28.9841 11.6756 28.2341V21.0181C12.3015 20.0094 13.2404 18.8714 14.9356 18.8714C16.5525 18.8714 17.1784 19.6473 17.1784 21.6647V28.2341C17.1784 28.9841 17.7783 29.579 18.5346 29.579C19.2909 29.579 19.9168 28.9841 19.9168 28.2341V21.225C19.969 18.8455 18.6128 16.3109 15.6136 16.3109ZM28.7579 16.3109C27.2452 16.3109 25.863 16.5954 24.4286 17.2161C23.9331 17.423 23.6201 17.8369 23.6201 18.38C23.6201 19.0525 24.1417 19.5697 24.7937 19.5697C24.8981 19.5697 25.0285 19.5439 25.1849 19.518C26.1499 19.2076 27.0627 18.949 28.3667 18.949C30.4791 18.949 31.3659 19.7249 31.3919 21.6388H28.6796C24.9763 21.6388 22.7856 23.2165 22.7856 25.8288C22.7856 28.3893 24.9241 29.7342 27.0366 29.7342C28.7318 29.7342 30.1923 29.2169 31.3919 28.2341V28.26C31.3919 29.01 31.9918 29.6049 32.7481 29.6049C33.5044 29.6049 34.1303 29.01 34.1303 28.26V21.3802C34.1303 18.8455 32.4612 16.3109 28.7579 16.3109ZM27.8712 27.2254C26.3324 27.2254 25.524 26.6564 25.524 25.5443C25.524 25.1304 25.524 23.889 28.9665 23.889H31.3659V25.5701C30.6617 26.346 29.3316 27.2254 27.8712 27.2254ZM39.5028 11.4485C40.3373 11.4485 41.0154 12.121 41.0154 12.9486V13.0521C41.0154 13.8797 40.3373 14.5522 39.5028 14.5522H39.3463C38.5117 14.5522 37.8337 13.8797 37.8337 13.0521V12.9486C37.8337 12.121 38.5117 11.4485 39.3463 11.4485H39.5028ZM39.4245 16.4143C40.2069 16.4143 40.8068 17.0351 40.8068 17.7851V28.2082C40.8068 28.9583 40.2069 29.5531 39.4245 29.5531C38.6682 29.5531 38.0684 28.9583 38.0684 28.2082V17.7851C38.0684 17.0092 38.6682 16.4143 39.4245 16.4143ZM46.3879 11.0605C47.1702 11.0605 47.7701 11.6813 47.7701 12.4313V28.2082C47.7701 28.9583 47.1702 29.5531 46.3879 29.5531C45.6315 29.5531 45.0317 28.9583 45.0317 28.2082V12.4313C45.0317 11.6554 45.6315 11.0605 46.3879 11.0605ZM57.2631 16.3109C55.3072 16.3109 53.6902 17.0351 52.5949 18.4059C51.656 19.5956 51.1344 21.225 51.1344 23.0096C51.1344 27.1995 53.612 29.7083 57.7326 29.7083C60.0015 29.7083 61.123 29.1911 62.1401 28.5962C62.6356 28.3117 62.8964 27.8979 62.8964 27.484C62.8964 26.8116 62.3487 26.2684 61.6446 26.2684C61.4359 26.2684 61.2534 26.2943 61.0969 26.3978C60.3666 26.7857 59.4539 27.1219 57.9151 27.1219C55.6201 27.1219 54.264 26.0615 53.9249 24.0442H61.9314C62.7399 24.0442 63.3137 23.4752 63.3137 22.6992C63.3658 18.3024 60.2102 16.3109 57.2631 16.3109ZM57.2631 18.6904C58.4107 18.6904 60.3406 19.337 60.6014 21.7164H53.9249C54.1857 19.6215 55.7505 18.6904 57.2631 18.6904ZM72.885 16.3109C73.6413 16.3109 74.2151 16.8799 74.2151 17.6299C74.2151 18.38 73.6413 18.9231 72.8328 18.9231H72.7024C71.2941 18.9231 70.0423 19.6215 69.1556 20.8888V28.2082C69.1556 28.9583 68.5296 29.5531 67.7733 29.5531C67.017 29.5531 66.4172 28.9583 66.4172 28.2082V17.7851C66.4172 17.0351 67.017 16.4143 67.7733 16.4143C68.5296 16.4143 69.1556 17.0351 69.1556 17.7851V18.1214C70.2509 16.9316 71.4506 16.3109 72.7546 16.3109H72.885Z" fill="black"/>
                    <path d="M111.572 0.917969H83.4383C81.2701 0.917969 79.472 2.69841 79.472 4.84542V17.9369V20.5028V29.7978L84.9455 24.4303H111.599C113.767 24.4303 115.565 22.6498 115.565 20.5028V4.84542C115.538 2.67223 113.767 0.917969 111.572 0.917969Z" fill="#09C269"/>
                    <path d="M106.39 10.0297C109.404 10.0297 110.779 12.4123 110.779 14.6117C110.779 15.2139 110.329 15.6328 109.721 15.6328H104.168C104.433 16.9682 105.385 17.6751 106.892 17.6751C107.976 17.6751 108.584 17.4395 109.113 17.1776C109.245 17.0991 109.377 17.0729 109.536 17.0729C110.065 17.0729 110.488 17.4918 110.488 18.0155C110.488 18.3559 110.277 18.6701 109.906 18.8795C109.166 19.2985 108.373 19.665 106.733 19.665C103.772 19.665 101.974 17.8584 101.974 14.8474C101.974 11.3127 104.354 10.0297 106.39 10.0297ZM97.5581 8.48489C97.9018 8.48489 98.1398 8.74672 98.1398 9.0871V10.1868H99.8321C100.361 10.1868 100.784 10.6057 100.784 11.1294C100.784 11.653 100.361 12.072 99.8321 12.072H98.1663V16.9944C98.1663 17.7013 98.5364 17.7537 99.0388 17.7537C99.3297 17.7537 99.4883 17.7013 99.647 17.6751C99.7792 17.6489 99.9114 17.5966 100.07 17.5966C100.493 17.5966 100.969 17.9369 100.969 18.4868C100.943 18.8272 100.758 19.1414 100.414 19.2985C99.9114 19.5341 99.409 19.6388 98.8537 19.6388C97.0293 19.6388 96.0509 18.7748 96.0509 17.1253V12.072H95.099C94.7553 12.072 94.5173 11.8101 94.5173 11.4959C94.5173 11.3127 94.5966 11.1294 94.7553 10.9985L97.0821 8.72054C97.135 8.66818 97.3201 8.48489 97.5581 8.48489ZM86.8492 6.33789C87.431 6.33789 87.9069 6.80918 87.9069 7.38521V18.513C87.9069 19.089 87.431 19.5341 86.8492 19.5341C86.2675 19.5341 85.818 19.0628 85.818 18.513V7.38521C85.818 6.80918 86.2675 6.33789 86.8492 6.33789ZM91.7674 10.1082C92.3491 10.1082 92.825 10.5795 92.825 11.1556V18.513C92.825 19.089 92.3491 19.5341 91.7674 19.5341C91.1857 19.5341 90.7362 19.0628 90.7362 18.513V11.1556C90.7362 10.5795 91.1857 10.1082 91.7674 10.1082ZM106.416 11.8887C105.411 11.8887 104.354 12.4909 104.168 13.8786H108.69C108.478 12.4909 107.421 11.8887 106.416 11.8887ZM91.8203 6.59972C92.4549 6.59972 92.9573 7.0972 92.9573 7.72559V7.80414C92.9573 8.43253 92.4549 8.93001 91.8203 8.93001H91.7145C91.0799 8.93001 90.5775 8.43253 90.5775 7.80414V7.72559C90.5775 7.0972 91.0799 6.59972 91.7145 6.59972H91.8203Z" fill="white"/>
                </g>
                <defs>
                    <clipPath id="clip0_123_132">
                        <rect width="115" height="29.3249" fill="white" transform="translate(0.617676 0.710938)"/>
                    </clipPath>
                </defs>
            </svg>
        </div>
        <!-- MailerLite logo -->
        <!-- Wizard breadcrumbs -->
        <?php require_once __DIR__.'/./components/wizard-breadcrumb-component.php'; ?>
        <!-- Wizard breadcrumbs -->
    </div>
    <?php require_once __DIR__.'/./components/woo-mailerlite-alerts.php'; ?>
    <!-- Intro title -->
    <?php if ($currentStep == 0) : ?>
    <div class="header-title-ml">
        <h1>Connect MailerLite with WooCommerce</h1>
        <p>Build custom segments, send automations, and track purchase activity in MailerLite. Enter your MailerLite account's API key to start using the integration.</p>
    </div>
    <?php endif; ?>

    <!-- Group's sync view title -->
    <?php if ($currentStep == 1) : ?>
        <button type="button" id="woo_ml_wizard_back_step_1" class="btn btn-link-ml flex-start-ml flex-ml align-items-center-ml" style="margin-bottom: 1rem;">
            <svg width="14" height="14" fill="none" style="margin-right: 0.25rem;" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to API key</button>
        <div class="header-title-ml">
            <?php if ((int)get_option('woo_mailerlite_platform', 1) == ApiType::CLASSIC) : ?>
                <h1>Import your customers to MailerLite</h1>
            <?php else: ?>
            <h1>Select subscriber group</h1>
            <?php endif; ?>
            <p>Subscribers from WooCommerce will join this MailerLite subscriber group.	</p>
        </div>
        <input type="hidden" value="<?php echo $total_untracked_resources ?? 0; ?>" id="totalUntrackedResources"/>
        <input type="hidden" value="<?php echo $this->settings['group'] ?? ''; ?>" id="selectedGroupValue"/>
    <?php endif; ?>

    <!-- Wizard content -->
    <div class="woo-ml-wizard-content">
        <?php if ($currentStep == 0) : ?>
            <div id="woo-ml-wizard-step-one">
                <div class="input-block-ml">
                    <label for="wooMlApiKey" class="settings-label mb-3-ml">API key</label>
                    <div class="api-key-input">
                        <input id="wooMlApiKey" type="text" name="api-key" placeholder="Enter your MailerLite API key" id="apiKey">
                        <button type="button" id="wooMlWizardApiKeyBtn" class="btn-primary-ml"><span class="woo-ml-button-text">Connect account</span></button>
                    </div>
                    <div class="signup-link-ml">
                        <p>Don't you have a MailerLite account yet? Click to <a href="https://www.mailerlite.com/signup?utm_source=referral&utm_medium=woocommerce&utm_campaign=integration" target="_blank">Sign up</a></p>
                    </div>
                </div>

                <div class="border-top-ml">
                    <div class="header-title-ml" style="margin-bottom: 0;">
                        <h2>Having trouble? Follow the instructions:</h2>
                        <ol class="instructions-list">
                            <li>Access your MailerLite account and go to the <a href="https://dashboard.mailerlite.com/integrations" target="_blank" class="body-link-ml">Integrations tab.</a></li>
                            <li>Locate the MailerLite API section and click Use and then Generate new token.</li>
                            <li>Enter a name for the token such as "WooCommerce" and click Generate token.</li>
                            <li>Copy the token and return to the Integrations page in WooCommerce. Paste your key in the API key box and click Connect account.
                            </li>
                        </ol>
                    </div>
                    <div style="display: none;">
                        <h3>Not a client of MailerLite? Click Sign up to create your account</h3>
                        <a class="btn btn-secondary-ml" href="https://www.mailerlite.com/signup?utm_source=referral&utm_medium=woocommerce&utm_campaign=integration" target="_blank">Create account</a>
                    </div>
                </div>
                <div class="border-top-ml">
                    <label class="settings-label-medium" style="margin:0;">Still having trouble connecting to your account? <a id="openDebugLog">Click here</a> for an advanced troubleshooting.</label>
                </div>
            </div>
        <?php endif; ?>
        <?php if (get_option('woo_ml_wizard_setup', 0) == 1) : ?>
            <div id="woo-ml-wizard-step-two">
                <label for="wooMlSubGroup" class="settings-label mb-3-ml">Group</label>
                <label class="input-mailerlite mb-2-ml" style="display: flex;">
                    <select id="wooMlSubGroup" class="wc-enhanced-select" type="select" name="subscriber-group"
                            style="width: 100%;">
                            <option value="" selected="selected">Select group</option>
                    </select>
                    <button id="createGroupModal" type="button" class="btn-secondary-ml" style="margin-left: 0.5rem; white-space: nowrap;">Create group</button>
                </label>
                <label class="settings-label-small"><?php echo get_option("woo_ml_account_name", false) ? "Account: " . get_option("woo_ml_account_name", false): "" ; ?></label>
            </div>
            <?php if ((int)get_option('woo_mailerlite_platform', 1) == ApiType::CLASSIC) : ?>
                <div class="border-top-ml">
                    <div id="woo-ml-wizard-step-two">
                        <div class="header-title-ml">
                            <h1>Consumer details</h1>
                            <p>The Consumer key and Consumer secret are required for e-commerce automations to work in MailerLite Classic.</p>
                        </div>
                        <div class="form-group-ml vertical">
                            <label for="wooMlSubGroup" class="settings-label flex-ml align-items-center-ml mb-3-ml mt-0-ml">Consumer key
                            </label>
                            <label class="input-mailerlite mb-2-ml mt-0-ml">
                                <input id="consumerKey" type="text" name="consumer_key" class="woo-ml-form-checkbox text-input flex-start-ml"
                                       style="width: 100%;" value="<?php echo $this->settings['consumer_key'] ?? '' ?>">
                            </label>
                            <label class="settings-label-small mt-0-ml mb-0-ml">Find out how to generate secret <a href="https://docs.woocommerce.com/document/woocommerce-rest-api/" target="_blank">here.</a></label>
                        </div>
                        <div class="form-group-ml vertical">
                            <label for="wooMlSubGroup" class="settings-label flex-ml align-items-center-ml mb-3-ml mt-0-ml">Consumer secret
                            </label>
                            <label class="input-mailerlite mb-2-ml mt-0-ml">
                                <input id="consumerSecret" type="text" name="consumer_secret" class="woo-ml-form-checkbox text-input flex-start-ml"
                                       style="width: 100%;" value="<?php echo $this->settings['consumer_secret'] ?? '' ?>">
                            </label>
                            <label class="settings-label-small mt-0-ml">Find out how to generate secret <a href="https://docs.woocommerce.com/document/woocommerce-rest-api/" target="_blank">here.</a></label>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="settings-block" style="display: flex; justify-content: space-between; padding-top: 2rem;">
                <label class="settings-label-medium" style="margin: 0;">Having trouble importing your group? <a id="openDebugLog">Click here</a> for an advanced troubleshooting.</label>
                <button id="startImport" type="button" class="btn-primary-ml">Start import</button>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- Wizard content -->
    <?php require_once __DIR__.'/./components/woo-mailerlite-modals.php'; ?>
</div>
