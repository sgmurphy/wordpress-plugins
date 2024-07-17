<?php return array(
    'root' => array(
        'name' => 'fullworks/stop-user-enumeration',
        'pretty_version' => 'dev-main',
        'version' => 'dev-main',
        'reference' => '41a8b417f09bd31455e37ca13d629dbc1f7b45bd',
        'type' => 'wordpress-plugin',
        'install_path' => __DIR__ . '/../../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        'composer/installers' => array(
            'pretty_version' => 'v1.0.12',
            'version' => '1.0.12.0',
            'reference' => '4127333b03e8b4c08d081958548aae5419d1a2fa',
            'type' => 'composer-installer',
            'install_path' => __DIR__ . '/./installers',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'fullworks/stop-user-enumeration' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'reference' => '41a8b417f09bd31455e37ca13d629dbc1f7b45bd',
            'type' => 'wordpress-plugin',
            'install_path' => __DIR__ . '/../../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'shama/baton' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => '*',
            ),
        ),
    ),
);
