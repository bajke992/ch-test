<?php namespace App\Repositories;

use App\Exceptions\EntityNotFoundException;
use App\Models\Answer;

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
     * @param Answer $answer
     */
    public function save(Answer $answer);

    /**
     * @param Answer $answer
     */
    public function delete(Answer $answer);

}