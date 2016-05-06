<!html>
<html>
<head>
    <title>Places to Stay</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- jQuery -->
    <script src="<?php echo $this->fileUrl('dist/js/jquery.min.js'); ?>"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo $this->fileUrl('bootstrap/css/bootstrap.css'); ?>">
    <script type="text/javascript" src="<?php echo $this->fileUrl('bootstrap/js/bootstrap.js'); ?>"></script>
    <!-- Custom scripts -->
    <link rel="stylesheet" href="<?php echo $this->fileUrl('dist/css/style.css'); ?>">
    <link rel="stylesheet" href="<?php echo $this->fileUrl('dist/css/calendar.css'); ?>">
    <link href='https://fonts.googleapis.com/css?family=Source+Code+Pro' rel='stylesheet' type='text/css'>

    <!-- Date Stuff -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="<?php echo $this->fileUrl('dist/js/calendar.js'); ?>"></script>
    <script>
        $(function() {
            localStorage.clear();

            $( "#dateFrom" ).datepicker();
            $( "#dateTo" ).datepicker();
        });
    </script>

    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
</head>
<body>
<div id="splash-index">
    <div class="overlay"></div>
    <div class="splash-text-container-outer">
        <div class="splash-text-container">
            <p class="main-message">
                Places To Stay
            </p>
            <p class="sub-message">
                <a class="start-search" data-scroll href="#searchContainer">Start Search</a>
                <a class="start-search" data-scroll href="#assignmentContainer">View Assignment</a>
            </p>
        </div>
    </div>
</div>
<div id="searchContainer">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1" id="error" style="display: none;">

                </div>
            </div>
            <form class="form-horizontal" id="searchPlace" method="post" action="<?php echo $this->url('api/search'); ?>">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="text" name="location" id="town" class="form-control" style="font-size: 22pt; height: 60px;" placeholder="Location">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <input name="available_to" class="form-control" type="text" id="dateFrom" style="font-size: 22pt; height: 60px;" placeholder="Date To">
                        </div>
                        <div class="col-md-6">
                            <input name="available_from" type="text" class="form-control" id="dateTo" style="font-size: 22pt; height: 60px;" placeholder="Date From">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn search">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="resultsContainer">
    <div class="row">
        <div class="col-xs-12">
            <div id="map">

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div id="results">

            </div>
        </div>
    </div>
</div>
<div id="assignmentContainer">
    <div class="row">
        <div class="col-xs-6">
            <h1>1) The web service must be able to look up locations</h1>
            <p>Url:
                <span class="code">
                    <a href="<?php echo $this->url('api/search/'); ?>London/2016-05-01/2016-05-31?api_key=dc45c373b4c92bc">
                        <?php echo $this->url('api/search/'); ?>London/2016-05-01/2016-05-31?api_key=dc45c373b4c92bc
                    </a>
                </span>
            </p>
            <p>And:
                <span class="code">
                    <a href="<?php echo $this->url('api/search/'); ?>London/2016-05-01/2016-05-31/Hotel?api_key=dc45c373b4c92bc">
                        <?php echo $this->url('api/search/'); ?>London/2016-05-01/2016-05-31/Hotel?api_key=dc45c373b4c92bc
                    </a>
                </span>
            </p>
        </div>
        <div class="col-xs-6">
            <h1>Returns</h1>
            <pre class="prettyprint">
{
  locations: [
    {
      ID: "2",
      name: "Premier Inn London Waterloo",
      lat: "51.501748",
      lng: "-0.11648600000000897",
      google_id: "ChIJ_75-fbgEdkgRp4ql6Rq76ao",
      street_number: "85",
      address_line1: "York Road",
      town: "London",
      postcode: "SE1 7NJ",
      country: "United Kingdom",
      location_type: "Hotel",
      belongs_to: "1",
      rooms: [
        {
          ID: "1",
          room_description: "2 beds with a view",
          location_id: "2",
          number_of_beds: "2",
          room_price: "2800",
          bookedDates: [
            {
              start: "2016-05-07",
              end: "2016-05-09"
            },
            {
              start: "2016-05-10",
              end: "2016-05-12"
            }
          ]
        },
        {
          ID: "2",
          room_description: "3 beds with a view",
          location_id: "2",
          number_of_beds: "3",
          room_price: "3000",
          bookedDates: [
            {
              start: "2016-05-20",
              end: "2016-05-23"
            },
            {
              start: "2016-05-10",
              end: "2016-05-12"
            },
            {
              start: "2016-05-13",
              end: "2016-05-16"
            },
            {
              start: "2016-05-17",
              end: "2016-05-18"
            },
            {
              start: "2016-05-08",
              end: "2016-05-09"
            }
          ]
        }
      ]
    },
    {
      ID: "3",
      name: "Premier Inn London Leicester Square",
      lat: "51.51104650000001",
      lng: "-0.13018379999994067",
      google_id: "ChIJJUyxFNIEdkgRajb-0tlYT_0",
      street_number: "1",
      address_line1: "Leicester Square",
      town: "London",
      postcode: "WC2H 7BP",
      country: "United Kingdom",
      location_type: "Hotel",
      belongs_to: "1",
      rooms: [
        {
          ID: "3",
          room_description: "3 beds with a view",
          location_id: "3",
          number_of_beds: "3",
          room_price: "3500",
          bookedDates: [

          ]
        },
        {
          ID: "4",
          room_description: "2 beds with a view",
          location_id: "3",
          number_of_beds: "2",
          room_price: "3000",
          bookedDates: [

          ]
        }
      ]
    },
    {
      ID: "4",
      name: "Premier Inn London Blackfriars",
      lat: "51.512878",
      lng: "-0.1055149999999685",
      google_id: "ChIJ24SRYq0EdkgRAksghbg1UM8",
      street_number: "1",
      address_line1: "Dorset Rise",
      town: "London",
      postcode: "EC4Y 8EN",
      country: "United Kingdom",
      location_type: "Hotel",
      belongs_to: "1"
    },
    {
      ID: "5",
      name: "Premier Inn London Southwark Borough Market",
      lat: "51.5071442",
      lng: "-0.09287050000000363",
      google_id: "ChIJgXlxzVcDdkgRWi5_YPdOOf4",
      street_number: "34",
      address_line1: "Park Street",
      town: "London",
      postcode: "SE1 9EF",
      country: "United Kingdom",
      location_type: "Hotel",
      belongs_to: "1",
      rooms: [
        {
          ID: "6",
          room_description: "Room for two with a view",
          location_id: "5",
          number_of_beds: "2",
          room_price: "4500",
          bookedDates: [

          ]
        }
      ]
    }
  ]
}
            </pre>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <h1>2) Web service must be able to make a booking</h1>
            <p><a data-scroll href="#searchContainer">Try here</a></p>
        </div>
        <div class="col-xs-6">
            <h1>Service returns if successful</h1>
            <pre class="prettyprint">
{
  "message": "Booking successfully created",
  "booking": {
    "ID": "14",
    "room_id": "3",
    "date_from": "2016-06-03",
    "date_to": "2016-06-06",
    "user_id": "1",
    "price_paid": "10500",
    "room": {
      "ID": "3",
      "room_description": "3 beds with a view",
      "location_id": "3",
      "number_of_beds": "3",
      "room_price": "3500",
      "location": {
        "ID": "3",
        "name": "Premier Inn London Leicester Square",
        "lat": "51.51104650000001",
        "lng": "-0.13018379999994067",
        "google_id": "ChIJJUyxFNIEdkgRajb-0tlYT_0",
        "street_number": "1",
        "address_line1": "Leicester Square",
        "town": "London",
        "postcode": "WC2H 7BP",
        "country": "United Kingdom",
        "location_type": "Hotel",
        "belongs_to": "1"
      }
    }
  }
}
            </pre>
            <h1>And an example error:</h1>
            <pre class="prettyprint">
{
  "error": "A booking already exists within this period",
  "message": "Booking failed",
  "errorCode": 400
}
            </pre>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h1>3) Places to stay should utilise AJAX front end - <a href="#searchContainer" data-scroll>View here</a></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h1>
                4) Visit Colorado should be able to look up locations using API
                - <a href="http://visitcolorado.alexpotter.dev/">View here</a>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h1>5) Places to stay should show users local area - <a href="#searchContainer" data-scroll>View here</a></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h1>6) Display results as markers and text - <a href="#searchContainer" data-scroll>View here</a></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h1>7) Visit Visit Colorado should be able to make bookings using API - <a href="http://visitcolorado.alexpotter.dev/">View here</a></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h1>8) When the user clicks on a marker a pop up of text displays explaining location - <a href="#searchContainer" data-scroll>View here</a></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h1>9) Interactive calendar should be implemented - <a href="#searchContainer" data-scroll>View here</a></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h1>Admin can be found <a href="<?php echo $this->url('admin'); ?>">here</a>, please <a href="mailto:alex.potter1993@gmail.com">email</a> for username and password</h1>
        </div>
    </div>
</div>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" id="displayAvailability" data-target="#roomAvailability" style="display: none;">
    Availability
</button>
<!-- Modal -->
<div class="modal fade modal-lg" id="roomAvailability" tabindex="-1" role="dialog" aria-labelledby="availabilityModalLabel" style="margin: auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Room Availability</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12" id="roomDateSelector">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal" onclick="location.reload();">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Note: This example requires that you consent to location sharing when
    // prompted by your browser. If you see the error "The Geolocation service
    // failed.", it means you probably did not give permission for the browser to
    // locate you.

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 51.5074, lng: 0.1278},
            zoom: 8
        });
        var infoWindow = new google.maps.InfoWindow({map: map});
        var geocoder = new google.maps.Geocoder;

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                infoWindow.setPosition(pos);
                infoWindow.setContent('Your location');
                map.setCenter(pos);
                map.setZoom(10);
            }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
        }

        $('#searchPlace').submit(function(e) {
            e.preventDefault();

            infoWindow.close();

            var dateFrom = $('#dateFrom').val().split('/');
            localStorage.setItem('dateFrom', $('#dateFrom').val());
            dateFrom = dateFrom[2] + '-' + dateFrom[0] + '-' + dateFrom[1];

            var dateTo = $('#dateTo').val().split('/');
            localStorage.setItem('dateTo', $('#dateTo').val());
            dateTo = dateTo[2] + '-' + dateTo[0] + '-' + dateTo[1];

            var url = $( this ).prop( 'action' ) +
                '/' + $('#town').val() + '/'
                + dateFrom + '/' + dateTo + '?api_key=dc45c373b4c92bc';

            $.get(url).done(function (rooms) {
                $('#error').hide().html();

                var html = '\
                <table class="table" style="margin-top: 20px;">\
                    <tr>\
                        <th>Location</th>\
                        <th>Type</th>\
                        <th>Room Description</th>\
                        <th>Beds</th>\
                        <th>Price per night</th>\
                        <th>View on map</th>\
                        <th>View dates and book</th>\
                    <tr/>\
                ';

                var count = 0;
                $.each(rooms, function (keys, params) {
                    $.each(params, function(key, param) {

                        var name = param.name;
                        var type = param.location_type;

                        localStorage.setItem("location" + param.ID, JSON.stringify(param));

                        // Drop pins
                        var location = {lat: parseFloat(param.lat), lng: parseFloat(param.lng)};

                        var contentString = '\
                        <div id="content">\
                            <div id="siteNotice">\
                            </div>\
                            <h1 id="firstHeading" class="firstHeading">' + param.name + '</h1>\
                            <div id="bodyContent">\
                                <div class="row">';

                        if (count == 0)
                        {
                            map.setCenter(location);
                            map.setZoom(14);
                        }

                        $.each(param.rooms, function(key1, param1) {
                            html += '\
                                <tr>\
                                    <td>' + name + '</td>\
                                    <td>' + type + '</td>\
                                    <td>' + param1.room_description + '</td>\
                                    <td>' + param1.number_of_beds + '</td>\
                                    <td> £ ' + parseFloat(param1.room_price / 100).toFixed(2) + '</td>\
                                    <td><a href="#" class="viewOnMap" data-value="' + param.ID + '">View on map</a></td>\
                                    <td><a href="#" class="viewAndBook" data-value="' + param1.ID + '">View and Book</a></td>\
                                </tr>\
                            ';

                            contentString += '\
                            <div class="col-md-4">\
                                <p>\
                                    '+ param1.room_description + '\
                                </p>\
                                <p>\
                                    Number of beds: ' + param1.number_of_beds +'\
                                    <br>\
                                    Price per night: £ ' + parseFloat(param1.room_price / 100).toFixed(2) + '\
                                <p>\
                                    <button class="btn btn-success viewAndBook" data-value="' + param1.ID + '">Book now</button>\
                                </p>\
                            </div>';

                            localStorage.setItem("room" + param1.ID, JSON.stringify(param1));
                        });

                        contentString += '\
                                </div>\
                            </div>\
                        </div>';

                        var infoWindow = new google.maps.InfoWindow({
                            content: contentString
                        });
                        var marker = new google.maps.Marker({
                            position: location,
                            map: map,
                            title: 'Location'
                        });
                        marker.addListener('click', function() {
                            infoWindow.open(map, marker);
                        });

                        count ++;
                    });
                });

                html += '</table>';

                $('#results').html(html);
            })
            .fail(function(jqXHR, status, thrownError) {
                var responseText = jQuery.parseJSON(jqXHR.responseText);
                $('#error').show().html('\
                    <div class="alert alert-danger">' + responseText.message + '<br>' + responseText.error + '</div>\
                ');
            });
        });

        // View on map
        $('#results').on('click', '.viewOnMap', function (e) {
            e.preventDefault();
            var location = JSON.parse(localStorage.getItem("location" + this.getAttribute('data-value')));
            geocodePlaceId(geocoder, map, infoWindow, location.google_id);
        });

        $('#results').on('click', '.viewAndBook', function (e) {
            e.preventDefault();

            var room = JSON.parse(localStorage.getItem("room" + this.getAttribute('data-value')));
            displayBookings(room);
        });

        $('#map').on('click', '.viewAndBook', function (e) {
            e.preventDefault();

            var room = JSON.parse(localStorage.getItem("room" + this.getAttribute('data-value')));
            displayBookings(room);
        });
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
    }

    function geocodePlaceId(geocoder, map, infowindow, placeId) {
        var placeId = placeId;
        geocoder.geocode({'placeId': placeId}, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    map.setZoom(18);
                    map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });
                    infowindow.setContent(results[0].formatted_address);
                    infowindow.open(map, marker);
                } else {
                    window.alert('No results found');
                }
            } else {
                window.alert('Geocoder failed due to: ' + status);
            }
        });
    }

    function displayBookings(room) {
        roomCalander.initialize($('#roomDateSelector'), room, '<?php echo $this->url('api/book'); ?>', 'dc45c373b4c92bc');
        $('#displayAvailability').click();
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAuK5rdDsSZpXyi5VBjW7g8N1IJUtAXZwA&callback=initMap">
</script>
<!-- Initiate smooth scroll -->
<script src="<?php echo $this->fileUrl('dist/js/smooth-scroll.js'); ?>"></script>
<script>
    smoothScroll.init();
</script>
</body>
</html>