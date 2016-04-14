<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidArgumentException;
use App\Models\Question;
use App\Repositories\QuestionRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;

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

    /**
     * @return Response
     */
    public function index()
    {
        $questions = $this->questionRepo->getAll();

        return view('admin.questions.list', ['questions' => $questions]);
    }

    /**
     * @return Response
     */
    public function create()
    {
        $question = new Question;

        return view('admin.questions.form', ['question' => $question]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @throws InvalidArgumentException
     */
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

    /**
     * @param $id
     *
     * @return Response
     */
    public function update($id)
    {
        $question = $this->questionRepo->findOrFail($id);

        if($question->userAnswers->count() > 0) {
            session()->flash('warning', 'The poll contains user answers and cannot be edited!');
            return redirect()->back();
        }

        return view('admin.questions.form', ['question' => $question]);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return Response
     * @throws InvalidArgumentException
     */
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

    /**
     * @param $id
     *
     * @return Response
     */
    public function delete($id)
    {
        $question = $this->questionRepo->findOrFail($id);
        $this->questionRepo->delete($question);

        return redirect()->route('admin.question.list');
    }
}
