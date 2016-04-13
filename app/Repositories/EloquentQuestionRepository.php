<?php namespace App\Repositories;

use App\Exceptions\EntityNotFoundException;
use App\Models\Question;

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
        if($question === null) {
            throw new EntityNotFoundException('Question not found.');
        }

        return $question;
    }

    /**
     * @param Question $question
     */
    public function save(Question $question)
    {
        $question->save();
    }

    /**
     * @param Question $question
     */
    public function delete(Question $question)
    {
        $question->delete();
    }
}