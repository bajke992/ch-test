<?php namespace App\Repositories;

use App\Exceptions\EntityNotFoundException;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Collection;

class EloquentAnswerRepository implements AnswerRepositoryInterface
{
    /**
     * @var Answer
     */
    private $answer;

    /**
     * EloquentAnswerRepository constructor.
     *
     * @param Answer $answer
     */
    public function __construct(Answer $answer)
    {
        $this->answer = $answer;
    }

    /**
     * @return Answer
     */
    public function getAll()
    {
        return $this->answer->all();
    }

    /**
     * @param integer $id
     *
     * @return Answer
     */
    public function find($id)
    {
        return $this->answer->query()->find($id);
    }

    /**
     * @param integer $id
     *
     * @return Answer
     * @throws EntityNotFoundException
     */
    public function findOrFail($id)
    {
        $answer = $this->find($id);
        if ($answer === null) {
            throw new EntityNotFoundException('Answer not found.');
        }

        return $answer;
    }

    /**
     * @param Question $question
     *
     * @return Collection|Answer[]
     */
    public function getAnswersForQuestion(Question $question)
    {
        return $question->answers()->get();
    }


    /**
     * @param Answer $answer
     */
    public function save(Answer $answer)
    {
        $answer->save();
    }

    /**
     * @param Question $question
     * @param Answer   $answer
     */
    public function saveAnswerToQuestion(Question $question, Answer $answer)
    {
        $question->answers()->save($answer);
    }


    /**
     * @param Answer $answer
     */
    public function delete(Answer $answer)
    {
        $answer->delete();
    }
}