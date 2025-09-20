<?php

namespace App\Http\Controllers;

use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\JsonResponse;

class AttendanceController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return view('attendance.dashboard');
        }
        return redirect()->route('login');
    }

    public function getUsersData(): JsonResponse
    {
        $users = User::select(['id', 'name', 'email', 'profile_image'])->where('is_admin', false);
        return DataTables::eloquent($users)->toJson();
    }

     public function attendanceData()
    {

        return view('attendance.attendance-list');
    }
     public function getAttendanceData()
    {

        $attendances = Attendance::with('user')
            ->select('attendances.id', 'attendances.user_id', 'attendances.date', 'attendances.type');

        return DataTables::eloquent($attendances)
            // add columns from related user
            ->addColumn('user_name', fn($row) => $row->user?->name)
            ->addColumn('user_email', fn($row) => $row->user?->email)
            ->addColumn('profile_image', fn($row) => $row->user?->profile_image)
            ->toJson();
    }
}

