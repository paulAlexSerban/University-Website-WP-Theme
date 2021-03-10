<?php
  function university_files() {
    wp_register_style('custom_fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i', array(), '1.0');
    wp_enqueue_style( 'custom_fonts' );

    wp_register_style( 'fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', array(), '4.2.0' );
    wp_enqueue_style( 'fontawesome' );

    wp_enqueue_script('vendors_js', get_theme_file_uri('/bundled-assets/vendors~scripts.8c97d901916ad616a264.js'), NULL, '1.0', true);
    wp_enqueue_script('main_uni_js', get_theme_file_uri('/bundled-assets/scripts.bc49dbb23afb98cfc0f7.js'), NULL, '1.0', true);
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/bundled-assets/styles.bc49dbb23afb98cfc0f7.css'));
  };

  add_action('wp_enqueue_scripts', 'university_files');

  function university_features() {
    add_theme_support( 'nav-menus' );
    register_nav_menu('headerNavigation', 'Header Navigation');
    register_nav_menu('footerNavigation', 'Footer Navigation');
    register_nav_menu('footerLegal', 'Footer Legal');
    add_theme_support('title-tag');
  }

  add_action('after_setup_theme', 'university_features');

  function university_post_types() {
    register_post_type('event', array(
      'show_in_rest'=> true,
      'supports' => array(
        'title', 'editor', 'excerpt'
      ),
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

    // register_post_type('program', array(
    //   'has_archive' => true,
    //   'public' => true,
    //   'labels' => array(
    //     'name' => 'Programs',
    //     'add_new_item' => 'Add New Program', 
    //     'edit_item' => 'Edit Program',
    //     'all_items' => 'All Programs',
    //     'singular_name' => 'Program'
    //   ),
    //   'menu_icon' => 'dashicons-calendar-alt'
    //   )
    // );

    // register_post_type('professor', array(
    //   'has_archive' => true,
    //   'public' => true,
    //   'labels' => array(
    //     'name' => 'Professors',
    //     'add_new_item' => 'Add New Professor', 
    //     'edit_item' => 'Edit Professor',
    //     'all_items' => 'All Professors',
    //     'singular_name' => 'Professor'
    //   ),
    //   'menu_icon' => 'dashicons-calendar-alt'
    //   )
    // );

    // register_post_type('campus', array(
    //   'has_archive' => true,
    //   'public' => true,
    //   'labels' => array(
    //     'name' => 'Campuses',
    //     'add_new_item' => 'Add New Campus', 
    //     'edit_item' => 'Edit Campus',
    //     'all_items' => 'All Campuses',
    //     'singular_name' => 'Campuses'
    //   ),
    //   'menu_icon' => 'dashicons-calendar-alt'
    //   )
    // );
  };

  add_action('init', 'university_post_types');

  function university_adjust_queries($query) {
    $today = date('Ymd');
    if(!is_admin() && is_post_type_archive('event') && $query->is_main_query()) {
      $query->set("meta_key", "event_date");
      $query->set("orderby","meta_value_num");
      $query->set("order",'ASC');
      $query->set("meta_query", array(
        array(
          "key" => "event_date",
          "compare" => ">=",
          "value" => $today,
          "type" => "numeric"
        )
      ));
    }
  };
  add_action('pre_get_posts', 'university_adjust_queries');

  ?>