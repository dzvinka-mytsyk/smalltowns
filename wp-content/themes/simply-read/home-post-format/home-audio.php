<li class="item format">
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		<?php if ( has_post_thumbnail()): the_post_thumbnail( 'full');  ?>
			<span class="fa fa-music"></span>
		<?php endif; ?>
	</a>
	<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
	<div class="date">
		<?php printf( __( '<time class="updated" datetime="%1$s" pubdate>%2$s</time>', 'simplyread' ), get_the_time('m-d-Y'), get_the_time(get_option('date_format'))); ?>
	</div>
	<div class="excerpt">
		<?php  if(is_plugin_active('advanced-custom-fields/acf.php')) : 
			$audio = get_field('wpdevshed_post_format_audio_content') ?>
			<?php $attr = array(
				'src'      => $audio,
				'loop'     => '',
				'autoplay' => '',
				'preload' => 'none'
				);
		echo wp_audio_shortcode( $attr ); 
		endif; ?><?php the_excerpt(); ?>
	</div>
</li>