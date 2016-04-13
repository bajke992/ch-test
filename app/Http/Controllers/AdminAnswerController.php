<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Repositories\AnswerRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;

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

    public function index()
    {
        $answers = $this->answerRepo->getAll();

        return view('admin.answers.list', ['answers' => $answers]);
    }

    public function create()
    {
        $answer = new Answer;

        return view('admin.answers.form', ['answer' => $answer]);
    }

    public function createPost(Request $request)
    {
        $input = $request->only([
            'answer'
        ]);

        $answer = Answer::make($input['answer']);

        $this->answerRepo->save($answer);

        return redirect()->route('admin.answer.list');
    }

    public function update($id)
    {
        $answer = $this->answerRepo->findOrFail($id);

        return view('admin.answers.form', ['answer' => $answer]);
    }

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

    public function delete($id)
    {
        $answer = $this->answerRepo->findOrFail($id);
        $this->answerRepo->delete($answer);

        return redirect()->back();
    }
}
