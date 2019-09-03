<?php
	/*
	 * Plugin Name: Climate Strike
	 * Plugin URI: https://github.com/iamwebrocker/wp-climatestrike/
	 * Description: A small plugin to put your WordPress site on climate strike
	 * Author: Tom Arnold
	 * Author URI: https://www.webrocker.de/
	 * Version: 1.1.3
	 */
	function wbr_wpcs_redirect() {

		$strike = '2019-09-20';
		$today  = date('Y-m-d');

		$home_url = home_url();
		$privacy_page_url = get_privacy_policy_url();
		$privacy_page_rel_url = trailingslashit(substr($privacy_page_url,strlen($home_url),-1));

		// @@TODO: make this from plugin settings:
		$allowed_urls = array('/wp-admin/','/impressum/',$privacy_page_rel_url);
		$strike_page = 'climatestrike.html';
		$current_url = trailingslashit($_SERVER['REQUEST_URI']);

		if (is_file(get_stylesheet_directory() . '/' . $strike_page )) {
			$strike_path = get_stylesheet_directory() . '/' . $strike_page;
		} else {
			$strike_path = plugin_path(__FILE_) . '/' . $strike_page;
		}

		if ( is_admin() || in_array($current_url,$allowed_urls)) {
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
?>
