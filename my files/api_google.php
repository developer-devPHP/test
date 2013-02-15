<div id="map_canvas" style="width: 500px; height: 300px;">
	
	</div>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCc6lmYtkq9UNNY2IojsId3coE1iI3T-3g&sensor=false&language=en"></script>



<script type="text/javascript">
<!--
titleText = 'asdasd';
lt='25.271185';
lg='55.329082';
init_map(lt, lg, titleText);
 function init_map(lt,lg,titleText) {
			  
				 var myLatlng = new google.maps.LatLng(lt,lg);
				  var mapOptions = {
				    zoom: 12,
				    center: myLatlng,
				    mapTypeId: google.maps.MapTypeId.ROADMAP
				  };
				  var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
				  var image = '/kandaclub/public/images/marker.png';
				  var contentString = '<div id="mapContentWindow">'+titleText+'</div>';
				 
				   marker = new google.maps.Marker({
				      position: myLatlng,
				      map: map,
				      animation: google.maps.Animation.DROP,
				     
				      title:titleText,
				      icon: image
				  });
				 
				var coordInfoWindow = new google.maps.InfoWindow();
			        coordInfoWindow.setContent(contentString);
			        //coordInfoWindow.setPosition(marker);
			        coordInfoWindow.open(map);
				  google.maps.event.addListener(marker, 'click', function() {
					  coordInfoWindow.open(map,marker);
					});
			};

			//-->
			</script>