$(function() {
    $('#searchPlace').submit(function(e) {
        $('#results').html('<h3>List here</h3>');
        e.preventDefault();

        var dateFrom = $('#dateFrom').val().split('/');
        dateFrom = dateFrom[2] + '-' + dateFrom[0] + '-' + dateFrom[1];

        var dateTo = $('#dateTo').val().split('/');
        dateTo = dateTo[2] + '-' + dateTo[0] + '-' + dateTo[1];

        var url = $( this ).prop( 'action' ) + 
            '/' + $('#town').val() + '/' 
            + dateFrom + '/' + dateTo + '?api_key=c2f3851b4fc9d0f';

        $.get(url)
            .done(function (rooms) {
                rooms = $.parseJSON(rooms);

                var html = '\
                    <table class="table">\
                        <tr>\
                            <th>Location</th>\
                            <th>Type</th>\
                            <th>Room Description</th>\
                            <th>Beds</th>\
                            <th>Price per night</th>>\
                        <tr/>\
                ';

                $.each(rooms, function (keys, params) {
                    $.each(params, function(key, param) {

                        var name = param.name;
                        var type = param.location_type;

                        $.each(param.rooms, function(key1, param1) {
                            html += '\
                                <tr>\
                                    <td>' + name + '</td>\
                                    <td>' + type + '</td>\
                                    <td>' + param1.room_description + '</td>\
                                    <td>' + param1.number_of_beds + '</td>\
                                    <td> £ ' + param1.room_price / 100 + '</td>\
                                </tr>\
                            ';
                            
                            localStorage.setItem("room" + param1.ID, JSON.stringify(param1));
                            console.log(JSON.parse(localStorage.getItem("room" + param1.ID)));
                        });
                    });
                });

                $('#results').html(html);
            });
    });
});