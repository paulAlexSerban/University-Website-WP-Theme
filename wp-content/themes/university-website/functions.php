<?php
require get_theme_file_path('./includes/search-route.php');

function university_custom_rest() {
  register_rest_field('post', 'authorName', array(
    'get_callback' => function() {return get_the_author();}
  ));
}

add_action('rest_api_init', 'university_custom_rest');
  function pageBanner($args = NULL) {
    /**
     * pageBanner(array(
     *   'title' => 'hardcoded title',
     *   'subtitle' => 'hardcoded subtitle',
     *   'photo' => 'hardcoded https://external-content.com'
     * ));
     */

    if(!$args['title']) {
      $args['title'] = get_the_title();
    }

    if(!$args['subtitle']) {
      $args['subtitle'] = get_field('page_banner_subtitle');
    }

    if(!$args['photo']) {
      if(get_field('page_banner_-_background_image') && !is_archive() && !is_home()) {
        $args['photo'] = get_field('page_banner_-_background_image')['sizes']['pageBanner'];
      } else {
        $args['photo'] = get_theme_file_uri('assets/images/ocean.jpg');
      }
    }
    ?>
<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>);">
  </div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
    <div class="page-banner__intro">
      <p><?php echo $args['subtitle'] ?></p>
    </div>
  </div>
</div>
<?php
  }

  function university_files() {
    wp_register_style('custom_fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i', array(), '1.0');
    wp_enqueue_style( 'custom_fonts' );

    wp_register_style( 'fontawesome', '//use.fontawesome.com/releases/v5.15.2/css/all.css', array(), '5.15.2' );
    wp_enqueue_style( 'fontawesome' );

    wp_enqueue_script('main_uni_js', get_theme_file_uri('/bundled-assets/scripts.4020631d2cb48435f2eb.js'), NULL, '1.0', true, true);
    wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyDHlvkqqLdH-p2X6UeekeucJlP4ZNeI1Mo', NULL, '1.0', true);
    wp_enqueue_script('vendors_js', get_theme_file_uri('/bundled-assets/vendors~scripts.8c97d901916ad616a264.js'), NULL, '1.0', true);

    wp_enqueue_style('university_main_styles', get_theme_file_uri('/bundled-assets/styles.4020631d2cb48435f2eb.css'));

    wp_localize_script('main_uni_js', 'universityData', array(
      'root_url' => get_site_url()
    ));
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
    add_image_size('pageBanner', 1500, 350, true);
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

    if(!is_admin() && is_post_type_archive('campus') && $query->is_main_query()) {
      $query->set("orderby", "title");
      $query->set("order", "ASC");
      $query->set("posts_per_page", -1);
    }

    if(!is_admin() && is_post_type_archive('program') && $query->is_main_query()) {
      $query->set("orderby", "title");
      $query->set("order", "ASC");
      $query->set("posts_per_page", -1);
    }
  };
  add_action('pre_get_posts', 'university_adjust_queries');

  function university_map_key($api) {
    $api['key'] = 'AIzaSyDHlvkqqLdH-p2X6UeekeucJlP4ZNeI1Mo';
    return $api;
  };

  add_filter('acf/fields/google_map/api', 'university_map_key');

  // redirect subscriber account out of admin to homepageEvents

  function redirect_subs_to_frontend() {
    $ourCurrentUser = wp_get_current_user();
    if(count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
      wp_redirect(site_url('/'));
      exit;
    }
  }
  
  add_action('admin_init', 'redirect_subs_to_frontend');

  function no_subs_admin_bar() {
    $ourCurrentUser = wp_get_current_user();
    if(count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
      show_admin_bar(false);
    };
  }
  
  add_action('wp_admin', 'no_subs_admin_bar');

  // customize login screen_id

  function our_header_url() {
    return esc_url(site_url('/'));
  }

  add_filter('login_headerurl', 'our_header_url');

  // here you load the theme files starting with the login page, not only the webpage

  function our_login_css() {
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/bundled-assets/styles.4020631d2cb48435f2eb.css'));
  }

  add_action( 'login_enqueue_scripts', 'our_login_css');

  function our_login_title() {
    return get_bloginfo( 'name');
  }

  add_filter('login_headertitle', 'our_login_title');

  ?>