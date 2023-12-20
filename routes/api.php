<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ********** INFORMATIONS API ******************
Route::post('/information/addinformation',[InformationController::class,'addInformation']);
Route::get('/information/allinformations',[InformationController::class,'getAllInformations']);
Route::get('/information/{id}',[InformationController::class,'getInformationById']);
Route::delete('/information/{id}',[InformationController::class,'deleteInformationById']);
Route::post('/information/{id}',[InformationController::class,'updateInformationById']);

// ********** ROLE API ******************
Route::post('/role/addrole', [RoleController::class, 'addRole']);
Route::get('/role/allroles', [RoleController::class, 'getAllRoles']);
Route::get('/role/{id}', [RoleController::class, 'getRoleById']);
Route::delete('/role/{id}', [RoleController::class, 'deleteRoleById']);
Route::post('/role/{id}', [RoleController::class, 'updateRoleById']);


// ********** CONTACT API *********************
Route::post('/contact/addcontact', [ContactController::class, 'addContact']);
Route::get('/contact/allcontacts', [ContactController::class,'getAllContact']);
Route::get('/contact/{id}', [ContactController::class,'getContactById']);
Route::delete('/contact/{id}', [ContactController::class,'deleteContactById']);
Route::post('/contact/{id}', [ContactController::class,'updateContactById']);

// ********** CATEGORY API *********************
Route::post('/category/addcategory', [CategoryController::class, 'addCategory']);
Route::get('/category/allcategories', [CategoryController::class,'getAllCategories']);
Route::get('/category/{id}',[CategoryController::class,'getCategoryById']);
Route::delete('/category/{id}', [CategoryController::class,'deleteCategoryById']);
Route::post('/category/{id}', [CategoryController::class,'updateCategoryById']);

// ********** TAXES API *********************
Route::post('/tax/addtax', [TaxController::class, 'addTax']);
Route::get('/tax/alltaxes', [TaxController::class,'getAllTaxes']);
Route::get('/tax/{id}',[TaxController::class,'getTaxById']);
Route::delete('/tax/{id}', [TaxController::class,'deleteTax']);
Route::post('/tax/{id}', [TaxController::class,'updateTax']);

// *********** PRODUCTS API ********************
Route::post('/product/addproduct', [ProductController::class,'addProduct']);
Route::get('/products/allproducts', [ProductController::class, 'getAllProducts']);
Route::get('/product/{id}', [ProductController::class, 'getProductById']);
Route::post('/product/{id}', [ProductController::class, 'updateProductById']);
Route::delete('/product/{id}', [ProductController::class,'deleteProductById']);


Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login'])->middleware('throttle:login');
Route::get('/allusers', [UserController::class, 'getAllUsers']);
Route::get('/user/{id}', [UserController::class,'getUserById']);
Route::post('/user/{id}', [UserController::class,'editUser']);
Route::delete('/user/{id}', [UserController::class,'deleteUser']);


