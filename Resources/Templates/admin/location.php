<!html>
<html>
<head>
    <title>Places to Stay Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- jQuery -->
    <script src="<?php echo $this->fileUrl('dist/js/jquery.min.js'); ?>"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo $this->fileUrl('bootstrap/css/bootstrap.css'); ?>">
    <script type="text/javascript" src="<?php echo $this->fileUrl('bootstrap/js/bootstrap.js'); ?>"></script>
    <!-- Custom scripts -->
    <link rel="stylesheet" href="<?php echo $this->fileUrl('dist/css/style.css'); ?>">
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $this->url('admin'); ?>">Places to Stay Admin</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo $this->url('admin/add-location'); ?>">Add Location</a></li>
                <li><a href="<?php echo $this->url('admin/add-room'); ?>">Add Room</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Account <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">API Settings</a></li>
                        <li><a href="<?php echo $this->url('admin/logout'); ?>">Log out</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="row">
    <div class="col-md-6">
        <div id="map">

        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-8 col-md-offset-2" style="padding-top: 20px;">
                <input class="form-control" type="text" name="location" id="location" type="text" placeholder="Enter a location" style="font-size: 22pt; height: 60px;">
            </div>
        </div>
        <div class="row">
            <div id="response" class="col-xs-10 col-xs-offset-1" style="margin-top: 20px; padding: 10px; display: none;">

            </div>
        </div>
        <div class="row">
            <div id="details" style="clear: both; padding-top: 20px;">

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12" id="listLocations">

    </div>
</div>
<script>
    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 51.5074, lng: 0.1278},
            zoom: 8
        });
        var input = /** @type {!HTMLInputElement} */(
            document.getElementById('location'));

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function() {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();

            // DO RESPONSE
            displayResponse(place);

            if (!place.geometry) {
                window.alert("Autocomplete's returned place contains no geometry");
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }
            marker.setIcon(/** @type {google.maps.Icon} */({
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(35, 35)
            }));
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }

            infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
            infowindow.open(map, marker);
        });
    }

    function displayResponse(place) {

        var components= {};

        $.each(place.address_components, function(key, value) {
            $.each(value.types, function(key2, value2) {
                components[value2] = value.long_name
            });
        });

        var street_number = (typeof components.street_number !== 'undefined') ? components.street_number : '';
        var addressLine1 = (typeof components.route !== 'undefined') ? components.route : '';
        var town = (typeof components.postal_town !== 'undefined') ? components.postal_town : components.administrative_area_level_1;
        var postcode = (typeof components.postal_code !== 'undefined') ? components.postal_code : '';
        var country = (typeof components.country !== 'undefined') ? components.country : '';
        var url = '<?php echo $this->url('admin/add-location'); ?>';

        $('#details').html('\
            <div class="col-sm-10 col-sm-offset-1">\
                <form action="' + url + '" method="post" id="addLocation">\
                    <input type="hidden" name="google_id" value="' + place.place_id + '">\
                    <input type="hidden" name="lat" value="' + place.geometry.location.lat() + '">\
                    <input type="hidden" name="long" value="' + place.geometry.location.lng() + '">\
                    <div class="form-group">\
                        <input type="text" name="name" class="form-control" placeholder="Name" value="' + place.name + '">\
                    </div>\
                    <div class="form-group">\
                        <input type="text" name="streetNumber" class="form-control" placeholder="Street Number" value="' + street_number + '">\
                    </div>\
                    <div class="form-group"> \
                        <input type="text" name="addressLine1" class="form-control" placeholder="Address Line 1" value="' + addressLine1 + '">\
                    </div>\
                    <div class="form-group"> \
                        <input type="text" name="town" class="form-control" placeholder="Town" value="' + town + '">\
                    </div>\
                    <div class="form-group"> \
                        <input type="text" name="postcode" class="form-control" placeholder="Postcode" value="' + postcode + '">\
                    </div>\
                    <div class="form-group"> \
                        <input type="text" name="country" class="form-control" placeholder="Country" value="' + country + '">\
                    </div>\
                    <div class="form-group">\
                        <select name="location_type" class="form-control">\
                            <option value="0">Location Type</option>\
                            <option value="Hostel">Hostel</option>\
                            <option value="Hotel">Hotel</option>\
                            <option value="Bed and Breakfast">Bed and Breakfast</option>\
                        </select>\
                    </div>\
                    <div class="form-group">\
                        <button type="submit" class="btn btn-lg btn-success">Submit</button>\
                    </div>\
                </form>\
            </div>\
        ');
    }

    function displayLocations(locations)
    {
        var html  = '\
            <h1 style="text-align: center">Current Locations</h1>\
            <table class="table" style="margin-top: 20px;">\
                <tr>\
                    <th>Name</th>\
                    <th>Street Number</th>\
                    <th>Address Line 1</th>\
                    <th>Town/City</th>\
                    <th>Postcode</th>\
                    <th>Country</th>\
                    <th>Location Type</th>\
                </tr>\
        ';

        $.each(locations, function(keys, params) {
            $.each(params, function(key, param) {
                var streetNumber = param.street_number == 0 ? '' : param.street_number;

                html += '\
                <tr>\
                    <td>' + param.name + '</td>\
                    <td>' + streetNumber + '</td>\
                    <td>' + param.address_line1 + '</td>\
                    <td>' + param.town + '</td>\
                    <td>' + param.postcode + '</td>\
                    <td>' + param.country + '</td>\
                    <td>' + param.location_type + '</td>\
                </tr>\
            ';
            });
        });

        html += '</table>';

        $('#listLocations').html(html);
    }

    $(function() {
        $('#details').on('submit', '#addLocation', function(e) {
            e.preventDefault();

            $.ajax({
                url: $( this ).prop( 'action' ),
                type: 'post',
                dataType: 'json',
                data: $( this ).serialize()
            })
            .done(function(response) {
                if ($('#response').hasClass('alert-danger')) {
                    $('#response').removeClass('alert-danger');
                }
                $('#response').addClass('alert-success').css('display', 'block').html(response.message);
                $.get( "<?php echo $this->url('admin/get-locations'); ?>", function( locations ) {
                    displayLocations(locations);
                });
            })
            .fail(function(jqXHR, status, thrownError) {
                var responseText = jQuery.parseJSON(jqXHR.responseText);
                if ($('#response').hasClass('alert-success')) {
                    $('#response').removeClass('alert-success');
                }
                $('#response').addClass('alert-danger').css('display', 'block').html(responseText.message);
            });
        });

        $.get( "<?php echo $this->url('admin/get-locations'); ?>", function( locations ) {
            displayLocations(locations);
        });
    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAuK5rdDsSZpXyi5VBjW7g8N1IJUtAXZwA&libraries=places&callback=initMap"
        async defer></script>
</body>
</html>