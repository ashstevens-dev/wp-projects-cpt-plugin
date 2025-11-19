<?php

if ( function_exists( 'add_theme_support' ) ) {
  add_image_size( 'screen-shot', 720, 540 ); // Full size screen
}

add_action( 'init', 'projects_register' );

function projects_register() { 
  $args = array( 
    'labels' => array (
    	'name' => __( 'Projects', 'projects-cpt' ),
    	'singular_name' => __( 'Project', 'projects-cpt' ),
    	'add_new' => __( 'Add Project', 'projects-cpt' ),
    	'add_new_item' => __( 'Add Project', 'projects-cpt' ),
    	'edit_item' => __( 'Edit Project', 'projects-cpt' ),
    	'new_item' => __( 'New Project', 'projects-cpt' ),
    	'view_item' => __( 'View Project', 'projects-cpt' ),
    	'view_items' => __( 'View Projects', 'projects-cpt' ),
    	'search_items' => __( 'Search Projects', 'projects-cpt' ),
    	'not_found' => __( 'No projects found', 'projects-cpt' ),
    	'not_found_in_trash' => __( 'No projects found in Trash', 'projects-cpt' ),
    	'all_items' => __( 'All Projects', 'projects-cpt' ),
    	'archives' => __( 'Project Archives', 'projects-cpt' ),
    	'attributes' => __( 'Project Attributes', 'projects-cpt' ),
    	'insert_into_item' => __( 'Insert into project', 'projects-cpt' ),
    	'uploaded_to_this_item' => __( 'Uploaded to this project', 'projects-cpt' ),
    	'filter_items_list' => __( 'Filter projects list', 'projects-cpt' ),
    	'items_list_navigation' => __( 'Projects list navigation', 'projects-cpt' ),
    	'items_list' => __( 'Projects list', 'projects-cpt' ),
    	'item_published' => __( 'Project published.', 'projects-cpt' ),
    	'item_published_privately' => __( 'Project published privately.', 'projects-cpt' ),
    	'item_reverted_to_draft' => __( 'Project reverted to draft.', 'projects-cpt' ),
    	'item_trashed' => __( 'Project trashed.', 'projects-cpt' ),
    	'item_scheduled' => __( 'Project scheduled.', 'projects-cpt' ),
    	'item_updated' => __( 'Project updated.', 'projects-cpt' ),
    	'item_link' => __( 'Project link', 'projects-cpt' ),
    	'item_link_description' => __( 'A link to a project.', 'projects-cpt' ),
    ),  
    'public' => true,
    'has_archive' => true, 
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'show_in_rest' => true,
    'capability_type' => 'post', 
    'hierarchical' => false, 
    'rewrite' => true, 
    'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields' ) ,
    'menu_icon' => 'dashicons-portfolio',
    'template' => array(
    	array( 'cpt/projects-cpt', array(
    		'lock' => array(
    			'remove' => true,
    		),
    	) )
    )
  ); 

  register_post_type( 'projects' , $args );

  register_taxonomy( 'project-type', array( 'projects' ), array(
		'hierarchical' => true,
		'labels' => array (
      'name' => __( 'Project Types', 'projects-cpt' ),
      'singular_name' => __( 'Project Type', 'projects-cpt' ), 
    ),
    'show_ui' => true,
    'show_admin_column' => true,
    'show_in_rest' => true,
    'query_var' => true,
		'rewrite' => true
	));

	register_post_meta(
		'projects',
		'projects_address',
		array(
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
		)
	);

	register_post_meta(
		'projects',
		'projects_phoneNumber',
		array(
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
		)
	);

	register_post_meta(
		'projects',
		'projects_website',
		array(
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
		)
	);
}