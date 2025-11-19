<?php
/**
 * Plugin Name:       Projects CPT
 * Description:       Integrates a Projects custom post type.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            Ash M
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       projects-cpt
 *
 * @package Cpt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Registers the block using a `blocks-manifest.php` file, which improves the performance of block type registration.
 * Behind the scenes, it also registers all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
 * @see https://make.wordpress.org/core/2024/10/17/new-block-type-registration-apis-to-improve-performance-in-wordpress-6-7/
 */
function cpt_projects_cpt_block_init() {
	/**
	 * Registers the block(s) metadata from the `blocks-manifest.php` and registers the block type(s)
	 * based on the registered block metadata.
	 * Added in WordPress 6.8 to simplify the block metadata registration process added in WordPress 6.7.
	 *
	 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
	 */
	if ( function_exists( 'wp_register_block_types_from_metadata_collection' ) ) {
		wp_register_block_types_from_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
		return;
	}

	/**
	 * Registers the block(s) metadata from the `blocks-manifest.php` file.
	 * Added to WordPress 6.7 to improve the performance of block type registration.
	 *
	 * @see https://make.wordpress.org/core/2024/10/17/new-block-type-registration-apis-to-improve-performance-in-wordpress-6-7/
	 */
	if ( function_exists( 'wp_register_block_metadata_collection' ) ) {
		wp_register_block_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
	}
	/**
	 * Registers the block type(s) in the `blocks-manifest.php` file.
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_block_type/
	 */
	$manifest_data = require __DIR__ . '/build/blocks-manifest.php';
	foreach ( array_keys( $manifest_data ) as $block_type ) {
		register_block_type( __DIR__ . "/build/{$block_type}" );
	}
}
add_action( 'init', 'cpt_projects_cpt_block_init' );

include_once( plugin_dir_path( __FILE__ ) . 'includes/register-post-type.php' );

/**
 * Loads the asset file for the given script or style.
 * Returns a default if the asset file is not found.
 */
function projects_cpt_get_asset_file( $filepath ) {
  $PLUGIN_PATH = plugin_dir_path( __FILE__ );

	// grab the asset file
	$asset_path = $PLUGIN_PATH . $filepath . '.asset.php';

	// if missing for some reason, can define defaults
	return file_exists( $asset_path )
		? include $asset_path
		: array(
			'dependencies' => array(),
			'version'      => microtime(),
		);
}

/**
 * Enqueue plugin specific editor scripts
 */
function projects_cpt_enqueue_editor_scripts() {
  $PLUGIN_URL = plugin_dir_url( __FILE__ );

	// get our asset file with dependencies / version
	$asset_file = projects_cpt_get_asset_file( 'build/editor' );

	// enqueue the script
	wp_enqueue_script(
		'projects-cpt-meta-custom-editor',
		$PLUGIN_URL . 'build/editor.js',
		[...$asset_file['dependencies'], 'wp-edit-post'], // I manually add wp-edit-post here as an extra safety to make sure our deregister happens AFTER any registration
		$asset_file['version']
	);

  // Add Post Types custom data as a variable for our JS to reference
  wp_localize_script( 'projects-cpt-meta-custom-editor', 'postData',
      array( 
        'postType' => get_post_type( get_the_id() ),
      )
  );
}
add_action( 'enqueue_block_editor_assets', 'projects_cpt_enqueue_editor_scripts' );