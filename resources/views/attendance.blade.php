<!DOCTYPE html>
<html>
<head>
    <title>Bytezap Attendance</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Bytezap Attendance</h4>
                    </div>
                    <div class="card-body text-center">

                        <div class="form-group">
                            <label for="photo" class="font-weight-bold">Upload Your Photo</label>
                            <input type="file" class="form-control-file border p-3 rounded" id="photo" accept="image/*">
                        </div>

                        <button id="uploadBtn" class="btn btn-primary btn-block mt-3">
                            Mark Attendance
                        </button>

                        <div id="loader" class="mt-3 d-none">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <p class="mt-2">Checking attendance, please wait...</p>
                        </div>
                        <div id="result" class="mt-4 alert d-none"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#uploadBtn').click(function(){
            var fileInput = $('#photo')[0].files[0];
            if(!fileInput){
                $('#result').removeClass('d-none alert-success').addClass('alert alert-danger')
                    .html("⚠️ Please select a photo before uploading.");
                return;
            }

            var formData = new FormData();
            formData.append('photo', fileInput);
            
            $('#loader').removeClass('d-none');
            $('#result').addClass('d-none');


            $.ajax({
                url: '/mark-attendance',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    $('#loader').addClass('d-none');
                    $('#result').removeClass('d-none alert-danger')
                        .addClass('alert alert-success')
                        .html("✅ " + data.message);
                },
                error: function(){
                    $('#loader').addClass('d-none');
                    $('#result').removeClass('d-none alert-success')
                        .addClass('alert alert-danger')
                        .html("❌ Something went wrong. Please try again.");
                }
            });
        });
    </script>

</body>
</html>
