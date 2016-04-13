<?php

namespace App\Providers;

use App\Models\Poll;
use App\Models\Question;
use App\Models\User;
use App\Repositories\EloquentPollRepository;
use App\Repositories\EloquentQuestionRepository;
use App\Repositories\EloquentUserRepository;
use App\Repositories\PollRepositoryInterface;
use App\Repositories\QuestionRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserRepositoryInterface::class, function (Application $app) {
            return new EloquentUserRepository(new User());
        });
        $this->app->bind(PollRepositoryInterface::class, function (Application $app) {
            return new EloquentPollRepository(new Poll());
        });
        $this->app->bind(QuestionRepositoryInterface::class, function (Application $app) {
            return new EloquentQuestionRepository(new Question());
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
