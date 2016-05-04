$(function() {
    localStorage.clear();

    $('#searchPlace').submit(function(e) {
        e.preventDefault();

        var dateFrom = $('#dateFrom').val().split('/');
        dateFrom = dateFrom[2] + '-' + dateFrom[0] + '-' + dateFrom[1];

        var dateTo = $('#dateTo').val().split('/');
        dateTo = dateTo[2] + '-' + dateTo[0] + '-' + dateTo[1];

        var url = $( this ).prop( 'action' ) + 
            '/' + $('#town').val() + '/' 
            + dateFrom + '/' + dateTo + '?api_key=c2f3851b4fc9d0f';

        $.get(url).done(function (rooms) {
            $('#error').hide().html();

            rooms = $.parseJSON(rooms);

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

            $.each(rooms, function (keys, params) {
                $.each(params, function(key, param) {

                    var name = param.name;
                    var type = param.location_type;

                    localStorage.setItem("location" + param.ID, JSON.stringify(param));
                    console.log(JSON.parse(localStorage.getItem("location" + param.ID)));

                    $.each(param.rooms, function(key1, param1) {
                        html += '\
                            <tr>\
                                <td>' + name + '</td>\
                                <td>' + type + '</td>\
                                <td>' + param1.room_description + '</td>\
                                <td>' + param1.number_of_beds + '</td>\
                                <td> £ ' + parseFloat(param1.room_price / 100).toFixed(2) + '</td>\
                                <td><a href="#" id="viewOnMap" data-value="' + param.ID + '">View on map</a></td>\
                                <td><a href="#" id="viewAndBook" data-value="' + param1.ID + '">View and Book</a></td>\
                            </tr>\
                        ';

                        localStorage.setItem("room" + param1.ID, JSON.stringify(param1));
                        console.log(JSON.parse(localStorage.getItem("room" + param1.ID)));
                    });
                });
            });

            html += '</table>';

            $('#results').html(html);
        })
        .fail(function(jqXHR, status, thrownError) {
            var responseText = jQuery.parseJSON(jqXHR.responseText);
            $('#error').show().html('\
                <div class="alert alert-danger">' + responseText.message + '</div>\
            ');
        });
    });

    $('#results').on('click', '#viewAndBook', function (e) {
        e.preventDefault();
    });
});