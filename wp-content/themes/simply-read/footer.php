			<footer class="footer" role="contentinfo">

				<div id="inner-footer" class="wrap cf">

					<div class="social-icons footer-social">
		           		<?php echo simplyread_social_icons(); ?>
                	</div> <!-- social-icons-->

					<p class="source-org copyright">
						 &#169; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?> 
						<span><?php if(is_home()): ?>
							- <a href="http://wordpress.org/" target="_blank">Powered by WordPress</a> and <a href="http://wpsimplyread.com/" target="_blank">WP Simply Read</a> 
						<?php endif; ?>
						</span>
					</p>

				</div>

			</footer>

		</div>

		<?php wp_footer(); ?>

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

	</body>

</html> <!-- end of site. what a ride! -->