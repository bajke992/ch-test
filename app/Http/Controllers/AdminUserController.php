<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use App\Services\Mailer;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Mail;

class AdminUserController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepo;

    /**
     * AdminUserController constructor.
     *
     * @param UserRepositoryInterface $userRepo
     */
    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $users = $this->userRepo->getAll();

        return view('admin.users.list', ['users' => $users]);
    }

    public function create()
    {
        $user = new User;

        return view('admin.users.form', ['user' => $user]);
    }

    public function createPost(Request $request, Mailer $mailer, Hasher $hasher)
    {
        $input = $request->only([
            'email',
            'password',
            'status',
            'verified'
        ]);

        $user = User::make($input['email'], $hasher->make($input['password']));
        $user->setType(User::TYPE_ADMIN);
        $user->setStatus($input['status']);
        if($input['verified']) {
            $user->setVerified(true);
        } else {
            $user->setVerified(false);
            $user->setToken();
        }

        $this->userRepo->save($user);

        if(!$input['verified'] && $user->getStatus() !== User::STATUS_BANNED) $mailer->sendActivationEmail($user);

        return redirect()->route('admin.user.list');
    }

    public function update($id)
    {
        $user = $this->userRepo->findOrFail($id);

        return view('admin.users.form', ['user' => $user, 'update' => true]);
    }

    public function updatePost(Request $request, $id, Hasher $hasher, Mailer $mailer)
    {
        $user = $this->userRepo->findOrFail($id);

        $input = $request->only([
            'email',
            'password',
            'status',
            'verified'
        ]);

        $user->setEmail($input['email']);
        if($input['password'] !== ""){
            $user->setPassword($hasher->make($input['password']));
        }
        $user->setStatus($input['status']);
        if($input['verified']) {
            $user->setVerified(true);
        } else {
            $user->setVerified(false);
            $user->setToken();
        }

        $this->userRepo->save($user);

        if(!$input['verified'] && $user->getStatus() !== User::STATUS_BANNED) $mailer->sendActivationEmail($user);

        return redirect()->route('admin.user.list');

    }

    public function ban($id)
    {
        $user = $this->userRepo->findOrFail($id);

        $user->setStatus(User::STATUS_BANNED);
        $this->userRepo->save($user);

        return redirect()->route('admin.user.list');
    }

    public function delete($id)
    {
        $user = $this->userRepo->findOrFail($id);

        $this->userRepo->delete($user);

        return redirect()->route('admin.user.list');
    }
}
