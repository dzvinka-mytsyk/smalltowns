<li class="item">
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		<?php if ( has_post_thumbnail()): the_post_thumbnail( 'full'); endif; ?>
	</a>
	<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
	<div class="date">
		<?php printf( __( '<time class="updated" datetime="%1$s" pubdate>%2$s</time>', 'simplyread' ), get_the_time('m-d-Y'), get_the_time(get_option('date_format'))); ?>
	</div>
	<div class="excerpt"><?php the_excerpt(); ?></div>
</li>