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
}

