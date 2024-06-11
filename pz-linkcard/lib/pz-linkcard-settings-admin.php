<?php defined('ABSPATH' ) || wp_die; ?>
<?php
	switch	($action) {
	case	'run-'.self::CRON_CHECK:
		wp_clear_scheduled_hook(self::CRON_CHECK );
		$cron_log		=	'* execute: '.self::CRON_CHECK.PHP_EOL.PHP_EOL;
		$cron_log		.=	$this->schedule_hook_check();
		if ($this->options['sns-position'] && !wp_next_scheduled(self::CRON_CHECK ) ) {
			wp_schedule_event(time() + HOUR_IN_SECONDS, 'hourly', self::CRON_CHECK );
		}
		break;
	case	'run-'.self::CRON_ALIVE:
		wp_clear_scheduled_hook(self::CRON_ALIVE );
		$cron_log		=	'* execute: '.self::CRON_ALIVE.PHP_EOL.PHP_EOL;
		$cron_log		.=	$this->schedule_hook_alive();
		if ($this->options['flg-alive'] && !wp_next_scheduled(self::CRON_ALIVE ) ) {
			wp_schedule_event(time() + DAY_IN_SECONDS, 'daily', self::CRON_ALIVE );
		}
		break;
	}

	// WP-Cron の実行結果
	if (isset($cron_log ) ) {
		$cron_log			=	esc_attr(esc_html($cron_log ) );
		$cron_log			=	str_replace(PHP_EOL, '<br />', $cron_log );
	}

	// WP-Cronスケジュールを取得
	$cron_schedule	=	_get_cron_array();
	$schedules		=	wp_get_schedules();		// タイミングの定数（604800→週1回 など）
	foreach			($cron_schedule	as $timestamp	=> $cronhooks ) {
		foreach		($cronhooks		as $hook		=> $dings ) {
			foreach	($dings			as $signature	=> $data ) {
				if	(($hook == self::CRON_ALIVE ) || ($hook == self::CRON_CHECK ) ) {
					$myjob		=	true;
					$button		=	'class="pz-lkc-button-sure" value="run-'.$hook.'"';
					$display	=	'class="pz-lkc-cron-list-lkc"';
				} else {
					$myjob		=	false;
					$button		=	'class="pz-lkc-button-disabled" disabled="disabled"';
					$display	=	'class="pz-lkc-cron-list-other"';
				}
				$schedule		=	isset($schedules[$data['schedule']]['display'] ) ? $schedules[$data['schedule']]['display'] : $data['schedule'] ;
				$interval		=	isset($data['interval'] ) ? $data['interval'].' '.__('Sec.', $this->text_domain ) : null ;
				$cron_list[]	=	array(
					//'key'			=>	($myjob ? '1' : '2' ).$hook,
					'key'			=>	$timestamp,
					'hook'			=>	$hook,
					'myjob'			=>	$myjob,
					'next_time'		=>	get_date_from_gmt( date( 'Y-m-d H:i:s', $timestamp ), $this->datetime_format ),
					'schedule'		=>	$schedule,
					'interval'		=>	$interval,
					'button'		=>	'<button type="submit" name="action" '.$button.' onclick="return confirm(\''.__('Are you sure?', $this->text_domain ).'\' );">'.__('Run Now', $this->text_domain ).'</button>',
					'display'		=>	$display
					);
			}
		}
	}
	asort($cron_list );

?>
<div class="pz-lkc-page pz-lkc-page-admin" id="pz-lkc-admin">
	<div class="pz-lkc-admin-notice"><?php _e('Do not use normally as it can be set to incapacitate.', $this->text_domain ); ?></div>
	<div class="pz-lkc-submit-float"><?php submit_button(); ?></div>

	<h2><?php _e('Information', $this->text_domain ); ?></h3>
	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('WordPress Version', $this->text_domain ); ?></th>
			<td><input type="text" size="20" value="<?php echo bloginfo('version' ); ?>" readonly="readonly" ?></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('PHP Version', $this->text_domain ); ?></th>
			<td><input type="text" size="20" value="<?php echo phpversion(); ?>" readonly="readonly" ?></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('DBMS Version', $this->text_domain ); ?></th>
			<td><input type="text" size="20" value="<?php global $wpdb; echo $wpdb->db_version(); ?>" readonly="readonly" ?></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Table Name', $this->text_domain ); ?></th>
			<td><input type="text" size="40" value="<?php echo esc_html($this->db_name ); ?>" readonly="readonly" /></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Plugin Version', $this->text_domain ); ?></th>
			<td>
				<input type="text" name="properties[plugin-version]" value="<?php echo esc_html(PLUGIN_VERSION ); ?>" size="10" readonly="readonly" <?php if ($this->options['admin-mode'] ) { echo	'ondblclick="this.readOnly=false;" '; }?>/>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Plugin DB Version', $this->text_domain ); ?></th>
			<td>
				<input type="text" name="properties[db-version]"     value="<?php echo esc_attr($this->options['db-version'] ); ?>"     size="40" readonly="readonly" <?php if ($this->options['admin-mode'] ) { echo	'ondblclick="this.readOnly=false;" '; }?>/>
			</td>
		</tr>
	</table>
	<?php submit_button(); ?>

	<h2><?php _e('for Debug', $this->text_domain ); ?></h3>
	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('Reboot This Plugin', $this->text_domain ); ?></th>
			<td>
				<button type="submit" name="action" value="init-plugin" class="pz-lkc-button-sure" onclick="return confirm('<?php _e('Are you sure?', $this->text_domain ); ?>');"><?php _e('Run', $this->text_domain ); ?></button>
				&ensp;<span><?php echo	__('Perform initial setup.', $this->text_domain ).'&nbsp;'.__('"Settings" will not be initialized.', $this->text_domain ); ?></span>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('DB Update Mode', $this->text_domain ); ?></span></th>
			<td>
				<label>
					<input type="hidden"   name="properties[debug-nocache]" value="0" />
					<input type="checkbox" name="properties[debug-nocache]" value="1" <?php checked($this->options['debug-nocache'] ); ?> class="pz-lkc-tab-show" />
					<?php _e('Forced access to links even if they are recorded in DB.', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
	</table>
	<?php submit_button(); ?>

	<h2><?php _e('Error Settings', $this->text_domain ); ?></h3>
	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('Error Conditions', $this->text_domain ); ?></th>
			<td>
				<label>
					<input type="hidden"   name="properties[error-mode]" value="0" />
					<input type="checkbox" name="properties[error-mode]" value="1" <?php checked($this->options['error-mode'] ); ?> />
					<?php _e('Check to enable error conditions.', $this->text_domain ); ?>
				</label>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Post URL', $this->text_domain ); ?></th>
			<td><input name="properties[error-url]" type="url" size="80" value="<?php echo esc_attr($this->options['error-url'] ); ?>" /></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Occurrence Time', $this->text_domain ); ?></th>
			<td>
				<input type="text" size="40" value="<?php echo is_numeric($this->options['error-time'] ) ? date($this->datetime_format, $this->options['error-time'] ) : $this->options['error-time']; ?>" readonly="readonly" />
				<input name="properties[error-time]" type="text" value="<?php echo $this->options['error-time']; ?>" class="pz-lkc-ad______min-only" />
			</td>
		</tr>
	</table>
	<?php submit_button(); ?>

	<?php if (isset($cron_log ) ) { ?>
		<h2><?php _e('Execution Result', $this->text_domain ); ?></h3>
		<div>
			<?php _e('Execution Result', $this->text_domain ); ?>
		</div>
		<div class="pz-lkc-cron-log">
			<?php echo $cron_log; ?>
		</div>
	<?php } ?>

	<h2><?php _e('WP-Cron Information', $this->text_domain ); ?></h3>
	<div class="pz-lkc-cron-margin">
		<label>
			<input type="checkbox" value="1" class="pz-lkc-cron-all" />
			<?php _e('View all schedules.', $this->text_domain ); ?>
		</label>
	</div>
	<table class="pz-lkc-cron-list widefat striped">
		<thead>
			<tr>
				<th scope="col" class="pz-lkc-cron-head-run"><?php _e('Run', $this->text_domain ); ?></th>
				<th scope="col" class="pz-lkc-cron-head-hook"><?php _e('Hook', $this->text_domain ); ?></th>
				<th scope="col" class="pz-lkc-cron-head-next-time"><?php echo __('Next Time', $this->text_domain ).__('▼', $this->text_domain ); ?></th>
				<th scope="col" class="pz-lkc-cron-head-schedule"><?php _e('Schedule', $this->text_domain ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($cron_list as $key => $cron ) { ?>
				<tr <?php echo $cron['display']; ?>>
					<td class="pz-lkc-cron-body-run"><?php echo $cron['button']; ?></td>
					<td class="pz-lkc-cron-body-hook"><?php echo $cron['hook']; ?></td>
					<td class="pz-lkc-cron-body-next-time"><?php echo $cron['next_time']; ?></td>
					<td class="pz-lkc-cron-body-schedule"><?php echo $cron['schedule']; ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php submit_button(); ?>
</div>
