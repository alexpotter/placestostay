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
    <div id="response" class="col-xs-10 col-xs-offset-1" style="margin-top: 20px; padding: 10px; display: none;">

    </div>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <form method="post" about="<?php echo $this->url('admin/add-room'); ?>" id="newRoom">
            <div class="col-sm-4">
                <div class="form-group">
                    <select name="location" class="form-control">
                        <?php foreach ($locations as $location): ?>
                            <option value="<?php echo $location['ID']; ?>"><?php echo $location['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input class="form-control" name="description" placeholder="Description">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <select name="number_of_beds" class="form-control">
                        <option value="0">Number of beds</option>
                        <?php for($count = 1; $count < 5; $count ++): ?>
                            <option value="<?php echo $count; ?>"><?php echo $count; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-4">
                    <input name="available_to" class="form-control" type="text" id="dateFrom" placeholder="Date To">
                </div>
                <div class="col-md-4">
                    <input name="available_from" type="text" class="form-control" id="dateTo" placeholder="Date From">
                </div>
                <div class="col-md-4">
                    <input type="number" name="price" class="form-control" placeholder="Price per night">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12" style="margin-top: 20px;">
                    <input class="btn btn-success btn-lg" type="submit" value="Add Room">
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-xs-12" id="listRooms"></div>
</div>
<script type="text/javascript">
    function displayRooms(rooms)
    {
        var html  = '\
            <h1 style="text-align: center">Current Rooms</h1>\
            <table class="table" style="margin-top: 20px;">\
                <tr>\
                    <th>Description</th>\
                    <th>Location</th>\
                    <th>Price per night</th>\
                    <th>Available From</th>\
                    <th>Available To</th>\
                    <th>Number of Beds</th>\
                </tr>\
        ';

        rooms = $.parseJSON(rooms);

        $.each(rooms, function(keys, params) {
            $.each(params, function(key, param) {
                var streetNumber = param.street_number == 0 ? '' : param.street_number;

                console.log(param);

                html += '\
                <tr>\
                    <td>' + param.room_description + '</td>\
                    <td>' + param.location_id + '</td>\
                    <td>' + param.room_price / 100 + '</td>\
                    <td>' + param.available_from + '</td>\
                    <td>' + param.available_to + '</td>\
                    <td>' + param.number_of_beds + '</td>\
                </tr>\
            ';
            });
        });

        html += '</table>';

        $('#listRooms').html(html);
    }

    $.get( "<?php echo $this->url('admin/get-rooms'); ?>", function( rooms ) {
        displayRooms(rooms);
    });

    $(function() {
        $('#newRoom').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: $( this ).prop( 'action' ),
                type: 'post',
                dataType: 'json',
                data: $( this).serialize()
            })
            .done(function(response) {
                $('#response').show().html('\
                    <div class="alert alert-success">' + response.message + '</div>\
                ');
                $.get( "<?php echo $this->url('admin/get-rooms'); ?>", function( rooms ) {
                    displayRooms(rooms);
                });
            })
            .fail(function(jqXHR, status, thrownError) {
                var responseText = jQuery.parseJSON(jqXHR.responseText);
                $('#response').show().html('\
                    <div class="alert alert-danger">' + responseText.message + '</div>\
                ');
            });
        });
    });
</script>
</body>
</html>