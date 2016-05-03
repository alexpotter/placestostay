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
    <script type="text/javascript" src="<?php echo $this->fileUrl('dist/js/frontend.js'); ?>"></script>

    <!-- Date Stuff -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script>
        $(function() {
            $( "#dateFrom" ).datepicker();
            $( "#dateTo" ).datepicker();
        });
    </script>
</head>
<body>
    <div class="row">
        <div class="col-xs-12" style="text-align: center;">
            <h1>Places to Stay</h1>
            <h2><?php echo $message ?></h2>
        </div>
    </div>
    <div class="row" style="padding-top: 30px;">
        <div class="col-xs-6">
            <div id="map">

            </div>
        </div>
        <div class="col-xs-6">
            <form class="form-horizontal" id="searchPlace">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <h2 style="text-align: center;">Search a place:</h2>
                            <input type="text" name="location" class="form-control" style="font-size: 22pt; height: 60px;" placeholder="Location">
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
                        <button type="submit" class="btn btn-lg btn-success" style="display: block; margin: auto;">Search</button>
                    </div>
                </div>
            </form>
            <div id="results">

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
        }

        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                'Error: The Geolocation service failed.' :
                'Error: Your browser doesn\'t support geolocation.');
        }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAuK5rdDsSZpXyi5VBjW7g8N1IJUtAXZwA&callback=initMap">
    </script>
</body>
</html>