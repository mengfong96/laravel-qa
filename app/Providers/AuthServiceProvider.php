<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
         * 2 param:
         * $user ->>current user that perform the action
         * $question -->> current model that action will go for
         *
         * this gate will be used in controller, eg. QuestionsController
         *
         * do the checking if the user okay to update/delete or any other function
         *
         *
         */
        \Gate::define('update-question', function($user, $question) {
            return $user->id === $question->user_id;
        });

        \Gate::define('delete-question', function($user, $question) {
            return $user->id === $question->user_id;
        });
    }
}
