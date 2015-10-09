<?php get_header(); ?>

			<div id="content">
				<header class="article-header">
					<div id="inner-content" class="wrap cf">
						<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
					</div>
				</header> <?php // end article header ?>

				<div id="inner-content" class="wrap cf">
					
					<div id="main" class="m-all t-2of3 d-5of7 cf" role="main">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
							<p class="byline vcard">
								<?php printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span>', 'simplyread' ), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), get_the_author_link( get_the_author_meta( 'ID' ) )); ?>
								<?php
									/* translators: used between list items, there is a space after the comma */
									$category_list = get_the_category_list( __( ', ', 'simplyread' ) );
									printf( __('under %s', 'simplyread'),
									$category_list
									);
								?>
							</p>

							<?php
								
								get_template_part( 'post-formats/format', get_post_format() );
							?>

							<div class="next-prev-post">
			                  <div class="prev">
			                    <?php previous_post_link('<p><span class="fa fa-angle-left"></span> PREVIOUS POST</p> %link'); ?>
			                  </div>
			                  <div class="center-divider"></div>
			                  <div class="next">
			                  <?php next_post_link('<p>NEXT POST <span class="fa fa-angle-right"></span></p> %link'); ?>
			                  </div>
			                  <div class="clear"></div>
			                </div> <!-- next-prev-post -->

							<?php 
								if ( get_theme_mod('simplyread_author_bio') ):
									$author_class = 'author-hide';
								else:
									$author_class = '';
								endif;
							?>

							<footer class="article-footer <?php echo $author_class; ?>">
								<div class="avatar">
									<?php echo get_avatar( get_the_author_meta( 'ID' ) , 150 ); ?>
								</div>
								<div class="info">
									<p class="author"><span><?php _e('Written by','simplyread'); ?></span> <?php the_author(); ?></p>
									<p class="author-desc"> <?php if (function_exists('simplyread_author_excerpt')){echo simplyread_author_excerpt(); } ?> </p>
								</div>
								<div class="clear"></div>
							</footer> <?php // end article footer ?>

							<?php $related = get_posts( array( 'category__in' => wp_get_post_categories($post->ID), 'numberposts' => 4, 'post__not_in' => array($post->ID) ) ); ?>
							<?php if (!empty($related)) : ?>
								<div class="related posts">
								
									<h3><?php _e('Related Posts','simplyread'); ?></h3>
									<ul> 
										<?php if( $related ) : foreach( $related as $post ) { ?>
											<?php setup_postdata($post); ?>

											<li>
												<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
													<?php $image_thumb = simplyread_catch_that_image_thumb(); $gallery_thumb = simplyread_catch_gallery_image_thumb(); 
													if ( has_post_thumbnail()) : 
														the_post_thumbnail('simplyread-thumb-image-300by300');  ?>
													<?php elseif(has_post_format('gallery') && !empty($gallery_thumb)) : 
														echo $gallery_thumb; ?>
													<?php elseif(has_post_format('image') && !empty($image_thumb)) : 
														echo $image_thumb; ?>
													<?php else: ?>
														<img src="<?php echo IMAGES; ?>/blank.jpg" alt="No Featured Image">
													<?php endif; ?>
													<br>
													<?php the_title(); ?>
												</a>

											</li>

										<?php } endif;
										wp_reset_postdata(); ?>
										<div class="clear"></div>
									</ul>

								</div>
							<?php endif; ?>

							<?php comments_template(); ?>

							</article> <?php // end article ?>

						<?php endwhile; ?>

						<?php else : ?>

							<article id="post-not-found" class="hentry cf">
									<header class="article-header">
										<h1><?php _e( 'Oops, Post Not Found!', 'simplyread' ); ?></h1>
										<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'simplyread' ); ?></p>
									</header>
							</article>

						<?php endif; ?>

					</div>

					<?php get_sidebar(); ?>

				</div>

			</div>

<?php get_footer(); ?>