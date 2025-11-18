<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Constants\CountryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Applicant\AccountController;
use App\Http\Controllers\Applicant\EducationQualificationsController;
use App\Http\Controllers\Backend\CourseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
});

;
Route::get('/logout', [AdminController::class, 'Logout'])->name('logout');
Route::middleware(['auth','history','verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



        Route::controller(AdminController::class)->group(function (){

//            Route::get('/admin/dashboard', 'AdminDashboard')->name('admin.dashobard');
            Route::get('/dashboard', 'AdminDashboard')->name('dashboard')->middleware('verified');

            Route::get('/admin/logout', 'AdminDestroy')->name('admin.logout');


            Route::get('/admin/profile',  'AdminProfile')->name('admin.profile');

            Route::post('/admin/profile/store',  'AdminProfileStore')->name('admin.profile.store');
            Route::get('/admin/change/password', 'AdminChangePassword')->name('admin.change.password');
            Route::post('/admin/update/password', 'AdminUpdatePassword')->name('update.password');

            Route::get('/all/admin','AllAdmin')->name('all.admin');
            Route::get('/add/admin','AddAdmin')->name('add.admin');
            Route::post('/store/admin','StoreAdmin')->name('admin.store');
            Route::get('/edit/admin/{id}','EditAdmin')->name('edit.admin');
            Route::post('/update/admin','UpdateAdmin')->name('admin.update');
            Route::get('/delete/admin/{id}','DeleteAdmin')->name('delete.admin');
        });

        Route::controller(RoleController::class)->group(function() {
            Route::get('/all/permission','AllPermission')->name('all.permission');
            Route::get('/add/permission','AddPermission')->name('add.permission');
            Route::post('/store/permission','StorePermission')->name('permission.store');
            Route::get('/edit/permission/{id}','EditPermission')->name('edit.permission');

            Route::post('/update/permission','UpdatePermission')->name('permission.update');
            Route::get('/delete/permission/{id}','DeletePermission')->name('delete.permission');

            Route::get('/all/roles','AllRoles')->name('all.roles');
            Route::get('/add/roles','AddRoles')->name('add.roles');
            Route::post('/store/roles','StoreRoles')->name('roles.store');
            Route::get('/edit/roles/{id}','EditRoles')->name('edit.roles');
            Route::post('/update/roles','UpdateRoles')->name('roles.update');
            Route::get('/delete/roles/{id}','DeleteRoles')->name('delete.roles');



            Route::get('/add/roles/permission','AddRolesPermission')->name('add.roles.permission');
            Route::post('/role/permission/store','StoreRolesPermission')->name('role.permission.store');

            Route::get('/all/roles/permission','AllRolesPermission')->name('all.roles.permission');
            Route::get('/admin/edit/roles/{id}','AdminEditRoles')->name('admin.edit.roles');
            Route::post('/role/permission/update/{id}','RolePermissionUpdate')->name('role.permission.update');
            Route::get('/admin/delete/roles/{id}','AdminDeleteRoles')->name('admin.delete.roles');

        });

    Route::controller(CourseController::class)->group(function() {
        Route::get('/all/courses', 'index')->name('all.courses');              // List all courses
        Route::get('/course/create', 'create')->name('courses.create');        // Show create form
        Route::post('/course/store', 'store')->name('courses.store');          // Save new course
        Route::get('/course/show/{course}', 'show')->name('courses.show');     // View single course
        Route::get('/course/edit/{course}', 'edit')->name('courses.edit');     // Edit form
        Route::put('/course/update/{course}', 'update')->name('courses.update'); // Update course
        Route::delete('/course/delete/{course}', 'destroy')->name('courses.delete'); // Delete course


    });



    Route::prefix('/admin')->namespace('Constants')-> resource('country',CountryController::class);


});


Route::group(['middleware' => ['role:applicant','auth','history','verified']], function () {
    //
    Route::controller(UsersController::class)->group(function (){

//            Route::get('/admin/dashboard', 'AdminDashboard')->name('admin.dashobard');
        Route::get('applicant/dashboard', 'ApplicantDashboard')->name('applicant.dashboard')->middleware('verified');
        Route::get('applicant/dprofile', 'ApplicantDProfile')->name('applicant.dprofile')->middleware('verified');

        //Route::get('/applicant/logout', 'ApplicantDestroy')->name('applicant.logout');
        Route::get('/applicant/logout',  'ApplicantLogout')->name('applicant.logout');

        Route::get('/applicant/profile',  'ApplicantProfile')->name('applicant.profile');

        Route::post('/applicant/profile/store',  'ApplicantProfileStore')->name('applicant.profile.store');
        Route::get('/applicant/change/password', 'ApplicantChangePassword')->name('applicant.change.password');
        Route::post('/applicant/update/password', 'ApplicantUpdatePassword')->name('applicant.update.password');

    });

    Route::group(['middleware' => ['permission:account.menu']], function () {

        Route::controller(AccountController::class)->group(function (){

            Route::get('applicant/register', 'Register')->name('applicant.register');
            Route::post('applicant/register/store',  'RegisterUpdate')->name('register.store');

        });
        Route::controller(EducationQualificationsController::class)->group(function (){

            Route::get('applicant/primary', 'PrimaryEducation')->name('applicant.primaryeducation');
            Route::post('applicant/primary/store',  'PrimaryEducationStore')->name('primaryeducation.store');
            Route::get('applicant/secondary', 'SecondaryEducation')->name('applicant.secondaryeducation');
            Route::post('applicant/secondary/store',  'SecondaryEducationStore')->name('secondaryeducation.store');
            Route::get('applicant/postsecondary', 'PostSecondaryEducation')->name('applicant.postsecondaryeducation');
            Route::post('applicant/postsecondary/store',  'PostSecondaryEducationStore')->name('postsecondaryeducation.store');
            Route::get('applicant/profile/application', 'ProfileSummary')->name('applicant.profileapplication');


        });
    });
});










require __DIR__.'/auth.php';
