<?php namespace App\Repositories;


use App\Models\Answer;
use App\Models\Poll;
use App\Models\Question;
use App\Models\User;
use App\Models\UserAnswer;
use Illuminate\Support\Collection;

interface UserAnswerRepositoryInterface
{

    /**
     * @param UserAnswer $userAnswer
     */
    public function save(UserAnswer $userAnswer);

    /**
     * @param UserAnswer $userAnswer
     * @param User       $user
     * @param Poll       $poll
     * @param Question   $question
     * @param Answer     $answer
     */
    public function saveUserAnswerToRelations(UserAnswer $userAnswer, User $user, Poll $poll, Question $question, Answer $answer);

    /**
     * @param User $user
     * @param Poll $poll
     *
     * @return Collection|Answer[]
     */
    public function getAnswersForUserAndPoll(User $user, Poll $poll);
}