<header class="header-container">
	<img class="migrateguru-logo" src="<?php echo esc_url(plugins_url("/../img/migrate-guru.png", __FILE__)); ?>">
	<img class="blogvault-logo" src="<?php echo esc_url(plugins_url("/../img/powered-by-blogvault.png", __FILE__)); ?>">
</header>
<main>
	<div class="card">
		<div class="card-header-links">
			<a class="bv-button" target="_blank" rel="noopener noreferrer" href="https://migrateguru.freshdesk.com/support/home">
				FAQs
			</a>
			<a class="bv-button" target="_blank" rel="noopener noreferrer" href="https://migrateguru.freshdesk.com/support/home">
				Help Docs
			</a>
			<a class="bv-button" target="_blank" rel="noopener noreferrer" href="https://www.migrateguru.com/contact-us/">
				Support
			</a>
			<a class="bv-button" target="_blank" rel="noopener noreferrer" href="https://wordpress.org/support/plugin/migrate-guru/reviews">
				Rate us 5 stars
			</a>
		</div>
		<form action="<?php echo esc_url($this->bvinfo->appUrl()); ?>/migration/migrate" method="post" name="signup">
			<h1 class="card-title">Easy WordPress Migrations</h1>
			<div class="iframe-container">
				<iframe width="80%" height="265" src="https://www.youtube.com/embed/ENIHodsYklU" frameborder="0" allowfullscreen></iframe>
			</div>
			<hr class="my-3">
			<div class="form-content">
				<label class="email-label" required>Email</label>
				<br>
				<input type="email" name="email" placeholder="Email address" class="email-input">
				<div class="tnc-check mt-2">
					<label class="normal-text horizontal">
						<input type="hidden" name="bvsrc" value="wpplugin" />
						<input type="hidden" name="migrate" value="migrateguru" />
						<input type="checkbox" name="consent" onchange="document.getElementById('migratesubmit').disabled = !this.checked;" value="1">
						<span class="checkmark"></span>&nbsp;
						I agree to BlogVault's <a href="https://blogvault.net/tos/">Terms &amp; Conditions</a> and <a href="https://blogvault.net/privacy/">Privacy&nbsp;Policy</a>
					</label>
				</div>
			</div>
			<?php echo $this->siteInfoTags(); ?>
			<input type="submit" name="submit" id="migratesubmit" class="button button-primary" value="Migrate" disabled>
		</form>
	</div>

	<div class="card migration-key-card">
		<h2><span>Migration Key</span></h2>
		<div>
			<div>
				Install Migrate Guru Plugin on destination and copy the key.
			</div><br/>
			<div style="display: flex; gap: 8px; align-items: center;">
				<input type="password" id="destination-migration-key" name="destination_migration_key" value="<?php echo esc_attr( $this->bvinfo->getConnectionKey() ); ?>" class="widefat" style="flex: 1;" readonly>
				<button type="button" id="view-key" class="button">View Key</button>
				<button type="button" id="copy-key" class="button" onclick="copyToClipboard()">Copy Key</button>
			</div>
		</div>
	</div>

	<script>
		function copyToClipboard() {
			var copyText = document.getElementById("destination-migration-key");
			copyText.type = 'text';

			copyText.select();
			document.execCommand("copy");
			copyText.type = 'password'; // Revert back to password type
			var copyButton = document.getElementById("copy-key");
			copyButton.textContent = 'Copied!';
			setTimeout(() => copyButton.textContent = 'Copy Key', 2000);
		}
		document.getElementById('view-key').addEventListener('click', function() {
			var keyField = document.getElementById("destination-migration-key");
			if (keyField.type === "password") {
				keyField.type = "text";
				this.textContent = 'Hide Key';
			} else {
				keyField.type = "password";
				this.textContent = 'View Key';
			}
		});
	</script>
</main>