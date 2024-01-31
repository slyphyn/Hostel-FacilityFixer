<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StaffComplaintController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


// User Routes
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/user', function () {
        return view('user');
    })->name('user');

    // Route::get('/check-username/{username}',[UserController::class, 'checkUsernameExists'])->name('check-username');


    // Complaints related routes [USER]
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/user/dashboard', [DashboardController::class, 'user'])->name('dashboard.user');

    Route::resource('complaints', ComplaintController::class)->only(['create', 'store']);
    Route::resource('complaints', ComplaintController::class)->except(['index', 'create', 'store'])->middleware('can:view,complaint');
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/{complaint}/edit', [ComplaintController::class, 'edit'])->name('complaints.edit');
    Route::put('/complaints/{complaint}', [ComplaintController::class, 'update'])->name('complaints.update');
    Route::delete('/complaints/{complaint}', [ComplaintController::class, 'destroy'])->name('complaints.destroy');

    // Feedback related
    Route::resource('complaints.feedback', FeedbackController::class)->only(['create', 'store']);
    Route::get('/feedback/user', [FeedbackController::class, 'userIndex'])->name('feedback.userIndex');
    Route::get('/complaints/{complaint}', [ComplaintController::class, 'show'])->name('complaints.show');

    //news
    Route::get('user/news', [UserController::class, 'news'])->name('user.news');

    //user-profile
    Route::prefix('user/profile')->middleware(['auth'])->group(function () {
        Route::get('/show', [UserProfileController::class, 'show'])->name('profile.show');
        Route::get('/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/update', [UserProfileController::class, 'update'])->name('profile.update');
    
        Route::get('/change-password', [UserProfileController::class, 'showChangePasswordForm'])->name('profile.showChangePasswordForm');
        Route::put('/change-password', [UserProfileController::class, 'changePassword'])->name('profile.change-password');
    });
    
    

});

// Staff Routes
Route::middleware(['auth', 'staff'])->group(function () {
    Route::get('/staff', function () {
        return view('home');
    })->name('staff');
    Route::get('/all', [StaffComplaintController::class, 'all'])->name('staff.all');
    // Route::put('/complaints/{complaint}/update-status', [ComplaintController::class, 'updateStatus'])->name('complaints.update.status');
    Route::put('/complaints/{complaint}/update-status-and-staff', [ComplaintController::class, 'updateStatusAndStaff'])->name('complaints.update.statusAndStaff');



    // Feedback routes for staff
    Route::get('/feedback', [FeedbackController::class, 'staffIndex'])->name('feedback.staffIndex');
    Route::get('/feedbacks/{feedback}/update-response', [FeedbackController::class, 'updateResponse'])->name('feedback.updateResponse'); // Updated name
    Route::put('/feedbacks/{feedback}/update-response', [FeedbackController::class, 'saveUpdatedResponse'])->name('feedback.saveUpdatedResponse');

    //news
    Route::get('staff/news', [StaffController::class, 'news'])->name('staff.news');

    Route::get('staff/report', [StaffController::class, 'showReport'])->name('staff.report.show');
    Route::post('staff/report/generate', [StaffController::class, 'generateReport'])->name('staff.report.generate');
    
});

// Admin Route
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin');
    })->name('admin');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/{user}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::delete('/admin/{user}/delete', [AdminController::class, 'destroy'])->name('admin.destroy');

    //news
    Route::get('admin/news/create', [NewsController::class, 'create'])->name('admin.news.create');
    Route::post('admin/news/store', [NewsController::class, 'store'])->name('admin.news.store');
    Route::get('admin/news/show/{id}', [NewsController::class, 'show'])->name('admin.news.show');
    Route::get('admin/news', [NewsController::class, 'index'])->name('admin.news.index');
    Route::get('admin/news/edit/{id}', [NewsController::class, 'edit'])->name('admin.news.edit');
    Route::put('admin/news/update/{id}', [NewsController::class, 'update'])->name('admin.news.update');
    Route::delete('admin/news/destroy/{id}', [NewsController::class, 'destroy'])->name('admin.news.destroy');

    //reporting
    // Route::get('admin/report', [AdminController::class, 'getComplaintsByDateAndCategory'])->name('admin.report');
    Route::get('admin/report', [AdminController::class, 'showReport'])->name('admin.report.show');
    Route::post('admin/report/generate', [AdminController::class, 'generateReport'])->name('admin.report.generate');

});



// Route::get('/complaints/{complaint}', [ComplaintController::class, 'show'])->name('complaints.show');
// Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
// Route::get('/complaints', [StaffComplaintController::class, 'find'])->name('complaints.find');
Route::get('/staff/complaints', [StaffComplaintController::class, 'find'])->name('staff.complaints.find');


