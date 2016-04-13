<?php namespace App\Repositories;

use App\Exceptions\EntityNotFoundException;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Collection;

interface AnswerRepositoryInterface
{

    /**
     * @return Answer
     */
    public function getAll();

    /**
     * @param integer $id
     *
     * @return Answer
     */
    public function find($id);

    /**
     * @param integer $id
     *
     * @return Answer
     * @throws EntityNotFoundException
     */
    public function findOrFail($id);

    /**
     * @param Question $question
     *
     * @return Collection|Answer[]
     */
    public function getAnswersForQuestion(Question $question);

    /**
     * @param Answer $answer
     */
    public function save(Answer $answer);

    /**
     * @param Question $question
     * @param Answer   $answer
     */
    public function saveAnswerToQuestion(Question $question, Answer $answer);

    /**
     * @param Answer $answer
     */
    public function delete(Answer $answer);

}