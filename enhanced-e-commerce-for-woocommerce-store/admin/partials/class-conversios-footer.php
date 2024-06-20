<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * @since      4.0.2
 * Description: Conversios Onboarding page, It's call while active the plugin
 */
if (!class_exists('Conversios_Footer')) {
	class Conversios_Footer
	{
		protected $TVC_Admin_Helper = "";
		public function __construct()
		{
			add_action('add_conversios_footer', array($this, 'before_end_footer'));
			add_action('add_conversios_footer', array($this, 'before_end_footer_add_script'));
			$this->TVC_Admin_Helper = new TVC_Admin_Helper();
		}
		public function before_end_footer()
		{
?>
			<div class="tvc_footer_links">
			</div>
			<?php
			$licenceInfoArr = array(
				"Plan Type:" => "Free",
				"Plan Price:" => "Not Available",
				"Active License Key:" => "Not Available",
				"Subscription ID:" => "Not Available",
				"Active License Key:" => "Not Available",
				"Last Bill Date:" => "Not Available",
				"Next Bill Date:" => "Not Available",
			);
			?>


			<div class="modal fade" id="convLicenceInfoMod" tabindex="-1" aria-labelledby="convLicenceInfoModLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg modal-dialog-centered" style="width: 700px;">
					<div class="modal-content">
						<div class="modal-header badge-dark-blue-bg text-white">
							<h5 class="modal-title text-white" id="convLicenceInfoModLabel">
								<?php esc_html_e("My Subscription", "enhanced-e-commerce-for-woocommerce-store"); ?>
							</h5>
							<button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<div class="container-fluid">
								<div class="row">
									<?php foreach ($licenceInfoArr as $key => $value) { ?>
										<div class="<?php echo $key == "Connected with:" ? "col-md-12" : "col-md-6"; ?> py-2 px-0">
											<span class="fw-bold">
												<?php
												printf(
													esc_html__('%s', 'enhanced-e-commerce-for-woocommerce-store'),
													esc_html($key)
												);
												?>
											</span>
											<span class="ps-2">
												<?php
												printf(
													esc_html__('%s', 'enhanced-e-commerce-for-woocommerce-store'),
													esc_html($value)
												);
												?>
											</span>
										</div>
									<?php  } ?>
								</div>
							</div>
						</div>
						<div class="modal-footer justify-content-center">
							<div class="fs-6">
								<span><?php esc_html_e("You are currently using our free plugin, no license needed! Happy Analyzing.", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
								<span><?php esc_html_e("To unlock more features of Google Products ", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
								<?php echo wp_kses_post($this->TVC_Admin_Helper->get_conv_pro_link_adv("planpopup", "globalheader", "conv-link-blue", "anchor", "Upgrade to Pro Version")); ?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- GA360 form modal -->
			<!-- Modal -->
			<div class="modal fade" id="convga360modal" tabindex="-1" aria-labelledby="convga360modalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-body p-0">
							<div class="convga360modal_body">
								<div class="row">
									<div class="col-6 p-5" id="convga360_left">
										<div class="">
											<img src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/conv_google_partner.png'); ?>">
										</div>
										<h4 class="text-white pt-4 mb-0">
											<?php esc_html_e("Let's discuss how GA4 360 can unlock", "enhanced-e-commerce-for-woocommerce-store"); ?>
											<br><?php esc_html_e("the full potential of your business", "enhanced-e-commerce-for-woocommerce-store"); ?>
										</h4>
										<div class="text-white pt-4 lh-lg">
											<?php esc_html_e("Start your GA4 journey with our Certified Google Analytics experts today. We will help you start with an informed and systematic plan.", "enhanced-e-commerce-for-woocommerce-store"); ?>
										</div>
										<div class="text-white d-flex justify-content-between pt-4">
											<div class="d-flex convmodalcta">
												<h3 class="m-0">100+</h3>
												<div class="lh-1 ps-2">
													<?php esc_html_e("GA & GMP", "enhanced-e-commerce-for-woocommerce-store"); ?>
													<br><?php esc_html_e("Certified Experts", "enhanced-e-commerce-for-woocommerce-store"); ?>
												</div>
											</div>
											<div class="d-flex convmodalcta">
												<h3 class="m-0">500+</h3>
												<div class="lh-1 ps-2">
													<?php esc_html_e("GA4 360 Licenses", "enhanced-e-commerce-for-woocommerce-store"); ?>
													<br><?php esc_html_e("Sold", "enhanced-e-commerce-for-woocommerce-store"); ?>
												</div>
											</div>
										</div>
									</div>
									<div class="col-6 p-5" id="convga360_right">
										<form id="convga360submit" class="row">
											<div class="col-6">
												<label for="convga360_name" class="form-label">Name</label>
												<input type="text" class="form-control" name="convga360_name" id="convga360_name" placeholder="Enter your name" value="">
											</div>

											<div class="col-6">
												<label for="convga360_phone" class="form-label">Contact No.</label>
												<input type="text" class="form-control" name="convga360_phone" id="convga360_phone" placeholder="Enter your contact no" value="">
											</div>

											<div class="col-12 pt-4">
												<label for="convga360_email" class="form-label">Email</label>
												<input type="text" class="form-control" name="convga360_email" id="convga360_email" placeholder="Enter your email id" value="">
											</div>

											<div class="col-12 pt-4">
												<label for="convga360_businessname" class="form-label">Business Name</label>
												<input type="text" class="form-control" name="convga360_businessname" id="convga360_businessname" placeholder="Enter your business name" value="">
											</div>

											<div class="col-12 pt-4">
												<button id="convga360submit_but" type="button" class="btn text-white w-100">
													Submit
													<div class="spinner-border text-light spinner-border-sm d-none" role="status">
														<span class="visually-hidden">Loading...</span>
													</div>
												</button>
											</div>

										</form>

										<div id="conv_ga360successmessage" class="alert alert-success d-none" role="alert">
											<b><?php esc_html_e("Thank you for your interest in GA 360!", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
											<br><?php esc_html_e("We have received your information and a member of our team will be in touch within 2 business days to discuss your needs.", "enhanced-e-commerce-for-woocommerce-store"); ?>
											<br><button type="button" class="btn btn-secondary btn-sm m-auto d-block" data-bs-dismiss="modal">Close</button>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ga360 modal end -->

			<!-- new feature notes modal start -->
			<?php $user_id = get_current_user_id(); ?>
			<div class="modal fade" id="convnewfeaturemodal" data-userdata="<?php echo esc_attr(get_option('conv_popup_newfeature')); ?>" tabindex="-1" aria-labelledby="convnewfeaturemodalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
				<div class="modal-dialog modal-dialog-centered" style="max-width: 700px;">
					<div class="modal-content">
						<div class="modal-header align-items-baseline">
							<div>
								<h3 class="modal-title" id="convnewfeaturemodalLabel">
									<?php esc_html_e("Exciting New Features!", "enhanced-e-commerce-for-woocommerce-store"); ?>
								</h3>
								<p class="m-0">In your updated plugin version:<code><?php echo esc_html(PLUGIN_TVC_VERSION) ?></code></p>
							</div>
							<button type="button" id="conv_close_popup" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body" style=" background: ghostwhite;">
							<h5 class="" style="font-weight: 500; color: #09BD83; ">We're excited to announce new features to help you better track user interactions on your website.</h5>
							<h4 style="color: #6c757d;">GA4 E-Commerce Tracking:</h4>
							<ul class="flex-wrap mb-3 d-flex" style="list-style: circle;">
								<li class="flex-fill w-50">page_view</li>
								<li class="flex-fill w-50">view_item_list</li>
								<li class="flex-fill w-50">select_item</li>
								<li class="flex-fill w-50">view_item</li>
								<li class="flex-fill w-50">add_to_cart</li>
								<li class="flex-fill w-50">view_cart</li>
								<li class="flex-fill w-50">remove_from_cart</li>
								<li class="flex-fill w-50">begin_checkout</li>
								<li class="flex-fill w-50">add_shipping_info</li>
								<li class="flex-fill w-50">add_payment_info</li>
								<li class="flex-fill w-50">purchase</li>
							</ul>
							<h4 style="color: #6c757d;">Lead Generation Tracking:</h4>
							<ul class="flex-wrap d-flex" style="list-style: circle;">
								<li class="flex-fill w-50">form_lead_submit</li>
								<li class="flex-fill w-50">phone_click</li>
								<li class="flex-fill w-50">email_click</li>
								<li class="flex-fill w-50">address_click</li>
							</ul>
						</div>
						<div class="modal-footer">
						<p>Take advantage of these powerful features to optimize your tracking and enhance your insights!</p>
							<button type="button" id="conv_dont_show_popup" class="btn btn-secondary btn-sm">
								<?php esc_html_e("Don't remind again", "enhanced-e-commerce-for-woocommerce-store"); ?>
							</button>
							<a href="<?php echo esc_url_raw('admin.php?page=conversios&wizard=pixelandanalytics&onboarding=1'); ?>" class="btn btn-success btn-sm">
								<?php esc_html_e("Setup Now ", "enhanced-e-commerce-for-woocommerce-store"); ?>
								&rarr;</a>
						</div>
					</div>
				</div>
			</div>
			<!-- new feature notes modal end -->

		<?php
		}

		public function before_end_footer_add_script()
		{
			$TVC_Admin_Helper = new TVC_Admin_Helper();
			$subscriptionId =  sanitize_text_field($TVC_Admin_Helper->get_subscriptionId());
		?>
			<script>
				jQuery(function() {
					jQuery("#convga360submit_but").click(function(event) {

						// Flag to track validation status
						var isValid = true;

						// Check Name field
						var name = jQuery("#convga360_name").val();
						if (name === "") {
							jQuery("#convga360_name").addClass("is-invalid");
							isValid = false;
						} else {
							jQuery("#convga360_name").removeClass("is-invalid");
						}

						// Check Email field
						var email = jQuery("#convga360_email").val().trim();
						var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
						if (email === "" || !emailRegex.test(email)) {
							jQuery("#convga360_email").addClass("is-invalid");
							isValid = false;
						} else {
							jQuery("#convga360_email").removeClass("is-invalid");
						}

						// Check Phone field (basic check for non-empty)
						var phone = jQuery("#convga360_phone").val().trim();
						if (phone === "") {
							jQuery("#convga360_phone").addClass("is-invalid");
							isValid = false;
						} else {
							jQuery("#convga360_phone").removeClass("is-invalid");
						}

						// Check Business Name field
						var businessName = jQuery("#convga360_businessname").val().trim();
						if (businessName === "") {
							jQuery("#convga360_businessname").addClass("is-invalid");
							isValid = false;
						} else {
							jQuery("#convga360_businessname").removeClass("is-invalid");
						}

						// Submit form if validation is successful

						if (isValid) {
							var emailmessage = {
								name: jQuery("#convga360_name").val().trim(),
								email: jQuery("#convga360_email").val().trim(),
								phone: jQuery("#convga360_phone").val().trim(),
								businessName: jQuery("#convga360_businessname").val().trim(),
							};
							jQuery("#convga360submit_but").find(".spinner-border").removeClass("d-none");
							jQuery("#convga360submit_but").addClass('disabled');
							jQuery.ajax({
								type: "POST",
								url: tvc_ajax_url,
								data: {
									action: "conv_send_email",
									sendmail_req_nonce: "<?php echo esc_js(wp_create_nonce('sendmail_req_nonce_val')); ?>",
									sendmail_message: emailmessage,
									sendmail_to: "dean@tatvic.com",
									sendmail_cc: "ankit.bhatia@tatvic.com,rajiv@conversios.io",
									sendmail_bcc: "ravi@tatvic.com,ruhbir@tatvic.com",
									sendmail_subject: "New Lead for GA4 360 From Conversios Free Plugin",
									subscription_id: "<?php echo esc_js($subscriptionId); ?>",
								},
								success: function(response) {
									jQuery("#convga360submit").remove();
									jQuery("#conv_ga360successmessage").removeClass("d-none");
								}
							});
						}
					});

					//New feature modal popup initiate
					if (!document.cookie.includes('conv_popup_newfeature') && jQuery('#convnewfeaturemodal').data('userdata') != 'yes') {
						// First visit, display popup
						jQuery("#convnewfeaturemodal").modal('show');
					}
					jQuery('#conv_close_popup').click(function() {
						// Set cookie to expire in 24 hours
						document.cookie = "conv_popup_newfeature=true; expires=" + new Date(Date.now() + 24 * 60 * 60 * 1000).toUTCString() + "; path=/";
						jQuery("#convnewfeaturemodal").modal('hide');
					});
					jQuery('#conv_dont_show_popup').click(function() {
						jQuery("#convnewfeaturemodal").modal('hide');
						jQuery.ajax({
							type: "POST",
							dataType: "json",
							url: tvc_ajax_url,
							data: {
								action: "conv_convnewfeaturemodal_ajax",
								wp_nonce: "<?php echo esc_js(wp_create_nonce('convnewfeaturemodal_nonce')); ?>",
							}
						});
					});


				});
			</script>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var screen_name = '<?php echo isset($_GET['page']) ? esc_js(sanitize_text_field($_GET['page'])) : ''; ?>';
					var error_msg = 'null';
					jQuery('.navinfotopnav ul li a').click(function() {
						var slug = $(this).find('span').text();
						var menu = $(this).attr('href');
						str_menu = slug.replace(/\s+/g, '_').toLowerCase();
						user_tracking_data('click', error_msg, screen_name, 'topmenu_' + str_menu);
					});
				});

				function user_tracking_data(event_name, error_msg, screen_name, event_label) {
					// alert();
					jQuery.ajax({
						type: "POST",
						dataType: "json",
						url: tvc_ajax_url,
						data: {
							action: "update_user_tracking_data",
							event_name: event_name,
							error_msg: error_msg,
							screen_name: screen_name,
							event_label: event_label,
							TVCNonce: "<?php echo esc_js(wp_create_nonce('update_user_tracking_data-nonce')); ?>"
						},
						success: function(response) {
							// console.log('user tracking');
						}
					});
				}
			</script>
			<script>
				window.fwSettings = {
					'widget_id': 81000001743
				};
				! function() {
					if ("function" != typeof window.FreshworksWidget) {
						var n = function() {
							n.q.push(arguments)
						};
						n.q = [], window.FreshworksWidget = n
					}
				}()
			</script>
			<script type='text/javascript' src='https://ind-widget.freshworks.com/widgets/81000001743.js' async defer></script>
<?php
		}
	}
}
new Conversios_Footer();
