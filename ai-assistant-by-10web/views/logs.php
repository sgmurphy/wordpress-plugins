<?php
$page = isset($_GET['list']) ? (int) $_GET['list'] : 1;
$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 20;
$logs = \AIAssistantTenWeb\Library::get_logs(array('list' => $page, 'limit' => $limit));
if ( empty($logs) ) {
  return;
}
?>
<div class="taa_flex_table">
  <div class="taa_flex_row taa_flex_header">
  <?php
  foreach ( array('URL', 'Parameters', 'Response code', 'Response', 'Date') as $header ) {
    ?>
    <div class="taa_flex_col"><?php echo esc_html($header); ?></div>
    <?php
  }
  ?>
  </div>
  <?php
  foreach ( $logs as $row ) {
    ?>
    <div class="taa_flex_row">
    <?php
    foreach ( $row as $header => $data ) {
      ?>
      <div class="taa_flex_col"><?php echo $header === 'date' ? esc_html(date('d/m/Y H:i:s', $data)) : esc_html($data); ?></div>
      <?php
    }
    ?>
    </div>
    <?php
  }
  ?>
</div>
