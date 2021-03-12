<?php get_header();
pageBanner(array(
  'title' => 'All events',
  'subtitle' => 'See what is going on in our world'
));
; ?>

<div class="container container--narrow page-section">
  <?php 
    while(have_posts()) {
      the_post(); 
      get_template_part( './template_parts/content', 'event' );
      // get_template_part( './template_parts/content', get_post_type() ); - this would dynamically look for a specific file according to the type of the post
    } 
    echo paginate_links();
  ?>

  <hr class="section-break">
  <p>Looking for a recap of past events? <a href="<?php echo site_url('/past-events');?>">Checkout our past events archive</a> </p>
</div>

<?php get_footer(); ?>