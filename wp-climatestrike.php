<?php
	/*
	 * Plugin Name: Climate Strike
	 * Plugin URI: https://github.com/iamwebrocker/wp-climatestrike/
	 * Description: A small plugin to put your WordPress site on climate strike
	 * Author: Tom Arnold
	 * Author URI: https://www.webrocker.de/
	 * Version: 1.1.0
	 */
	function wbr_wpcs_redirect() {

		$strike = '2019-09-20';
		$today  = date('Y-m-d');

		$home_url = home_url();
		$privacy_page_url = get_privacy_policy_url();
		$privacy_page_rel_url = substr($privacy_page_url,strlen($home_url),-1) .'/';

		// @@TODO: make this from plugin settings:
		$allowed_urls = array('/impressum/',$privacy_page_rel_url);
		$strike_page = 'climatestrike.html';
		$current_url = $_SERVER['REQUEST_URI'];

		if (is_file(get_stylesheet_directory() . '/' . $strike_page )) {
			$strike_url = get_stylesheet_directory_uri() . '/' . $strike_page;
		} else {
			$strike_url = plugins_url('templates/' . $strike_page,__FILE__);
		}

		if ( is_admin() || in_array($current_url,$allowed_urls)) {
			return;
		} else if ($today == $strike) {
			wp_redirect($strike_url);
			exit;
		}

	}
	add_action( 'template_redirect', 'wbr_wpcs_redirect');


?>