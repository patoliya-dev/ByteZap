<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class FaceRecognitionService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function recognizeFace(string $searchFacesPath): array
    {
        $pythonScript = base_path('recognize_faces.py');
        $knownFacesDir = storage_path('app/known_faces');

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
                foreach ($result['recognized'] as $name) {
                    // \DB::table('attendances')->insert([
                    //     'user_id' => '',
                    //     'date' => ,
                    //     'type' => ,
                    //     'created_at' => now(),
                    //     'updated_at' => now(),
                    // ]);
                }
            }

            return response()->json($result);
    }

    /**
     * Save base64 webcam image temporarily and return path.
     */
    public function saveWebcamImage(string $base64Data): string
    {
        $base64_str = substr($base64Data, strpos($base64Data, ",") + 1);
        $image = base64_decode($base64_str);

        $tempPath = 'temp/webcam_' . time() . '.jpg';
        Storage::put($tempPath, $image);

        return storage_path('app/' . $tempPath);
    }
}
