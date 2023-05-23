<?php

namespace App\Http\Controllers\API;

use App\Events\UserLoginEvent;
use App\Events\UserPasswordResetEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\API\LoginAPIRequest;
use App\Http\Requests\API\RegisterAPIRequest;
use App\Http\Requests\API\PasswordResetAPIRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\User;
class AuthController extends AppBaseController 
{
  /**
   * Display a listing of the resource.
   */

   public function index(Request $request): Response 

   {

    $query = User::query();
    if($request->get('skip')) {
      $query->skip($request->get('skip'));
    }

    if($request->get('limit')) {
      $request->limit($request->get('limit'));
    }

    $users - $query->get();

    return $this->sendResponse($users->toArray(),'Users retrieved successfully');

   }

   public function login(LoginAPIRequest $request)
   {
    $user = User::where('email',$request->email)->first();

    if($user == null || !Hash::check($request->password,$user->password)) {
      return response()->json([
        'email' => ['The provided credentials are incorrect.'],
      ],200);
    }

    // UserLoginEvent::dispatch($user);

    if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
      $request->session()->regenerate();
      return $this->sendResponse(
        ['token' => $user->createToken('API Token')->plainTextToken,'profile' => $user
      ],

      'Login successful'
      );
    }
   }

   public function register(RegisterAPIRequest $request) 
   {
     $request->validated($request->all());

     $user = User::create([
      'username' => $request->username,
      'email' => $request->email,
      'password' => Hash::make($request->password)
     ]);

     return $this->sendResponse(
      [
        'user' => $user,
        'token' => $user->createToken('API Token')->plainTextToken,
      ],
      'Registration successful'
      );
   }

   public function reset(PasswordResetAPIRequest $request)
   {
    $user = User::where('email',$request->email)->first();

    if($user == null || !Hash::check($request->password, $user->password)) {
      return response()->json([
        'email' => ['The provided credentials are incorrect.'],
      ],200);
    }

    $user->password = Hash::make($request->password);
    $user->save();

    UserPasswordResetEvent::dispatch($user);
    return $this->sendResponse(null,'Reset successful');
   }


   public function resetPassword(PasswordResetAPIRequest $request)
   {
      $user = User::where('email', $request->email)->first();

      if(!$user) {
        return $this->sendError('User not found');
      }

      $user->password = Hash::make($request->password);
      $user->save();

      UserPasswordResetEvent::dispatch($user);
      return $this->sendResponse(null,'Reset successful');
   }


   public function recoverPassword(PasswordResetAPIRequest $request) {
    $user = User::where('email',$request->email)->first();
    if($user == null) {
      return response()->json([
        'email' => ['The email address is not correct.'],
      ],200);

    }
      $token = \Illuminate\Support\Str::random(10);
      $user->sendPasswordResetNotification($token);

      UserPasswordResetEvent::dispatch($user);
      return $this->sendResponse(null,'Reset successful.');
   }


   public function logout(Request $request)

   {
    Auth:logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return $this->sendResponse(null,'Logout successful');
   }

}