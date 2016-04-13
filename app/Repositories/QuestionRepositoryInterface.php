<?php namespace App\Repositories;


use App\Exceptions\EntityNotFoundException;
use App\Models\Question;

interface QuestionRepositoryInterface
{
    /**
     * @return Question
     */
    public function getAll();

    /**
     * @param integer $id
     *
     * @return Question
     */
    public function find($id);

    /**
     * @param integer $id
     *
     * @return Question
     * @throws EntityNotFoundException
     */
    public function findOrFail($id);

    /**
     * @param Question $question
     */
    public function save(Question $question);

    /**
     * @param Question $question
     */
    public function delete(Question $question);
}