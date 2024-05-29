<?php defined('ABSPATH' ) || wp_die; ?>
<div id="pz-lkc-modal">
  <div id="pz-lkc-close">
    <a><?php _e('×', $this->text_domain ); ?></a>
  </div>
  <div id="pz-lkc-content">
    <form method="post">
      <label><?php _e('Input URL', $this->text_domain ); ?></label><br />
      <input id="pz-lkc-code" type="hidden" value="<?php echo $this->options['code1']; ?>">
      <input id="pz-lkc-url" type="url" size="60">
      <input id="pz-lkc-insert" type="submit" value="<?php _e('Insert', $this->text_domain ); ?>" onClick="return false;" >
    </form>
  </div>
</div>
<div id="pz-lkc-overlay"></div>
