<?php
/**
 * Plugin Name: Ihor LearnDash Test Addon
 * Description: Displays LearnDash course materials via shortcode, with access settings for enrolled or all users.
 * Version: 1.0
 * Author: Ihor M.
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once plugin_dir_path( __FILE__ ) . 'includes/class-learndash-course-materials.php';

add_action( 'plugins_loaded', [ 'LearndashCourseMaterials', 'init' ] );
