<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class AttendanceController extends Controller
{
    public function index()
    {   
        return view('attendance.dashboard');
    }

    public function getUsersData()
    {
        $users = User::select(['id', 'name', 'email', 'profile_image'])->where('is_admin', false);
        return DataTables::eloquent($users)->toJson();
    }
}

