<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginPostRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationPostRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use App\Services\Mailer;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepo;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * AuthController constructor.
     *
     * @param UserRepositoryInterface $userRepo
     */
    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
        $this->middleware($this->guestMiddleware(), ['except' => 'getLogout']);
    }

    public function getRegistration(RegistrationRequest $request)
    {
        return view('auth.register');
    }

    public function postRegistration(RegistrationPostRequest $request, Mailer $mailer, Hasher $hasher, Guard $guard)
    {
        $input = $request->only([
            'email',
            'password',
        ]);

        $user = $this->userRepo->findByEmail(trim($input['email']));

        if ($user !== null) {
            session()->flash('warning', 'Korisnik sa tom email adresom već postoji.');
            return redirect()->back();
        }

        $user = User::make(
            $input['email'],
            $hasher->make($input['password'])
        );

        $user->setToken();

        $this->userRepo->save($user);

        $mailer->sendActivationEmail($user);

        session()->flash('message', 'Verifikacioni email je poslat na vašu email adresu.');

        return redirect()->route('auth.login');
    }

    public function getLogin(LoginRequest $request)
    {
        return view('auth.login');
    }

    public function postLogin(LoginPostRequest $request, Guard $guard)
    {
        $input = $request->only([
            'email',
            'password',
            'remember'
        ]);

        $user  = $this->userRepo->findByEmailOrFail($input['email']);
        if ($user->getStatus() === User::STATUS_BANNED) {
            session()->flash('warning', 'Vaš nalog je banovan.');
            return redirect()->route('home');
        }

        $success = $guard->attempt([
            'email'    => $input['email'],
            'password' => $input['password']
        ], $input['remember']);

        if (!$success) {
            session()->flash('error', 'Pogrešna email adresa ili lozinka!');
            return redirect()->back();
        }

        $user = $this->userRepo->findByEmail($input['email']);
        if ($user->getType() === User::TYPE_ADMIN) {
            return redirect()->route('admin.home');
        }

        return redirect()->route('home');
    }

    public function getLogout(Guard $guard)
    {
        $guard->logout();
        return redirect()->route('home');
    }

    public function verifyEmail(Guard $guard, $token)
    {
        $user = $this->userRepo->findByTokenOrFail($token);

        $user->setVerified(true);
        $user->clearToken();
        $this->userRepo->save($user);

        session()->flash('message', 'Vaš nalog je verifikovan.');

        $guard->login($user);

        return redirect()->route('home');
    }

    public function resendVerificationEmail(Mailer $mailer)
    {
    }
}
