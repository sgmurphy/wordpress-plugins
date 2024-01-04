<?php
/**
 * Iubenda head script handler.
 *
 * It is used to attach scripts into head directly.
 *
 * @package Iubenda
 */

class Head_Script_Handler {
	/**
	 * @var array
	 */
	private $script;

	/**
	 * Head_Script_Handler constructor.
	 *
	 * @param   array  $script
	 */
	public function __construct( $script ) {
		$this->script = $script;
	}

	/**
	 * Handle the script.
	 */
	public function handle() {
		add_action( 'wp_head', array( $this, 'output_script' ), 2 );
	}

	/**
	 * Output the script in the head.
	 */
	public function output_script() {
		if ( isset( $this->script['src'] ) ) { ?>
            <script class="_iub_cs_skip" src="<?php echo esc_url( $this->script['src'] ); ?>"></script>
			<?php
		}
	}
}
