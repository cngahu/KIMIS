<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentProfileController extends Controller
{
    public function show()
    {
        $student = Student::with('profile')
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('student.profile.show', compact('student'));
    }

    public function updatePhoto0(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();

        $path = $request->file('photo')
            ->store('profile_photos', 'public');

        // Optional: delete old photo
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->update(['photo' => $path]);

        return back()->with('success', 'Profile photo updated successfully.');
    }
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();

        // Ensure directory exists
        $uploadPath = public_path('upload/admin_images');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Delete old photo if exists
        if (!empty($user->photo)) {
            $oldPath = $uploadPath . '/' . $user->photo;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Generate filename
        $filename = time() . '_' . uniqid() . '.' .
            $request->file('photo')->getClientOriginalExtension();

        // Move file
        $request->file('photo')->move($uploadPath, $filename);

        // Save filename only
        $user->update([
            'photo' => $filename,
        ]);

        return back()->with('success', 'Profile photo updated successfully.');
    }

}

