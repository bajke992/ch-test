<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidArgumentException;
use App\Http\Requests;
use App\Models\Answer;
use App\Models\Poll;
use App\Models\Question;
use App\Repositories\AnswerRepositoryInterface;
use App\Repositories\PollRepositoryInterface;
use App\Repositories\QuestionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminFlowController extends Controller
{
    /**
     * @var PollRepositoryInterface
     */
    private $pollRepo;
    /**
     * @var QuestionRepositoryInterface
     */
    private $questionRepo;
    /**
     * @var AnswerRepositoryInterface
     */
    private $answerRepo;

    /**
     * AdminFlowController constructor.
     *
     * @param PollRepositoryInterface     $pollRepo
     * @param QuestionRepositoryInterface $questionRepo
     * @param AnswerRepositoryInterface   $answerRepo
     */
    public function __construct(PollRepositoryInterface $pollRepo, QuestionRepositoryInterface $questionRepo, AnswerRepositoryInterface $answerRepo)
    {
        $this->pollRepo     = $pollRepo;
        $this->questionRepo = $questionRepo;
        $this->answerRepo   = $answerRepo;
    }

    /**
     * @return Response
     */
    public function poll()
    {
        $poll = new Poll();

        return view('admin.polls.flowForm', ['poll' => $poll]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @throws InvalidArgumentException
     */
    public function pollPost(Request $request)
    {
        $input = $request->only([
            'title',
            'visibility',
            'status'
        ]);

        $poll = Poll::make(
            $input['title'],
            $input['visibility'],
            $input['status']
        );

        $this->pollRepo->save($poll);

        $question = new Question();

        return view('admin.questions.flowForm', ['poll' => $poll, 'question' => $question]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @throws InvalidArgumentException
     */
    public function questionPost(Request $request)
    {
        $input = $request->only([
            'question',
            'type',
            'poll_id'
        ]);

        $poll = $this->pollRepo->findOrFail($input['poll_id']);

        foreach ($input['question'] as $k => $v) {
            $question = Question::make(
                $input['type'][$k],
                $v
            );

            $this->questionRepo->save($question);
            $this->questionRepo->saveQuestionToPoll($poll, $question);
        }

        $questions = $this->questionRepo->getQuestionsForPoll($poll);

        return view('admin.answers.flowForm', ['poll' => $poll, 'questions' => $questions]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function answerPost(Request $request)
    {
        $input = $request->only([
            'answer',
            'poll_id'
        ]);

        foreach ($input['answer'] as $k => $v) {
            $question = $this->questionRepo->findOrFail($k);
            foreach ($v as $a) {
                $answer = Answer::make($a);
                $this->answerRepo->save($answer);
                $this->answerRepo->saveAnswerToQuestion($question, $answer);
            }
        }

        $poll = $this->pollRepo->findOrFail($input['poll_id']);

        return redirect()->route('admin.poll.view', [$poll->id]);
    }
}
