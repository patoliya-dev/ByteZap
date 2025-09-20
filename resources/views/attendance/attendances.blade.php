<div class="container">
    <h1>Attendance List</h1>
    <div class="mb-3">
        <button id="daily" class="btn btn-primary">Export Daily Attendance</button>
        <button id="weekly" class="btn btn-primary">Export Weekly Attendance</button>
    </div>
    <table id="attendance-table" class="display">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Date</th>
                <th>Type</th>
                <th>Profile Image</th>
            </tr>
        </thead>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="{{ asset('js/attendance-export.js') }}"></script>

<script>
$(function() {
    $('#attendance-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('getattendance.data') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'user_name', name: 'user.name' },
            { data: 'user_email', name: 'user.email' },
            { data: 'date', name: 'date' },
            { data: 'type', name: 'type' },
            {
                data: 'profile_image',
                name: 'profile_image',
                render: function(data) {
                    if (data) {
                        return '<img src="/storage/' + data + '" width="50" height="50" style="border-radius:50%">';
                    }
                    return '<img src="/storage/profiles/default.png" width="50" height="50" style="border-radius:50%">';
                },
                orderable: false,
                searchable: false
            }
        ]
    });
});
</script>
