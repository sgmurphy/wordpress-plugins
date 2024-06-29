<?php

namespace Full\Customer\Actions;

use Full\Customer\License;

defined('ABSPATH') || exit;

function insertFooterNote(): void
{
  $full = fullCustomer();
  $file = FULL_CUSTOMER_APP . '/views/footer/note.php';

  if ($full->get('allow_backlink') && file_exists($file)) :
    require_once $file;
  endif;
}

function insertAdminNotice(): void
{
  $full = fullCustomer();
  $file = FULL_CUSTOMER_APP . '/views/admin/notice.php';

  if (!$full->hasDashboardUrl() && file_exists($file)) :
    require_once $file;
  endif;
}

function insertAdminApiNotice(): void
{
  $file = FULL_CUSTOMER_APP . '/views/admin/notice-api.php';

  if (file_exists($file) && current_user_can('manage_options')) :
    require_once $file;
  endif;
}

function verifySiteConnection(): void
{
  $flag = 'previous-connect-site-check';
  $full = fullCustomer();

  if ($full->get($flag) || $full->hasDashboardUrl()) :
    return;
  endif;

  $response = fullGetSiteConnectionData();

  if ($response && $response->success) :
    $full->set('connection_email', sanitize_email($response->connection_email));
    $full->set('dashboard_url', esc_url($response->dashboard_url));
  endif;

  $full->set($flag, 1);
}

function activationAnalyticsHook(): void
{
  $full  = fullCustomer();
  $url   = $full->getFullDashboardApiUrl() . '-customer/v1/analytics';

  wp_remote_post($url, [
    'sslverify' => false,
    'headers'   => ['x-full' => 'Jkd0JeCPm8Nx', 'Content-Type' => 'application/json'],
    'body'      => json_encode([
      'site_url'      => home_url(),
      'admin_email'   => get_bloginfo('admin_email'),
      'plugin_status' => 'active'
    ])
  ]);

  $full->set('allow_backlink', true);
}

function deactivationAnalyticsHook(): void
{
  $full  = fullCustomer();
  $url   = $full->getFullDashboardApiUrl() . '-customer/v1/analytics';

  wp_remote_post($url, [
    'sslverify' => false,
    'headers'   => ['x-full' => 'Jkd0JeCPm8Nx', 'Content-Type' => 'application/json'],
    'body'      => json_encode([
      'site_url'      => home_url(),
      'admin_email'   => get_bloginfo('admin_email'),
      'plugin_status' => 'inactive'
    ])
  ]);
}

function addMenuPage(): void
{
  $full = fullCustomer();

  add_menu_page(
    $full->getBranding('admin-page-name', 'FULL.services'),
    $full->getBranding('admin-page-name', 'FULL.services'),
    'manage_options',
    'full-connection',
    'fullGetAdminPageView',
    'data:image/svg+xml;base64,' . base64_encode(file_get_contents(plugin_dir_url(FULL_CUSTOMER_FILE) . 'app/assets/img/menu-novo.svg')),
    0
  );

  $connectionOk   = fullIsCorrectlyConnected();
  $cls = $connectionOk ? 'success' : 'error';
  $text = $connectionOk ? 'conectado' : 'desconectado';

  add_submenu_page(
    'full-connection',
    'Conexão',
    'Conexão <span class="full-badge full-' . $cls . '">' . $text . '</span>',
    'manage_options',
    'full-connection',
    'fullGetAdminPageView'
  );

  $status = License::status();
  $cls = $status['plan'] ? 'full' : 'error';
  $text = $status['plan'] ? $status['plan'] : 'seja PRO';

  add_submenu_page(
    'full-connection',
    'FULL.PRO',
    'FULL.PRO <span class="full-badge full-' . sanitize_title($cls) . '">' . $text . '</span>',
    'manage_options',
    'full-widgets',
    'fullGetAdminPageView'
  );

  add_submenu_page(
    'full-connection',
    'Integrações',
    'Integrações',
    'manage_options',
    'full-store',
    'fullGetAdminPageView'
  );
}

function adminEnqueueScripts(): void
{
  $version = getFullAssetsVersion();
  $baseUrl = trailingslashit(plugin_dir_url(FULL_CUSTOMER_FILE)) . 'app/assets/';

  if (isFullsAdminPage()) :
    wp_enqueue_style('full-icons', 'https://painel.full.services/wp-content/plugins/full/app/assets/vendor/icon-set/style.css');
    wp_enqueue_style('full-swal', $baseUrl . 'vendor/sweetalert/sweetalert2.min.css', [], '11.4.35');
    wp_enqueue_style('full-flickity', $baseUrl . 'vendor/flickity/flickity.min.css', [], '2.3.0');
    wp_enqueue_style('full-magnific-popup', $baseUrl . 'vendor/magnific-popup/magnific-popup.min.css', [], '1.0.0');
    wp_enqueue_style('full-admin', $baseUrl . 'css/admin.css', [], $version);

    wp_enqueue_script('full-swal', $baseUrl . 'vendor/sweetalert/sweetalert2.min.js', ['jquery'], '11.4.35', true);
    wp_enqueue_script('full-flickity', $baseUrl . 'vendor/flickity/flickity.min.js', ['jquery'], '2.3.0', true);
    wp_enqueue_script('full-magnific-popup', $baseUrl . 'vendor/magnific-popup/magnific-popup.min.js', ['jquery'], '1.0.0', true);
  endif;

  wp_enqueue_style('full-global-admin', $baseUrl . 'css/global-admin.css', [], $version);

  if ('store' === fullAdminPageEndpoint()) :
    wp_enqueue_script('full-store', $baseUrl . 'js/admin-store.js', ['jquery'], $version, true);
  endif;

  wp_enqueue_script('full-admin', $baseUrl . 'js/admin.js', ['jquery'], $version, true);
  wp_localize_script('full-admin', 'FULL', fullGetLocalize());
}

function upgradePlugin(): void
{
  $env = fullCustomer();
  $siteVersion = $env->get('version') ? $env->get('version') : '0.0.0';

  if (version_compare(FULL_CUSTOMER_VERSION, $siteVersion, '>') && !get_transient('full-upgrading')) :
    set_transient('full-upgrading', 1, MINUTE_IN_SECONDS);

    $upgradeVersions = apply_filters('full-versions-upgrades', []);

    foreach ($upgradeVersions as $pluginVersion) :
      if (version_compare($pluginVersion, $siteVersion, '>=')) :
        do_action('full-customer/upgrade/' . $pluginVersion);
      endif;
    endforeach;

    $env->set('version', FULL_CUSTOMER_VERSION);
  endif;
}

function notifyPluginError(): bool
{
  $error = get_option('full_customer_last_error');

  if (!$error) :
    return false;
  endif;

  $full = fullCustomer();
  $url  = $full->getFullDashboardApiUrl() . '-customer/v1/error';

  wp_remote_post($url, [
    'sslverify' => false,
    'headers'   => [
      'Content-Type'  => 'application/json',
    ],
    'body'  => json_encode([
      'site_url'  => home_url(),
      'error'     => $error,
      'version'   => FULL_CUSTOMER_VERSION
    ])
  ]);

  delete_option('full_customer_last_error');
  return true;
}

function initFullAccessWidget(): void
{
  if (fullCustomer()->isServiceEnabled('full-access')) :
    require_once FULL_CUSTOMER_APP . '/controller/access/Authentication.php';
    require_once FULL_CUSTOMER_APP . '/controller/access/RegistrationFields.php';
    require_once FULL_CUSTOMER_APP . '/controller/access/Interaction.php';
  endif;
}

function startWidgets(): void
{
  if (fullCustomer()->isServiceEnabled('full-login')) :
    require_once FULL_CUSTOMER_APP . '/controller/login/hooks.php';
    require_once FULL_CUSTOMER_APP . '/controller/login/actions.php';
    require_once FULL_CUSTOMER_APP . '/controller/login/Settings.php';
    require_once FULL_CUSTOMER_APP . '/controller/login/Url.php';
    require_once FULL_CUSTOMER_APP . '/controller/login/Identity.php';
    require_once FULL_CUSTOMER_APP . '/controller/login/Menu.php';
    require_once FULL_CUSTOMER_APP . '/controller/login/LogoutRedirect.php';
    require_once FULL_CUSTOMER_APP . '/controller/login/LoginRedirect.php';
  endif;

  if (fullCustomer()->isServiceEnabled('full-email')) :
    require_once FULL_CUSTOMER_APP . '/controller/email/hooks.php';
    require_once FULL_CUSTOMER_APP . '/controller/email/actions.php';
    require_once FULL_CUSTOMER_APP . '/controller/email/Settings.php';
    require_once FULL_CUSTOMER_APP . '/controller/email/SMTP.php';
  endif;

  if (fullCustomer()->isServiceEnabled('full-images')) :
    require_once FULL_CUSTOMER_APP . '/controller/images/hooks.php';
    require_once FULL_CUSTOMER_APP . '/controller/images/actions.php';
    require_once FULL_CUSTOMER_APP . '/controller/images/Settings.php';
    require_once FULL_CUSTOMER_APP . '/controller/images/SvgUpload.php';
    require_once FULL_CUSTOMER_APP . '/controller/images/MediaReplacement.php';
    require_once FULL_CUSTOMER_APP . '/controller/images/UploadResizer.php';
    require_once FULL_CUSTOMER_APP . '/controller/images/ImageOptimization.php';
  endif;

  if (fullCustomer()->isServiceEnabled('full-code')) :
    require_once FULL_CUSTOMER_APP . '/controller/code/hooks.php';
    require_once FULL_CUSTOMER_APP . '/controller/code/actions.php';
    require_once FULL_CUSTOMER_APP . '/controller/code/Settings.php';
  endif;

  if (fullCustomer()->isServiceEnabled('full-speed')) :
    require_once FULL_CUSTOMER_APP . '/controller/speed/hooks.php';
    require_once FULL_CUSTOMER_APP . '/controller/speed/actions.php';
    require_once FULL_CUSTOMER_APP . '/controller/speed/Settings.php';
    require_once FULL_CUSTOMER_APP . '/controller/speed/DeprecatedComponents.php';
    require_once FULL_CUSTOMER_APP . '/controller/speed/BlockBasedFeatures.php';
    require_once FULL_CUSTOMER_APP . '/controller/speed/Revisions.php';
    require_once FULL_CUSTOMER_APP . '/controller/speed/Heartbeat.php';
  endif;

  if (fullCustomer()->isServiceEnabled('full-admin')) :
    require_once FULL_CUSTOMER_APP . '/controller/admin/hooks.php';
    require_once FULL_CUSTOMER_APP . '/controller/admin/actions.php';
    require_once FULL_CUSTOMER_APP . '/controller/admin/Settings.php';
    require_once FULL_CUSTOMER_APP . '/controller/admin/AdminInterface.php';
  endif;

  if (fullCustomer()->isServiceEnabled('full-security')) :
    require_once FULL_CUSTOMER_APP . '/controller/security/hooks.php';
    require_once FULL_CUSTOMER_APP . '/controller/security/actions.php';
    require_once FULL_CUSTOMER_APP . '/controller/security/Settings.php';

    require_once FULL_CUSTOMER_APP . '/controller/security/Feeds.php';
    require_once FULL_CUSTOMER_APP . '/controller/security/LastLoginColumn.php';
    require_once FULL_CUSTOMER_APP . '/controller/security/PasswordProtection.php';
    require_once FULL_CUSTOMER_APP . '/controller/security/UsersOnlyMode.php';
  endif;

  if (fullCustomer()->isServiceEnabled('full-woocommerce')) :
    require_once FULL_CUSTOMER_APP . '/controller/woocommerce/hooks.php';
    require_once FULL_CUSTOMER_APP . '/controller/woocommerce/actions.php';
    require_once FULL_CUSTOMER_APP . '/controller/woocommerce/Settings.php';

    if (function_exists('WC')) :
      require_once FULL_CUSTOMER_APP . '/controller/woocommerce/EstimateMode.php';
      require_once FULL_CUSTOMER_APP . '/controller/woocommerce/HidePrices.php';
      require_once FULL_CUSTOMER_APP . '/controller/woocommerce/OrderReceived.php';
      require_once FULL_CUSTOMER_APP . '/controller/woocommerce/ProductCustomTab.php';
      require_once FULL_CUSTOMER_APP . '/controller/woocommerce/ProductReviews.php';
      require_once FULL_CUSTOMER_APP . '/controller/woocommerce/TestPaymentGateway.php';
      require_once FULL_CUSTOMER_APP . '/controller/woocommerce/AutocompleteOrders.php';
      require_once FULL_CUSTOMER_APP . '/controller/woocommerce/WhatsAppCheckout.php';
    endif;
  endif;

  if (fullCustomer()->isServiceEnabled('full-clone')) :
    require_once FULL_CUSTOMER_APP . '/controller/content/hooks.php';
    require_once FULL_CUSTOMER_APP . '/controller/content/actions.php';
    require_once FULL_CUSTOMER_APP . '/controller/content/Settings.php';

    require_once FULL_CUSTOMER_APP . '/controller/content/Posts.php';
    require_once FULL_CUSTOMER_APP . '/controller/content/Links.php';
    require_once FULL_CUSTOMER_APP . '/controller/content/Comments.php';
  endif;

  if (fullCustomer()->isServiceEnabled('full-shortcodes')) :
    require_once FULL_CUSTOMER_APP . '/controller/shortcodes/Hooks.php';
    require_once FULL_CUSTOMER_APP . '/controller/shortcodes/Collection.php';
  endif;

  if (fullCustomer()->isServiceEnabled('full-elementor-crm')) :
    require_once FULL_CUSTOMER_APP . '/controller/elementor-crm/Settings.php';
    require_once FULL_CUSTOMER_APP . '/controller/elementor-crm/Hooks.php';
    require_once FULL_CUSTOMER_APP . '/controller/elementor-crm/Leads.php';
  endif;

  if (fullCustomer()->isServiceEnabled('full-whatsapp')) :
    require_once FULL_CUSTOMER_APP . '/controller/whatsapp/hooks.php';
    require_once FULL_CUSTOMER_APP . '/controller/whatsapp/actions.php';
    require_once FULL_CUSTOMER_APP . '/controller/whatsapp/Settings.php';
  endif;

  if (fullCustomer()->isServiceEnabled('full-ai-images')) :
    require_once FULL_CUSTOMER_APP . '/controller/ai-images/hooks.php';
    require_once FULL_CUSTOMER_APP . '/controller/ai-images/actions.php';
  endif;

  if (fullCustomer()->isServiceEnabled('full-ai-copy')) :
    require_once FULL_CUSTOMER_APP . '/controller/ai-copy/hooks.php';
    require_once FULL_CUSTOMER_APP . '/controller/ai-copy/actions.php';
  endif;

  if (fullCustomer()->isServiceEnabled('full-ai-meta')) :
    require_once FULL_CUSTOMER_APP . '/controller/ai-meta/hooks.php';
    require_once FULL_CUSTOMER_APP . '/controller/ai-meta/actions.php';
  endif;

  if (fullCustomer()->isServiceEnabled('full-analytics')) :
    require_once FULL_CUSTOMER_APP . '/controller/analytics/Settings.php';
    require_once FULL_CUSTOMER_APP . '/controller/analytics/Database.php';
    require_once FULL_CUSTOMER_APP . '/controller/analytics/Assets.php';
    require_once FULL_CUSTOMER_APP . '/controller/analytics/PageView.php';
    require_once FULL_CUSTOMER_APP . '/controller/analytics/API.php';
    require_once FULL_CUSTOMER_APP . '/controller/analytics/Admin.php';
  endif;

  if (fullCustomer()->isServiceEnabled('full-social-proof')) :
    require_once FULL_CUSTOMER_APP . '/controller/social-proof/Settings.php';
    require_once FULL_CUSTOMER_APP . '/controller/social-proof/RecentPurchases.php';
    require_once FULL_CUSTOMER_APP . '/controller/social-proof/RecentVisitors.php';
    require_once FULL_CUSTOMER_APP . '/controller/social-proof/Admin.php';
  endif;

  if (fullCustomer()->isServiceEnabled('full-secret-coupon')) :
    require_once FULL_CUSTOMER_APP . '/controller/secret-coupon/Settings.php';
    require_once FULL_CUSTOMER_APP . '/controller/secret-coupon/Frontend.php';
    require_once FULL_CUSTOMER_APP . '/controller/secret-coupon/Admin.php';
  endif;
}

function initFullElementorTemplates(): void
{
  if (class_exists('\Elementor\Plugin')) :
    require_once FULL_CUSTOMER_APP . '/controller/elementor/hooks.php';
    require_once FULL_CUSTOMER_APP . '/controller/elementor/actions.php';
    require_once FULL_CUSTOMER_APP . '/controller/elementor/filters.php';
    require_once FULL_CUSTOMER_APP . '/controller/elementor/TemplateManager.php';
    require_once FULL_CUSTOMER_APP . '/controller/elementor/Importer.php';
    require_once FULL_CUSTOMER_APP . '/controller/elementor/Exporter.php';
  endif;
}
