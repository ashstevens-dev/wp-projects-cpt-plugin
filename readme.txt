=== Projects CPT ===
Contributors:      Ash M
Tags:              block
Tested up to:      6.7
Stable tag:        0.1.0
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

Integrates a Projects custom post type.

== Description ==

Integrates a Projects custom post type.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/projects-cpt` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress

== Usage ==

A. Block Theme: Create a single-projects.html template file. Use block bindings to output the post meta values: 
     <!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"core/post-meta","args":{"key":"projects_address"}}}}} -->
	 <p></p>
	 <!-- /wp:paragraph -->
B. Standard Theme: Create a single-projects.php template file. Use the get_post_meta() function to get the post meta values:
     <?php $project_address = get_post_meta( get_the_ID(), 'projects_address', true ); ?>

== Changelog ==

= 0.1.0 =
* Release
