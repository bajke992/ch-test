<?php

namespace App\Providers;

use App\Models\Answer;
use App\Models\Poll;
use App\Models\Question;
use App\Models\User;
use App\Repositories\AnswerRepositoryInterface;
use App\Repositories\EloquentAnswerRepository;
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
        $this->app->bind(AnswerRepositoryInterface::class, function (Application $app) {
            return new EloquentAnswerRepository(new Answer());
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
