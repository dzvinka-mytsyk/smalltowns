<?php
/*
Template Name: Empty
*/
?>
<?php get_header(); ?>
  
  <div id="content">
    <div id="inner-content" class="wrap cf">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; else : ?>
        <p>nope</p>
      <?php endif; ?>
    </div>
  </div>

<?php get_footer(); ?>