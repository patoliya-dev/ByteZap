@extends('layouts.app')

@section('title', 'Attendance Dashboard')

@section('content')
    {{-- Users lists --}}
    @include('attendance.users')
@endsection
