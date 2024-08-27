<?php
$itemArray = [
    'My Apps'       => [
        'data-name' => 'sumome-control-apps',
        'class'     => 'sumo-apps',
        'columns'   => 2,
        'data-type' => 'sumome-app',
        'img-url'   => esc_url(plugins_url('images/icon-apps.png', dirname(__FILE__)))
    ],
    'Store'         => [
        'data-name' => 'sumome-control-store',
        'class'     => 'sumo-store',
        'columns'   => 2,
        'data-type' => 'sumome-app',
        'img-url'   => esc_url(plugins_url('images/icon-store.png', dirname(__FILE__)))
    ],
    'Notifications' => [
        'data-name' => 'sumome-control-notifications',
        'class'     => 'sumo-notifications',
        'columns'   => 1,
        'data-type' => 'sumome-app',
        'img-url'   => esc_url(plugins_url('images/icon-notifications.png', dirname(__FILE__)))
    ],
    'Statistics'    => [
        'data-name' => 'sumome-control-statistics',
        'class'     => 'sumome-popup-no-dim sumo-statistics',
        'columns'   => 1,
        'img-url'   => esc_url(plugins_url('images/icon-statistics.png', dirname(__FILE__))),
        'href'      => 'https://sumome.com/site/' . get_option('sumome_site_id') . '/manage'
    ],
    'Help'   => [
        'data-name' => 'sumome-control-help',
        'class'     => 'sumome-control-help sumome-popup-no-dim',
        'columns'   => 1,
        'img-url'   => esc_url(plugins_url('images/icon-help.png', dirname(__FILE__)))
    ],
    'About'         => [
        'data-name' => 'sumome-control-about',
        'class'     => 'sumome-tile-about sumome-popup-no-dim',
        'columns'   => 1,
        'img-url'   => esc_url(plugins_url('images/icon-about.png', dirname(__FILE__)))
    ],
    'Settings' => [
        'data-name' => 'sumome-control-settings',
        'class'     => 'sumo-settings',
        'columns'   => 1,
        'data-type' => 'sumome-app',
        'img-url'   => esc_url(plugins_url('images/icon-settings.png', dirname(__FILE__)))
    ]
];
?>
<div class="sumome-plugin-main-wrapper wash-bg">
    <div class="sumome-logged-in-container">
        <!-- Header -->

        <div class="header-banner"></div>

        <div class="items">
            <?php foreach ($itemArray as $title => $parameters) : ?>
                <div <?php
                        foreach ($parameters as $parameterName => $parameterValue) :
                            echo esc_attr($parameterName) . '="' . ($parameterName === 'class' ? esc_attr($parameterValue) . ' item-tile' : esc_attr($parameterValue)) . '" ';
                        endforeach;
                        ?> data-title="<?php echo esc_attr($title); ?>">

                    <?php if ($parameters['href']) : ?>
                      <a class="item-tile-title" href="<?php echo esc_url($parameters['href']); ?>" target="_blank">
                          <img src="<?php echo esc_html($parameters['img-url']); ?>" alt="<?php echo esc_html($title); ?>">
                          <?php echo esc_html($title); ?>
                      </a>
                    <?php else : ?>
                        <div class="item-tile-title">
                            <img src="<?php echo esc_html($parameters['img-url']); ?>" alt="<?php echo esc_html($title); ?>">
                            <?php echo esc_html($title); ?>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
        </div>

        <div class="tabbed-content-container">
            <div class="back-logged-in">Back</div>
            <div class="content"></div>
        </div>
    </div>

    <div class="sumome-plugin-main main-bottom wash-bg">
        <!-- Review -->
        <div class="row row3 wash-bg">
            <div class="large-12 columns wash-bg">
                <div class="list-bullet">
                    <h4 class="list-number-title">Leave a Review!</h4>
                </div>
                <div class="sumome-instructions">We will love you forever if you leave an <a href="https://wordpress.org/support/view/plugin-reviews/sumome" target="_blank">honest
                        review here</a> of the Sumo plugin.
                </div>
            </div>
        </div>

        <!-- Help -->
        <div class="row">
            <div class="large-12 columns footer">
                <h4 class="list-number-title">Need Help?</h4>
                <div class="sumome-help">
                    <span>Take a look at our <a target="_blank" href="https://help.bdow.com/">help page</a> to see our frequently answered</span>
                    <span>questions or <a target="_blank" href="mailto:help@bdow.com">send us a message</a> and we will get back to you asap.</span>
                </div>
            </div>
        </div>


    </div>
</div>

<div class="sumome-logged-in-container-overlay"></div>
<?php
include_once 'popup.php';
?>
