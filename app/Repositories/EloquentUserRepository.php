<?php namespace App\Repositories;

use App\Exceptions\EntityNotFoundException;
use App\Models\Poll;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EloquentUserRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    private $user;

    /**
     * EloquentUserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return Collection|User[]
     */
    public function getAll()
    {
        return $this->user->all();
    }

    /**
     * @param integer $id
     *
     * @return User
     */
    public function find($id)
    {
        return $this->user->query()->find($id);
    }

    /**
     * @param integer $id
     *
     * @return User
     * @throws EntityNotFoundException
     */
    public function findOrFail($id)
    {
        $user = $this->find($id);
        if($user === null){
            throw new EntityNotFoundException("User not found.");
        }

        return $user;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function findByEmail($email)
    {
        return $this->user->query()->where('email', $email)->first();
    }

    /**
     * @param string $email
     *
     * @return User
     * @throws EntityNotFoundException
     */
    public function findByEmailOrFail($email)
    {
        $user = $this->findByEmail($email);
        if($user === null) {
            throw new EntityNotFoundException('User not found.');
        }

        return $user;
    }

    /**
     * @param string $token
     *
     * @return User
     */
    public function findByToken($token)
    {
        return $this->user->query()->where('token', $token)->first();
    }

    /**
     * @param string $token
     *
     * @return User
     * @throws EntityNotFoundException
     */
    public function findByTokenOrFail($token)
    {
        $user = $this->findByToken($token);
        if($user === null){
            throw new EntityNotFoundException('User not found.');
        }

        return $user;
    }

    /**
     * @param Poll $poll
     * @param User $user
     *
     * @return boolean
     */
    public function userCanParticipate(Poll $poll, User $user){
        if(DB::table('user_answers')->whereUserId($user->id)->wherePollId($poll->id)->count() > 0) return false;

        return true;
    }

    /**
     * @param User $user
     */
    public function save(User $user)
    {
        $user->save();
    }

    /**
     * @param User $user
     */
    public function delete(User $user)
    {
        $user->delete();
    }
}