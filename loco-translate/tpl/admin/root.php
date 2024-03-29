<?php
/**
 * Root admin screen
 */

/* @var Loco_mvc_View $this */
$this->extend('layout');
?>  
    <div class="panel panel-info">
        <p class="has-lang">
            <span <?php echo $siteLocale->attr?>><code><?php $siteLocale->e('code')?></code></span>
            <span><?php
                // translators: %s will be replaced with the full name of the site language
                printf( esc_html( __('The language of this site is %s.','loco-translate') ), $siteLocale->link );
                if( $params->has('adminLocale') ): echo ' ';
                // translators: %s will be replaced with the full name of the user profile's admin language        
                printf( esc_html( __('Your admin language is %s.','loco-translate') ), $adminLocale->link );
                endif?> 
            </span>
        </p>
    </div><?php


    if( $recent ):?> 
    <div>
        <h2>
            <?php esc_html_e('Recently updated:','loco-translate')?> 
        </h2>
        <p>
            <?php esc_html_e("Translations have been recently modified in the following bundles",'loco-translate')?>:
        </p><?php
        echo $this->render('list/inc-table', [ 'bundles' => $recent ] );?> 
    </div><?php
    endif;?> 
        

    <div>
        <h2>
            <?php esc_html_e('Active theme:','loco-translate')?> 
        </h2><?php
        echo $this->render('list/inc-table', [ 'bundles' => [$theme] ] )?> 
        <p>
            <a href="<?php $this->route('theme')->e('href')?>" class="button button-link has-raquo"><?php esc_html_e('See all themes','loco-translate')?></a>
        </p>
    </div>


    <?php if( $plugins ):?> 
    <div>
        <h2>
            <?php esc_html_e('Running plugins:','loco-translate')?> 
        </h2>
        <p>
            <?php esc_html_e('These plugins have recently loaded translation files into the admin area','loco-translate')?>:
        </p><?php
        echo $this->render('list/inc-table', [ 'bundles' => $plugins ] )?> 
        <p>
            <a href="<?php $this->route('plugin')->e('href')?>" class="button button-link has-raquo"><?php esc_html_e('See all plugins','loco-translate')?></a>
        </p>
    </div><?php
    endif;
