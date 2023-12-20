<?php

use App\Http\Controllers\CategoryControllerView;
use App\Http\Controllers\ChartsController;
use App\Http\Controllers\ContactControllerView;
use App\Http\Controllers\InformationControllerView;
use App\Http\Controllers\ProductControllerView;
use App\Http\Controllers\RoleControllerView;
use App\Http\Controllers\TaxControllerView;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserControllerView;
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

Route::get('/', function () {
    // Check if the "access_token" cookie exists
    if (!request()->cookie('access_token')) {
        // Redirect to the login page if the token doesn't exist
        return redirect('/login');
    }

    // Proceed to the home page if the token exists
    return view('home');
});

Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
});




// *********** CATEGORIES VIEWS *************************
Route::get('/categories', function () {
    return view('pages.categories');
})->name('categories');
Route::post('/categories',  [ CategoryControllerView::class,'addCategory'])->name('addcategory.submit');
Route::get('/categories', [CategoryControllerView::class, 'getAllCategories'])->name('categories');
Route::delete('/categories/{id}',  [CategoryControllerView::class, 'deleteCategoryById'])->name('categories.delete');
Route::get('/categories/edit/{id}', [CategoryControllerView::class, 'getCategoryById'])->name('categories.getbyid');
Route::patch('/categories/edit/{id}', [CategoryControllerView::class, 'updateCategoryById'])->name('categories.update');



// *********** INFO VIEWS *************************
Route::get('/informations', function () {
    return view('pages.informations');
})->name('informations');
Route::post('/informations',  [ InformationControllerView::class,'addInformation'])->name('addinformation.submit');
Route::get('/informations', [InformationControllerView::class, 'getAllInformations'])->name('informations');
Route::delete('/informations/{id}',  [InformationControllerView::class, 'deleteInformationById'])->name('informations.delete');
Route::get('/informations/edit/{id}', [InformationControllerView::class, 'getInformationById'])->name('informations.getbyid');
Route::patch('/informations/edit/{id}', [InformationControllerView::class, 'updateInformationById'])->name('informations.update');



// *********** CONTACTS VIEWS *************************
Route::get('/contacts', function () {
    return view('pages.contacts');
})->name('contacts');
Route::post('/contacts',  [ ContactControllerView::class,'addContact'])->name('addcontact.submit');
Route::get('/contacts', [ContactControllerView::class, 'getAllContact'])->name('contacts');
Route::delete('/contacts/{id}',  [ContactControllerView::class, 'deleteContactById'])->name('contacts.delete');
Route::get('/contacts/edit/{id}', [ContactControllerView::class, 'getContactById'])->name('contacts.getbyid');
Route::patch('/contacts/edit/{id}', [ContactControllerView::class, 'updateContactById'])->name('contacts.update');


// *********** USER VIEWS *************************
Route::post('/login',  [ UserControllerView::class,'login'])->name('login.submit');
Route::post('/register', [UserControllerView::class, 'register'])->name('register.submit');



// *********** TAXES VIEWS *************************
Route::get('/taxes', function () {
    return view('pages.taxes');
})->name('taxes');
Route::post('/taxes',  [ TaxControllerView::class,'addTax'])->name('addtax.submit');
Route::get('/taxes', [TaxControllerView::class, 'getAllTaxes'])->name('taxes');
Route::delete('/taxes/{id}',  [TaxControllerView::class, 'deleteTaxById'])->name('taxes.delete');
Route::get('/taxes/edit/{id}', [TaxControllerView::class, 'getTaxById'])->name('taxes.getbyid');
Route::patch('/taxes/edit/{id}', [TaxControllerView::class, 'updateTaxById'])->name('taxes.update');


// *********** ROLES VIEWS *************************
Route::get('/roles', function () {
    return view('pages.roles');
})->name('roles');
Route::post('/roles',  [RoleControllerView::class,'addRole'])->name('addrole.submit');
Route::get('/roles', [RoleControllerView::class, 'getAllRoles'])->name('roles');
Route::delete('/roles/{id}',  [RoleControllerView::class, 'deleteRoleById'])->name('roles.delete');
Route::get('/roles/edit/{id}', [RoleControllerView::class, 'getRoleById'])->name('roles.getbyid');
Route::patch('/roles/edit/{id}', [RoleControllerView::class, 'updateroleById'])->name('roles.update');

// *********** PRODUCTS VIEWS *************************

Route::get('/products', function () {
    return view('pages.products');
})->name('products');
Route::post('/products',  [ProductControllerView::class,'addProduct'])->name('addproduct.submit');
Route::get('/products', [ProductControllerView::class, 'getAllProducts'])->name('products');
Route::delete('/products/{id}',  [ProductControllerView::class, 'deleteProductById'])->name('products.delete');
Route::get('/products/edit/{id}', [ProductControllerView::class, 'getProductById'])->name('products.getbyid');
Route::patch('/products/edit/{id}', [ProductControllerView::class, 'updateProductById'])->name('products.update');

// *********** Charts VIEWS *************************
Route::get('/', [ChartsController::class, 'multipleCharts'])->name('home');

