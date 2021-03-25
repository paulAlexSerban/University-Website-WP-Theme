<?php get_header(); ?>

<?php
  while (have_posts()) {
      the_post(); 
      pageBanner();
      ?>

<div class="container container--narrow page-section">
  <div class="generic-content">
    <div class="row group">
      <div class="one-third">
        <?php the_post_thumbnail('professorPortrait'); ?>
      </div>
      <?php
        $likeCount = new WP_Query(array(
          'post_type' => 'like',
          'meta_query' => array(
            array(
              'key' => 'liked_professor_id',
              'compare' => '=',
              'value' => get_the_ID()
            )
          ),
        ));

        $existsStatus = 'no';

        if(is_user_logged_in()) {
          $existQuery = new WP_Query(array(
            'author' => get_current_user_id(),
            'post_type' => 'like',
            'meta_query' => array(
              array(
                'key' => 'liked_professor_id',
                'compare' => '=',
                'value' => get_the_ID()
              )
            ),
          ));

          if($existQuery->found_posts) { 
            $existsStatus = 'yes';
          }
        }

      ?>
      <span class="like-box" data-professor="<?php the_ID(); ?>" data-exists="<?php echo $existsStatus; ?>" data-like="<?php echo $existQuery->posts[0]->ID;?>">
        <i class="fas fa-heartbeat" aria-hidden="true" ></i>
        <i class="far fa-heart" aria-hidden="true"></i>
        <span class="like-count"><?php echo $likeCount->found_posts ?></span>
      </span>
      <div class="two-thirds">
        <?php the_content();?>
      </div>
    </div>
  </div>
  <?php 
        $relatedPrograms= get_field('related_program');
        // print_r($relatedPrograms); - this helps you see what type of data you receive
    if($relatedPrograms) { ?>

  <h2 class="headline headline--medium">Subject(s) Taught</h2>
  <hr class="section-break">
  <ul class="link-list min-list">
    <?php 
    foreach ($relatedPrograms as $program) { ?>
    <li>
      <a href="<?php echo get_the_permalink($program);?>">
        <?php echo get_the_title($program); ?>
      </a>
    </li>
    <?php } ?>
  </ul>

  <?php } ?>
</div>
<?php
  }
?>

<?php get_footer(); ?>