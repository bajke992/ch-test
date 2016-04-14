<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginPostRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\PostResetPasswordRequest;
use App\Http\Requests\Auth\RegistrationPostRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use App\Services\Mailer;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Response;

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

    /**
     * @param RegistrationRequest $request
     *
     * @return Response
     */
    public function getRegistration(RegistrationRequest $request)
    {
        return view('auth.register');
    }

    /**
     * @param RegistrationPostRequest $request
     * @param Mailer                  $mailer
     * @param Hasher                  $hasher
     * @param Guard                   $guard
     *
     * @return Response
     */
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

    /**
     * @param LoginRequest $request
     *
     * @return Response
     */
    public function getLogin(LoginRequest $request)
    {
        return view('auth.login');
    }

    /**
     * @param LoginPostRequest $request
     * @param Guard            $guard
     *
     * @return Response
     */
    public function postLogin(LoginPostRequest $request, Guard $guard)
    {
        $input = $request->only([
            'email',
            'password',
            'remember'
        ]);

        $user = $this->userRepo->findByEmail($input['email']);
        if (!$user) {
            session()->flash('error', 'Pogrešna email adresa ili lozinka!');
            return redirect()->back();
        }
        if (!$user->getVerified()) {
            session()->flash('warning', 'Verifikujte Vašu email adresu.');
            return redirect()->back();
        }
        if ($user->getStatus() === User::STATUS_BANNED) {
            session()->flash('warning', 'Vaš nalog je banovan.');
            return redirect()->back();
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
            return redirect()->route('admin.poll.list');
        }

        return redirect()->route('home');
    }

    /**
     * @param Guard $guard
     *
     * @return Response
     */
    public function getLogout(Guard $guard)
    {
        $guard->logout();
        return redirect()->route('home');
    }

    /**
     * @param Guard $guard
     * @param       $token
     *
     * @return Response
     */
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

    /**
     * @param $token
     *
     * @return Response
     */
    public function getReset($token)
    {
        $user = $this->userRepo->findByTokenOrFail($token);

        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => $user->getEmail()
        ]);
    }

    /**
     * @param PostResetPasswordRequest $request
     * @param Hasher                   $hasher
     * @param Guard                    $guard
     *
     * @return Response
     */
    public function postReset(PostResetPasswordRequest $request, Hasher $hasher, Guard $guard)
    {
        $input = $request->only([
            'token',
            'email',
            'password',
            'password_confirmation'
        ]);

        $user = $this->userRepo->findByTokenOrFail($input['token']);
        $user->setPassword($hasher->make($input['password']));
        $user->setToken();
        $this->userRepo->save($user);

        session()->flash('message', 'Uspešno ste promenili lozinku.');

        $guard->login($user);

        return redirect()->route('home');
    }

    /**
     * @return Response
     */
    public function getEmail()
    {
        return view('auth.passwords.email');
    }

    /**
     * @param ResetPasswordRequest $request
     * @param Mailer            $mailer
     *
     * @return Response
     */
    public function postEmail(ResetPasswordRequest $request, Mailer $mailer)
    {
        $input = $request->only([
            'email',
        ]);

        $user = $this->userRepo->findByEmail(trim($input['email']));

        $user->setToken();
        $mailer->sendPasswordResetEmail($user);
        $this->userRepo->save($user);

        session()->flash('message', 'Poslat vam je email sa instrukcijama za reset lozinke.');

        return redirect()->back();
    }
}
