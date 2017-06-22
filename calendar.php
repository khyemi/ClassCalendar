<?php
	session_start();
	if(!isset($_SESSION['login'])){
		header("LOCATION:login.php");
		die();
	}
	$username = $_SESSION['login'];
?>
<!DOCTYPE html>
<!-- Hye Mi Kim 5044613 -->
<html lang="en">
  <head>
	<meta name="viewport" content="initial-scale=1.0 user-scalable=no">
    <meta charset="utf-8">
    <title>Calendar</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
  </head>
  <body>
    <!-- Start of the bar div -->
    <div>
		<h1>My Class Schedule - Fall 2016</h1>
    <button onclick="window.location.href='logout.php'">Log out</button><br>
		<span><?php echo 'Welcome '.$username. '!'; ?></span><br>	
		<nav>
			<button onclick="window.location.href='calendar.php'">My Calendar</button>
			<button onclick="window.location.href='input.php'">Form Input</button>
			<button onclick="window.location.href='admin.php'">Administration Page</button>		
    </nav>	
	</div>
	<br>
    <!-- Start of the events div  -->
	<div>
	<?php
		if(!file_exists("./calendar.txt")||!filesize("./calendar.txt")){
			echo "<div class = 'errorMessages'><span class = 'error'>Calendar has no events. Please use the input page to add some events</span></div>";
		}
		else{
			$data = file_get_contents("./calendar.txt");
			$events = json_decode($data, true);
			$monEvents = $tueEvents = $wedEvents = $thurEvents = $friEvents = array();

			foreach ($events as $event) {
				if ($event['day'] == 'Mon') {
					array_push($monEvents, $event);
				}
				elseif ($event['day'] == 'Tue') {
					array_push($tueEvents, $event);

				}
				elseif ($event['day'] == 'Wed') {
					array_push($wedEvents, $event);
				}
				elseif ($event['day'] == 'Thur') {
					array_push($thurEvents, $event);
				}
				elseif ($event['day'] == 'Fri') {
					array_push($friEvents, $event);
				}				
			}
			echo 	"<div class='Table'><table>";
			if(!empty($monEvents)){
				usort($monEvents, function($a, $b) {return $a['starttime'] - $b['starttime'];}); //sort time
				echo "<tr><th><span>Monday</span></th>";
				foreach($monEvents as $m){
					echo "<td>".$m['starttime']." - ".$m['endtime']."<br>".$m['eventname']." - <span class = 'location'>".$m['location']."</span></td>";
				}
				echo "</tr>";
			}
			if(!empty($tueEvents)){
				usort($tueEvents, function($a, $b) {return $a['starttime'] - $b['starttime'];});
				echo "<tr><th><span>Tuesday</span></th>";
				foreach($tueEvents as $t){
					echo "<td>".$t['starttime']." - ".$t['endtime']."<br>".$t['eventname']." - <span class = 'location'>".$t['location']."</span></td>";
				}
				echo "</tr>";				
			}
			if(!empty($wedEvents)){
				usort($wedEvents, function($a, $b) {return $a['starttime'] - $b['starttime'];});
				echo "<tr><th><span>Wednesday</span></th>";
				foreach($wedEvents as $w){
					echo "<td>".$w['starttime']." - ".$w['endtime']."<br>".$w['eventname']." - <span class = 'location'>".$w['location']."</span></td>";
				}
				echo "</tr>";
			}
			if(!empty($thurEvents)){
				usort($thurEvents, function($a, $b) {return $a['starttime'] - $b['starttime'];});
				echo "<tr><th><span>Thursday</span></th>";
				foreach($thurEvents as $th){
					echo "<td>".$th['starttime']." - ".$th['endtime']."<br>".$th['eventname']." - <span class = 'location'>".$th['location']."</span></td>";
				}
				echo "</tr>";
			}
			if(!empty($friEvents)){
				usort($friEvents, function($a, $b) {return $a['starttime'] - $b['starttime'];});
				echo "<tr><th><span>Friday</span></th>";				
				foreach($friEvents as $f){
					echo "<td>".$f['starttime']." - ".$f['endtime']."<br>".$f['eventname']." - <span class = 'location'>".$f['location']."</span></td>";
				}
				echo "</tr>";			
			}
			echo "</table>";
		}
	?>
	</div>
	
  <!-- start of the map div -->
	<div id="map"></div>
	
  <!-- Script for the map -->
	<script>
	// Code obtained from https://developers.google.com/maps/documentation/javascript/examples/geocoding-simple, 
	// 					          https://developers.google.com/maps/documentation/javascript/examples/place-search and lecture note.
	var map;
	var myLatLng = {lat: 44.975262, lng: -93.243348}; 
	var infowindow;
	function initMap() {	
    var bounds = new google.maps.LatLngBounds();
    map = new google.maps.Map(document.getElementById('"map"'), {
            zoom: 16,
            center: myLatLng
    });
		
		// Geocode the locations
		var geocoder = new google.maps.Geocoder();
		var markers = [];
		var location_list = document.getElementsByClassName('location');
		for(var i = 0; i < location_list.length; i++)
		{
		   location = location_list.item(i).innerHTML;
		   lat_long = geocodeAddress(geocoder, location);
		   marker = [location, lat_long];
		   markers.push(marker);
		}
		
		var infoWindow = new google.maps.InfoWindow(), marker, i;

		for( i = 0; i < markers.length; i++ ) {
    			var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
    			bounds.extend(position);
    			marker = new google.maps.Marker({
	            	position: position,
	            	map: map,
	            	title: markers[i][0],
					      animation: google.maps.Animation.DROP

  		  		});
          google.maps.event.addListener(marker, 'click', (function(marker, i) {
        			return function() {
            			infoWindow.setContent(markers[i][1]);
            			infoWindow.open(map, marker);
        			}
    			})(marker, i));

    			// Automatically center the map fitting all markers on the screen
    			map.fitBounds(bounds);
    	}
    }

    function geocodeAddress(geocoder, address) {
        	geocoder.geocode({'address': address}, function(results, status) {
          		if (status === 'OK') {
            		map.setCenter(results[0].geometry.location);
            		marker = new google.maps.Marker({
            				map: map,
            				position: results[0].geometry.location,
							title:address
            			});
          		} else {
            		alert('Geocode was not successful for the following reason: ' + status);
          		}
        	});
	}
    function callback(results, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
          for (var i = 0; i < results.length; i++) {
          		createMarker(results[i]);
          }
        }
    }

    function createMarker(place) {
        var placeLoc = place.geometry.location;
        var marker = new google.maps.Marker({
          map: map,
          position: place.geometry.location
        });

        google.maps.event.addListener(marker, 'click', function() {
          infowindow.setContent(place.name + '<br>' + place.vicinity);
          infowindow.open(map, this);
        });
    }
	</script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkSn1D_TEIwQ97LIoFB5Vyv4c7fDzTLrs&callback=initMap&libraries=places"
  async defer></script>
	<p class="italic_2">This page has been tested in Chrome and Internet Explorer.</p>
  </body>
</html>

