<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Repositories\QuestionRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminQuestionController extends Controller
{
    /**
     * @var QuestionRepositoryInterface
     */
    private $questionRepo;

    /**
     * AdminQuestionController constructor.
     *
     * @param QuestionRepositoryInterface $questionRepo
     */
    public function __construct(QuestionRepositoryInterface $questionRepo)
    {
        $this->questionRepo = $questionRepo;
    }

    public function index()
    {
        $questions = $this->questionRepo->getAll();

        return view('admin.questions.list', ['questions' => $questions]);
    }

    public function create()
    {
        $question = new Question;

        return view('admin.questions.form', ['question' => $question]);
    }

    public function createPost(Request $request)
    {
        $input = $request->only([
            'question',
            'type'
        ]);

        $question = Question::make(
            $input['type'],
            $input['question']
        );

        $this->questionRepo->save($question);

        return redirect()->route('admin.question.list');
    }

    public function update($id)
    {
        $question = $this->questionRepo->findOrFail($id);

        return view('admin.questions.form', ['question' => $question]);
    }

    public function updatePost(Request $request, $id)
    {
        $input = $request->only([
            'question',
            'type'
        ]);

        $question = $this->questionRepo->findOrFail($id);

        $question->setQuestion($input['question']);
        $question->setType($input['type']);

        $this->questionRepo->save($question);

        return redirect()->route('admin.question.list');
    }

    public function delete($id)
    {
        $question = $this->questionRepo->findOrFail($id);
        $this->questionRepo->delete($question);

        return redirect()->route('admin.question.list');
    }
}
