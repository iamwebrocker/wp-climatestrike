<?php
	/*
	 * Plugin Name: Climate Strike
	 * Plugin URI: https://github.com/iamwebrocker/wp-climatestrike/
	 * Description: A small plugin to put your WordPress site on climate strike
	 * Author: Tom Arnold
	 * Author URI: https://www.webrocker.de/
	 * Version: 1.2.0
	 */
	function wbr_wpcs_redirect() {

		$strike = '2019-09-20';
		$today  = date('Y-m-d');

		$allowed_urls = get_option('wbr_wpcs_urls');

		$strike_page = 'climatestrike.html';
		$current_url = trailingslashit($_SERVER['REQUEST_URI']);

		if (is_file(get_stylesheet_directory() . '/' . $strike_page )) {
			$strike_path = get_stylesheet_directory() . '/' . $strike_page;
		} else {
			$strike_path = plugin_path(__FILE_) . '/' . $strike_page;
		}

		if ( is_admin() || $current_url == '/wp-admin/' || in_array($current_url,$allowed_urls)) {
			return;
		} else if ($today == $strike) {
			wp_cache_flush();
			if (function_exists('wpsc_delete_files')) {
				wpsc_delete_files(get_supercache_dir() . $current_url);
			}
			status_header(503);
			include $strike_path;
			exit;
		}

	}
	add_action( 'template_redirect', 'wbr_wpcs_redirect');

	function wbr_wpcs_register_settings() {
		$allowed_urls         = array();
		$home_url             = home_url();
		$privacy_page_url     = get_privacy_policy_url();
		$privacy_page_rel_url = trailingslashit(substr($privacy_page_url,strlen($home_url),-1));
		array_push($allowed_urls,$privacy_page_rel_url);
		add_option( 'wbr_wpcs_urls', $allowed_urls );
   		register_setting( 'wbr_wpcs_og', 'wbr_wpcs_urls', array('sanitize_callback' => 'wbr_wpcs_urls_cb'));
	}
	add_action( 'admin_init', 'wbr_wpcs_register_settings' );

	function wbr_wpcs_urls_cb($value) {
		$value = preg_split('/\r\n|\r|\n/', $value);
		return $value;
	}

	function wbr_wpcs_register_options_page() {
		add_options_page(__('WP Climate Strike Settings','wbrwpcs'), __('WP Climate Strike','wbrwpcs'), 'manage_options', 'wp-climatestrike', 'wbr_wpcs_options_page');
	}
	add_action('admin_menu', 'wbr_wpcs_register_options_page');

	function wbr_wpcs_options_page() {
?>
	<div class="wrap">
  		<h2><?php _e('WP Climate Strike Settings','wbrwpcs'); ?></h2>
		<form method="post" action="options.php">
  			<?php settings_fields( 'wbr_wpcs_og' ); ?>
  			<?php do_settings_sections( 'wbr_wpcs_og' ); ?>
  			<table class="form-table">
        		<tr valign="top">
        			<th scope="row"><label for="wbr_wpcs_urls"><?php _e('Non-blocked URLs','wbrwpcs'); ?></label></th>
        			<td><textarea id="wbr_wpcs_urls" name="wbr_wpcs_urls"><?php echo esc_attr( implode("\n", get_option('wbr_wpcs_urls') ) ); ?></textarea></td>
        		</tr>
         	</table>
         	<p><?php _e('One URL per new line','wbrwpcs'); ?></p>
  			<?php submit_button(); ?>
  		</form>
	</div>
<?php
	}

	register_deactivation_hook(
		__FILE__,
		'wbr_wpcs_deactivate'
	);
	function wbr_wpcs_deactivate() {
		delete_option( 'wbr_wpcs_urls' );
	}
?>
