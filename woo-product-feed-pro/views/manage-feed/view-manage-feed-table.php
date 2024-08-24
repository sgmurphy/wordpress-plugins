<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// phpcs:disable

use AdTribes\PFP\Factories\Product_Feed_Query;
use AdTribes\PFP\Helpers\Product_Feed_Helper;

$product_feeds_query = new Product_Feed_Query(
    array(
        'post_status'    => array( 'draft', 'publish' ),
        'posts_per_page' => -1,
    ),
    'edit'
);

?>
<table id="woosea_main_table" class="woo-product-feed-pro-table">
    <tr>
        <td><strong><?php esc_html_e( 'Active', 'woo-product-feed-pro' ); ?></strong></td>
        <td><strong><?php esc_html_e( 'Project name and channel', 'woo-product-feed-pro' ); ?></strong></td>
        <td><strong><?php esc_html_e( 'Format', 'woo-product-feed-pro' ); ?></strong></td>
        <td><strong><?php esc_html_e( 'Refresh interval', 'woo-product-feed-pro' ); ?></strong></td>
        <td><strong><?php esc_html_e( 'Status', 'woo-product-feed-pro' ); ?></strong></td>
        <td></td>
    </tr>
<?php
if ( $product_feeds_query->have_posts() ) :
foreach ( $product_feeds_query->get_posts() as $product_feed ) :
?>
    <form action="" method="post">
        <?php wp_nonce_field( 'woosea_ajax_nonce' ); ?>
        <tr class="<?php echo 'processing' === $product_feed->status ? 'processing' : ''; ?>">
            <td>
                <label class="woo-product-feed-pro-switch">
                    <input type="hidden" name="manage_record" value="<?php echo esc_attr( $product_feed->legacy_project_hash ); ?>">
                    <input type="checkbox" name="project_active[]" class="checkbox-field" value="<?php echo esc_html( $product_feed->legacy_project_hash ); ?>" <?php echo 'publish' === $product_feed->post_status ? 'checked="true"' : ''; ?>">
                    <div class="woo-product-feed-pro-slider round"></div>
                </label>
            </td>
            <td>
                <span><?php echo esc_html( $product_feed->title ); ?></span><br/>
                <span class="woo-product-feed-pro-channel">Channel: <?php echo esc_html( $product_feed->get_channel( 'name' ) ); ?></span>
            </td>
            <td><span><?php echo esc_html( $product_feed->file_format ); ?></span></td>
            <td><span><?php echo esc_html( $product_feed->refresh_interval ); ?></span></td>
            <td>
                <?php if ( 'processing' === $product_feed->status ) : ?>
                    <span class="woo-product-feed-pro-blink_me" id="woosea_proc_<?php echo esc_attr( $product_feed->legacy_project_hash ); ?>">
                        <?php echo esc_html( $product_feed->status . ' (' . $product_feed->get_processing_percentage() . '%)' ); ?>
                    </span>
                <?php else : ?>
                    <span class="woo-product-feed-pro-blink_off_<?php echo esc_attr( $product_feed->legacy_project_hash ); ?>" id="woosea_proc_<?php echo esc_attr( $product_feed->legacy_project_hash ); ?>"><?php echo esc_html( $product_feed->status ); ?></span>
                <?php endif; ?>
            </td>
            <td>
                <div class="actions">
                    <span class="gear dashicons dashicons-admin-generic" id="gear_<?php echo esc_attr( $product_feed->legacy_project_hash ); ?>" title="project settings" style="display: inline-block;"></span>
                    <?php if ( 'processing' !== $product_feed->status ) : ?>
                        <?php if ( 'publish' === $product_feed->post_status ) : ?>
                            <span
                                class="dashicons dashicons-admin-page"
                                id="copy_<?php echo esc_attr( $product_feed->legacy_project_hash ); ?>"
                                title="copy project"
                                style="display: inline-block;"
                            >
                            </span>
                            <span
                                class="dashicons dashicons-update"
                                id="refresh_<?php echo esc_attr( $product_feed->legacy_project_hash ); ?>"
                                title="manually refresh productfeed"
                                style="display: inline-block;"
                            >
                            </span>
                            <?php if ( 'not run yet' !== $product_feed->status ) : // Yes, the status is called `not run yet` x_x. ?>
                                <a
                                    href="<?php echo esc_url( $product_feed->get_file_url() ); ?>"
                                    target="_blank"
                                    class="dashicons dashicons-download"
                                    id="download"
                                    title="download productfeed"
                                    style="display: inline-block"
                                >
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                        <span class="trash dashicons dashicons-trash" id="trash_<?php echo esc_attr( $product_feed->legacy_project_hash ); ?>" title="delete project and productfeed" style="display: inline-block;"></span>
                    <?php else : ?>
                        <span class="dashicons dashicons-dismiss" id="cancel_<?php echo esc_attr( $product_feed->legacy_project_hash ); ?>" title="cancel processing productfeed" style="display: inline-block;"></span>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td id="manage_inline" colspan="8">
                <div>
                    <table class="woo-product-feed-pro-inline_manage">
                        <?php
                        if ( in_array( $product_feed->status, array( 'ready', 'stopped', 'not run yet' ), true ) ) :

                        ?>
                            <tr>
                                <td>
                                    <strong><?php esc_html_e( 'Change settings', 'woo-product-feed-pro' ); ?></strong>
                                    <br/>
                                    <span class="dashicons dashicons-arrow-right" style="display: inline-block;"></span>
                                    <a href="<?php echo esc_url( Product_Feed_Helper::get_product_feed_setting_url( $product_feed->id, 0 ) ); ?>">
                                        <?php esc_html_e( 'General feed settings', 'woo-product-feed-pro' ); ?>
                                    </a>
                                    <br/>
                                    <?php if ( $product_feed->get_channel( 'fields' ) == 'standard' ) : ?>
                                        <span class="dashicons dashicons-arrow-right" style="display: inline-block;"></span>
                                        <a href="<?php echo esc_url( Product_Feed_Helper::get_product_feed_setting_url( $product_feed->id, 2 ) ); ?>">
                                            <?php esc_html_e( 'Attribute selection', 'woo-product-feed-pro' ); ?>
                                        </a>
                                        <br/>
                                    <?php else : ?>
                                        <span class="dashicons dashicons-arrow-right" style="display: inline-block;"></span>
                                        <a href="<?php echo esc_url( Product_Feed_Helper::get_product_feed_setting_url( $product_feed->id, 7 ) ); ?>">
                                            <?php esc_html_e( 'Field mapping', 'woo-product-feed-pro' ); ?>
                                        </a>
                                        <br/>
                                    <?php endif; ?>
                                    
                                    <?php if ( $product_feed->get_channel( 'taxonomy' ) != 'none' ) : ?>
                                        <span class="dashicons dashicons-arrow-right" style="display: inline-block;"></span>
                                        <a href="<?php echo esc_url( Product_Feed_Helper::get_product_feed_setting_url( $product_feed->id, 1 ) ); ?>">
                                            <?php esc_html_e( 'Category mapping', 'woo-product-feed-pro' ); ?>
                                        </a>
                                        <br/>
                                    <?php endif; ?>
                                    <span class="dashicons dashicons-arrow-right" style="display: inline-block;"></span>
                                    <a href="<?php echo esc_url( Product_Feed_Helper::get_product_feed_setting_url( $product_feed->id, 4 ) ); ?>">
                                        <?php esc_html_e( 'Feed filters and rules', 'woo-product-feed-pro' ); ?>
                                    </a>
                                    <br />
                                    <span class="dashicons dashicons-arrow-right" style="display: inline-block;"></span>
                                    <a href="<?php echo esc_url( Product_Feed_Helper::get_product_feed_setting_url( $product_feed->id, 5 ) ); ?>">
                                        <?php esc_html_e( 'Conversion & Google Analytics settings', 'woo-product-feed-pro' ); ?>
                                    </a>
                                    <br />
                                </td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td>
                                <strong><?php esc_html_e( 'Feed URL', 'woo-product-feed-pro' ); ?></strong><br/>
                                <?php if ( ( $product_feed->post_status == 'publish' ) && ( $product_feed->status != 'not run yet' ) ) : ?>
                                    <span class="dashicons dashicons-arrow-right" style="display: inline-block;"></span>
                                    <a href="<?php echo esc_url( $product_feed->get_file_url() ); ?>" target="_blank">
                                        <?php echo esc_html( $product_feed->get_file_url() ); ?>
                                    </a>
                                <?php else : ?>
                                    <span class="dashicons dashicons-warning"></span>
                                    <?php echo esc_html__( 'Whoops, there is no active product feed for this project as the project has been disabled or did not run yet.', 'woo-product-feed-pro' ); ?>
                                <?php
                                endif;
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </form>
<?php endforeach; else : ?>
    <tr class="woo-product-feed-pro-table--empty">
        <td colspan="6">
            <span class="dashicons dashicons-warning"></span>
            <p>
                <?php
                printf(
                    // translators: %s: close <a> tag.
                    esc_html__( 'You haven\'t configured a product feed yet, %1$splease create one first%3$s or read our tutorial on %2$show to set up your very first Google Shopping product feed%3$s.', 'woo-product-feed-pro' ),
                    '<a href="admin.php?page=woo-product-feed-pro">',
                    '<a href="https://adtribes.io/setting-up-your-first-google-shopping-product-feed/?utm_source=pfp&utm_medium=manage-feed&utm_campaign=first shopping feed" target="_blank">',
                    '</a>',
                );
                ?>
            </p>
        </td>
    </tr>
<?php endif; ?> 
</table>
