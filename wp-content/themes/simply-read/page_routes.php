<?php
/*
Template Name: Routes
*/
?>
<?php get_header(); ?>

  <div id="content">

    <header class="article-header">
      <div id="inner-content" class="wrap cf">
        <h1 class="entry-title single-title" itemprop="headline">
          <?php the_title(); ?>
        </h1>
      </div>
    </header>

    <div id="inner-content" class="wrap cf routes-content">

      <!-- {:en}Route planning{:}{:uk}Планування маршруту{:} -->
      <div>
        <h3>
          <?php _e('Chosen towns for Route:', 'simplyread'); ?>
        </h3>
        <div id="locations" class="towns" style="display: none;">
          <ul>
            <?php
              $count_posts = wp_count_posts();
              $published_posts = $count_posts->publish;
              $myposts = get_posts(array('posts_per_page' => $published_posts));
              foreach ($myposts as $post) : setup_postdata($post);
                $location = get_field('geotag');
                if (!empty($location)):?>
                  <li class="selected-town-id-<?php the_ID(); ?>" style="display: none;">
                    <input type="checkbox" checked="checked" town-data='{"lat":<?php echo $location['lat']; ?>,"lng":<?php echo $location['lng']; ?>, "townId": "<?php the_ID(); ?>"}'/>
                    <?php the_title(); ?>
                  </li>
                <?php endif;
              endforeach;
              wp_reset_postdata();
            ?>
          </ul>
          <div class="clear"></div>
        </div>
        <div class="wrap cf" id="inner-content" style="position:relative">
          <div id="more-towns-label" class="divider-title">
            <span>
              <?php _e('More', 'simplyread'); ?>
            </span>
          </div>
        </div>
        <div id="more-towns" class="towns" style="display: none;">
          <ul>
            <?php
              $count_posts = wp_count_posts();
              $published_posts = $count_posts->publish;
              $myposts = get_posts(array('posts_per_page' => $published_posts));
              foreach ($myposts as $post) : setup_postdata($post);
                $location = get_field('geotag');
                if (!empty($location)):?>
                  <li class="not-selected-town-id-<?php the_ID(); ?>">
                    <input type="checkbox" town-data='{"lat":<?php echo $location[' lat ']; ?>,"lng":<?php echo $location['lng ']; ?>, "townId": "<?php the_ID(); ?>"}'/>
                    <?php the_title(); ?>
                  </li>
                <?php endif;
              endforeach;
              wp_reset_postdata();
            ?>
          </ul>
          <div class="clear"></div>
        </div>
        <div style="padding: 0 0 20px 0;">
          <input type="submit" id="build-route-btn" value="<?php _e('Build Route', 'simplyread'); ?>" />
          <div class="clear"></div>
        </div>
      </div>
      <div id="map" style="height: 600px;"></div>

    </div>

  </div>

<?php get_footer(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="/wp-content/themes/simply-read/library/js/routes/routes.js"></script>
<!-- https://github.com/leejacobson/googlemaps-tsp-ga/blob/master/index.html -->
<script src="/wp-content/themes/simply-read/library/js/routes/BpTspSolver.js"></script>
<script type="text/javascript">
  jQuery(function($) {

    var storeService = new StoreService('selectedLocations');

    loadSelectedTowns();
    initMoreTownsSection();
    jQuery('#build-route-btn').click(rebuildRoute);

    function loadSelectedTowns() {

      var locations = storeService.findAll();

      for (var i = 0; i < locations.length; i++) {
        var data = locations[i].value;
        jQuery('.selected-town-id-' + data.townId).show();
        jQuery('.not-selected-town-id-' + data.townId).hide();
      }

      jQuery('#locations').show();

    }

    function initMoreTownsSection() {
      var moreTownsLabels = ['<span><?php _e('More ', 'simplyread '); ?></span>', '<span><?php _e('Hide ', 'simplyread '); ?></span>'];
      var labelIndex = 0;
      jQuery("#more-towns-label").click(function() {
        labelIndex = (labelIndex + 1) % 2;
        var elem = jQuery(this);
        jQuery("#more-towns").slideToggle(function() {
          elem.html(moreTownsLabels[labelIndex]);
        });
      });
    }

    function rebuildRoute() {

      $('#locations input:checkbox:not(:checked)[town-data]').each(function() {
        storeService.removeItem(JSON.parse($(this).attr('town-data')));
      });

      $('#more-towns input:checkbox:checked[town-data]').each(function() {
        storeService.addItem(JSON.parse($(this).attr('town-data')));
      });

      location.reload();

      return false;

    }

  });
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
          stopover: true
        });
      }
    }

    var map;
    if (!start) {
      map = new google.maps.Map(document.getElementById('map'), {
        center: {
          lat: 50.7519067,
          lng: 10.6163516
        },
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

    if (!end) {
      var marker = new google.maps.Marker({
        position: start,
        map: map
      });
      return;
    }

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

  function initMapOpt() {

    var storeService = new StoreService('selectedLocations');
    var locations = storeService.findAll();

    var dirRenderer;
    var markers = new Array();
    var mode = 1;

    var map = new google.maps.Map(document.getElementById('map'), {
      center: {
        lat: 50.7519067,
        lng: 10.6163516
      },
      zoom: 6
    });

    // Create the tsp object
    tsp = new BpTspSolver(map);

    // Set your preferences
    tsp.setAvoidHighways(false);
    tsp.setTravelMode(google.maps.DirectionsTravelMode.DRIVING);

    for (var i = 0; i < locations.length; i++) {
      tsp.addWaypoint(new google.maps.LatLng(locations[i].value.lat, locations[i].value.lng));
    }

    function removeOldMarkers() {
      for (var i = 0; i < markers.length; ++i) {
        markers[i].setMap(null);
      }
      markers = new Array();
    }

    tsp.solveAtoZ(function() {
      console.log("done");

      var dirRes = tsp.getGDirections();
      var dir = dirRes.routes[0];

      removeOldMarkers();

      for (var i = 0; i < dir.legs.length; i++) {
        var route = dir.legs[i];
        var myPt1 = route.end_location;
        var marker = new google.maps.Marker({
          position: myPt1,
          map: map
        });
        markers.push(marker);
      }

      // Clean up old path.
      if (dirRenderer != null) {
        dirRenderer.setMap(null);
      }

      dirRenderer = new google.maps.DirectionsRenderer({
        directions: dirRes,
        hideRouteList: true,
        map: map,
        panel: null,
        preserveViewport: false
      });

    });

  }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUVdoVhv2NH-Rzxb5ko455nb6OcsrcaEo&callback=initMapOpt"></script>
