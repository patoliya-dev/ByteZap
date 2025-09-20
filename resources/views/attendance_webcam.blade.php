<!DOCTYPE html>
<html>
<head>
    <title>Webcam Attendance</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Bytezap Webcam Attendance</h4>
        </div>
        <div class="card-body text-center">
            <video id="webcam" autoplay playsinline muted class="mb-3 border rounded" width="320" height="240"></video>
            <br>
            <button id="captureBtn" class="btn btn-primary">Mark Attendance</button>
            <div class="mt-3" id="result"></div>
        </div>
    </div>
</div>

<script>
navigator.mediaDevices.getUserMedia({ video: true })
.then(stream => { document.getElementById('webcam').srcObject = stream; });

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$('#captureBtn').click(function(){
    const video = document.getElementById('webcam');
    const canvas = document.createElement('canvas');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);
    const dataUrl = canvas.toDataURL('image/jpeg');

    $.ajax({
        url: '/webcam-attendance',
        type: 'POST',
        data: { photo: dataUrl },
        success: function(data){
            let alertClass = data.status === 'success' ? 'alert-success' : 'alert-danger';
            $('#result').html('<div class="alert '+alertClass+'">'+data.message+'</div>');
        }
    });
});
</script>

</body>
</html>

