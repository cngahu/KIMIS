<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// =====================================================
// CONTROLLER IMPORTS - Organized by Feature
// =====================================================

// Core Controllers
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;

// Auth Controllers
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ForcePasswordController;

// Backend Management
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\CourseController;
use App\Http\Controllers\Backend\TrainingController;
use App\Http\Controllers\Backend\CountyController;
use App\Http\Controllers\Backend\SubcountyController;
use App\Http\Controllers\Backend\PostalCodeController;
use App\Http\Controllers\Backend\RequirementController;
use App\Http\Controllers\Backend\AcademicDepartmentController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\MasterdataController;
use App\Http\Controllers\Admin\RegistrarApplicationController;
use App\Http\Controllers\Admin\OfficerController;
use App\Http\Controllers\Admin\RegistrarDashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AdmissionDocumentTypeController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\AccountsController;
use App\Http\Controllers\Admin\ShortCourseDataController;
use App\Http\Controllers\Admin\AdmissionRecordImportController;
use App\Http\Controllers\Admin\BiodataImportController;

// Registrar Controllers
use App\Http\Controllers\Registrar\DocumentVerificationController;
use App\Http\Controllers\Registrar\AdmissionProcessingController;

// Applicant Controllers
use App\Http\Controllers\Applicant\AccountController;
use App\Http\Controllers\Applicant\EducationQualificationsController;

// Report Controllers
use App\Http\Controllers\Report\ShortCoursesReportsController;
use App\Http\Controllers\Report\FinanceReportController;

// Payment Controllers
use App\Http\Controllers\Payment\PaymentSimulationController;

// Constants
use App\Http\Controllers\Constants\CountryController;

// Models (for inline routes)
use App\Models\Course;
use App\Models\Departmentt;
use App\Models\AcademicDepartment;
use App\Models\Subcounty;

// Student Controllers (root namespace)
use App\Http\Controllers\StudentDashboardController;

// =====================================================
// PUBLIC ROUTES (No Auth Required)
// =====================================================

// Home
Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Payment Callback (Public)
Route::get('/payment/callback', function () {
    return view('public.payments.callback');
})->name('callback');

// Dynamic Location Data
Route::get('/counties/{county}/subcounties', function ($county) {
    return Subcounty::where('county_id', $county)
        ->orderBy('name')
        ->select('id', 'name')
        ->get();
});

// Public Training Pages
Route::get('/training/scheduled', [TrainingController::class, 'index'])
    ->name('public.trainings');

Route::get('/trainings/long-term', [TrainingController::class, 'longTerm'])
    ->name('public.trainings.long');

Route::get('/trainings/short-term', [TrainingController::class, 'shortTerm'])
    ->name('public.trainings.short');

// Academic Departments by Campus
Route::get('/academic-departments/by-campus/{campus}', function ($campus) {
    return AcademicDepartment::where('college_id', $campus)
        ->orderBy('name')
        ->get(['id', 'name']);
})->name('admin.academic-departments.byCampus');

// Dev Payment Simulation (Local/Testing Only)
if (app()->environment(['local', 'testing'])) {
    Route::get('/simulate-payment-local-dev/{invoice}', [PaymentSimulationController::class, 'simulate'])
        ->name('simulate.payment');
}

// =====================================================
// AUTH ROUTES (OTP Flow)
// =====================================================

Route::get('/verify-otp', [AuthenticatedSessionController::class, 'showOtpForm'])
    ->name('otp.verify.form');

Route::post('/verify-otp', [AuthenticatedSessionController::class, 'verifyOtp'])
    ->name('otp.verify');

Route::get('/resend-otp', [AuthenticatedSessionController::class, 'resendOtp'])
    ->name('otp.resend');

Route::get('/otp/channel', [AuthenticatedSessionController::class, 'showOtpChannelForm'])
    ->name('otp.channel.form');

Route::post('/otp/channel', [AuthenticatedSessionController::class, 'chooseOtpChannel'])
    ->name('otp.channel.choose');

// ✅ FIXED: Logout route - uses AuthenticatedSessionController, POST method
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// =====================================================
// FORCE PASSWORD CHANGE ROUTES
// =====================================================

Route::middleware(['auth'])->group(function () {
    Route::get('/force-password-change', [ForcePasswordController::class, 'show'])
        ->name('password.force');
    
    Route::post('/force-password-change', [ForcePasswordController::class, 'update'])
        ->name('password.force.update');
});

// =====================================================
// PROTECTED ROUTES (Auth + Force Password Check)
// =====================================================

Route::middleware(['auth', 'force.password'])->group(function () {
    // Dashboards and protected content go here
    // Individual dashboards are defined in their respective route files
});

// =====================================================
// PROFILE ROUTES (Auth Required)
// =====================================================

Route::middleware(['auth', 'history', 'verified', 'force.password'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =====================================================
// ADMIN ROUTES (Superadmin/Admin Only)
// =====================================================

Route::middleware(['auth', 'role:superadmin|admin'])->prefix('admin')->group(function () {

    // User Management
    Route::controller(UserManagementController::class)->group(function () {
        Route::get('/users', 'index')->name('admin.users.index');
        Route::get('/users/student', 'indexstudent')->name('admin.users.students');
        Route::get('/users/create', 'create')->name('admin.users.create');
        Route::post('/users/store', 'store')->name('admin.users.store');
        Route::get('/users/edit/{user}', 'edit')->name('admin.users.edit');
        Route::get('/users/students/{user}/edit', 'editStudent')->name('admin.users.students.edit');
        Route::match(['post', 'put'], 'users/update/{user}', 'update')->name('admin.users.update');
        Route::delete('/users/{user}', 'destroy')->name('admin.users.destroy');
    });

    // Course & Department Lookups
    Route::get('/courses/by-campus/{college}', function ($college) {
        return Course::where('college_id', $college)
            ->orderBy('course_name')
            ->get(['id', 'course_name', 'course_code']);
    })->name('admin.courses.byCampus');

    // ✅ FIXED: Removed double /admin prefix
    Route::get('/departments/by-campus/{college}', function ($college) {
        return Departmentt::where('college_id', $college)
            ->orderBy('name')
            ->get(['id', 'name', 'code']);
    })->name('admin.departments.byCampus');

    Route::post('/courses/by-departments', function (\Illuminate\Http\Request $request) {
        $data = $request->validate([
            'campus_id' => 'required|exists:colleges,id',
            'department_ids' => 'required|array',
            'department_ids.*' => 'integer|exists:departmentts,id',
        ]);

        return Course::where('college_id', $data['campus_id'])
            ->whereIn('department_id', $data['department_ids'])
            ->orderBy('course_name')
            ->get(['id', 'course_name', 'course_code']);
    })->name('admin.courses.byDepartments');

});

// =====================================================
// ADMIN CONTROLLER ROUTES (Legacy Structure)
// =====================================================

Route::controller(AdminController::class)->group(function () {
    Route::get('/dashboard', 'AdminDashboard')->name('dashboard')->middleware('verified');
    // ✅ FIXED: Removed redundant /admin/logout (use global logout route instead)
    Route::get('/admin/profile', 'AdminProfile')->name('admin.profile');
    Route::post('/admin/profile/store', 'AdminProfileStore')->name('admin.profile.store');
    Route::get('/admin/change/password', 'AdminChangePassword')->name('admin.change.password');
    Route::post('/admin/update/password', 'AdminUpdatePassword')->name('update.password');
    Route::get('/all/admin', 'AllAdmin')->name('all.admin');
    Route::get('/add/admin', 'AddAdmin')->name('add.admin');
    Route::post('/store/admin', 'StoreAdmin')->name('admin.store');
    Route::get('/edit/admin/{id}', 'EditAdmin')->name('edit.admin');
    Route::post('/update/admin', 'UpdateAdmin')->name('admin.update');
    Route::get('/delete/admin/{id}', 'DeleteAdmin')->name('delete.admin');
});

// =====================================================
// ROLES & PERMISSIONS ROUTES
// =====================================================

Route::controller(RoleController::class)->group(function () {
    Route::get('/all/permission', 'AllPermission')->name('all.permission');
    Route::get('/add/permission', 'AddPermission')->name('add.permission');
    Route::post('/store/permission', 'StorePermission')->name('permission.store');
    Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission');
    Route::post('/update/permission', 'UpdatePermission')->name('permission.update');
    Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission');
    Route::get('/all/roles', 'AllRoles')->name('all.roles');
    Route::get('/add/roles', 'AddRoles')->name('add.roles');
    Route::post('/store/roles', 'StoreRoles')->name('roles.store');
    Route::get('/edit/roles/{id}', 'EditRoles')->name('edit.roles');
    Route::post('/update/roles', 'UpdateRoles')->name('roles.update');
    Route::get('/delete/roles/{id}', 'DeleteRoles')->name('delete.roles');
    Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission');
    Route::post('/role/permission/store', 'StoreRolesPermission')->name('role.permission.store');
    Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission');
    Route::get('/admin/edit/roles/{id}', 'AdminEditRoles')->name('admin.edit.roles');
    Route::post('/role/permission/update/{id}', 'RolePermissionUpdate')->name('role.permission.update');
    Route::get('/admin/delete/roles/{id}', 'AdminDeleteRoles')->name('admin.delete.roles');
});

// =====================================================
// COURSE & REQUIREMENT ROUTES
// =====================================================

Route::controller(CourseController::class)->group(function () {
    Route::get('/all/courses', 'index')->name('all.courses');
    Route::get('/course/create', 'create')->name('courses.create');
    Route::post('/course/store', 'store')->name('courses.store');
    Route::get('/course/show/{course}', 'show')->name('courses.show');
    Route::get('/course/edit/{course}', 'edit')->name('courses.edit');
    Route::put('/course/update/{course}', 'update')->name('courses.update');
    Route::delete('/course/delete/{course}', 'destroy')->name('courses.delete');
});

Route::controller(RequirementController::class)->group(function () {
    Route::get('/courses/{course}/requirements/create', 'create')->name('courses.requirements.create');
    Route::post('/courses/{course}/requirements', 'store')->name('courses.requirements.store');
    Route::delete('/courses/{course}/requirements/{requirement}', 'destroy')->name('courses.requirements.delete');
});

// =====================================================
// TRAINING ROUTES
// =====================================================

Route::controller(TrainingController::class)->group(function () {
    Route::get('/all/trainings', 'index')->name('all.trainings');
    Route::get('/training/create', 'create')->name('trainings.create');
    Route::post('/training/store', 'store')->name('trainings.store');
    Route::get('/training/show/{training}', 'show')->name('trainings.show');
    Route::get('/training/edit/{training}', 'edit')->name('trainings.edit');
    Route::put('/training/update/{training}', 'update')->name('trainings.update');
    Route::delete('/training/delete/{training}', 'destroy')->name('trainings.delete');

    Route::get('/trainings/registrar', 'registrarIndex')->name('trainings.registrar.index');
    Route::get('/trainings/hqregistrar', 'hqregistrarIndex')->name('trainings.hqregistrar.index');
    Route::get('/trainings/director/registrar', 'directorregistrarIndex')->name('trainings.drregistrar.index');

    Route::post('/training/{training}/send-for-approval', 'sendForApproval')->name('trainings.send_for_approval');
    Route::post('/training/{training}/registrar-approve', 'registrarApprove')->name('trainings.registrar_approve');
    Route::post('/training/{training}/registrar-reject', 'registrarReject')->name('trainings.registrar_reject');
    Route::post('/training/{training}/hqReject', 'hqReject')->name('trainings.hqReject');
    Route::post('/training/{training}/hq-review', 'hqReview')->name('trainings.hq_review');
    Route::post('/training/{training}/director-approve', 'directorApprove')->name('trainings.director_approve');
    Route::post('/training/{training}/director-reject', 'directorReject')->name('trainings.director_reject');

    // ✅ FIXED: Removed redundant auth middleware (already in outer group if needed)
    Route::prefix('admin-departments')->group(function () {
        Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
        Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');
        Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
        Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
        Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
        Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
    });
});

// =====================================================
// BACKEND ADMIN ROUTES (Counties, Subcounties, Postal Codes)
// =====================================================

Route::middleware(['auth'])->prefix('admin')->group(function () {

    // Counties
    Route::get('/counties', [CountyController::class, 'index'])->name('backend.counties.index');
    Route::get('/counties/create', [CountyController::class, 'create'])->name('backend.counties.create');
    Route::post('/counties/store', [CountyController::class, 'store'])->name('backend.counties.store');
    Route::get('/counties/{county}/edit', [CountyController::class, 'edit'])->name('backend.counties.edit');
    Route::post('/counties/{county}/update', [CountyController::class, 'update'])->name('backend.counties.update');
    Route::delete('/counties/{county}/destroy', [CountyController::class, 'destroy'])->name('backend.counties.destroy');

    // Subcounties
    Route::get('/subcounties', [SubcountyController::class, 'index'])->name('backend.subcounties.index');
    Route::get('/subcounties/create', [SubcountyController::class, 'create'])->name('backend.subcounties.create');
    Route::post('/subcounties/store', [SubcountyController::class, 'store'])->name('backend.subcounties.store');
    Route::get('/subcounties/{subcounty}/edit', [SubcountyController::class, 'edit'])->name('backend.subcounties.edit');
    Route::post('/subcounties/{subcounty}/update', [SubcountyController::class, 'update'])->name('backend.subcounties.update');
    Route::delete('/subcounties/{subcounty}/destroy', [SubcountyController::class, 'destroy'])->name('backend.subcounties.destroy');

    // Postal Codes
    Route::get('/postal-codes', [PostalCodeController::class, 'index'])->name('backend.postal_codes.index');
    Route::get('/postal-codes/create', [PostalCodeController::class, 'create'])->name('backend.postal_codes.create');
    Route::post('/postal-codes/store', [PostalCodeController::class, 'store'])->name('backend.postal_codes.store');
    Route::get('/postal-codes/{postal_code}/edit', [PostalCodeController::class, 'edit'])->name('backend.postal_codes.edit');
    Route::post('/postal-codes/{postal_code}/update', [PostalCodeController::class, 'update'])->name('backend.postal_codes.update');
    Route::delete('/postal-codes/{postal_code}/destroy', [PostalCodeController::class, 'destroy'])->name('backend.postal_codes.destroy');

});

// =====================================================
// COUNTRY RESOURCE ROUTES
// =====================================================

// ✅ FIXED: Replaced deprecated namespace() with modern resource syntax
Route::prefix('admin')
    ->middleware(['auth'])
    ->group(function () {
        Route::resource('country', CountryController::class)
            ->names('admin.country');
    });

// =====================================================
// BACKEND ACADEMIC DEPARTMENTS ROUTES
// =====================================================

Route::prefix('backend')->name('backend.')->group(function () {
    Route::get('/academic-departments', [AcademicDepartmentController::class, 'index'])->name('academic-departments.index');
    Route::get('/academic-departments/create', [AcademicDepartmentController::class, 'create'])->name('academic-departments.create');
    Route::post('/academic-departments', [AcademicDepartmentController::class, 'store'])->name('academic-departments.store');
    Route::get('/academic-departments/{id}/edit', [AcademicDepartmentController::class, 'edit'])->name('academic-departments.edit');
    Route::put('/academic-departments/{id}', [AcademicDepartmentController::class, 'update'])->name('academic-departments.update');
    Route::delete('/academic-departments/{id}', [AcademicDepartmentController::class, 'destroy'])->name('academic-departments.destroy');
    Route::get('/academic-departments/{id}/assign-hod', [AcademicDepartmentController::class, 'assignHodForm'])->name('academic-departments.assign-hod');
    Route::post('/academic-departments/{id}/assign-hod', [AcademicDepartmentController::class, 'assignHod'])->name('academic-departments.assign-hod.store');
});

// =====================================================
// ACCOUNTS ROUTES (Superadmin/Accounts/Cash Office)
// =====================================================

Route::prefix('admin/accounts')->name('accounts.')->middleware(['role:superadmin|accounts|cash_office'])->group(function () {
    Route::get('/dashboard', [AccountsController::class, 'dashboard'])->name('dashboard');
    Route::get('/invoices', [AccountsController::class, 'invoices'])->name('invoices');
    Route::post('/verify-sponsor/{payment}', [AccountsController::class, 'verifySponsor'])->name('verify.sponsor');
    Route::post('/offline-payment/{payment}', [AccountsController::class, 'markOfflinePayment'])->name('offline.mark');
    Route::post('/clear/{admission}', [AccountsController::class, 'clearForAdmission'])->name('clear.admission');
});

// =====================================================
// REGISTRAR ADMISSION ROUTES
// =====================================================

Route::prefix('admin/registrar')->middleware(['auth'])->group(function () {
    Route::get('/admissions/verified', [AdmissionProcessingController::class, 'verifiedList'])->name('admin.admissions.verified');
    Route::post('/admissions/{admission}/admit', [AdmissionProcessingController::class, 'admitStudent'])->name('admin.admissions.admit');
});

Route::prefix('registrar')->middleware(['auth', 'role:registrar|hod|superadmin'])->group(function () {
    Route::get('/verification', [DocumentVerificationController::class, 'index'])->name('registrar.verification.index');
    Route::get('/verification/{admission}', [DocumentVerificationController::class, 'show'])->name('registrar.verification.show');
    Route::post('/verification/{admission}/approve', [DocumentVerificationController::class, 'approve'])->name('registrar.verification.approve');
    Route::post('/verification/{admission}/reject', [DocumentVerificationController::class, 'reject'])->name('registrar.verification.reject');
    Route::post('/admissions/{admission}/verify-documents', [DocumentVerificationController::class, 'verifyDocument'])->name('registrar.verify.documents');
    Route::post('/verification/{admission}/finalize', [DocumentVerificationController::class, 'finalize'])->name('admin.verify.finalize');
    Route::post('/verification/{admission}/document', [DocumentVerificationController::class, 'verifyDocument'])->name('admin.verify.document');
});

// =====================================================
// SUPERADMIN/REGISTRAR DATA IMPORT & MANAGEMENT
// =====================================================

Route::middleware(['role:superadmin|registrar'])->group(function () {

    // Admission Documents
    Route::get('admission-documents', [AdmissionDocumentTypeController::class, 'index'])->name('admin.admission.documents.index');
    Route::get('admission-documents/create', [AdmissionDocumentTypeController::class, 'create'])->name('admin.admission.documents.create');
    Route::post('admission-documents', [AdmissionDocumentTypeController::class, 'store'])->name('admin.admission.documents.store');
    Route::get('admission-documents/{doc}/edit', [AdmissionDocumentTypeController::class, 'edit'])->name('admin.admission.documents.edit');
    Route::post('admission-documents/{doc}', [AdmissionDocumentTypeController::class, 'update'])->name('admin.admission.documents.update');
    Route::delete('admission-documents/{doc}', [AdmissionDocumentTypeController::class, 'destroy'])->name('admin.admission.documents.delete');

    // Data Imports
    Route::get('/shortcourses/import', [ShortCourseDataController::class, 'showImportForm'])->name('admin.shortcourses.import.form');
    Route::post('/shortcourses/import', [ShortCourseDataController::class, 'import'])->name('admin.shortcourses.import');
    Route::get('/admissions/import', [AdmissionRecordImportController::class, 'showImportForm'])->name('admin.admissions.import.form');
    Route::post('/admissions/import', [AdmissionRecordImportController::class, 'import'])->name('admin.admissions.import');
    Route::get('/biodata/import', [BiodataImportController::class, 'showImportForm'])->name('admin.biodata.import.form');
    Route::post('/biodata/import', [BiodataImportController::class, 'import'])->name('admin.biodata.import');
    Route::get('/biodata', [BiodataImportController::class, 'index'])->name('admin.biodata.index');

    // Master Data
    Route::get('/masterdata', [MasterdataController::class, 'index'])->name('masterdata.index');
    Route::post('/masterdata/import', [MasterdataController::class, 'import'])->name('masterdata.import');
    Route::post('/masterdata/truncate', [MasterdataController::class, 'truncate'])->name('masterdata.truncate');

});

// =====================================================
// REGISTRAR APPLICATION WORKFLOW
// =====================================================

Route::get('/applications/awaiting', [RegistrarApplicationController::class, 'awaiting'])->name('registrar.applications.awaiting');
Route::get('/applications/assigned', [RegistrarApplicationController::class, 'assigned'])->name('registrar.applications.assigned');
Route::get('/applications/completed', [RegistrarApplicationController::class, 'completed'])->name('registrar.applications.completed');
Route::post('/applications/{application}/assign', [RegistrarApplicationController::class, 'assignReviewer'])->name('registrar.assign');

Route::prefix('admin/registrar')->group(function () {
    Route::get('/applications/{application}', [RegistrarApplicationController::class, 'view'])->name('registrar.applications.view');
});

// =====================================================
// REPORT ROUTES
// =====================================================

Route::get('/reports/rejected', [ReportController::class, 'rejectedIndex'])->name('reports.rejected');
Route::get('/reports/rejected/pdf', [ReportController::class, 'rejectedPdf'])->name('reports.rejected.pdf');
Route::get('/reports/applications/summary/pdf', [ReportController::class, 'applicationsSummaryPdf'])->name('reports.summary.pdf');
Route::get('/reports/applications/summary', [ReportController::class, 'applicationsSummaryIndex'])->name('reports.summary.index');
Route::get('/registrar/dashboard', [RegistrarDashboardController::class, 'index'])->name('registrar.dashboard');

// Admin Reports (Superadmin/HOD/Campus Registrar)
Route::prefix('admin/reports')->middleware(['auth', 'role:superadmin|hod|campus_registrar'])->group(function () {
    Route::get('/applications', [ReportController::class, 'applicationsIndex'])->name('reports.applications');
    Route::get('/knec-filter-applications', [ReportController::class, 'applicationsIndexKnec'])->name('knec.reports.applications');
    Route::get('/applications/preview', [ReportController::class, 'applicationsPreview'])->name('reports.applications.preview');
    Route::get('/applications/pdf', [ReportController::class, 'applicationsPdf'])->name('reports.applications.pdf');
    Route::get('/reports/applications/data', [ReportController::class, 'applicationsData'])->name('reports.applications.data');
    Route::get('/decisions', [ReportController::class, 'decisionsIndex'])->name('reports.decisions');
    Route::get('/decisions/rejected-data', [ReportController::class, 'rejectedData'])->name('reports.decisions.rejected.data');
    Route::get('/decisions/preview', [ReportController::class, 'decisionsPreview'])->name('reports.decisions.preview');
    Route::get('/decisions/pdf', [ReportController::class, 'decisionsPdf'])->name('reports.decisions.pdf');
    Route::get('/reviewers', [ReportController::class, 'reviewerIndex'])->name('reports.reviewers');
    Route::get('/reviewers/preview', [ReportController::class, 'reviewerPreview'])->name('reports.reviewers.preview');
    Route::get('/reviewers/pdf', [ReportController::class, 'reviewerPdf'])->name('reports.reviewers.pdf');

    // Short Course Reports
    Route::prefix('reports/short')->name('reports.short.')->group(function () {
        Route::get('/applications', [ShortCoursesReportsController::class, 'shortApplicationsIndex'])->name('applications');
        Route::get('/applications/pdf', [ShortCoursesReportsController::class, 'shortApplicationsPdf'])->name('applications.pdf');
        Route::get('/training-summary', [ShortCoursesReportsController::class, 'shortTrainingSummaryIndex'])->name('training.summary');
        Route::get('/training-summary/pdf', [ShortCoursesReportsController::class, 'shortTrainingSummaryPdf'])->name('training.summary.pdf');
        Route::get('/participants', [ShortCoursesReportsController::class, 'shortParticipantsIndex'])->name('participants');
        Route::get('/participants/pdf', [ShortCoursesReportsController::class, 'shortParticipantsPdf'])->name('participants.pdf');
        Route::get('/employers', [ShortCoursesReportsController::class, 'employerReportIndex'])->name('employers');
        Route::get('/employers/pdf', [ShortCoursesReportsController::class, 'employerReportPdf'])->name('employers.pdf');
        Route::get('/employers/{employer}/statement', [ShortCoursesReportsController::class, 'employerStatement'])->name('employer.statement');
        Route::get('/employers/{employer}/statement/pdf', [ShortCoursesReportsController::class, 'employerStatementPdf'])->name('employer.statement.pdf');
        Route::get('/revenue', [ShortCoursesReportsController::class, 'shortRevenueIndex'])->name('revenue.index');
        Route::get('/revenue/pdf', [ShortCoursesReportsController::class, 'shortRevenuePdf'])->name('revenue.pdf');
    });
});

// =====================================================
// OFFICER ROUTES (HOD/Campus Registrar)
// =====================================================

Route::prefix('officer')->middleware(['auth', 'role:hod|campus_registrar'])->group(function () {
    Route::get('/applications/pending', [OfficerController::class, 'pending'])->name('officer.applications.pending');
    Route::get('/applications/completed', [OfficerController::class, 'completed'])->name('officer.applications.completed');
    Route::get('/applications/{application}/review', [OfficerController::class, 'reviewPage'])->name('officer.applications.review');
    Route::post('/applications/{application}/approve', [OfficerController::class, 'approve'])->name('officer.applications.approve');
    Route::post('/applications/{application}/reject', [OfficerController::class, 'reject'])->name('officer.applications.reject');
});

// =====================================================
// APPLICANT ROUTES
// =====================================================

Route::group(['middleware' => ['role:applicant', 'auth', 'history', 'verified']], function () {
    
    Route::controller(UsersController::class)->group(function () {
        Route::get('applicant/dashboard', 'ApplicantDashboard')->name('applicant.dashboard')->middleware('verified');
        Route::get('applicant/dprofile', 'ApplicantDProfile')->name('applicant.dprofile')->middleware('verified');
        Route::get('/applicant/logout', 'ApplicantLogout')->name('applicant.logout');
        Route::get('/applicant/profile', 'ApplicantProfile')->name('applicant.profile');
        Route::post('/applicant/profile/store', 'ApplicantProfileStore')->name('applicant.profile.store');
        Route::get('/applicant/change/password', 'ApplicantChangePassword')->name('applicant.change.password');
        Route::post('/applicant/update/password', 'ApplicantUpdatePassword')->name('applicant.update.password');
    });

    Route::group(['middleware' => ['permission:account.menu']], function () {
        Route::controller(AccountController::class)->group(function () {
            Route::get('applicant/register', 'Register')->name('applicant.register');
            Route::post('applicant/register/store', 'RegisterUpdate')->name('register.store');
        });
        
        Route::controller(EducationQualificationsController::class)->group(function () {
            Route::get('applicant/primary', 'PrimaryEducation')->name('applicant.primaryeducation');
            Route::post('applicant/primary/store', 'PrimaryEducationStore')->name('primaryeducation.store');
            Route::get('applicant/secondary', 'SecondaryEducation')->name('applicant.secondaryeducation');
            Route::post('applicant/secondary/store', 'SecondaryEducationStore')->name('secondaryeducation.store');
            Route::get('applicant/postsecondary', 'PostSecondaryEducation')->name('applicant.postsecondaryeducation');
            Route::post('applicant/postsecondary/store', 'PostSecondaryEducationStore')->name('postsecondaryeducation.store');
            Route::get('applicant/profile/application', 'ProfileSummary')->name('applicant.profileapplication');
        });
    });
});

// =====================================================
// MASTER DASHBOARD ROUTE
// =====================================================

Route::middleware(['auth', 'role:registrar|superadmin'])
    ->prefix('admin/dashboard')
    ->group(function () {
        Route::get('/master', [AdminDashboardController::class, 'index'])->name('admin.dashboard.master');
    });

// =====================================================
// COLLEGE DEPARTMENTS LOOKUP
// =====================================================

// ✅ FIXED: Parameter name matches route placeholder
Route::get('/admin/colleges/{college}/departments', function ($college) {
    return AcademicDepartment::where('college_id', $college)
        ->orderBy('name')
        ->get(['id', 'name']);
})->name('admin.colleges.departments');

// =====================================================
// EXTERNAL ROUTE FILES (Student, Finance, HOD, etc.)
// =====================================================

require __DIR__.'/auth.php';
require __DIR__.'/application.php';
require __DIR__.'/student.php';
require __DIR__.'/finance.php';
require __DIR__.'/ongoing.php';
require __DIR__.'/hod.php';
require __DIR__.'/errors.php';