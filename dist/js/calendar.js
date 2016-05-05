$(function() {
    $('#roomDateSelector').on('click', '.selected', function() {
        if (roomCalander.canBook != false) {
            roomCalander.selectedTo = $(this).attr("data-value");
            roomCalander.makeBooking();
        }
    });
});

window.roomCalander = {
    initialize: function(div, room, endpoint, apiKey) {
        this.calander = div;
        this.room = room;
        this.endPoint = endpoint;
        this.apiKey = apiKey;

        var dateFrom = localStorage.getItem('dateFrom').split('/');
        this.dateFrom  = new Date(dateFrom[2], dateFrom[0] - 1, dateFrom[1]);

        var dateTo = localStorage.getItem('dateTo').split('/');
        this.dateTo  = new Date(dateTo[2], dateTo[0] - 1, dateTo[1]);

        this.selectedFrom = null;
        this.selectedTo = null;
        this.selectedFromElement = null;
        this.canBook = false;

        var oneDay = 24*60*60*1000;
        this.daysWithinRange = Math.round(Math.abs((this.dateFrom.getTime() - this.dateTo.getTime())/(oneDay)));

        var bookedDays = [];

        $.each(this.room.bookedDates, function(key, param) {
            var start = param.start.split('-');
            start = new Date(start[0], start[1] - 1, start[2]);

            var end = param.end.split('-');
            end = new Date(end[0], end[1] - 1, end[2]);

            for (var date = start; date <= end; date.setDate(date.getDate() + 1)) {
                bookedDays.push(date.toJSON());
            }
        });

        this.weekday = new Array(7);
        this.weekday[0] = "Sunday";
        this.weekday[1] = "Monday";
        this.weekday[2] = "Tuesday";
        this.weekday[3] = "Wednesday";
        this.weekday[4] = "Thursday";
        this.weekday[5] = "Friday";
        this.weekday[6] = "Saturday";

        this.monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        this.bookedDays = bookedDays;
        this.drawDates();

        var availableDays = document.getElementsByClassName('available');

        for (var count = 0; count < availableDays.length; count ++) {
            availableDays[count].addEventListener('click', this.selectClickedDate, false);
            availableDays[count].addEventListener('mouseover', this.changeDatesOnMouseOver, false);
        }

        var bookedDays = document.getElementsByClassName('booked');

        for (var count = 0; count < bookedDays.length; count ++) {
            bookedDays[count].addEventListener('click', this.showSelectorError, false);
        }
    },

    drawDates: function() {
        var html = '';
        var count = 0;

        for (var date = new Date(Date.parse(this.dateFrom.toDateString())); date <= this.dateTo; date.setDate(date.getDate() + 1)) {
            var cssClass = $.inArray(date.toJSON(), this.bookedDays) === -1 ? 'available' : 'booked';

            html += '\
                        <div class="col-md-3" style="padding: 10px 0;">\
                            <div id="day-' + count + '" data-value="' + date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + '" style="cursor: pointer; border: solid 1px #000; border-radius: 5px; margin: 0 10px;" class="' + cssClass + '">\
                                <p style="font-size: 26pt; text-align: center;">' + this.weekday[date.getDay()] + '</p>\
                                <p style="font-size: 34pt; text-align: center;">' + date.getDate() + '</p>\
                                <p style="font-size: 26pt; text-align: center;">' + this.monthNames[date.getMonth()] + '</p>\
                            </div>\
                        </div>\
                    ';
            count ++;
        }

        this.calander.html(html);
    },

    showSelectorError: function() {
        alert('Sorry, this day has already been booked.')
    },

    selectClickedDate: function() {
        if (roomCalander.selectedFrom == null) {
            $(this).removeClass('available');
            $(this).addClass('selected');
            roomCalander.selectedFrom = $(this).attr("data-value");
            roomCalander.selectedFromElement = $(this).attr('id');

            setTimeout(function() {
                roomCalander.canBook = true;
            }, 200);
        }
    },

    changeDatesOnMouseOver: function() {
        if (roomCalander.selectedFrom != null) {
            var selectedFromElementId = roomCalander.selectedFromElement.split('-');
            var selectedFromId = selectedFromElementId[1];

            var currentHoverElementId = $(this).attr('id').split('-');
            var currentHoverId = currentHoverElementId[1];

            for (var count = selectedFromId; count <= roomCalander.daysWithinRange; count ++) {
                if (selectedFromId != currentHoverId) {
                    if ($('#day-' + count).attr('class') != 'booked'  && (count <= currentHoverId) || (count > selectedFromElementId )) {
                        $('#day-' + count).addClass('selected');
                        $('#day-' + count).removeClass('available');
                    }
                    else if ($('#day-' + count).attr('class') != 'booked'  && ((count >= currentHoverId) || (count => selectedFromElementId))) {
                        $('#day-' + count).addClass('available');
                        $('#day-' + count).removeClass('selected');
                    }
                }
            }
        }
    },

    makeBooking: function() {
        this.canBook = false;

        $.ajax({
            url: roomCalander.endPoint + '?api_key=' + roomCalander.apiKey,
            type: 'post',
            dataType: 'json',
            data: {
            room_id: roomCalander.room.ID,
                date_from: roomCalander.selectedFrom,
                date_to: roomCalander.selectedTo,
                user_id: 1
            }
        })
        .done(function(response) {
            $('#roomDateSelector').html('\
                <div class="alert alert-success">Booking successfully made</div>\
                <div class="col-xs-12" style="font-size: 14pt">\
                    <table class="table">\
                        <tr>\
                            <td>Booking ID</td>\
                            <td>' + response.booking.ID + '</td>\
                        </tr>\
                        <tr>\
                            <td>From</td>\
                            <td>' + response.booking.date_from + '</td>\
                        </tr>\
                        <tr>\
                            <td>To</td>\
                            <td>' + response.booking.date_to + '</td>\
                        </tr>\
                        <tr>\
                            <td>Paid</td>\
                            <td>' + parseFloat(response.booking.price_paid / 100).toFixed(2) + '</td>\
                        </tr>\
                        <tr>\
                            <td>Location</td>\
                            <td>\
                                ' + response.booking.room.location.name + '<br>\
                                ' + response.booking.room.location.address_line1 + '<br>\
                                ' + response.booking.room.location.town + '<br>\
                                ' + response.booking.room.location.postcode + '<br>\
                                ' + response.booking.room.location.country + '\
                            </td>\
                        </tr>\
                        <tr>\
                            <td>Room</td>\
                            <td>\
                                Number of beds: ' + response.booking.room.number_of_beds + '</br>\
                                ' + response.booking.room.room_description + '\
                            </td>\
                        </tr>\
                    </table>\
                </div>\
            ');
        })
        .fail(function(jqXHR, status, thrownError) {
            var responseText = jQuery.parseJSON(jqXHR.responseText);

            alert(responseText.message);
            roomCalander.calander.html('');
            roomCalander.initialize(roomCalander.calander, roomCalander.room, roomCalander.endPoint);
        });
    }
};