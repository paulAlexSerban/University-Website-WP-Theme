<?php 
if(!is_user_logged_in()) {
  wp_redirect(esc_url(site_url('/')));
  exit;
}

get_header(); 
pageBanner();?>

<div class="container container--narrow page-section">

  <?php 
    $theParent = wp_get_post_parent_id(get_the_id());
    if($theParent) {?>
  <div class="metabox metabox--position-up metabox--with-home-link">
    <p>
      <a class="metabox__blog-home-link" href="<?php echo the_permalink($theParent);?>"><i class="fa fa-home"
          aria-hidden="true"></i> Back to <?php echo get_the_title($theParent);?> </a>
      <span class="metabox__main"><?php the_title(); ?></span>
    </p>
  </div>
  <?php }?>

  <?php
  while(have_posts()) {
    the_post(); ?>

  <div class="container container--narrow page-section">
    <div class="create-note">
      <h2 class="headline healdine--medium">Create new note:</h2>
      <input class="new-note-title" type="text" placeholder="Title">
      <textarea class="new-note-body" name="" id="" cols="30" rows="10" placeholder="Your note here"></textarea>
      <span class="submit-note">Create Note</span>
      <span class="note-limit-message">Note limit reached! DELETE an old note to make room for a new one</span>
    </div>
    <ul class="link-list min-list" id="myNotes">
      <?php
          $userNotes = new WP_Query(array(
            'post_type' => 'note', 
            'posts_per_page' => -1,
            'author' => get_current_user_id()
          ));

          while($userNotes-> have_posts()) {
            $userNotes->the_post(); ?>
      <li class="note__item" data-id="<?php the_ID(); ?>" data-state="readonly">
        <input readonly class="note-title-field" type="text" name="" id="input_postID<?php the_ID(); ?>"
          value="<?php echo str_replace('Private: ', '', esc_attr(get_the_title()));?>">
        <span class="edit-note">
          <i class="far fa-edit" aria-hidden="true"></i> Edit
        </span>
        <span class="delete-note"><i class="fas fa-trash" aria-hidden="true"></i> Delete</span>
        <textarea readonly class="note-body-field" name="" id="textarea_postId<?php the_ID(); ?>" cols="30"
          rows="10"><?php echo esc_textarea(wp_strip_all_tags(get_the_content()))?></textarea>
        <span class="update-note btn btn--blue btn--small">
          <i class="fas fa-arrow-right" aria-hidden="true"></i> Save
        </span>
      </li>
      <?php }
        ?>
    </ul>
  </div>

  <?php }
  
  ?>


</div>

<?php get_footer(); ?>