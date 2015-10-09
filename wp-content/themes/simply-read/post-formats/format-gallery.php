<section class="entry-content cf" itemprop="articleBody">
 
  <?php
    the_content();

   
    wp_link_pages( array(
      'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'simplyread' ) . '</span>',
      'after'       => '</div>',
      'link_before' => '<span>',
      'link_after'  => '</span>',
    ) );
  ?>
  <?php if(has_tag()): ?>
    <div class="tag-links">
      <div class="clear"></div>
      <?php _e('TAGS: ','wpcontented'); ?>
      <?php echo get_the_tag_list('',',','');?>
    </div>
  <?php endif; ?>
</section> <?php // end article section ?>
