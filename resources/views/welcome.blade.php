@extends('layouts.app')

@section('title', 'Login Selection')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="row w-100 justify-content-center">

        <!-- User Login Card -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm text-center border-0">
                <div class="card-body">
                    <img src="{{ asset('/user.png') }}" alt="User Login"
                         class="img-fluid mb-3" style="max-height:150px;">
                    <h5 class="mb-3">User Login</h5>
                    <a href="{{ route('manual') }}" class="btn btn-primary w-100">User Attendence</a>
                </div>
            </div>
        </div>

        <!-- Admin Login Card -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm text-center border-0">
                <div class="card-body">
                    <img src="{{ asset('/admin.jpg') }}" alt="Admin Login"
                         class="img-fluid mb-3" style="max-height:150px;">
                    <h5 class="mb-3">Admin Login</h5>
                    <a href="{{ route('login') }}" class="btn btn-dark w-100">Login as Admin</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
