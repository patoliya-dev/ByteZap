<div class="container">
    <h1>Users</h1>
    <table id="users-table" class="display">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Profile Image</th>
            </tr>
        </thead>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('users.data') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { 
                    data: 'profile_image', 
                    name: 'profile_image',
                    render: function(data, type, full, meta) {
                        if(data){
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