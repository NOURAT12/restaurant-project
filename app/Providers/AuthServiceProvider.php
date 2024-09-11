<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
      $this->registerPolicies();
      VerifyEmail::toMailUsing(function($notifiable,$url){
        $spaurl="http:spa.test?email_verify_url=".$url;
        return (new MailMessage)
        ->subject('verify email address')
        ->line('click the button below to verify your email address')
        ->line('your verify code is 23456');
        // ->action('verify email address',$spaurl);
      });
    }
}
