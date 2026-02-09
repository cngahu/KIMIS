<?php
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\Master\MasterdataController;


Route::get('/masterdata', [MasterdataController::class, 'index'])
    ->name('masterdata.index');
Route::get('/masterdata/create', [MasterdataController::class, 'create'])
    ->name('masterdata.create');

Route::post('/masterdata/store', [MasterdataController::class, 'store'])
    ->name('masterdata.store');
Route::get('/colleges/{college}/departments', function ($collegeId) {
    return \App\Models\AcademicDepartment::where('college_id', $collegeId)
        ->orderBy('name')
        ->get();
})->name('college.departments');
Route::get('/colleges/{college}/courses', function ($collegeId) {
    return \App\Models\Course::where('college_id', $collegeId)
        ->where('course_mode', 'Long Term')
        ->orderBy('course_name')
        ->get();
})->name('college.courses');


Route::get('/courses/{course}/cohorts', function ($courseId) {
    return \App\Models\CourseCohort::where('course_id', $courseId)
        ->orderBy('intake_year')
        ->orderBy('intake_month')
        ->get();
})->name('course.cohorts');
