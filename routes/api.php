<?php

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\validation\ValidationException;

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


Route::name('api.')->prefix('v1')->group(function(){
    Route::middleware('auth:sanctum')->get('/user',function(Request $request){
       return $request->user();
    });

    Route::post('/sanctum/token', function(Request $request){
        $request->validate([
            'email' =>'required|email',
            'password' => 'required',
            'device_name' =>'required'
        ]);

        $user =User::where('email', $request->email)->first();
        if(! $user || !Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }

        return $user->createToken($request->device_name)->plainTextToken;
    });


    Route::post('/register',[App\Http\Controllers\API\AuthController::class,'register']);
    Route::post('/login',[App\Http\Controllers\API\AuthController::class,'login']);
    Route::post('/recover-password',[App\Http\Controllers\API\AuthController::class,'recoverPassword']);

    Route::resource('posts',App\Http\Controllers\API\PostAPIController::class);
});
