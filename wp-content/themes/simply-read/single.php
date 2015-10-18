<?php get_header(); ?>

			<div id="content">

				<header class="article-header">
					<div id="inner-content" class="wrap cf">
						<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
						<h3 class="entry-title single-title"><?php
							/* translators: used between list items, there is a space after the comma */
							$category_list = get_the_category_list( __( ', ', 'simplyread' ) );
							printf( __('%s', 'simplyread'),
							$category_list
							);
						?></h3>
					</div>
					<div id="add-to-route-btn">
						<?php $location = get_field('geotag'); if( !empty($location) ): ?>
							<input type="checkbox" store-key="selectedLocations" store-value='{"lat":<?php echo $location['lat']; ?>,"lng":<?php echo $location['lng']; ?>, "name": "<?php the_title(); ?>"}'/> Add to route
						<?php endif; ?>
					</div>
				</header>  <?php // end article header ?>

				<div id="inner-content" class="wrap cf">

					<div id="main" class="m-all t-2of3 d-5of7 cf" role="main">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
							<!--p class="byline vcard"-->
								<!--?php printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span>', 'simplyread' ), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), get_the_author_link( get_the_author_meta( 'ID' ) )); ?-->
								<!--?php
									/* translators: used between list items, there is a space after the comma */
									$category_list = get_the_category_list( __( ', ', 'simplyread' ) );
									printf( __('%s', 'simplyread'),
									$category_list
									);
								?-->
							<!--/p-->

							<?php

								get_template_part( 'post-formats/format', get_post_format() );
							?>

							<div class="next-prev-post">
			                  <div class="prev">
			                  <!--?php previous_post_link('<p><span class="fa fa-angle-left"></span>	<<<</p> %link'); ?-->
												<?php previous_post_link('<p><<<<</p> %link'); ?>
			                  </div>
			                  <div class="center-divider"></div>
			                  <div class="next">
			                  <!--?php next_post_link('<p>NEXT POST <span class="fa fa-angle-right"></span></p> %link'); ?-->
												<?php next_post_link('<p>>>>></p> %link'); ?>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="/wp-content/themes/simply-read/library/js/routes.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script type="text/javascript">
(function($) {
function new_map( $el ) {
        var $markers = $el.find('.marker');
	var args = {
		zoom		: 10,
		center		: new google.maps.LatLng(0, 0),
		mapTypeId	: google.maps.MapTypeId.ROADMAP
	};

	var map = new google.maps.Map( $el[0], args);
	map.markers = [];

	$markers.each(function(){
            add_marker( $(this), map );
	});

	center_map( map );
	return map;
}

function add_marker( $marker, map ) {
	var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

	var marker = new google.maps.Marker({
		position	: latlng,
		map			: map
	});

	map.markers.push( marker );

	if( $marker.html() ) {
		var infowindow = new google.maps.InfoWindow({
			content		: $marker.html()
		});

		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open( map, marker );
		});
	}

}

function center_map( map ) {

	var bounds = new google.maps.LatLngBounds();

	$.each( map.markers, function( i, marker ){
		var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
		bounds.extend( latlng );
	});

	if( map.markers.length == 1 ) {
	    map.setCenter( bounds.getCenter() );
	    map.setZoom( 10 );
	} else {
		map.fitBounds( bounds );
	}

}

var map = null;

$(document).ready(function(){
	$('.acf-map').each(function(){
		map = new_map( $(this) );
	});
});

})(jQuery);
</script>
