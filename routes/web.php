<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('user/logout', [UserController::class, 'UserLogout'])->name('user.logout');

    Route::controller(FileController::class)->group(function () {
        Route::post('user/file/upload', 'fileUpload')->name('user.file.upload');
        Route::get('user/file/delete/{id}', 'fileDelete')->name('user.file.delete');
        Route::get('user/file/download/{id}', 'fileDownload')->name('user.file.download');
        Route::get('user/plagiarism/download/{id}', 'plagiarismDownload')->name('user.plagiarism.download');
        Route::get('user/ai/download/{id}', 'aiDownload')->name('user.ai.download');
    });

});

require __DIR__.'/auth.php';

Route::get('/', [UserController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::controller(AdminController::class)->group(function () {
        Route::get('admin/dashboard', 'AdminDashboard')->name('admin.dashboard');
        Route::get('admin/logout', 'AdminLogout')->name('admin.logout');
        Route::get('admin/profile', 'AdminProfile')->name('admin.profile');
        Route::post('admin/profile/update', 'AdminProfileUpdate')->name('admin.profile.update');
        Route::get('admin/change/password', 'AdminChangePassword')->name('admin.change.password');
        Route::post('admin/update/password', 'AdminUpdatePassword')->name('admin.update.password');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('all/users', 'AllUsers')->name('all.users');
        Route::get('add/user', 'AddUser')->name('add.user');
        Route::post('store/user', 'StoreUser')->name('store.user');
        Route::get('edit/user/{id}', 'EditUser')->name('edit.user');
        Route::post('update/user/{id}', 'UpdateUser')->name('update.user');
        Route::get('delete/user/{id}', 'DeleteUser')->name('delete.user');
    });

    Route::controller(FileController::class)->group(function () {
        Route::get('all/files', 'AllFiles')->name('all.files');
        Route::get('files/download/{id}', 'FilesDownload')->name('files.download');
        Route::get('files/delete/{id}', 'FilesDelete')->name('files.delete');
        Route::get('files/edit/{id}', 'FilesEdit')->name('files.edit');
        Route::post('files/update/{id}', 'FilesUpdate')->name('files.update');
    });

    Route::controller(PageController::class)->group(function () {
        Route::get('all/pages', 'AllPage')->name('all.pages');
        Route::get('add/page', 'AddPage')->name('add.page');
        Route::post('store/page', 'StorePage')->name('store.page');
        Route::get('edit/page/{id}', 'EditPage')->name('edit.page');
        Route::post('update/page/{id}', 'UpdatePage')->name('update.page');
        Route::get('delete/page/{id}', 'DeletePage')->name('delete.page');
    });

    Route::controller(NoticeController::class)->group(function () {
        Route::get('/notice', 'index')->name('notice');
        Route::post('/notice/update/{id}', 'noticeUpdate')->name('notice.update');
    });

});

Route::middleware(['auth', 'role:agent'])->group(function () {

    Route::controller(AgentController::class)->group(function () {
        Route::get('agent/dashboard', 'AgentDashboard')->name('agent.dashboard');
        Route::get('agent/logout', 'AgentLogout')->name('agent.logout');
    });

    Route::controller(FileController::class)->group(function () {
        Route::get('agent/all/files', 'agentAllFiles')->name('agent.all.files');
        Route::get('agent/files/download/{id}', 'agentFilesDownload')->name('agent.files.download');
        Route::get('agent/files/delete/{id}', 'agentFilesDelete')->name('agent.files.delete');
        Route::get('agent/files/edit/{id}', 'agentFilesEdit')->name('agent.files.edit');
        Route::post('agent/files/update/{id}', 'agentFilesUpdate')->name('agent.files.update');
    });

});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
