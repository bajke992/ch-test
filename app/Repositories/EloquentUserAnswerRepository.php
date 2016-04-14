<?php namespace App\Repositories;

use App\Models\Answer;
use App\Models\Poll;
use App\Models\Question;
use App\Models\User;
use App\Models\UserAnswer;
use Illuminate\Database\Eloquent\Collection;

class EloquentUserAnswerRepository implements UserAnswerRepositoryInterface
{
    /**
     * @var UserAnswer
     */
    private $userAnswer;

    /**
     * EloquentUserAnswerRepository constructor.
     *
     * @param UserAnswer $userAnswer
     */
    public function __construct(UserAnswer $userAnswer)
    {
        $this->userAnswer = $userAnswer;
    }

    /**
     * @param UserAnswer $userAnswer
     */
    public function save(UserAnswer $userAnswer)
    {
        $userAnswer->save();
    }

    /**
     * @param UserAnswer $userAnswer
     * @param User       $user
     * @param Poll       $poll
     * @param Question   $question
     * @param Answer     $answer
     */
    public function saveUserAnswerToRelations(UserAnswer $userAnswer, User $user, Poll $poll, Question $question, Answer $answer)
    {
        $user->userAnswers()->save($userAnswer);
        $poll->userAnswers()->save($userAnswer);
        $question->userAnswers()->save($userAnswer);
        $answer->userAnswers()->save($userAnswer);
    }

    /**
     * @param User $user
     * @param Poll $poll
     *
     * @return Collection|Answer[]
     */
    public function getAnswersForUserAndPoll(User $user, Poll $poll)
    {
        $query = $this->userAnswer->query();

        $query->where('user_id', $user->id)
            ->where('poll_id', $poll->id);

        return $query->get();
    }
}