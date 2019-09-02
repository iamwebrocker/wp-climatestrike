<?php
	/*
	 * Plugin Name: Climate Strike
	 * Plugin URI: https://github.com/iamwebrocker/wp-climatestrike/
	 * Description: A small plugin to put your WordPress site on climate strike
	 * Author: Tom Arnold
	 * Author URI: https://www.webrocker.de/
	 * Version: 1.0.2
	 */

	$strike = '2019-09-20';
	$today  = date('Y-m-d');
	// @@TODO: make this from plugin settings:
	$allowed_urls = array('/impressum/','/datenschutzerklaerung/');
	$current_url = $_SERVER['REQUEST_URI'];
	$strike_page = 'climatestrike.html';

	if (is_file(get_stylesheet_directory() . '/' . $strike_page )) {
		$strike_url = get_stylesheet_directory_uri() . '/' . $strike_page;
	} else {
		$strike_url = plugins_url($strike_page,__FILE__);
	}

	if ( is_admin() || in_array($current_url,$allowed_urls)) {
		return;
	} else if ($today == $strike) {
		header('Location: ' . $strike_url, 503);
	}

?>