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
use App\Http\Controllers\Backend\TrainingController;
use App\Http\Controllers\public\TrainingPublicController;
use App\Http\Controllers\Backend\CountyController;
use App\Http\Controllers\Backend\SubcountyController;
use App\Http\Controllers\Backend\PostalCodeController;
use App\Http\Controllers\Backend\RequirementController;
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

Route::get('/training/scheduled', [TrainingPublicController::class, 'index'])
    ->name('public.trainings');

Route::get('/verify-otp', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'showOtpForm'])
    ->name('otp.verify.form');

Route::post('/verify-otp', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'verifyOtp'])
    ->name('otp.verify');
Route::get('/resend-otp', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'resendOtp'])->name('otp.resend');

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


    Route::controller(RequirementController::class)->group(function () {
        Route::get('/courses/{course}/requirements/create', 'create')->name('courses.requirements.create');
        Route::post('/courses/{course}/requirements', 'store')->name('courses.requirements.store');
        Route::delete('/courses/{course}/requirements/{requirement}', 'destroy')->name('courses.requirements.delete');
    });

    Route::controller(TrainingController::class)->group(function() {
        Route::get('/all/trainings', 'index')->name('all.trainings');                     // List all trainings
        Route::get('/training/create', 'create')->name('trainings.create');               // Show create form
        Route::post('/training/store', 'store')->name('trainings.store');                 // Store new training
        Route::get('/training/show/{training}', 'show')->name('trainings.show');          // View single training
        Route::get('/training/edit/{training}', 'edit')->name('trainings.edit');          // Edit training
        Route::put('/training/update/{training}', 'update')->name('trainings.update');    // Update training
        Route::delete('/training/delete/{training}', 'destroy')->name('trainings.delete'); // Delete training


        Route::post('/training/{training}/submit-for-approval', 'submitForApproval')->name('trainings.submit');

        // 🔸 Registrar view pending trainings
     Route::get('/registrar/trainings/pending', 'registrarIndex')->name('registrar.trainings.pending')
        ->middleware('role:campus_registrar|kihbt_registrar|superadmin');

    });



    Route::middleware(['auth'])->prefix('admin')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Counties
        |--------------------------------------------------------------------------
        */
        Route::get('/counties', [CountyController::class, 'index'])
            ->name('backend.counties.index');

        Route::get('/counties/create', [CountyController::class, 'create'])
            ->name('backend.counties.create');

        Route::post('/counties/store', [CountyController::class, 'store'])
            ->name('backend.counties.store');

        Route::get('/counties/{county}/edit', [CountyController::class, 'edit'])
            ->name('backend.counties.edit');

        Route::post('/counties/{county}/update', [CountyController::class, 'update'])
            ->name('backend.counties.update');

        Route::delete('/counties/{county}/destroy', [CountyController::class, 'destroy'])
            ->name('backend.counties.destroy');


        /*
        |--------------------------------------------------------------------------
        | Subcounties
        |--------------------------------------------------------------------------
        */
        Route::get('/subcounties', [SubcountyController::class, 'index'])
            ->name('backend.subcounties.index');

        Route::get('/subcounties/create', [SubcountyController::class, 'create'])
            ->name('backend.subcounties.create');

        Route::post('/subcounties/store', [SubcountyController::class, 'store'])
            ->name('backend.subcounties.store');

        Route::get('/subcounties/{subcounty}/edit', [SubcountyController::class, 'edit'])
            ->name('backend.subcounties.edit');

        Route::post('/subcounties/{subcounty}/update', [SubcountyController::class, 'update'])
            ->name('backend.subcounties.update');

        Route::delete('/subcounties/{subcounty}/destroy', [SubcountyController::class, 'destroy'])
            ->name('backend.subcounties.destroy');



        /*
     |--------------------------------------------------------------------------
     | Postal Codes
     |--------------------------------------------------------------------------
     */

        Route::get('/postal-codes', [PostalCodeController::class, 'index'])
            ->name('backend.postal_codes.index');

        Route::get('/postal-codes/create', [PostalCodeController::class, 'create'])
            ->name('backend.postal_codes.create');

        Route::post('/postal-codes/store', [PostalCodeController::class, 'store'])
            ->name('backend.postal_codes.store');

        Route::get('/postal-codes/{postal_code}/edit', [PostalCodeController::class, 'edit'])
            ->name('backend.postal_codes.edit');

        Route::post('/postal-codes/{postal_code}/update', [PostalCodeController::class, 'update'])
            ->name('backend.postal_codes.update');

        Route::delete('/postal-codes/{postal_code}/destroy', [PostalCodeController::class, 'destroy'])
            ->name('backend.postal_codes.destroy');
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
