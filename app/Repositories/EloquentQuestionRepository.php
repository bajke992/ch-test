<?php namespace App\Repositories;

use App\Exceptions\EntityNotFoundException;
use App\Models\Poll;
use App\Models\Question;
use Illuminate\Support\Collection;

class EloquentQuestionRepository implements QuestionRepositoryInterface
{
    /**
     * @var Question
     */
    private $question;

    /**
     * EloquentQuestionRepository constructor.
     *
     * @param Question $question
     */
    public function __construct(Question $question)
    {
        $this->question = $question;
    }

    /**
     * @return Question
     */
    public function getAll()
    {
        return $this->question->all();
    }

    /**
     * @param integer $id
     *
     * @return Question
     */
    public function find($id)
    {
        return $this->question->query()->find($id);
    }

    /**
     * @param integer $id
     *
     * @return Question
     * @throws EntityNotFoundException
     */
    public function findOrFail($id)
    {
        $question = $this->find($id);
        if ($question === null) {
            throw new EntityNotFoundException('Question not found.');
        }

        return $question;
    }

    /**
     * @param Poll $poll
     *
     * @return Collection|Question[]
     */
    public function getQuestionsForPoll(Poll $poll)
    {
        return $poll->questions()->get();
    }

    /**
     * @param Question $question
     */
    public function save(Question $question)
    {
        $question->save();
    }

    /**
     * @param Poll     $poll
     * @param Question $question
     */
    public function saveQuestionToPoll(Poll $poll, Question $question)
    {
        $poll->questions()->save($question);
    }

    /**
     * @param Question $question
     */
    public function delete(Question $question)
    {
        $question->delete();
    }
}