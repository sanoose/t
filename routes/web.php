<?php

use App\Http\Controllers\Archivings\LetterTypeController;
use App\Http\Controllers\Archivings\SubjectController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyEmailController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReportPartyController;
use App\Http\Controllers\ReferenceNumberController;
use App\Http\Controllers\userController;

use App\Mail\TestMail;
use App\Models\Admin;
use App\Models\Archivings\LetterType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use function PHPUnit\Framework\returnSelf;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

Route::get('/Login' ,  [userController::class , 'LoginPage'] )->name('Login') ;
Route::post('/Login' ,  [userController::class , 'Login'] )->name('Login') ;
Route::get('/Logout' ,  [userController::class , 'Logout'] )->name('Logout') ;

Route::get('/ForgotPassword' , function () {
    return Inertia::render('Auth/ForgotPassword' ); 
} )->name('ForgotPassword') ;


// Route::get('/x' , [LetterTypeController::class , "x"] )  ;

// Route::get('/LetterTypes' , function (Request $req ) {
//     // if ($req->hasValidSignature())
//     // return  "secret" ;
//     // else 
//     // return "error" ;

//     $LetterTypes = LetterType::all()->map(function ($el) {
//         return [
//             'id' => $el->id,
//             'title' => $el->title,
//             // generate a signed URL for each post
//             'url' => URL::signedRoute('Archiving.Settings.LetterTypes.edit', $el->id),
//         ];
//     });
//     return  $LetterTypes   ;
// } )  ;


// ->middleware('signed') ;

// Main Routes  Group
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {

        return Inertia::render('HomeMain' );
    })->name("HomeMain");
 
    // users routes  Group
    Route::get('/Users/Create' ,  [userController::class , 'Create'] )->name('Users.Create') ;
    Route::post('/Users/Store' ,  [userController::class , 'Store'] )->name('Users.Store') ;
    Route::get('/Users/' ,  [userController::class , 'Index'] )->name('Users.Index') ;
    Route::get('/Users/Deleted' ,  [userController::class , 'Deleted'] )->name('Users.Deleted') ;
    Route::get('/Users/Edit/{id}' ,  [userController::class , 'Edit'] )->name('Users.Edit') ;
    Route::put('/Users/Update' ,  [userController::class , 'Update'] )->name('Users.Update') ;
    Route::delete('/Users/Delete/{id}' ,  [userController::class , 'Delete'] )->name('Users.Delete') ;
    Route::get('/Users/Restore/{id}' ,  [userController::class , 'Restore'] )->name('Users.Restore') ;
    Route::get('/Users/Banned/{id}' ,  [userController::class , 'Banned'] )->name('Users.Banned') ;
    Route::get('/Users/UnBanned/{id}' ,  [userController::class , 'UnBanned'] )->name('Users.UnBanned') ;

    Route::get('Users/Profile/Partials/UpdatePasswordForm' , [userController::class , 'UpdatePasswordForm'])
    ->name('Users.Profile.Partials.UpdatePasswordForm') ;


    Route::get('/Departments/Deleted' ,  [DepartmentController::class , 'Deleted'] )->name('Departments.Deleted') ;
    Route::get('/Departments/Restore/{id}' ,  [DepartmentController::class , 'Restore'] )->name('Departments.Restore') ;
    Route::resource('Departments',  DepartmentController::class ) ;
 

});

// Archive routes
Route::group([
    'prefix'        => 'Archiving'           ,
    'as'            => 'Archiving.'   ,
    'middleware'    => [
        'auth:sanctum'                            ,
        config('jetstream.auth_session')          ,
        'verified' ,
    ]
] , function () {
    Route::get('/', function () { return Inertia::render('Archiving/HomeArchive' ); })->name("HomeArchive") ;

    Route::group([ 
        'prefix' => 'Settings' ,
         'as' => 'Settings.' ] , function () {
        // LetterType routes
        Route::get('LetterTypes/Deleted' ,  [LetterTypeController::class , 'Deleted'] )->name('LetterTypes.Deleted') ;
        Route::get('LetterTypes/Restore/{id}' ,  [LetterTypeController::class , 'Restore'] )->name('LetterTypes.Restore') ;
        Route::resource('LetterTypes',  LetterTypeController::class ) ;
        // Subjects routes
        Route::get('Subjects/Deleted' ,  [SubjectController::class , 'Deleted'] )->name('Subjects.Deleted') ;
        Route::get('Subjects/Restore/{id}' ,  [SubjectController::class , 'Restore'] )->name('Subjects.Restore') ;
        Route::resource('Subjects',  SubjectController::class ) ;
     
    });


});


// Financial routes Group
Route::group([ 'prefix'        => 'Financial' , 'middleware'    => [ 'auth:sanctum' ,config('jetstream.auth_session') ,'verified' ,]] , function () {});








// Route::get("/test" , function () {
//     $user = auth()->user() ;
//     return inertia("Profile/Show" , compact("user")) ;
// })->name('test') ;