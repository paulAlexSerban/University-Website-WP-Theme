<?php
  function university_files() {
      // wp_enqueue_script('main_uni_js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);

      wp_register_style('custom_fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i', array(), '1.0');
      wp_enqueue_style( 'custom_fonts' );

      wp_register_style( 'fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', array(), '4.2.0' );
      wp_enqueue_style( 'fontawesome' );

      if(strstr($_SERVER['SERVER_NAME'], 'universitywebsite.local')) {
        // the CSS and the JS are going to get bundled and served from this address for live development purposes
        wp_enqueue_script('main_uni_js', 'http://localhost:3000/bundled.js', NULL, '1.0', true);
      } else {
        wp_enqueue_script('vendors_js', get_theme_file_uri('/bundled-assets/vendors~scripts.8c97d901916ad616a264.js'), NULL, '1.0', true);
        wp_enqueue_script('main_uni_js', get_theme_file_uri('/bundled-assets/scripts.a405fb87a4493cd04ce4.js'), NULL, '1.0', true);
        wp_enqueue_style('university_main_styles', get_theme_file_uri('/bundled-assets/style.css'));
      }
  };

  function university_features() {
    add_theme_support( 'nav-menus' );
    register_nav_menu('headerNavigation', 'Header Navigation');
    register_nav_menu('footerNavigation', 'Footer Navigation');
    register_nav_menu('footerLegal', 'Footer Legal');
    add_theme_support('title-tag');
  }

  add_action('wp_enqueue_scripts', 'university_files');
  add_action('after_setup_theme', 'university_features');

  ?>