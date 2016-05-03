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
            + dateFrom + '/' + dateTo + '?api_key=b9b6cb5b0f322d9';

        $.get(url)
            .done(function (data) {
                // Display data here
            });
    });
});