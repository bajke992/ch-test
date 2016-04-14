<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Poll;
use App\Models\User;
use App\Models\UserAnswer;
use App\Repositories\AnswerRepositoryInterface;
use App\Repositories\PollRepositoryInterface;
use App\Repositories\QuestionRepositoryInterface;
use App\Repositories\UserAnswerRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    /**
     * @var PollRepositoryInterface
     */
    private $pollRepo;
    /**
     * @var UserRepositoryInterface
     */
    private $userRepo;
    /**
     * @var QuestionRepositoryInterface
     */
    private $questionRepo;
    /**
     * @var AnswerRepositoryInterface
     */
    private $answerRepo;
    /**
     * @var UserAnswerRepositoryInterface
     */
    private $userAnswerRepo;

    /**
     * Create a new controller instance.
     *
     * @param PollRepositoryInterface       $pollRepo
     * @param UserRepositoryInterface       $userRepo
     * @param QuestionRepositoryInterface   $questionRepo
     * @param AnswerRepositoryInterface     $answerRepo
     * @param UserAnswerRepositoryInterface $userAnswerRepo
     */
    public function __construct(PollRepositoryInterface $pollRepo, UserRepositoryInterface $userRepo, QuestionRepositoryInterface $questionRepo, AnswerRepositoryInterface $answerRepo, UserAnswerRepositoryInterface $userAnswerRepo)
    {
        $this->pollRepo       = $pollRepo;
        $this->userRepo       = $userRepo;
        $this->questionRepo   = $questionRepo;
        $this->answerRepo     = $answerRepo;
        $this->userAnswerRepo = $userAnswerRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $polls = $this->pollRepo->getAvailablePolls();

        return view('home', ['polls' => $polls]);
    }

    /**
     * @param       $id
     * @param Guard $guard
     *
     * @return Response
     */
    public function poll($id, Guard $guard)
    {
        $poll = $this->pollRepo->findOrFail($id);
        /** @var User $user */
        $user = $guard->user();

        if (!$guard->guest() && (!$this->userRepo->userCanParticipate($poll, $user) && $poll->isPublic())) {
            return redirect()->route('user.polls.view', [$poll->id]);
        }

        return view('polls.view', ['poll' => $poll]);
    }

    /**
     * @param Guard $guard
     *
     * @return Response
     */
    public function myPolls(Guard $guard)
    {
        /** @var User $user */
        $user = $guard->user();

        $poll_ids = array_unique($user->userAnswers->pluck('poll_id')->toArray());
        $polls    = null;

        foreach ($poll_ids as $poll) {
            $tmp = $this->pollRepo->findOrFail($poll);
            if ($tmp->getVisibility() === Poll::VISIBILITY_PUBLIC) {
                $polls[] = $tmp;
            }
        }

        return view('polls.list', ['polls' => $polls]);
    }

    /**
     * @param       $id
     * @param Guard $guard
     *
     * @return Response
     */
    public function myPollView($id, Guard $guard)
    {
        $poll = $this->pollRepo->findOrFail($id);
        /** @var User $user */
        $user        = $guard->user();
        $userAnswers = $this->userAnswerRepo->getAnswersForUserAndPoll($user, $poll);

//        dd($userAnswers);

        return view('polls.results', ['poll' => $poll, 'userAnswers' => $userAnswers]);
    }

    /**
     * @param Request $request
     * @param Guard   $guard
     *
     * @return Response
     */
    public function pollPost(Request $request, Guard $guard)
    {
        $input = $request->only([
            'poll_id',
            'answer'
        ]);

        /** @var User $user */
        $user = $guard->user();
        $poll = $this->pollRepo->findOrFail($input['poll_id']);

        foreach ($input['answer'] as $q_id => $item) {
            $question = $this->questionRepo->findOrFail($q_id);
            if (!is_array($item)) {
                $answer = $this->answerRepo->findOrFail($item);

                $userAnswer = new UserAnswer();

                $this->userAnswerRepo->save($userAnswer);
                $this->userAnswerRepo->saveUserAnswerToRelations($userAnswer, $user, $poll, $question, $answer);
            } else {
                foreach ($item as $a_id => $answerItem) {
                    $answer = $this->answerRepo->findOrFail($a_id);

                    $userAnswer = new UserAnswer();

                    $this->userAnswerRepo->save($userAnswer);
                    $this->userAnswerRepo->saveUserAnswerToRelations($userAnswer, $user, $poll, $question, $answer);
                }
            }
        }

        return redirect()->route('user.polls.view', [$poll->id]);
    }
}
