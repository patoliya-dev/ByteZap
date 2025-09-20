<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class AttendanceExportController extends Controller
{
    public function exportAttendance($filter = 'daily')
    {
        $base = $filter == 'weekly' ? 'attendance_weekly' : 'attendance_daily';

        $stamp = Carbon::now()->format('YmdHis');

        $filename = "{$base}_{$stamp}.csv";

        return Excel::download(new AttendanceExport($filter), $filename);
    }
}
