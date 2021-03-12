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
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
  }

  add_action('after_setup_theme', 'university_features');


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

    if(!is_admin() && is_post_type_archive('program') && $query->is_main_query()) {
      $query->set("orderby", "title");
      $query->set("order", "ASC");
      $query->set("posts_per_page", -1);
    }
  };
  add_action('pre_get_posts', 'university_adjust_queries');

  ?>