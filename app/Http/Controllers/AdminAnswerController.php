<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Answer;
use App\Repositories\AnswerRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminAnswerController extends Controller
{
    /**
     * @var AnswerRepositoryInterface
     */
    private $answerRepo;

    /**
     * AdminAnswerController constructor.
     *
     * @param AnswerRepositoryInterface $answerRepo
     */
    public function __construct(AnswerRepositoryInterface $answerRepo)
    {
        $this->answerRepo = $answerRepo;
    }

    /**
     * @return Response
     */
    public function index()
    {
        $answers = $this->answerRepo->getAll();

        return view('admin.answers.list', ['answers' => $answers]);
    }

    /**
     * @return Response
     */
    public function create()
    {
        $answer = new Answer;

        return view('admin.answers.form', ['answer' => $answer]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function createPost(Request $request)
    {
        $input = $request->only([
            'answer'
        ]);

        $answer = Answer::make($input['answer']);

        $this->answerRepo->save($answer);

        return redirect()->route('admin.answer.list');
    }

    /**
     * @param $id
     *
     * @return Response
     */
    public function update($id)
    {
        $answer = $this->answerRepo->findOrFail($id);

        if ($answer->userAnswers->count() > 0) {
            session()->flash('warning', 'This poll contains user answers and cannot be edited!');
            return redirect()->back();
        }

        return view('admin.answers.form', ['answer' => $answer]);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return Response
     */
    public function updatePost(Request $request, $id)
    {
        $input = $request->only([
            'answer'
        ]);

        $answer = $this->answerRepo->findOrFail($id);

        $answer->setAnswer($input['answer']);

        $this->answerRepo->save($answer);

        return redirect()->route('admin.answer.list');
    }

    /**
     * @param $id
     *
     * @return Response
     */
    public function delete($id)
    {
        $answer = $this->answerRepo->findOrFail($id);
        $this->answerRepo->delete($answer);

        return redirect()->back();
    }
}
