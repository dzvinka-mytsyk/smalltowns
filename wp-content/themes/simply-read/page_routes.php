<?php
/*
Template Name: Routes
*/
?>
<?php get_header(); ?>

  <div id="content">

    <header class="article-header">
      <div id="inner-content" class="wrap cf">
        <h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
      </div>
    </header>

    <div id="inner-content" class="wrap cf" style="padding: 20px 0px 50px 0px;">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; else : ?>
        <p>nope</p>
      <?php endif; ?>
    </div>
  </div>

<?php get_footer(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="/wp-content/themes/simply-read/library/js/routes.js"></script>
<script type="text/javascript">
(function() {

  var storeService = new StoreService('selectedLocations');
  var locations = storeService.findAll();

  var list = jQuery('#locations');

  for (var i = 0; i < locations.length; i++) {
    list.append('<li>' + (i + 1) + '. ' +locations[i].value.name + '</li>');
  }

})();
</script>
<script type="text/javascript">
function initMap() {

  var storeService = new StoreService('selectedLocations');
  var locations = storeService.findAll();

  var start;
  var end;
  var waypoints = [];

  for (var i = 0; i < locations.length; i++) {
    if (i === 0) {
      start = locations[i].value;
    } else if (i === locations.length - 1) {
      end = locations[i].value;
    } else {
      waypoints.push({
        location: locations[i].value,
        stopover:true
      });
    }
  }

  var map;
  if (!start) {
    map = new google.maps.Map(document.getElementById('map'), {
      center: {lat:50.7519067, lng:10.6163516},
      scrollwheel: false,
      zoom: 6
    });
    return;
  }

  map = new google.maps.Map(document.getElementById('map'), {
    center: start,
    scrollwheel: false,
    zoom: 7
  });

  var directionsDisplay = new google.maps.DirectionsRenderer({
    map: map
  });
  // Set destination, origin and travel mode.
  var request = {
    origin: start,
    destination: end,
    waypoints: waypoints,
    travelMode: google.maps.TravelMode.DRIVING
  };
  // Pass the directions request to the directions service.
  var directionsService = new google.maps.DirectionsService();
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      // Display the route on the map.
      directionsDisplay.setDirections(response);
    }
  });
}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUVdoVhv2NH-Rzxb5ko455nb6OcsrcaEo&callback=initMap"></script>
