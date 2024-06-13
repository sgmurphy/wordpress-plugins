<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php
function getMillisecond() {
    list($t1, $t2) = explode(' ', microtime());
    return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
}
function encrypt_aesgcm($key, $text){
    $cipher='aes-128-gcm';
    $ivlen= openssl_cipher_iv_length($cipher);
    $iv=openssl_random_pseudo_bytes($ivlen);
    $ss=openssl_encrypt($text,$cipher,$key,OPENSSL_RAW_DATA,$iv,$tag);
    $ssss=$iv.$ss.$tag;
    return bin2hex($ssss);
 }
?>

<div id="LA_INTEGRATE_BOX"></div>
<script src="//sdk.51.la/js-sdk-integrate.min.js" crossorigin="anonymous" charset="UTF-8"></script>
<script>
    const la_integrate = new LAIntegrate({
        asKey: '<?php echo esc_attr(trim(get_option(YAOLA_PRODUCT_VENDORS_AK))) ?>',
        token: '<?php echo encrypt_aesgcm(esc_attr(trim(get_option(YAOLA_PRODUCT_VENDORS_SK))), (esc_attr(trim(get_option(YAOLA_PRODUCT_ID)))) . '|' . (esc_attr(trim(get_option(YAOLA_PRODUCT_VENDORS_MODULE_ID)))) .'|' . (getMillisecond() + 14400000)) ?>',
        navbarType: 2,
        height: 'calc(100vh - 120px)'
    })
    la_integrate.start();
</script>
<img src="//ia.51.la/go1?id=21261191&pvFlag=1" style="border:none;height:1px;width:1px;" />

<style>
    #wpcontent {
        padding: 0;
        overflow-y: hidden;
    }
</style>