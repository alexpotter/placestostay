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
            .done(function (data) {
                // Display data here
            });
    });
});