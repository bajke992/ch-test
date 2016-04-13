<?php namespace App\Repositories;


use App\Exceptions\EntityNotFoundException;
use App\Models\Poll;
use App\Models\Question;
use Illuminate\Support\Collection;

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
     * @param Poll $poll
     *
     * @return Collection|Question[]
     */
    public function getQuestionsForPoll(Poll $poll);

    /**
     * @param Question $question
     */
    public function save(Question $question);

    /**
     * @param Poll     $poll
     * @param Question $question
     */
    public function saveQuestionToPoll(Poll $poll, Question $question);

    /**
     * @param Question $question
     */
    public function delete(Question $question);
}