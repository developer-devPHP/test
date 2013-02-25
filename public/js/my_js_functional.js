jQuery(function($){
	
/*	$('#enter_country,#enter_city,#search_by_hotel_name').flexselect({
		preSelection: false
	});*/

	//$('#enter_city_flexselect').attr('disabled','disabled');
	
	/* data form js START */
	//alert($('#mydate').val());
	var global_date = new Date ($('#mydate').val()); //$('#mydate').val()
	
	var global_mounth = new Date ($('#mydate').val());
		global_mounth.setDate(global_date.getDate() + 30);
	
	var global_day = new Date ($('#mydate').val());
		global_day.setDate(global_date.getDate() + 1);
	
	
	//global_date.setMonth(global_date.getMonth() + 2);
	
	//var new_global_mounth = new Date();
	$.datepicker.setDefaults({
		dateFormat: 'yy-mm-dd'
	});
	
	$( "#check_in_date" ).datepicker({
		
	    minDate: global_date,
	    
		onSelect: function( selectedDate ) {
			 var dateObject = $(this).datepicker('getDate');
			 
		      if (dateObject) 
			  {
		    	  var new_day = new Date(dateObject);
		    	  new_day.setDate(new_day.getDate() + 1);
		    	  
		    	  var new_month = new Date(dateObject); 
		    	  new_month.setDate(new_month.getDate() + 30);
		    
		          $( "#check_out_date" ).datepicker( "option",{
				       minDate : new_day,
				       maxDate: new_month
					});
		          $('#number_of_nights').removeAttr('disabled');
		          
		          if($('#check_out_date').val() != '')
					{
						var one_day=1000*60*60*24; // miliseconds
						
						var chech_out_date_val = $.datepicker.parseDate('yy-mm-dd', $('#check_out_date').val());
					
						date_caunt = Math.ceil((chech_out_date_val.getTime()-new_day.getTime())/(one_day)) + 1;
						$('#number_of_nights').val(date_caunt);
						
					}
		      }
		      else
		      {
		    	  $( "#check_out_date" ).datepicker('disable');
		      }
			
		    $('#check_out_date').datepicker('enable');
		}
	});
	$( "#check_out_date" ).datepicker({
		minDate: global_day,
		maxDate: global_mounth,
		onSelect: function( selectedDate ) {
			$(".ui-datepicker a").removeAttr("href");
			var dateObject = $(this).datepicker('getDate');
			if (dateObject) 
			 {
				var new_date = new Date(dateObject);
				new_date.setDate(new_date.getDate() - 1);
		          $( "#check_in_date" ).datepicker( "option",{
				       maxDate : new_date
					});
		          
					if($('#check_in_date').val() != '')
					{
						var one_day=1000*60*60*24; // miliseconds
						
						var chech_in_date_val = $.datepicker.parseDate('yy-mm-dd' , $('#check_in_date').val());
						
						date_caunt = Math.ceil((new_date.getTime()-chech_in_date_val.getTime())/(one_day)) + 1;
						
						$('#number_of_nights').val(date_caunt);
						$('#number_of_nights').removeAttr('disabled');
						
					}
		     }
		}
	});

	$('#number_of_nights').attr("disabled", "disabled");
	
	$('#check_in_date,#check_out_date').live('change',function(){

		if($(this).val().length !== 0)
		{
			var new_date = new Date($(this).val());
			
			if(new_date.toString() != 'Invalid Date' && $(this).val().length == 10)
			{
			    $('#number_of_nights').removeAttr('disabled');
			}
			else
			{
				if($("#dialog-message-invalid_date").dialog( "isOpen" ))
				{
					$('body').append('<div id="dialog-message-invalid_date" title="Invalid Date">ashjkdasdh</div>');
				}
				$( "#dialog-message-invalid_date" ).dialog({
					resizable: false,
					modal: true,
					buttons: 
					{
						Ok: function()
					    {
							$( this ).dialog( "close" );
						}
					}
				});

				
				$('#number_of_nights').attr("disabled", "disabled");
				$('#number_of_nights').val(null).attr('selecdet','selected');
			}
		}
		else
		{
			$('#number_of_nights').attr("disabled", "disabled");
			$('#number_of_nights').val(null);
			
			$('#check_in_date').datepicker( "option",{
			       maxDate : null
			});
			
		}
	});
	$('#number_of_nights').live('change',function(){
		var value = parseInt($(this).val());
		if($('#check_in_date').val().length !==0)
		{
			queryDate = $('#check_in_date').val();

			var parsedDate = $.datepicker.parseDate('yy-mm-dd', queryDate);
			var day = parsedDate.setDate(parsedDate.getDate() + value);
			var new_date = new Date(day);
			
			
			$('#check_out_date').datepicker('setDate', new_date);
		}
		else
		{
			$('#number_of_nights').attr("disabled", "disabled");
			$('#number_of_nights').val(null);
		}
	});
	
	/*Date Form js END*/
	
	$('form input:submit').on('click',function(){
		var opts = {
				  lines: 13, // The number of lines to draw
				  length: 15, // The length of each line
				  width: 7, // The line thickness
				  radius: 25, // The radius of the inner circle
				  corners: 1, // Corner roundness (0..1)
				  rotate: 0, // The rotation offset
				  color: '#000', // #rgb or #rrggbb
				  speed: 1.0, // Rounds per second
				  trail: 100, // Afterglow percentage
				  shadow: false, // Whether to render a shadow
				  hwaccel: false, // Whether to use hardware acceleration
				  className: 'spinner', // The CSS class to assign to the spinner
				  zIndex: 2e9, // The z-index (defaults to 2000000000)
				  top: 'auto', // Top position relative to parent in px
				  left: 'auto' // Left position relative to parent in px
				};
				$('body').append("<div class='ui-widget-overlay' id='preloader'></div>");
				$('#preloader').css({'width':$(window).width(),'height':$(document).height(),'z-index':1001});
				var target = document.getElementById('preloader');
				var spinner = new Spinner(opts).spin(target);
	});
});


/*functions */
function init_map(lt,lg,titleText,zoom_precent) 
{
	 var myLatlng = new google.maps.LatLng(lt,lg);
	  var mapOptions = {
			  scrollwheel: false,
			    navigationControl: false,
			    mapTypeControl: false,
			    scaleControl: false,
			    draggable: false,
			    
	    zoom: zoom_precent,
	    center: myLatlng,
	    mapTypeId: google.maps.MapTypeId.ROADMAP  //ROADMAP  HYBRID
	  };
	  var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	  var image = 'http://maps.gstatic.com/mapfiles/icon.png';
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
