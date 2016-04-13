<?php namespace App\Repositories;

use App\Exceptions\EntityNotFoundException;
use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{

    /**
     * @return Collection|User[]
     */
    public function getAll();

    /**
     * @param integer $id
     *
     * @return User
     */
    public function find($id);

    /**
     * @param integer $id
     *
     * @return User
     * @throws EntityNotFoundException
     */
    public function findOrFail($id);

    /**
     * @param string $email
     *
     * @return User
     */
    public function findByEmail($email);

    /**
     * @param string $email
     *
     * @return User
     * @throws EntityNotFoundException
     */
    public function findByEmailOrFail($email);

    /**
     * @param string $token
     *
     * @return User
     */
    public function findByToken($token);

    /**
     * @param string $token
     *
     * @return User
     * @throws EntityNotFoundException
     */
    public function findByTokenOrFail($token);

    /**
     * @param User $user
     */
    public function save(User $user);

    /**
     * @param User $user
     */
    public function delete(User $user);

}