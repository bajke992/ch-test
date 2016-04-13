<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/13/2016
 * Time: 4:13 PM
 */

namespace App\Repositories;


use App\Exceptions\EntityNotFoundException;
use App\Models\Poll;
use Illuminate\Database\Eloquent\Collection;

interface PollRepositoryInterface
{

    /**
     * @return Collection|Poll[]
     */
    public function getAll();

    /**
     * @param integer $id
     *
     * @return Poll
     */
    public function find($id);

    /**
     * @param integer $id
     *
     * @return Poll
     * @throws EntityNotFoundException
     */
    public function findOrFail($id);

    /**
     * @param string $title
     *
     * @return Poll
     */
    public function findByTitle($title);

    /**
     * @param string $title
     *
     * @return Poll
     * @throws EntityNotFoundException
     */
    public function findByTitleOrFail($title);

    /**
     * @param Poll $poll
     */
    public function save(Poll $poll);

    /**
     * @param Poll $poll
     */
    public function archive(Poll $poll);

    /**
     * @param Poll $poll
     */
    public function delete(Poll $poll);
}