@extends('layouts.app')
@section('title', 'Register')
@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4>Register</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('register.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror" required>
                        <div class="invalid-feedback">
                            @error('name') {{ $message }} @else Name is required. @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                       <label for="email" class="form-label">Email Address</label>
                       <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" required>
                       <div class="invalid-feedback">
                           @error('email') {{ $message }} @else Enter a valid email. @enderror
                       </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password (min 6 characters)</label>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" required minlength="6">
                        <div class="invalid-feedback">
                            @error('password') {{ $message }} @else Password must be at least 6 characters. @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="profile_image" class="form-label">Profile Image</label>
                        <input type="file" name="profile_image" id="profile_image"
                            class="form-control @error('profile_image') is-invalid @enderror"
                            accept="image/png, image/jpeg">
                        <small class="form-text text-muted">Allowed: JPG, PNG. Max: 2MB.</small>
                        <div class="invalid-feedback">
                            @error('profile_image') {{ $message }} @enderror
                        </div>
                        <!-- Image preview -->
                        <img id="imagePreview" src="#" alt="Image Preview"
                            style="display:none; max-width: 150px; margin-top: 10px;">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
                <script>
                    (() => {
                        'use strict';
                        // Bootstrap form validation
                        const forms = document.querySelectorAll('.needs-validation');
                        Array.from(forms).forEach(form => {
                            form.addEventListener('submit', event => {
                                if (!form.checkValidity()) {
                                    event.preventDefault();
                                    event.stopPropagation();
                                }
                                form.classList.add('was-validated');
                            }, false);
                        });
                        // Image preview logic
                        const profileImageInput = document.getElementById('profile_image');
                        const imagePreview = document.getElementById('imagePreview');
                        profileImageInput.addEventListener('change', function() {
                            const file = this.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    imagePreview.src = e.target.result;
                                    imagePreview.style.display = 'block';
                                }
                                reader.readAsDataURL(file);
                            } else {
                                imagePreview.style.display = 'none';
                            }
                        });
                    })();
                </script>
            </div>
        </div>
    </div>
</div>
@endsection