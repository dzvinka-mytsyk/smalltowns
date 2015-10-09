<?php get_header(); ?>

			<div id="content">
				<header class="article-header">
					<div id="inner-content" class="wrap cf">
							<?php if (is_category()) : ?>
								<h1 class="archive-title h2">
									<span><?php _e( 'Posts Categorized:', 'simplyread' ); ?></span> <?php single_cat_title(); ?>
								</h1>

							<?php elseif (is_tag()) : ?>
								<h1 class="archive-title h2">
									<span><?php _e( 'Posts Tagged:', 'simplyread' ); ?></span> <?php single_tag_title(); ?>
								</h1>

							<?php elseif (is_author()) :
								global $post;
								$author_id = $post->post_author;
							?>
								<h1 class="archive-title h2">

									<span><?php _e( 'Posts By:', 'simplyread' ); ?></span> <?php the_author_meta('display_name', $author_id); ?>

								</h1>
							<?php elseif (is_day()) : ?>
								<h1 class="archive-title h2">
									<span><?php _e( 'Daily Archives:', 'simplyread' ); ?></span> <?php the_time(get_option('date_format')); ?>
								</h1>

							<?php elseif (is_month()) : ?>
									<h1 class="archive-title h2">
										<span><?php _e( 'Monthly Archives:', 'simplyread' ); ?></span> <?php the_time(get_option('date_format')); ?>
									</h1>

							<?php elseif (is_year()) : ?>
									<h1 class="archive-title h2">
										<span><?php _e( 'Yearly Archives:', 'simplyread' ); ?></span> <?php the_time(get_option('date_format')); ?>
									</h1>
							<?php endif; ?>
						</div>
				</header>

				<div id="inner-content" class="wrap cf">

						<div id="main" class="m-all t-2of3 d-5of7 cf" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf archive' ); ?> role="article">
								<?php
								if ( has_post_thumbnail()):
									?> <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"> <?php
									$thumb_id = get_post_thumbnail_id();
									$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'simplyread-thumb-image-300by300', true);
									$thumb_url = $thumb_url_array[0]; ?> <img src="<?php echo $thumb_url; ?>" alt="Featured Image" > 
									</a>
								<?php else: ?>
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo IMAGES; ?>/blank.jpg" alt="No Featured Image"></a>

								<?php endif; ?>
								<section class="entry-content cf">

									<h3 class="h2 entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
									<p class="byline vcard"><?php
										printf(__( 'Posted', 'simplyread' ) . ' <time class="updated" datetime="%1$s" pubdate>%2$s</time> ' . __('by', 'simplyread' ) . ' <span class="author">%3$s</span>', get_the_time(get_option('date_format')), get_the_time(__( get_option('date_format'), 'simplyread' )), get_the_author_link( get_the_author_meta( 'ID' ) ));
									?></p>

									<?php the_excerpt(); ?>

								</section>

							</article>

							<?php endwhile; ?>

									<?php simplyread_page_navi(); ?>

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