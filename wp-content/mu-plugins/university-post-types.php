<?php

function university_post_types() {
  register_post_type('event', array(
    'show_in_rest'=> true,
    'supports' => array(
      'title', 'editor', 'excerpt'
    ),
    'capability_type' => 'event',
    'map_meta_cap' => true,
    'rewrite' => array(
      'slug' => 'events'
    ),
    'has_archive' => true,
    'public' => true,
    'labels' => array(
      'name' => 'Events',
      'add_new_item' => 'Add New Event', 
      'edit_item' => 'Edit Event',
      'all_items' => 'All Events',
      'singular_name' => 'Event'
    ),
    'menu_icon' => 'dashicons-calendar'
    )
  );

  register_post_type('program', array(
    'show_in_rest'=> true,
    'supports' => array(
      'title'
    ),
    'rewrite' => array(
      'slug' => 'programs'
    ),
    'has_archive' => true,
    'public' => true,
    'labels' => array(
      'name' => 'Programs',
      'add_new_item' => 'Add New Program', 
      'edit_item' => 'Edit Program',
      'all_items' => 'All Programs',
      'singular_name' => 'Program'
    ),
    'menu_icon' => 'dashicons-awards'
    )
  );

  register_post_type('professor', array(
    'show_in_rest'=> true,
    'supports' => array(
      'title', 'editor', 'thumbnail'
    ),
    'public' => true,
    'labels' => array(
      'name' => 'Professor',
      'add_new_item' => 'Add New Professor', 
      'edit_item' => 'Edit Professor',
      'all_items' => 'All Professors',
      'singular_name' => 'Professor'
    ),
    'menu_icon' => 'dashicons-welcome-learn-more'
    )
  );

  register_post_type('campus', array(
    'show_in_rest'=> true,
    'supports' => array(
      'title', 'editor', 'excerpt'
    ),
    'capability_type' => 'campus',
    'map_meta_cap' => true,
    'rewrite' => array(
      'slug' => 'campus'
    ),
    'has_archive' => true,
    'public' => true,
    'labels' => array(
      'name' => 'Campuses',
      'add_new_item' => 'Add New Campus', 
      'edit_item' => 'Edit Campus',
      'all_items' => 'All Campuses',
      'singular_name' => 'Campus'
    ),
    'menu_icon' => 'dashicons-location-alt'
    )
  );

  register_post_type('note', array(
    'show_in_rest'=> true,
    'capability_type' => 'note', // this way we set up brand new permissions that only apply to this post type
     'map_meta_cap' => true, // enforces and requires permissions at the right time and place 
    'supports' => array(
      'title', 'editor'
    ),
    'public' => false,
    'show_ui' => true,
    'labels' => array(
      'name' => 'Notes',
      'add_new_item' => 'Add New Note', 
      'edit_item' => 'Edit Note',
      'all_items' => 'All Notes',
      'singular_name' => 'Note'
    ),
    'menu_icon' => 'dashicons-welcome-write-blog'
    )
  );

  // like post types

  register_post_type('like', array(
    'supports' => array(
      'title'
    ),
    'public' => false,
    'show_ui' => true,
    'labels' => array(
      'name' => 'Likes',
      'add_new_item' => 'Add New Like', 
      'edit_item' => 'Edit Like',
      'all_items' => 'All Likes',
      'singular_name' => 'Like'
    ),
    'menu_icon' => 'dashicons-heart'
    )
  );
};

add_action('init', 'university_post_types');

?>