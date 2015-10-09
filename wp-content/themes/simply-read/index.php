<?php get_header(); ?>
		<div class="front-wrapper">

			<div id="content">

				<div id="inner-content" class="wrap cf">

						<div id="slide-wrap">
							<?php 
								$args = array(
									'posts_per_page' => 10,
									'post_status' => 'publish',
									'post__in' => get_option("sticky_posts")
								);
								$fPosts = new WP_Query( $args );
							?>

							<?php if ( $fPosts->have_posts() ) : ?>

								<div class="cycle-slideshow" <?php 
								if ( get_theme_mod('simplyread_slider_effect') ) :
									echo 'data-cycle-fx="' . wp_kses_post( get_theme_mod('simplyread_slider_effect') ) . '" data-cycle-tile-count="10"';
								else:
									echo 'data-cycle-fx="scrollHorz"';
								endif;
								?> data-cycle-slides="> div.slides" <?php
								if ( get_theme_mod('simplyread_slider_timeout') ) :
								$slider_timeout = wp_kses_post( get_theme_mod('simplyread_slider_timeout') );
									echo 'data-cycle-timeout="' . $slider_timeout . '000"';
								else:
									echo 'data-cycle-timeout="5000"';
								endif;
								?> data-cycle-prev="#sliderprev" data-cycle-next="#slidernext">


							<?php while ( $fPosts->have_posts() ) : $fPosts->the_post();  ?>

									<div class="slides">

										<div id="post-<?php the_ID(); ?>" <?php post_class('post-theme'); ?>>

											<?php 
												$image_full = simplyread_catch_that_image(); 
												$gallery_full = simplyread_catch_gallery_image_full(); 
											?>
											<?php if ( has_post_thumbnail()) : ?>
												<div class="slide-thumb"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( "full" ); ?></a></div>
											
											<?php elseif(has_post_format('image') && !empty($image_full)) :  ?>
												<div class="slide-thumb"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php echo $image_full; ?></a></div>
											
											<?php elseif(has_post_format('gallery') && !empty($gallery_full)) : ?>  
												<div class="slide-thumb"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php echo $gallery_full; ?></a></div>
											
											<?php else : ?>
												<div class="slide-noimg"><p><?php _e('No featured image set for this post.', 'simplyread') ?></p></div>
											<?php endif;  ?>

										</div>

										<div class="slide-copy-wrap">
											<div class="slide-copy">
												<h2 class="slide-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'simplyread' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
												<?php the_excerpt(); ?>
											</div>
										</div>

									</div>

							<?php endwhile; ?>

									<div class="slidernav">
										<a id="sliderprev" href="#" title="<?php _e('Previous', 'simplyread'); ?>"><?php _e('&#9664;', 'simplyread'); ?></a>
										<a id="slidernext" href="#" title="<?php _e('Next', 'simplyread'); ?>"><?php _e('&#9654;', 'simplyread'); ?></a>
									</div>

								</div>

							<?php endif; ?>

							<?php wp_reset_postdata(); ?>

						</div> <!-- slider-wrap -->
						
				<div class="wrap cf" id="inner-content" style="position:relative">
					<div class="divider-title"><span>Latest</span></div>
				</div>
				<ul class="blog-list">
					<div id='masonry'>
						<?php $args2= array('post__not_in' => get_option( 'sticky_posts' ) ,'paged' => $paged);
						$blogPosts = new WP_Query( $args2 ); ?>
						<?php while ( $blogPosts -> have_posts() ) : $blogPosts -> the_post(); ?>
						<li class="gutter-sizer"></li>
		  						<?php get_template_part( 'home-post-format/home', get_post_format() ); ?>
		  				<?php endwhile;  ?>
	     				<div class="clear"></div>
					</div>
				</ul>
				</div> <!-- inner-content -->
				<?php  simplyread_page_navi(); ?>
				<?php wp_reset_postdata(); ?>
			</div> <!-- content -->
		</div><!-- front-wrapper -->

<?php get_footer(); ?>