$(document).ready(function() {

    function exportAttendance(filter) {
        let url = `/attendance/export/${filter}`;

        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                console.log('export request completed successfully');
            },
            error: function (xhr, status, error) {
                console.error(`Failed to export attendance (${filter}): ${error}`);
            }
        });
    }

    $('#daily').click(function() {
        exportAttendance('daily');
    });

    $('#weekly').click(function() {
        exportAttendance('weekly');
    });

});
