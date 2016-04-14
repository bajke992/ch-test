<?php namespace App\Repositories;

use App\Exceptions\EntityNotFoundException;
use App\Models\Poll;
use Illuminate\Database\Eloquent\Collection;

class EloquentPollRepository implements PollRepositoryInterface
{

    /**
     * @var Poll
     */
    private $poll;

    /**
     * EloquentPollRepository constructor.
     *
     * @param Poll $poll
     */
    public function __construct(Poll $poll)
    {
        $this->poll = $poll;
    }

    /**
     * @return Collection|Poll[]
     */
    public function getAll()
    {
        return $this->poll->all();
    }

    /**
     * @param integer $id
     *
     * @return Poll
     */
    public function find($id)
    {
        return $this->poll->query()->find($id);
    }

    /**
     * @param integer $id
     *
     * @return Poll
     * @throws EntityNotFoundException
     */
    public function findOrFail($id)
    {
        $poll = $this->find($id);
        if($poll === null){
            throw new EntityNotFoundException('Poll not found.');
        }

        return $poll;
    }

    /**
     * @param string $title
     *
     * @return Poll
     */
    public function findByTitle($title)
    {
        return $this->poll->query()->where('title', $title)->first();
    }

    /**
     * @param string $title
     *
     * @return Poll
     * @throws EntityNotFoundException
     */
    public function findByTitleOrFail($title)
    {
        $poll = $this->findByTitle($title);
        if($poll === null){
            throw new EntityNotFoundException('Poll not found.');
        }

        return $poll;
    }

    /**
     * @return Collection|Poll[]
     */
    public function getAvailablePolls(){
        $query = $this->poll->query();

        $query->where('status', Poll::STATUS_ACTIVE)
            ->where('visibility', Poll::VISIBILITY_PUBLIC);

        return $query->get();
    }

    /**
     * @param Poll $poll
     */
    public function save(Poll $poll)
    {
        $poll->save();
    }

    /**
     * @param Poll $poll
     */
    public function archive(Poll $poll)
    {
        $poll->setStatus(Poll::STATUS_ARCHIVED);
        $this->save($poll);
    }

    /**
     * @param Poll $poll
     */
    public function delete(Poll $poll)
    {
        $poll->delete();
    }
}