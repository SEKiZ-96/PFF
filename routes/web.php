<?php 
use App\Http\Controllers\Admin\TimeScheduleCrudController;
use Illuminate\Support\Facades\Route;

Route::get('', function () {
    return redirect(backpack_url('dashboard'));
});
Route::get('/', function () {
    return redirect(backpack_url('dashboard'));
});
Route::get('/admin/time-schedule/{id}/schedule', [TimeScheduleCrudController::class, 'show']);
