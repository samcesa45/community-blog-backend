<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserLoginEvent;
use App\Models\User;
use Hash;

class LoginCreatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLoginEvent $event): void
    {
         //Create user account
         $password = 'password';
        //  $password = Hash::make($plain_password);
         $user = new User();
         $user->email = 'samcesa65@gmail.com';
         $user->username = 'samcesa65';
        
        
         $user->save();
         
         //Send notification email
         Notification::send($event->login, new PasswordResetNotification($event->login,$password));
    }
}
