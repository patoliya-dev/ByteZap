<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\JsonResponse;
use App\Services\FaceRecognitionService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    protected $faceService;

    public function __construct(FaceRecognitionService $faceService)
    {
        $this->faceService = $faceService;
    }
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

    public function showManualForm()
    {
        return view('attendance');
    }


    public function markAttendance(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);

        try {
            $file = $request->file('photo');
            $path = $file->store('uploads', 'public');
            $searchFacesPath = storage_path("app/public/{$path}");
            $pythonScript = base_path('recognize_faces.py');
            $knownFacesDir = storage_path('app/public/profiles');

            \Log::info('Python script & directories', [
                'pythonScript'   => $pythonScript,
                'knownFacesDir'  => $knownFacesDir,
                'searchFacesDir' => $searchFacesPath,
            ]);

            $command = escapeshellcmd("python3 {$pythonScript} {$searchFacesPath} {$knownFacesDir}");
            $output = shell_exec($command);

            if (!$output) {
                \Log::error('Python script did not return output');
                return response()->json(['status' => 'error', 'message' => 'Face recognition failed.'], 500);
            }

            $result = json_decode($output, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                \Log::error('Invalid JSON returned from Python script', ['output' => $output]);
                return response()->json(['status' => 'error', 'message' => 'Invalid response from recognition script.'], 500);
            }

            if (!empty($result['status']) && $result['status'] === 'success') {
                foreach ($result['recognized'] as $userId) {
                    $today = now()->toDateString();
                    $alreadyMarked = \DB::table('attendances')
                        ->where('user_id', $userId)
                        ->whereDate('date', $today)
                        ->exists();

                    if ($alreadyMarked) {
                        
                        $userName = \DB::table('users')
    ->where('id', $userId)
    ->value('name');

                        \Log::info("Attendance already marked", ['user_id' => $userId, 'date' => $today]);

                        return response()->json([
                            'status'  => 'info',
                            'message' => "Attendance already marked today for user {$userName}.",
                        ], 200);
                    }

                    \DB::table('attendances')->insert([
                        'user_id' => $userId,
                        'date' => now(),
                        'type' => 'manual',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Attendance marked successfully! ',
                ], 200);
            }
            return response()->json($result);

        } catch (\Throwable $e) {
            \Log::error('Attendance marking failed', ['error' => $e->getMessage()]);
            return response()->json([
                'status'  => 'error',
                'message' => 'An error occurred while marking attendance.',
            ], 500);
        }
    }

    public function showWebcamForm()
    {
        return view('attendance_webcam');
    }

    public function markFromWebcam(Request $request)
    {
        $request->validate([
            'photo' => 'required|string'
        ]);

        $data = $request->photo;
        $base64_str = substr($data, strpos($data, ",") + 1);
        $image = base64_decode($base64_str);
        $tempPath = storage_path('app/temp_webcam_' . time() . '.jpg');
        file_put_contents($tempPath, $image);

        $pythonScript = base_path('recognize_faces.py');
        \Log::info('$pythonScript', ['$pythonScript' => $pythonScript]);
        $knownFacesDir = storage_path('app/public/profiles');
        \Log::info('$knownFacesDir', ['$knownFacesDir' => $knownFacesDir]);

        $command = escapeshellcmd("python3 $pythonScript " . $tempPath . " $knownFacesDir");
        $output = shell_exec($command);
        $result = json_decode($output, true);

        if ($result['status'] == 'success') {
            foreach ($result['recognized'] as $userId) {

                $today = now()->toDateString();
                $alreadyMarked = \DB::table('attendances')
                    ->where('user_id', $userId)
                    ->whereDate('date', $today)
                    ->exists();

                if ($alreadyMarked) {
                    \Log::info("Attendance already marked", ['user_id' => $userId, 'date' => $today]);

                    return response()->json([
                        'status'  => 'info',
                        'message' => "Attendance already marked today for user {$userId}.",
                    ], 200);
                }


                \DB::table('attendances')->insert([
                    'user_id' => $userId,
                    'date' => now(),
                    'type' => 'webcam',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Attendance marked successfully! ',
        ], 200);
    }
}
