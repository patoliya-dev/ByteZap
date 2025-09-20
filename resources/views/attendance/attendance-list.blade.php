    @extends('layouts.app')

@section('title', 'Attendance Dashboard')

@section('content')
    {{-- Users lists --}}
    @include('attendance.attendances')
@endsection
