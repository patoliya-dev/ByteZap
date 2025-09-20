<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class AttendanceExport implements FromCollection, WithHeadings
{
    public $filter;

    public function __construct($filter = null)
    {
        $this->filter = $filter;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Attendance::with('user')->select('id', 'user_id', 'date', 'type');

        // Apply filter
       if ($this->filter === 'daily') {
            $query->whereDate('date', Carbon::today());
        } elseif ($this->filter === 'weekly') {
            $query->whereBetween('date', [Carbon::now()->subDays(7), Carbon::today()]);
        }

        $id = 1;
         return $query->get()->map(function ($record) use (&$id) {
            return [
                'Id' => $id++,
                'Name' => $record->user->name,
                'Email' => $record->user->email,
                'Date' => Carbon::parse($record->date)->format('Y-m-d'),
                'type' => $record->type,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Attendance ID',
            'User Name',
            'Email',
            'Date',
            'type',
        ];
    }
}
