<?php
$sumomeStatus = (isset($_COOKIE['__smUser']) && !is_null($_COOKIE['__smUser']))
    ? 'status-logged-in'
    : 'status-logged-out';
?>

<div class="sumome-plugin-container">
    <!-- Logged in -->
    <div class="sumome-plugin-main logged-in <?php print esc_attr($sumomeStatus) ?>">
        <div class="loading"><img src="<?php echo esc_url(plugins_url('images/sumome-loading.gif', dirname(__FILE__))) ?>"></div>
    </div>

    <!-- Logged out -->
    <div class="sumome-plugin-main logged-out <?php print esc_attr($sumomeStatus) ?>">
        <?php
        $noClose = true;
        include 'wordpress-dashboard-welcome-page.php';
        ?>
    </div>

    <?php
    include_once 'popup.php';
    ?>


</div>