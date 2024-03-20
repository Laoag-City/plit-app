<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\SearchController;
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

Route::middleware(['guest'])->controller((AuthenticationController::class))->group(function(){
	Route::get('/login', 'showLogin')->name('login');
	Route::post('/login', 'authenticate');
});

Route::middleware(['auth'])->group(function(){
	Route::get('/', HomeController::class);

	Route::get('/new-business', [BusinessController::class, 'showAddNewBusiness'])
		->name('new_business')
		->middleware('can:pld-personnel-action-only');

	Route::post('/new-business', [BusinessController::class, 'addNewBusiness'])->middleware('can:pld-personnel-action-only');

	Route::get('/home', HomeController::class)->name('home');

	Route::get('/businesses', [BusinessController::class, 'getBusinesses'])->name('businesses');

	Route::get('/businesses/{business}', [BusinessController::class, 'getBusinessInfo'])->name('business_info');

	Route::get('/businesses/{business}/edit', [BusinessController::class, 'showEditBusiness'])
		->name('edit_business')
		->middleware('can:pld-personnel-action-only');

	Route::put('/businesses/{business}/edit', [BusinessController::class, 'editBusiness'])
		->middleware('can:pld-personnel-action-only');

	Route::get('/businesses/{business}/image-manager', [ImageUploadController::class, 'showImageManager'])
		->name('image_manager')
		->middleware('can:pld-personnel-action-only');

	Route::put('/businesses/{business}/image-manager', [ImageUploadController::class, 'updateImages'])
		->middleware('can:pld-personnel-action-only');

	Route::get('/businesses/{business}/images/{image_upload}', [ImageUploadController::class, 'showImage'])
		->name('image')
		->scopeBindings();

	Route::get('/checklist', [BusinessController::class, 'getChecklist'])->name('checklist');
	
	Route::post('/checklist', [BusinessController::class, 'saveChecklist'])->name('save_checklist');

	Route::get('/owners', [OwnerController::class, 'getOwners'])->name('owners');

	Route::get('/owners/{owner}', [OwnerController::class, 'getOwnerInfo'])->name('owner_info');

	Route::get('/owners/{owner}/edit', [OwnerController::class, 'showEditOwner'])
		->name('edit_owner')
		->middleware('can:pld-personnel-action-only');

	Route::put('/owners/{owner}/edit', [OwnerController::class, 'editOwner'])
		->middleware('can:pld-personnel-action-only');

	Route::get('/search', [SearchController::class, 'getSearchResults'])->name('search');

	Route::post('/logout', [AuthenticationController::class, 'logOut']);
});
